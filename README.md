# DATAMORPHO

**Datamorpho** is an open file standard for **multi-state files**.

A Datamorphed file remains valid in its original format while containing one or more **sealed hidden states** that can be reconstructed later using a state-specific reconstruction object.

Datamorpho is **not steganography**.  
A Datamorphed file is expected to **publicly declare** that hidden states exist and where reconstruction information may later be found.

## Core idea

Datamorpho separates a file into four conceptual layers:

1. **Base carrier** — the ordinary visible file
2. **Public manifest** — declares Datamorphosis, states, triggers, and MorphoStorage
3. **Concealed payload** — hidden bytes embedded in the carrier
4. **Reconstruction object** — the secret-bearing object used to reconstruct one hidden state

A hidden state may be built from:

- multiple fragments
- non-monotonic offsets
- sparse layout
- sparse-with-chaff layout
- heterogeneous cryptographic suites across fragments of the same state

## Why Datamorpho matters

Datamorpho enables:

- controlled disclosure of hidden file states
- staged media and document releases
- archives and delayed publication workflows
- games, unlockable items, and interactive assets
- financial and auction disclosure flows
- censorship-resistant wide distribution with later reveal
- digital objects that evolve without changing the original carrier file

A strong example is NFT pre-reveal / reveal without moving metadata, but Datamorpho is designed as a broader file standard, not as an NFT-only system.

## Current version

**Specification version:** `0.001`  
**Status:** Public Draft

Initial carrier profiles:

- JPEG
- TXT
- PDF

Immediate next media targets after first release:

- Audio
- Video

## Documents

- [Specification](./docs/specification/Datamorpho-Specification-v0.001.md)
- [Whitepaper](./docs/whitepaper/Datamorpho-Whitepaper-v0.001.md)
- [Changelog](./CHANGELOG.md)

## Reference tooling

Planned and/or in-progress reference tooling:

- Python file creation tooling
- Python reconstruction / decrypt / output tooling
- JavaScript library for browser detection and processing
- Example files and interoperability vectors

## Repository structure

- `docs/` — specification, whitepaper, glossary, roadmap, FAQ, diagrams
- `python/` — Python tooling to create datamorphed files, their re-constructors and for reconstructing them.
- `js/` — JavaScript/browser library to recognize and process datamorphed JPEGs on any website
- `examples/` — sample files, manifests, reconstruction objects, vectors
- `assets/` — diagrams, branding, screenshots
- `research/` — research notes and future carrier ideas
- `site/` — website source code and assets
- `tools/` — other repo and validation scripts

## Project status

Datamorpho is currently in the **open specification + first tooling** phase.

The initial focus is:

1. finalize the specification
2. publish the whitepaper
3. release first Python tooling
4. release first JavaScript/browser library
5. publish examples and test vectors

## Discussion

- GitHub Discussions
- GitHub Issues for specification and implementation issues

## Author

**Germán Abal** — [@ariutokintumi](https://x.com/ariutokintumi) — g@evvm.org — code, architecture, implementation

## Contributors

- Ben Dumoulin — [@BenDumoulin](https://x.com/BenDumoulin) — early PoC implementation support
- R. Benson Evans — [@iglobecreator](https://x.com/iglobecreator) — early PoC research support
- Eduardo — [@metaversearchi_](https://x.com/metaversearchi_) — early PoC design support

## License

Reference software is intended to be released under the **MIT License**.