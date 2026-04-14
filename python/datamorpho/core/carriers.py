from __future__ import annotations

import json
from dataclasses import dataclass
from pathlib import Path

from .constants import (
    CHUNK_WRAP,
    JPEG_MAGIC,
    TXT_BEGIN_MARKER,
    TXT_END_MARKER,
    TXT_MANIFEST_BEGIN,
    TXT_MANIFEST_END,
    TXT_PAYLOAD_BEGIN,
    TXT_PAYLOAD_END,
)
from .exceptions import CarrierError
from .utils import b64std_decode, b64std_encode, json_dumps_canonical


@dataclass(slots=True)
class ParsedCarrier:
    carrier_profile: str
    manifest: dict
    payload: bytes
    text_encoding: str | None = None


JPEG_PROFILE = "jpeg-trailer"
TXT_PROFILE = "txt-envelope"


def _find_first_jpeg_eoi(base_bytes: bytes) -> int:
    if len(base_bytes) < 4 or not base_bytes.startswith(b"\xff\xd8"):
        raise CarrierError("Input JPEG must begin with the SOI marker 0xFFD8.")
    marker_index = base_bytes.find(b"\xff\xd9", 2)
    if marker_index == -1:
        raise CarrierError("Input JPEG does not contain a valid EOI marker 0xFFD9.")
    return marker_index


def ensure_jpeg_is_clean(base_bytes: bytes) -> int:
    eoi_index = _find_first_jpeg_eoi(base_bytes)
    trailer = base_bytes[eoi_index + 2 :]
    if trailer.startswith(JPEG_MAGIC):
        raise CarrierError("Input JPEG already appears to be Datamorphed.")
    if trailer:
        raise CarrierError(
            "Input JPEG contains trailing bytes after the original EOI marker. "
            "This first demo creator only accepts clean JPEG carriers with no trailer data."
        )
    return eoi_index


def build_jpeg_carrier(base_bytes: bytes, manifest: dict, payload: bytes) -> bytes:
    ensure_jpeg_is_clean(base_bytes)
    manifest_bytes = json_dumps_canonical(manifest).encode("utf-8")
    return (
        base_bytes
        + JPEG_MAGIC
        + len(manifest_bytes).to_bytes(8, "big")
        + len(payload).to_bytes(8, "big")
        + manifest_bytes
        + payload
    )


def parse_jpeg_carrier(carrier_bytes: bytes) -> ParsedCarrier:
    eoi_index = _find_first_jpeg_eoi(carrier_bytes)
    trailer = carrier_bytes[eoi_index + 2 :]
    if not trailer.startswith(JPEG_MAGIC):
        raise CarrierError("The JPEG carrier does not contain a Datamorpho trailer block immediately after the original EOI marker.")

    header_start = len(JPEG_MAGIC)
    if len(trailer) < header_start + 16:
        raise CarrierError("The JPEG Datamorpho trailer is truncated.")

    manifest_len = int.from_bytes(trailer[header_start : header_start + 8], "big")
    payload_len = int.from_bytes(trailer[header_start + 8 : header_start + 16], "big")
    manifest_start = header_start + 16
    manifest_end = manifest_start + manifest_len
    payload_end = manifest_end + payload_len
    if payload_end > len(trailer):
        raise CarrierError("The JPEG Datamorpho block declares invalid lengths.")

    manifest = json.loads(trailer[manifest_start:manifest_end].decode("utf-8"))
    payload = trailer[manifest_end:payload_end]
    return ParsedCarrier(carrier_profile=JPEG_PROFILE, manifest=manifest, payload=payload)


def _detect_text_encoding(carrier_bytes: bytes) -> str:
    if carrier_bytes.startswith(b"\xef\xbb\xbf"):
        return "utf-8-sig"
    try:
        carrier_bytes.decode("utf-8")
        return "utf-8"
    except UnicodeDecodeError:
        return "cp1252"


def ensure_txt_is_clean(base_text: str) -> None:
    if TXT_BEGIN_MARKER in base_text or TXT_END_MARKER in base_text:
        raise CarrierError("Input TXT already appears to contain a Datamorpho envelope.")


def build_txt_carrier(base_text: str, manifest: dict, payload: bytes, encoding: str) -> bytes:
    ensure_txt_is_clean(base_text)
    manifest_json = json.dumps(manifest, indent=2, ensure_ascii=True)
    payload_b64 = b64std_encode(payload, wrap=CHUNK_WRAP)
    block = (
        "\n\n\n"
        f"{TXT_BEGIN_MARKER}\n"
        f"{TXT_MANIFEST_BEGIN}\n"
        f"{manifest_json}\n"
        f"{TXT_MANIFEST_END}\n"
        f"{TXT_PAYLOAD_BEGIN}\n"
        f"{payload_b64}\n"
        f"{TXT_PAYLOAD_END}\n"
        f"{TXT_END_MARKER}\n"
    )
    return (base_text + block).encode(encoding)


def parse_txt_carrier(carrier_bytes: bytes) -> ParsedCarrier:
    encoding = _detect_text_encoding(carrier_bytes)
    text = carrier_bytes.decode(encoding)

    markers = [TXT_BEGIN_MARKER, TXT_MANIFEST_BEGIN, TXT_MANIFEST_END, TXT_PAYLOAD_BEGIN, TXT_PAYLOAD_END, TXT_END_MARKER]
    if not all(marker in text for marker in markers):
        raise CarrierError("The TXT carrier does not contain a complete Datamorpho envelope.")

    manifest_section = text.split(TXT_MANIFEST_BEGIN, 1)[1].split(TXT_MANIFEST_END, 1)[0].strip()
    payload_section = text.split(TXT_PAYLOAD_BEGIN, 1)[1].split(TXT_PAYLOAD_END, 1)[0].strip()
    manifest = json.loads(manifest_section)
    payload = b64std_decode(payload_section)
    return ParsedCarrier(carrier_profile=TXT_PROFILE, manifest=manifest, payload=payload, text_encoding=encoding)


def build_carrier(carrier_kind: str, base_bytes: bytes, manifest: dict, payload: bytes) -> tuple[str, bytes]:
    if carrier_kind == "jpeg":
        return JPEG_PROFILE, build_jpeg_carrier(base_bytes, manifest, payload)
    if carrier_kind == "txt":
        encoding = _detect_text_encoding(base_bytes)
        base_text = base_bytes.decode(encoding)
        return TXT_PROFILE, build_txt_carrier(base_text, manifest, payload, encoding)
    raise CarrierError(f"Unsupported carrier kind: {carrier_kind}")


def parse_carrier(path: Path) -> ParsedCarrier:
    data = path.read_bytes()
    if path.suffix.lower() in {".jpg", ".jpeg"}:
        return parse_jpeg_carrier(data)
    if path.suffix.lower() == ".txt":
        return parse_txt_carrier(data)
    raise CarrierError("Unsupported carrier extension in this first implementation.")