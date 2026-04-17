# Datamorpho Python Reference Tools

**Website:** https://datamorpho.io  
**Specification:** https://datamorpho.io/specification  
**Examples:** https://datamorpho.io/examples  
**Repository:** https://github.com/ariutokintumi/datamorpho

This directory contains the first reference implementation for creating and reconstructing Datamorphed files in the first public demo wave.

## Scope of this first implementation

- Supported carriers: **JPEG** and **TXT**
- Not enabled in this implementation: **PDF**
- Max default carrier file size: **5 MiB**
- Max default hidden states: **5**
- Max default hidden-state file size: **5 MiB each**
- Intended role: **reference implementation**, testing basis, fixtures, vectors, and later JavaScript migration

## Why this implementation exists first

The Datamorpho website (https://datamorpho.io) will later use browser-side JavaScript, not server-side Python processing.

For that reason, the correct path is:

1. build and test the Python reference implementation,
2. validate the creator and reconstructor behavior,
3. produce stable outputs and reconstruction objects,
4. and only then migrate the logic to browser-side JavaScript for the public website demo.

This Python implementation is therefore the canonical first executable reference.

## Supported cryptographic profiles

This first implementation provides two user-selectable profiles.

### `simple`

Designed for speed, clarity, and strong enough personal use.

This profile alternates randomly by fragment between:

- `AES-256-GCM`
- `AES-256-CTR+HMAC-SHA-256`

Important:

- fragments are encrypted **once**
- different fragments of the same state may use different suites
- this is aligned with the Datamorpho model of heterogeneous fragment protection

### `hardened`

Designed for stronger compartmentalization while staying compatible with a later browser migration path.

This profile alternates randomly by fragment between:

- `RSA-OAEP-4096+AES-256-GCM`
- `RSA-OAEP-4096+AES-256-CTR+HMAC-SHA-256`

Important:

- the fragment payload is still encrypted **once**
- RSA is used to wrap fragment secret material
- this is **envelope encryption**, not “encrypting the whole payload twice”
- this keeps the model aligned with Datamorpho’s fragment-level suite mixing

## Layout strategies

Supported:

- `sparse`
- `sparse-with-chaff`

Default:

- `sparse-with-chaff`

## Current behavior and safety limits

This first implementation intentionally rejects some cases to reduce ambiguity and bugs.

### JPEG

- only accepts clean JPEG carriers
- rejects JPEGs that already contain a Datamorpho trailer
- rejects JPEGs that contain arbitrary trailing bytes after the original EOI marker

### TXT

- rejects TXT files that already contain a Datamorpho envelope
- does **not** require UTF-8 input
- attempts to preserve detected text encoding on output

## Command line usage

### Create

```bash
python3 -m datamorpho.cli.create \
  --carrier ./base.jpg \
  --state ./secret1.txt \
  --state ./secret2.bin \
  --suite simple \
  --layout sparse-with-chaff \
  --morphostorage "https://example.com/reconstruction-state-1.json" \
  --out-dir ./out
```

`--morphostorage` is optional. It sets the free-text location hint for the reconstruction object that is embedded in the public manifest. Defaults to a generic description if omitted.

### Reconstruct

```bash
python3 -m datamorpho.cli.reconstruct \
  --carrier ./out/base.datamorpho.jpg \
  --reconstruction ./out/reconstruction-state-1.json \
  --out-dir ./recovered
```

## Outputs

### Creator output

The creator produces:

- one Datamorphed carrier file
- one public manifest JSON copy
- one reconstruction object JSON per hidden state
- one creation summary JSON

### Reconstructor output

The reconstructor produces:

- one recovered hidden-state file
- one reconstruction summary JSON

## Real fixture examples

The repository includes real carrier fixture sets for JPEG and TXT.

### JPEG fixture — `datamorpho/tests/jpg_real_test/`

A four-image set: one base carrier (`1.jpg`) and three hidden states (`2.jpg`, `3.jpg`, `4.jpg`).

```
jpg_real_test/
├── 1.jpg                        base JPEG carrier
├── 2.jpg                        hidden state 1
├── 3.jpg                        hidden state 2
├── 4.jpg                        hidden state 3
└── result/
    ├── 1.datamorpho.jpg         datamorphed output carrier
    ├── 1.public-manifest.json   public manifest (embedded copy)
    ├── reconstruction-state-1.json
    ├── reconstruction-state-2.json
    ├── reconstruction-state-3.json
    ├── 1/ → carrier + RO + reconstructed output for state 1
    ├── 2/ → carrier + RO + reconstructed output for state 2
    └── 3/ → carrier + RO + reconstructed output for state 3
```

Created with `--suite simple --layout sparse-with-chaff --morphostorage "unknown"`.

Each `result/N/` subdirectory is self-contained: it includes a copy of the datamorphed carrier, the matching reconstruction object, and the reconstructed hidden state output.

## Testing

Tests are part of the repo on purpose.

They should remain in the repository because they help:

- validate the implementation
- catch regressions
- produce confidence for future JavaScript migration
- support future interoperability work

Run tests with:

```bash
PYTHONPATH=. pytest -q
```

## What should NOT be committed

The following should not be committed to the repository:

- __pycache__/
- .pytest_cache/
- *.pyc

These are local Python cache artifacts, not source code.

## Dependencies

Current dependency:

- cryptography

Install with:

```bash
pip install -r requirements.txt
```

## Important note

This implementation is a reference/demo implementation.

It is suitable for:

- local experiments
- protocol learning
- vectors and fixtures
- future browser porting work
- implementation review

It is **not** presented as a production-grade privacy service.
For privacy-sensitive usage, users should run their own implementation locally or on infrastructure they control.

---

Protocol documentation and free web tools at **https://datamorpho.io**