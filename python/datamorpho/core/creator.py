from __future__ import annotations

import json
import secrets
from pathlib import Path
from typing import Any

from .carriers import build_carrier
from .constants import DEFAULT_LAYOUT
from .crypto_utils import encrypt_fragment, finalize_state_key_material
from .exceptions import ValidationError
from .file_utils import (
    validate_distinct_input_paths,
    validate_existing_file,
    validate_state_count,
    validate_supported_carrier,
)
from .fragmenter import split_plaintext
from .manifest import (
    make_public_manifest,
    make_public_state_descriptor,
    make_reconstruction_object,
)
from .utils import (
    ensure_dir,
    json_dump_pretty,
    json_dumps_canonical,
    read_bytes,
    safe_filename,
    sha256_bytes,
    write_bytes,
)


def _build_payload_and_reconstruction(
    *,
    state_paths: list[Path],
    suite_profile: str,
    layout_strategy: str,
) -> tuple[bytes, list[dict[str, Any]]]:
    payload_entries: list[dict[str, Any]] = []
    reconstruction_templates: list[dict[str, Any]] = []

    for state_index, state_path in enumerate(state_paths, start=1):
        state_id = f"state-{state_index}"
        plain_bytes = read_bytes(state_path)
        fragments = split_plaintext(plain_bytes)

        shared_state_keys: dict[str, Any] | None = None
        fragment_entries: list[dict[str, Any]] = []
        suites_used: list[str] = []

        for fragment in fragments:
            encrypted, shared_state_keys = encrypt_fragment(
                fragment.data,
                suite_profile,
                shared_state_keys,
            )
            suites_used.append(encrypted.cipher_suite)
            fragment_id = f"{state_id}-fragment-{fragment.order}"

            payload_entries.append(
                {
                    "state_id": state_id,
                    "fragment_id": fragment_id,
                    "order": fragment.order,
                    "crypto_suite": encrypted.cipher_suite,
                    "ciphertext": encrypted.ciphertext,
                    "iv_b64url": encrypted.iv_b64url,
                    "key_material": encrypted.key_material,
                }
            )

            fragment_entries.append(
                {
                    "fragment_id": fragment_id,
                    "payload_region": "main",
                    "order": fragment.order,
                    "crypto_suite": encrypted.cipher_suite,
                    "iv_b64url": encrypted.iv_b64url,
                    "key_material": encrypted.key_material,
                }
            )

        reconstruction_templates.append(
            {
                "state_id": state_id,
                "state_path": state_path,
                "state_key_material": finalize_state_key_material(shared_state_keys),
                "fragments": fragment_entries,
                "suites_used": sorted(set(suites_used)),
            }
        )

    use_chaff = layout_strategy == "sparse-with-chaff"
    shuffled_entries = payload_entries[:]
    secrets.SystemRandom().shuffle(shuffled_entries)

    payload = bytearray()
    offsets_by_fragment_id: dict[str, tuple[int, int]] = {}

    for index, entry in enumerate(shuffled_entries):
        if use_chaff:
            pre_size = 0 if index == 0 else secrets.randbelow(65)
            if pre_size:
                payload.extend(secrets.token_bytes(pre_size))

        start = len(payload)
        payload.extend(entry["ciphertext"])
        end = len(payload)
        offsets_by_fragment_id[entry["fragment_id"]] = (start, end - start)

        if use_chaff:
            post_size = secrets.randbelow(65)
            if post_size:
                payload.extend(secrets.token_bytes(post_size))

    for template in reconstruction_templates:
        for fragment in template["fragments"]:
            start, length = offsets_by_fragment_id[fragment["fragment_id"]]
            fragment["offset"] = start
            fragment["length"] = length

    return bytes(payload), reconstruction_templates


def _compute_reconstruction_digest(reconstruction_object: dict[str, Any]) -> str:
    # Spec Section 7.9: reconstruction_digest MUST be computed after
    # removing carrier_file_digest and base_file_digest if present.
    # This prevents circular dependency between file binding and
    # reconstruction-object binding.
    filtered = {
        key: value
        for key, value in reconstruction_object.items()
        if key not in ("carrier_file_digest", "base_file_digest")
    }
    reconstruction_bytes = json_dumps_canonical(filtered).encode("utf-8")
    return sha256_bytes(reconstruction_bytes)


