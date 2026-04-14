from __future__ import annotations

import json
from json import JSONDecodeError
from pathlib import Path
from typing import Any

from .carriers import parse_carrier
from .crypto_utils import decrypt_fragment
from .exceptions import ReconstructionError, ValidationError
from .file_utils import validate_existing_file, validate_existing_json_file
from .utils import ensure_dir, json_dump_pretty, safe_filename, sha256_bytes, sha256_file, write_bytes


def reconstruct_hidden_state(
    *,
    carrier_path: Path,
    reconstruction_path: Path,
    out_dir: Path,
    max_file_size_bytes: int = 5 * 1024 * 1024,
) -> dict[str, Any]:
    validate_existing_file(carrier_path, max_size_bytes=max_file_size_bytes)
    validate_existing_json_file(reconstruction_path, max_size_bytes=max_file_size_bytes)

    ensure_dir(out_dir)
    parsed_carrier = parse_carrier(carrier_path)

    try:
        reconstruction = json.loads(reconstruction_path.read_text(encoding="utf-8"))
    except UnicodeDecodeError as exc:
        raise ValidationError("Reconstruction object must be valid UTF-8 JSON.") from exc
    except JSONDecodeError as exc:
        raise ValidationError("Reconstruction object is not valid JSON.") from exc

    if not isinstance(reconstruction, dict):
        raise ReconstructionError("The reconstruction object root must be a JSON object.")

    declared_digest = reconstruction.get("carrier_file_digest", {}).get("value")
    if not declared_digest:
        raise ReconstructionError("The reconstruction object is missing carrier_file_digest.value.")

    actual_digest = sha256_file(carrier_path)
    if declared_digest != actual_digest:
        raise ReconstructionError(
            "Carrier digest mismatch. The reconstruction object does not match the supplied Datamorphed file."
        )

    state_id = reconstruction.get("state_id")
    if not state_id:
        raise ReconstructionError("The reconstruction object is missing state_id.")

    fragments = reconstruction.get("fragments")
    if not isinstance(fragments, list) or not fragments:
        raise ReconstructionError("The reconstruction object contains no valid fragments.")

    state_key_material = reconstruction.get("state_key_material")
    plaintext_fragments: list[tuple[int, bytes]] = []
    payload = parsed_carrier.payload

    for fragment in fragments:
        if not isinstance(fragment, dict):
            raise ReconstructionError("A fragment entry is not a JSON object.")

        try:
            start = int(fragment["source_offset"])
            length = int(fragment["length"])
            order = int(fragment["order"])
            cipher_suite = str(fragment["cipher_suite"])
            iv_b64url = str(fragment["iv_b64url"])
        except KeyError as exc:
            raise ReconstructionError(f"A fragment is missing a required field: {exc}") from exc
        except (TypeError, ValueError) as exc:
            raise ReconstructionError("A fragment contains an invalid numeric or string field.") from exc

        end = start + length
        if start < 0 or length <= 0 or end > len(payload):
            raise ReconstructionError("A fragment offset or length is outside the decoded payload region.")

        key_material = fragment.get("key_material")
        if not isinstance(key_material, dict):
            raise ReconstructionError("A fragment is missing valid key_material.")

        ciphertext = payload[start:end]
        plaintext = decrypt_fragment(
            ciphertext=ciphertext,
            cipher_suite=cipher_suite,
            iv_b64url=iv_b64url,
            key_material=key_material,
            state_key_material=state_key_material,
        )
        plaintext_fragments.append((order, plaintext))

    recovered_bytes = b"".join(
        data for _, data in sorted(plaintext_fragments, key=lambda item: item[0])
    )

    output_name = (
        reconstruction.get("expected_output", {}).get("filename")
        or f"{safe_filename(str(state_id))}.bin"
    )
    output_path = out_dir / output_name
    write_bytes(output_path, recovered_bytes)

    summary = {
        "carrier_input": str(carrier_path),
        "reconstruction_object": str(reconstruction_path),
        "state_id": state_id,
        "output_path": str(output_path),
        "output_sha256": sha256_bytes(recovered_bytes),
        "output_size_bytes": len(recovered_bytes),
    }

    summary_path = out_dir / f"reconstruct-summary-{safe_filename(str(state_id))}.json"
    json_dump_pretty(summary, summary_path)
    summary["summary_path"] = str(summary_path)
    return summary