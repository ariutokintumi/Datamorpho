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


# ---------------------------------------------------------------------------
# Additional roundtrip coverage
# ---------------------------------------------------------------------------


def test_jpeg_hardened_roundtrip(tmp_path: Path) -> None:
    carrier = tmp_path / "base.jpg"
    state = tmp_path / "secret.bin"
    out_dir = tmp_path / "out"
    recovered_dir = tmp_path / "recovered"
    _write_minimal_jpeg(carrier)
    state.write_bytes(b"\xde\xad\xbe\xef" * 20)

    create = _run([
        sys.executable, "-m", "datamorpho.cli.create",
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
        sys.executable, "-m", "datamorpho.cli.reconstruct",
        "--carrier", str(carrier_out),
        "--reconstruction", str(reconstruction),
        "--out-dir", str(recovered_dir),
    ], cwd=PYTHON_DIR)
    assert reconstruct.returncode == 0, reconstruct.stderr
    result = json.loads(reconstruct.stdout)
    recovered_path = Path(result["result"]["output_path"])
    assert recovered_path.read_bytes() == b"\xde\xad\xbe\xef" * 20


def test_txt_simple_roundtrip(tmp_path: Path) -> None:
    carrier = tmp_path / "base.txt"
    state = tmp_path / "secret.txt"
    out_dir = tmp_path / "out"
    recovered_dir = tmp_path / "recovered"
    _write_text(carrier, "Plain text carrier.\n")
    _write_text(state, "hidden message in simple mode")

    create = _run([
        sys.executable, "-m", "datamorpho.cli.create",
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
        sys.executable, "-m", "datamorpho.cli.reconstruct",
        "--carrier", str(carrier_out),
        "--reconstruction", str(reconstruction),
        "--out-dir", str(recovered_dir),
    ], cwd=PYTHON_DIR)
    assert reconstruct.returncode == 0, reconstruct.stderr
    result = json.loads(reconstruct.stdout)
    recovered_path = Path(result["result"]["output_path"])
    assert recovered_path.read_text(encoding="utf-8") == "hidden message in simple mode"


