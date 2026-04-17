# Security

**Security page:** https://datamorpho.io/security  
**Public issues:** https://github.com/ariutokintumi/datamorpho/issues  
**Private reports:** g@evvm.org

## What Datamorpho aims to protect

- controlled disclosure of hidden states
- clear separation between public declaration and private reconstruction
- state-specific reconstruction semantics
- attack-cost increase through structure and layout strategy

## What it does not claim

- not impossible to break
- not a substitute for sound cryptography
- not a defense against compromised endpoints
- not a guarantee against poor operational security

## What matters most in practice

- correct cryptographic implementation
- correct reconstruction-object handling
- careful key-material protection
- clear validation and error handling

## Areas especially worth reviewing

- carrier profile parsing and validation
- digest cross-binding behavior
- reconstruction-object interpretation
- key-material serialization and handling
- sparse and sparse-with-chaff reconstruction semantics
- browser-compatible tooling limitations

## Project security posture

Datamorpho is a layered resistance architecture. It is strongest when the protocol, tooling, examples, operational handling, and cryptographic decisions are all treated seriously instead of relying on any one mechanism alone.

The project is currently in its first public specification and tooling phase. Early implementations should be treated carefully and reviewed critically. Correctness, clear semantics, and public review matter more right now than feature breadth.

## Demo tooling logging policy

When the public create and reconstruct tools go live in browser form, Datamorpho.io will clearly disclose that successful demo-tool use may log original file hashes, result file hashes, and reconstruction objects for security and abuse-response reasons. Users who need privacy should run the open-source tooling locally instead of using the public demo.

## When to use public issues

Use [public GitHub issues](https://github.com/ariutokintumi/datamorpho/issues) or [discussions](https://github.com/ariutokintumi/datamorpho/discussions) for non-sensitive problems such as:

- wording errors
- specification clarity problems
- implementation bugs without security sensitivity
- documentation fixes
- example inconsistencies

## When to report privately

Report potentially sensitive issues privately by email when public disclosure would create meaningful risk, such as:

- exploitable implementation flaws
- unsafe reconstruction handling
- severe cryptographic misuse in live tooling

## Responsible reporting

For security-sensitive reports, contact **g@evvm.org**.

Include:
- a clear description of the issue
- the affected component
- reproduction steps if possible
- why you believe the issue should be handled privately first
