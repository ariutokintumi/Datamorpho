from __future__ import annotations

import json
from dataclasses import dataclass
from pathlib import Path

from .constants import (
    DMB_FLAGS,
    DMB_FIXED_HEADER_SIZE,
    DMB_MAGIC,
    DMB_MANIFEST_ENCODING,
    DMB_RESERVED,
    DMB_VERSION,
    SPEC_VERSION,
    TXT_BEGIN_MARKER,
    TXT_END_MARKER,
)
from .exceptions import CarrierError
from .utils import b64url_decode, b64url_encode, json_dumps_canonical


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
    if trailer.startswith(DMB_MAGIC):
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
    # DMB-0.001 binary block per spec Section 13
    return (
        base_bytes
        + DMB_MAGIC                                     # 4 bytes: "DMOR"
        + DMB_VERSION                                   # 5 bytes: "0.001"
        + bytes([DMB_MANIFEST_ENCODING])                # 1 byte:  0x01 (UTF-8 JSON)
        + bytes([DMB_FLAGS])                            # 1 byte:  0x00
        + len(manifest_bytes).to_bytes(8, "big")        # 8 bytes: manifest length
        + len(payload).to_bytes(8, "big")               # 8 bytes: payload length
        + DMB_RESERVED                                  # 8 bytes: zero
        + manifest_bytes
        + payload
    )


def parse_jpeg_carrier(carrier_bytes: bytes) -> ParsedCarrier:
    eoi_index = _find_first_jpeg_eoi(carrier_bytes)
    trailer = carrier_bytes[eoi_index + 2 :]
    if not trailer.startswith(DMB_MAGIC):
        raise CarrierError("The JPEG carrier does not contain a Datamorpho trailer block immediately after the original EOI marker.")

    if len(trailer) < DMB_FIXED_HEADER_SIZE:
        raise CarrierError("The JPEG Datamorpho trailer is truncated.")

    # Validate DMB-0.001 fixed header fields
    version = trailer[4:9]
    if version != DMB_VERSION:
        raise CarrierError(f"Unsupported DMB version: {version!r}")

    # Offsets within the trailer: magic(4) + version(5) + encoding(1) + flags(1) = 11
    manifest_len = int.from_bytes(trailer[11:19], "big")
    payload_len = int.from_bytes(trailer[19:27], "big")
    # reserved bytes at 27:35 -- ignored per spec

    manifest_start = DMB_FIXED_HEADER_SIZE
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
    payload_b64url = b64url_encode(payload)
    # DTE-0.001 envelope per spec Section 14
    block = (
        "\n\n\n"
        f"{TXT_BEGIN_MARKER}\n"
        f"Datamorpho-Version: {SPEC_VERSION}\n"
        f"Carrier-Profile: {TXT_PROFILE}\n"
        "Manifest-Encoding: json-utf8\n"
        "Payload-Encoding: base64url\n"
        f"Manifest-Length: {len(manifest_json.encode('utf-8'))}\n"
        f"Payload-Length: {len(payload)}\n"
        "\n"
        f"{manifest_json}\n"
        "\n"
        f"{payload_b64url}\n"
        f"{TXT_END_MARKER}\n"
    )
    return (base_text + block).encode(encoding)


def parse_txt_carrier(carrier_bytes: bytes) -> ParsedCarrier:
    encoding = _detect_text_encoding(carrier_bytes)
    text = carrier_bytes.decode(encoding)

    if TXT_BEGIN_MARKER not in text or TXT_END_MARKER not in text:
        raise CarrierError("The TXT carrier does not contain a complete Datamorpho envelope.")

    envelope = text.split(TXT_BEGIN_MARKER, 1)[1].split(TXT_END_MARKER, 1)[0]

    # Split header section (before first blank line) from body
    parts = envelope.split("\n\n", 1)
    if len(parts) < 2:
        raise CarrierError("The TXT Datamorpho envelope is missing the header/body separator.")
    body = parts[1]

    # Body contains: manifest JSON, blank line, base64url payload
    body_parts = body.split("\n\n", 1)
    if len(body_parts) < 2:
        raise CarrierError("The TXT Datamorpho envelope is missing the manifest/payload separator.")

    manifest_section = body_parts[0].strip()
    payload_section = body_parts[1].strip()
    # Remove trailing end marker remnants if any
    if payload_section.endswith("\n"):
        payload_section = payload_section.rstrip("\n")

    manifest = json.loads(manifest_section)
    payload = b64url_decode(payload_section)
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