def test_multi_state_roundtrip(tmp_path: Path) -> None:
    carrier = tmp_path / "base.jpg"
    state1 = tmp_path / "secret1.txt"
    state2 = tmp_path / "secret2.bin"
    out_dir = tmp_path / "out"
    _write_minimal_jpeg(carrier)
    _write_text(state1, "first hidden state")
    state2.write_bytes(b"\x01\x02\x03\x04")

    create = _run([
        sys.executable, "-m", "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state1),
        "--state", str(state2),
        "--suite", "simple",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode == 0, create.stderr
    created = json.loads(create.stdout)
    assert created["result"]["state_count"] == 2

    carrier_out = Path(created["result"]["carrier_output"])
    recon_paths = [Path(p) for p in created["result"]["reconstruction_objects"]]
    assert len(recon_paths) == 2

    # Reconstruct state 1
    recovered1 = tmp_path / "recovered1"
    r1 = _run([
        sys.executable, "-m", "datamorpho.cli.reconstruct",
        "--carrier", str(carrier_out),
        "--reconstruction", str(recon_paths[0]),
        "--out-dir", str(recovered1),
    ], cwd=PYTHON_DIR)
    assert r1.returncode == 0, r1.stderr
    out1 = Path(json.loads(r1.stdout)["result"]["output_path"])
    assert out1.read_text(encoding="utf-8") == "first hidden state"

    # Reconstruct state 2
    recovered2 = tmp_path / "recovered2"
    r2 = _run([
        sys.executable, "-m", "datamorpho.cli.reconstruct",
        "--carrier", str(carrier_out),
        "--reconstruction", str(recon_paths[1]),
        "--out-dir", str(recovered2),
    ], cwd=PYTHON_DIR)
    assert r2.returncode == 0, r2.stderr
    out2 = Path(json.loads(r2.stdout)["result"]["output_path"])
    assert out2.read_bytes() == b"\x01\x02\x03\x04"


def test_sparse_layout_roundtrip(tmp_path: Path) -> None:
    carrier = tmp_path / "base.jpg"
    state = tmp_path / "secret.txt"
    out_dir = tmp_path / "out"
    recovered_dir = tmp_path / "recovered"
    _write_minimal_jpeg(carrier)
    _write_text(state, "sparse layout test")

    create = _run([
        sys.executable, "-m", "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state),
        "--suite", "simple",
        "--layout", "sparse",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode == 0, create.stderr
    created = json.loads(create.stdout)
    reconstruction = Path(created["result"]["reconstruction_objects"][0])
    carrier_out = Path(created["result"]["carrier_output"])

    reconstruct = _run([
        sys.executable, "-m", "datamorpho.cli.reconstruct",
        "--carrier", str(carrier_out),
        "--reconstruction", str(reconstruction),
        "--out-dir", str(recovered_dir),
    ], cwd=PYTHON_DIR)
    assert reconstruct.returncode == 0, reconstruct.stderr
    result = json.loads(reconstruct.stdout)
    recovered_path = Path(result["result"]["output_path"])
    assert recovered_path.read_text(encoding="utf-8") == "sparse layout test"


def test_reconstruction_digest_matches_manifest(tmp_path: Path) -> None:
    """Verify that the reconstruction_digest in the public manifest matches
    the SHA-256 of the reconstruction object computed per spec Section 7.9
    (excluding carrier_file_digest and base_file_digest)."""
    import base64
    import hashlib

    carrier = tmp_path / "base.jpg"
    state = tmp_path / "secret.txt"
    out_dir = tmp_path / "out"
    _write_minimal_jpeg(carrier)
    _write_text(state, "digest verification test")

    create = _run([
        sys.executable, "-m", "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state),
        "--suite", "simple",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode == 0, create.stderr
    created = json.loads(create.stdout)

    manifest_path = Path(created["result"]["public_manifest"])
    manifest = json.loads(manifest_path.read_text(encoding="utf-8"))
    recon_path = Path(created["result"]["reconstruction_objects"][0])
    recon = json.loads(recon_path.read_text(encoding="utf-8"))

    # Compute expected digest per spec: exclude carrier_file_digest and base_file_digest,
    # then SHA-256 as base64url-without-padding (spec Section 7.6)
    filtered = {k: v for k, v in recon.items() if k not in ("carrier_file_digest", "base_file_digest")}
    canonical = json.dumps(filtered, ensure_ascii=False, separators=(",", ":"), sort_keys=True)
    raw_digest = hashlib.sha256(canonical.encode("utf-8")).digest()
    expected_digest = base64.urlsafe_b64encode(raw_digest).decode("ascii").rstrip("=")

    actual_digest = manifest["states"][0]["reconstruction_digest"]["value"]
    assert actual_digest == expected_digest, (
        f"Manifest reconstruction_digest {actual_digest} != computed {expected_digest}"
    )


def test_manifest_field_structure(tmp_path: Path) -> None:
    """Verify that the public manifest and reconstruction object use
    spec-compliant field names and structures."""
    carrier = tmp_path / "base.jpg"
    state = tmp_path / "secret.txt"
    out_dir = tmp_path / "out"
    _write_minimal_jpeg(carrier)
    _write_text(state, "structure test")

    create = _run([
        sys.executable, "-m", "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state),
        "--suite", "simple",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode == 0, create.stderr
    created = json.loads(create.stdout)

    manifest = json.loads(Path(created["result"]["public_manifest"]).read_text(encoding="utf-8"))
    recon = json.loads(Path(created["result"]["reconstruction_objects"][0]).read_text(encoding="utf-8"))

    # Public manifest top-level
    assert manifest["datamorpho_version"] == "0.001"
    assert manifest["manifest_type"] == "public"
    assert manifest["carrier"] == "jpeg"
    assert manifest["profile"] == "jpeg-trailer"
    assert "carrier_profile" not in manifest  # old field should not be present

    # State descriptor
    state_desc = manifest["states"][0]
    assert "triggers" in state_desc and isinstance(state_desc["triggers"], list)
    assert len(state_desc["triggers"]) > 0
    assert "trigger_id" in state_desc["triggers"][0]
    assert "morphostorage" in state_desc and isinstance(state_desc["morphostorage"], list)
    assert len(state_desc["morphostorage"]) > 0
    assert "reconstruction_digest" in state_desc
    assert "reconstruction_object_digest" not in state_desc  # old field

    # Reconstruction object
    assert recon["datamorpho_version"] == "0.001"
    assert recon["object_type"] == "reconstruction"
    assert recon["reassembly"] == "concat-by-order"

    # Fragment fields
    frag = recon["fragments"][0]
    assert "offset" in frag
    assert "source_offset" not in frag  # old field
    assert "crypto_suite" in frag
    assert "cipher_suite" not in frag  # old field
    assert frag["payload_region"] == "main"


def test_jpeg_binary_block_header(tmp_path: Path) -> None:
    """Verify the raw DMB-0.001 header structure in a created JPEG."""
    carrier = tmp_path / "base.jpg"
    state = tmp_path / "secret.txt"
    out_dir = tmp_path / "out"
    _write_minimal_jpeg(carrier)
    _write_text(state, "header test")

    create = _run([
        sys.executable, "-m", "datamorpho.cli.create",
        "--carrier", str(carrier),
        "--state", str(state),
        "--suite", "simple",
        "--out-dir", str(out_dir),
    ], cwd=PYTHON_DIR)
    assert create.returncode == 0, create.stderr
    created = json.loads(create.stdout)

    carrier_out = Path(created["result"]["carrier_output"])
    data = carrier_out.read_bytes()

    # Find the JPEG EOI marker
    eoi_idx = data.find(b"\xff\xd9", 2)
    assert eoi_idx != -1
    trailer = data[eoi_idx + 2:]

    # DMB-0.001 header validation
    assert trailer[:4] == b"DMOR", f"Magic bytes: {trailer[:4]!r}"
    assert trailer[4:9] == b"0.001", f"Version: {trailer[4:9]!r}"
    assert trailer[9] == 0x01, f"Manifest encoding: {trailer[9]:#x}"
    assert trailer[10] == 0x00, f"Flags: {trailer[10]:#x}"

    manifest_len = int.from_bytes(trailer[11:19], "big")
    payload_len = int.from_bytes(trailer[19:27], "big")
    reserved = trailer[27:35]
    assert reserved == b"\x00" * 8, f"Reserved: {reserved!r}"

    # Verify lengths are consistent
    manifest_bytes = trailer[35:35 + manifest_len]
    assert len(manifest_bytes) == manifest_len
    # Manifest should be valid JSON
    parsed = json.loads(manifest_bytes.decode("utf-8"))
    assert parsed["datamorpho_version"] == "0.001"

    # Payload should match declared length
    payload_start = 35 + manifest_len
    payload_bytes = trailer[payload_start:payload_start + payload_len]
    assert len(payload_bytes) == payload_len