from __future__ import annotations

from pathlib import Path

from .constants import DEFAULT_MAX_FILE_SIZE_BYTES, DEFAULT_MAX_STATES, SUPPORTED_CARRIERS
from .exceptions import ValidationError
from .utils import file_extension


def validate_state_count(state_paths: list[Path], max_states: int = DEFAULT_MAX_STATES) -> None:
    if not state_paths:
        raise ValidationError("At least one hidden state file is required.")
    if len(state_paths) > max_states:
        raise ValidationError(f"A maximum of {max_states} hidden state files is allowed in this demo.")


def validate_existing_file(path: Path, max_size_bytes: int = DEFAULT_MAX_FILE_SIZE_BYTES) -> None:
    if not path.exists() or not path.is_file():
        raise ValidationError(f"File does not exist or is not a file: {path}")

    size = path.stat().st_size
    if size <= 0:
        raise ValidationError(f"File is empty: {path}")

    if size > max_size_bytes:
        raise ValidationError(
            f"File exceeds the configured size limit of {max_size_bytes} bytes: {path}"
        )


def validate_existing_json_file(path: Path, max_size_bytes: int = DEFAULT_MAX_FILE_SIZE_BYTES) -> None:
    validate_existing_file(path, max_size_bytes=max_size_bytes)
    if file_extension(path) != "json":
        raise ValidationError(f"Reconstruction object must be a .json file: {path}")


def validate_supported_carrier(path: Path) -> str:
    extension = file_extension(path)
    if extension == "jpg":
        extension = "jpeg"

    if extension not in SUPPORTED_CARRIERS:
        raise ValidationError(
            f"Unsupported carrier format '{path.suffix}'. This first implementation only supports JPEG and TXT."
        )

    return extension


def validate_distinct_input_paths(paths: list[Path]) -> None:
    resolved = [path.resolve() for path in paths]
    if len(set(resolved)) != len(resolved):
        raise ValidationError("All input files must be different paths in this demo implementation.")