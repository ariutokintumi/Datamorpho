from __future__ import annotations

import base64
import hashlib
import json
import mimetypes
import os
import re
import uuid
from datetime import UTC, datetime
from pathlib import Path
from typing import Any


def now_iso() -> str:
    return datetime.now(UTC).replace(microsecond=0).isoformat().replace("+00:00", "Z")


def new_id(prefix: str) -> str:
    return f"{prefix}-{uuid.uuid4().hex}"


def sha256_bytes(data: bytes) -> str:
    """Return SHA-256 digest as base64url without padding (spec Section 7.6)."""
    return b64url_encode(hashlib.sha256(data).digest())


def sha256_file(path: Path) -> str:
    """Return SHA-256 digest as base64url without padding (spec Section 7.6)."""
    hasher = hashlib.sha256()
    with path.open("rb") as handle:
        for chunk in iter(lambda: handle.read(1024 * 1024), b""):
            hasher.update(chunk)
    return b64url_encode(hasher.digest())


def b64url_encode(data: bytes) -> str:
    return base64.urlsafe_b64encode(data).decode("ascii").rstrip("=")


def b64url_decode(text: str) -> bytes:
    padding = "=" * ((4 - (len(text) % 4)) % 4)
    return base64.urlsafe_b64decode(text + padding)


def b64std_encode(data: bytes, wrap: int | None = None) -> str:
    raw = base64.b64encode(data).decode("ascii")
    if not wrap or wrap <= 0:
        return raw
    return "\n".join(raw[i : i + wrap] for i in range(0, len(raw), wrap))


def b64std_decode(text: str) -> bytes:
    compact = re.sub(r"\s+", "", text)
    return base64.b64decode(compact)


def json_dumps_canonical(value: Any) -> str:
    return json.dumps(value, ensure_ascii=False, separators=(",", ":"), sort_keys=True)


def json_dump_pretty(value: Any, path: Path) -> None:
    path.write_text(json.dumps(value, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")


def ensure_dir(path: Path) -> None:
    path.mkdir(parents=True, exist_ok=True)


def safe_filename(name: str) -> str:
    cleaned = re.sub(r"[^A-Za-z0-9._-]+", "-", name).strip(".-")
    return cleaned or "file"


def file_extension(path: Path) -> str:
    return path.suffix.lower().lstrip(".")


def detect_output_mime(path: Path) -> str:
    mime, _ = mimetypes.guess_type(path.name)
    return mime or "application/octet-stream"


def write_bytes(path: Path, data: bytes) -> None:
    path.write_bytes(data)


def read_bytes(path: Path) -> bytes:
    return path.read_bytes()


def env_flag(name: str, default: bool = False) -> bool:
    value = os.getenv(name)
    if value is None:
        return default
    return value.strip().lower() in {"1", "true", "yes", "on"}
