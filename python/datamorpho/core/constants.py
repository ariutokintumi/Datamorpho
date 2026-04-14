from __future__ import annotations

from pathlib import Path

DEMO_VERSION = "0.001-demo-jtxt"
SPEC_VERSION = "0.001"
SUPPORTED_CARRIERS = {"jpeg", "jpg", "txt"}
SUPPORTED_LAYOUTS = {"sparse", "sparse-with-chaff"}
DEFAULT_LAYOUT = "sparse-with-chaff"
DEFAULT_MAX_FILE_SIZE_BYTES = 5 * 1024 * 1024
DEFAULT_MAX_STATES = 5
MIN_FRAGMENT_SIZE = 32
MAX_FRAGMENTS_PER_STATE = 8
# DMB-0.001 (Datamorpho Binary Block) header constants per spec Section 13
DMB_MAGIC = b"DMOR"                         # 4 bytes
DMB_VERSION = b"0.001"                      # 5 bytes ASCII
DMB_MANIFEST_ENCODING = 0x01                # UTF-8 JSON
DMB_FLAGS = 0x00                            # reserved in v0.001
DMB_RESERVED = b"\x00" * 8                  # 8 bytes, must be zero in v0.001
DMB_FIXED_HEADER_SIZE = 4 + 5 + 1 + 1 + 8 + 8 + 8  # 35 bytes
# TXT Datamorpho Envelope (DTE-0.001) markers per spec Section 14
TXT_BEGIN_MARKER = "===DATAMORPHO-BEGIN==="
TXT_END_MARKER = "===DATAMORPHO-END==="
DEFAULT_OUT_DIR = Path(".")
SIMPLE_SUITE = "simple"
HARDENED_SUITE = "hardened"
SUPPORTED_SUITES = {SIMPLE_SUITE, HARDENED_SUITE}
SIMPLE_FRAGMENT_SUITES = (
    "AES-256-GCM",
    "AES-256-CTR+HMAC-SHA-256",
)
HARDENED_FRAGMENT_SUITES = (
    "RSA-OAEP-4096+AES-256-GCM",
    "RSA-OAEP-4096+AES-256-CTR+HMAC-SHA-256",
)
AES_KEY_SIZE_BYTES = 32
AES_GCM_IV_BYTES = 12
AES_CTR_COUNTER_BYTES = 16
HMAC_SHA256_KEY_SIZE_BYTES = 32
RSA_BITS = 4096