from __future__ import annotations

from pathlib import Path
from typing import Any

from .constants import DEFAULT_LAYOUT, SPEC_VERSION
from .utils import detect_output_mime, new_id, now_iso


# Map carrier profile strings to the carrier kind for the manifest.
_PROFILE_TO_CARRIER = {
    "jpeg-trailer": "jpeg",
    "txt-envelope": "txt",
    "pdf-incremental": "pdf",
}


def make_public_manifest(
    *,
    carrier_profile: str,
    layout_strategy: str,
    state_entries: list[dict[str, Any]],
) -> dict[str, Any]:
    carrier = _PROFILE_TO_CARRIER.get(carrier_profile, carrier_profile)
    return {
        "datamorpho_version": SPEC_VERSION,
        "manifest_type": "public",
        "carrier": carrier,
        "profile": carrier_profile,
        "layout_strategy": layout_strategy or DEFAULT_LAYOUT,
        "created_at": now_iso(),
        "x-demo_scope": {
            "supported_carriers": ["jpeg", "txt"],
            "notes": [
                "This first public demo implementation supports JPEG and TXT only.",
                "The protocol specification may define additional profiles outside this demo implementation.",
            ],
        },
        "states": state_entries,
    }


def make_public_state_descriptor(
    *,
    state_id: str,
    hidden_file: Path,
    reconstruction_digest: str,
    morphostorage_text: str = "Accompanying reconstruction object file generated alongside the carrier output.",
) -> dict[str, Any]:
    return {
        "state_id": state_id,
        "state_filename": hidden_file.name,
        "state_media_type": detect_output_mime(hidden_file),
        "triggers": [
            {
                "trigger_id": "t1",
                "type": "custom",
                "value": "manual-release",
                "description": "Demo release when the matching reconstruction object is provided.",
            },
        ],
        "morphostorage": [
            {
                "type": "text",
                "value": morphostorage_text,
            },
        ],
        "reconstruction_digest": {
            "algorithm": "sha256",
            "value": reconstruction_digest,
        },
    }


def make_reconstruction_object(
    *,
    carrier_profile: str,
    state_id: str,
    carrier_digest: str,
    hidden_file: Path,
    layout_strategy: str,
    suite_profile: str,
    state_key_material: dict[str, Any] | None,
    fragments: list[dict[str, Any]],
    suites_used: list[str],
) -> dict[str, Any]:
    return {
        "datamorpho_version": SPEC_VERSION,
        "object_type": "reconstruction",
        "reconstruction_id": new_id("reconstruction"),
        "state_id": state_id,
        "carrier_profile": carrier_profile,
        "created_at": now_iso(),
        "layout_strategy": layout_strategy,
        "reassembly": "concat-by-order",
        "suite_profile": suite_profile,
        "suites_used": suites_used,
        "carrier_file_digest": {
            "algorithm": "sha256",
            "value": carrier_digest,
        },
        "state_filename": hidden_file.name,
        "state_media_type": detect_output_mime(hidden_file),
        "original_file": {
            "filename": hidden_file.name,
            "size_bytes": hidden_file.stat().st_size,
        },
        "state_key_material": state_key_material,
        "fragments": fragments,
    }