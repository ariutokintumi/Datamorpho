from __future__ import annotations

import json
import subprocess
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parents[2]
PYTHON_DIR = ROOT


def _write_minimal_jpeg(path: Path) -> None:
    path.write_bytes(b"\xff\xd8\xff\xd9")


def _write_text(path: Path, text: str, encoding: str = "utf-8") -> None:
    path.write_text(text, encoding=encoding)


def _run(args: list[str], cwd: Path) -> subprocess.CompletedProcess[str]:
    env = dict(**__import__("os").environ)
    env["PYTHONPATH"] = str(PYTHON_DIR)
    return subprocess.run(args, cwd=cwd, env=env, text=True, capture_output=True, check=False)


def test_jpeg_simple_roundtrip(tmp_path: Path) -> None:
    carrier = tmp_path / "base.jpg"
    state = tmp_path / "secret.txt"
    out_dir = tmp_path / "out"
    recovered_dir = tmp_path / "recovered"
    _write_minimal_jpeg(carrier)
    _write_text(state, "hello from a hidden state")

    create = _run([
        sys.executable,
        "-m",
        "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state),
        "--suite", "simple",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode == 0, create.stderr
    created = json.loads(create.stdout)
    reconstruction = Path(created["result"]["reconstruction_objects"][0])
    carrier_out = Path(created["result"]["carrier_output"])

    reconstruct = _run([
        sys.executable,
        "-m",
        "datamorpho.cli.reconstruct",
        "--carrier", str(carrier_out),
        "--reconstruction", str(reconstruction),
        "--out-dir", str(recovered_dir),
    ], cwd=PYTHON_DIR)
    assert reconstruct.returncode == 0, reconstruct.stderr
    result = json.loads(reconstruct.stdout)
    recovered_path = Path(result["result"]["output_path"])
    assert recovered_path.read_text(encoding="utf-8") == "hello from a hidden state"


def test_txt_hardened_roundtrip(tmp_path: Path) -> None:
    carrier = tmp_path / "base.txt"
    state = tmp_path / "secret.bin"
    out_dir = tmp_path / "out"
    recovered_dir = tmp_path / "recovered"
    _write_text(carrier, "Visible carrier text.\n", encoding="cp1252")
    state.write_bytes(b"\x00\x01secret\x02\x03")

    create = _run([
        sys.executable,
        "-m",
        "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state),
        "--suite", "hardened",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode == 0, create.stderr
    created = json.loads(create.stdout)
    reconstruction = Path(created["result"]["reconstruction_objects"][0])
    carrier_out = Path(created["result"]["carrier_output"])

    reconstruct = _run([
        sys.executable,
        "-m",
        "datamorpho.cli.reconstruct",
        "--carrier", str(carrier_out),
        "--reconstruction", str(reconstruction),
        "--out-dir", str(recovered_dir),
    ], cwd=PYTHON_DIR)
    assert reconstruct.returncode == 0, reconstruct.stderr
    result = json.loads(reconstruct.stdout)
    recovered_path = Path(result["result"]["output_path"])
    assert recovered_path.read_bytes() == b"\x00\x01secret\x02\x03"


def test_reject_existing_txt_envelope(tmp_path: Path) -> None:
    carrier = tmp_path / "base.txt"
    state = tmp_path / "secret.txt"
    _write_text(carrier, "hello\n===DATAMORPHO-BEGIN===\n")
    _write_text(state, "secret")
    out_dir = tmp_path / "out"
    create = _run([
        sys.executable,
        "-m",
        "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state),
        "--suite", "simple",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode != 0
    assert "already appears to contain a Datamorpho envelope" in create.stderr


def test_reject_jpeg_with_trailing_bytes(tmp_path: Path) -> None:
    carrier = tmp_path / "base.jpg"
    state = tmp_path / "secret.txt"
    carrier.write_bytes(b"\xff\xd8\xff\xd9EXTRA")
    _write_text(state, "secret")
    out_dir = tmp_path / "out"
    create = _run([
        sys.executable,
        "-m",
        "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state),
        "--suite", "simple",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode != 0
    assert "only accepts clean JPEG carriers" in create.stderr