from __future__ import annotations

from pathlib import Path
from typing import Any

from .constants import DEFAULT_LAYOUT, DEMO_VERSION
from .utils import detect_output_mime, new_id, now_iso


def make_public_manifest(
    *,
    carrier_profile: str,
    layout_strategy: str,
    state_entries: list[dict[str, Any]],
) -> dict[str, Any]:
    return {
        "datamorpho_version": DEMO_VERSION,
        "spec_target": "0.001",
        "manifest_type": "public-manifest",
        "carrier_profile": carrier_profile,
        "layout_strategy": layout_strategy or DEFAULT_LAYOUT,
        "created_at": now_iso(),
        "website_demo_scope": {
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
    reconstruction_object_digest: str,
) -> dict[str, Any]:
    return {
        "state_id": state_id,
        "declared_output": {
            "filename": hidden_file.name,
            "mime": detect_output_mime(hidden_file),
        },
        "trigger": {
            "type": "manual",
            "description": "Demo release when the matching reconstruction object is provided.",
        },
        "morphostorage": {
            "kind": "accompanying-file",
            "description": "Use the reconstruction object file generated alongside the carrier output.",
        },
        "reconstruction_object_digest": {
            "algorithm": "sha256",
            "value": reconstruction_object_digest,
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
        "datamorpho_version": DEMO_VERSION,
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
        "expected_output": {
            "filename": hidden_file.name,
            "mime": detect_output_mime(hidden_file),
        },
        "original_file": {
            "filename": hidden_file.name,
            "size_bytes": hidden_file.stat().st_size,
        },
        "state_key_material": state_key_material,
        "fragments": fragments,
    }