def create_datamorpho(
    *,
    carrier_path: Path,
    state_paths: list[Path],
    out_dir: Path,
    suite_profile: str,
    layout_strategy: str = DEFAULT_LAYOUT,
    max_file_size_bytes: int = 5 * 1024 * 1024,
    max_states: int = 5,
    morphostorage_text: str = "Accompanying reconstruction object file generated alongside the carrier output.",
) -> dict[str, Any]:
    validate_existing_file(carrier_path, max_size_bytes=max_file_size_bytes)
    validate_state_count(state_paths, max_states=max_states)

    for state_path in state_paths:
        validate_existing_file(state_path, max_size_bytes=max_file_size_bytes)

    validate_distinct_input_paths([carrier_path, *state_paths])

    carrier_kind = validate_supported_carrier(carrier_path)
    ensure_dir(out_dir)

    carrier_bytes = read_bytes(carrier_path)
    payload_bytes, reconstruction_templates = _build_payload_and_reconstruction(
        state_paths=state_paths,
        suite_profile=suite_profile,
        layout_strategy=layout_strategy,
    )

    # Placeholder build to detect carrier_profile string (e.g. "jpeg-trailer")
    placeholder_manifest = make_public_manifest(
        carrier_profile="pending",
        layout_strategy=layout_strategy,
        state_entries=[],
    )
    carrier_profile, _ = build_carrier(
        carrier_kind,
        carrier_bytes,
        placeholder_manifest,
        payload_bytes,
    )

    # Build reconstruction objects with a placeholder carrier digest.
    # Since _compute_reconstruction_digest excludes carrier_file_digest
    # (per spec Section 7.9), the reconstruction digests are stable
    # regardless of the final carrier digest value.
    reconstruction_objects: list[dict[str, Any]] = []
    for template in reconstruction_templates:
        reconstruction_objects.append(
            make_reconstruction_object(
                carrier_profile=carrier_profile,
                state_id=template["state_id"],
                carrier_digest="pending",
                hidden_file=template["state_path"],
                layout_strategy=layout_strategy,
                suite_profile=suite_profile,
                state_key_material=template["state_key_material"],
                fragments=template["fragments"],
                suites_used=template["suites_used"],
            )
        )

    # Build public state descriptors. Reconstruction digests are now stable
    # because they exclude carrier_file_digest, so no reconvergence needed.
    public_states = []
    for reconstruction, template in zip(reconstruction_objects, reconstruction_templates, strict=True):
        public_states.append(
            make_public_state_descriptor(
                state_id=reconstruction["state_id"],
                hidden_file=template["state_path"],
                reconstruction_digest=_compute_reconstruction_digest(reconstruction),
                morphostorage_text=morphostorage_text,
            )
        )

    public_manifest = make_public_manifest(
        carrier_profile=carrier_profile,
        layout_strategy=layout_strategy,
        state_entries=public_states,
    )

    # Build the final carrier and compute its digest
    carrier_profile, final_carrier_bytes = build_carrier(
        carrier_kind,
        carrier_bytes,
        public_manifest,
        payload_bytes,
    )
    final_carrier_digest = sha256_bytes(final_carrier_bytes)

    # Set the final carrier digest in reconstruction objects
    for reconstruction in reconstruction_objects:
        reconstruction["carrier_file_digest"]["value"] = final_carrier_digest

    carrier_suffix = ".datamorpho.jpg" if carrier_kind == "jpeg" else ".datamorpho.txt"
    output_carrier_path = out_dir / f"{safe_filename(carrier_path.stem)}{carrier_suffix}"
    write_bytes(output_carrier_path, final_carrier_bytes)

    public_manifest_path = out_dir / f"{safe_filename(carrier_path.stem)}.public-manifest.json"
    json_dump_pretty(public_manifest, public_manifest_path)

    reconstruction_paths: list[Path] = []
    for reconstruction in reconstruction_objects:
        state_id = reconstruction["state_id"]
        reconstruction_path = out_dir / f"reconstruction-{safe_filename(state_id)}.json"
        json_dump_pretty(reconstruction, reconstruction_path)
        reconstruction_paths.append(reconstruction_path)

    summary = {
        "carrier_input": str(carrier_path),
        "carrier_output": str(output_carrier_path),
        "carrier_profile": carrier_profile,
        "suite_profile": suite_profile,
        "layout_strategy": layout_strategy,
        "carrier_output_sha256": final_carrier_digest,
        "public_manifest": str(public_manifest_path),
        "reconstruction_objects": [str(path) for path in reconstruction_paths],
        "state_count": len(reconstruction_objects),
        "limits": {
            "max_file_size_bytes": max_file_size_bytes,
            "max_states": max_states,
        },
    }

    summary_path = out_dir / "create-summary.json"
    json_dump_pretty(summary, summary_path)
    summary["summary_path"] = str(summary_path)
    return summary