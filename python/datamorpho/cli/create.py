from __future__ import annotations

import argparse
import json
import sys
from pathlib import Path

from datamorpho.core.constants import DEFAULT_LAYOUT, DEFAULT_MAX_FILE_SIZE_BYTES, DEFAULT_MAX_STATES, SUPPORTED_LAYOUTS, SUPPORTED_SUITES
from datamorpho.core.creator import create_datamorpho
from datamorpho.core.exceptions import DatamorphoError


def build_parser() -> argparse.ArgumentParser:
    parser = argparse.ArgumentParser(
        description=(
            "Create a Datamorphed JPEG or TXT carrier from one base file and one or more hidden states. "
            "The maximum number of states is controlled by --max-states."
        )
    )
    parser.add_argument("--carrier", required=True, type=Path, help="Path to the base carrier file (JPEG or TXT).")
    parser.add_argument(
        "--state",
        required=True,
        action="append",
        type=Path,
        help="Path to a hidden state file. Repeat as needed, subject to --max-states.",
    )
    parser.add_argument(
        "--suite",
        choices=sorted(SUPPORTED_SUITES),
        default="simple",
        help="Cryptographic suite profile: simple or hardened.",
    )
    parser.add_argument("--layout", choices=sorted(SUPPORTED_LAYOUTS), default=DEFAULT_LAYOUT, help="Payload layout strategy.")
    parser.add_argument("--out-dir", type=Path, default=Path("./out"), help="Output directory.")
    parser.add_argument("--max-file-size-bytes", type=int, default=DEFAULT_MAX_FILE_SIZE_BYTES)
    parser.add_argument("--max-states", type=int, default=DEFAULT_MAX_STATES)
    return parser


def main() -> int:
    parser = build_parser()
    args = parser.parse_args()
    try:
        summary = create_datamorpho(
            carrier_path=args.carrier,
            state_paths=args.state,
            out_dir=args.out_dir,
            suite_profile=args.suite,
            layout_strategy=args.layout,
            max_file_size_bytes=args.max_file_size_bytes,
            max_states=args.max_states,
        )
    except DatamorphoError as exc:
        print(json.dumps({"ok": False, "error": str(exc)}, ensure_ascii=False), file=sys.stderr)
        return 1

    print(json.dumps({"ok": True, "result": summary}, ensure_ascii=False, indent=2))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())