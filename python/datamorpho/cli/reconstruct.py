from __future__ import annotations

import argparse
import json
import sys
from pathlib import Path

from datamorpho.core.constants import DEFAULT_MAX_FILE_SIZE_BYTES
from datamorpho.core.exceptions import DatamorphoError
from datamorpho.core.reconstructor import reconstruct_hidden_state


def build_parser() -> argparse.ArgumentParser:
    parser = argparse.ArgumentParser(
        description="Reconstruct one hidden state from a Datamorphed JPEG or TXT carrier.",
        epilog=(
            "Datamorpho reference implementation\n"
            "Website:       https://datamorpho.io\n"
            "Specification: https://datamorpho.io/specification\n"
            "Examples:      https://datamorpho.io/examples\n"
        ),
        formatter_class=argparse.RawDescriptionHelpFormatter,
    )
    parser.add_argument(
        "--carrier",
        required=True,
        type=Path,
        help="Path to the Datamorphed carrier file.",
    )
    parser.add_argument(
        "--reconstruction",
        required=True,
        type=Path,
        help="Path to the reconstruction object JSON.",
    )
    parser.add_argument(
        "--out-dir",
        type=Path,
        default=Path("./recovered"),
        help="Output directory.",
    )
    parser.add_argument(
        "--max-file-size-bytes",
        type=int,
        default=DEFAULT_MAX_FILE_SIZE_BYTES,
        help="Maximum allowed size for the carrier file and reconstruction object in this demo.",
    )
    return parser


def main() -> int:
    parser = build_parser()
    args = parser.parse_args()
    try:
        summary = reconstruct_hidden_state(
            carrier_path=args.carrier,
            reconstruction_path=args.reconstruction,
            out_dir=args.out_dir,
            max_file_size_bytes=args.max_file_size_bytes,
        )
    except DatamorphoError as exc:
        print(json.dumps({"ok": False, "error": str(exc)}, ensure_ascii=False), file=sys.stderr)
        return 1

    print(json.dumps({"ok": True, "result": summary}, ensure_ascii=False, indent=2))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())