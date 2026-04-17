<?php
declare(strict_types=1);
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Specification v0.001 - Normative Core Specification</title>
    <meta name="description" content="Datamorpho Specification v0.001 - the normative core specification for multi-state files, public manifests, concealed payloads, and reconstruction objects.">
    <meta name="theme-color" content="#0f172a">

    <style>
        @font-face {
            font-family: "Unifont";
            src: url("/assets/fonts/unifont-17.0.04.otf") format("opentype");
            font-display: swap;
        }

        :root {
            --bg: #f6f7f8;
            --surface: #ffffff;
            --surface-alt: #eef2f7;
            --text: #0f172a;
            --muted: #475569;
            --line: #d6dbe3;
            --accent: #0b57d0;
            --accent-strong: #083b8a;
            --accent-soft: #dbeafe;
            --warning-soft: #fef3c7;
            --shadow: 0 14px 50px rgba(15, 23, 42, 0.08);

            --font-body: "Unifont", "Courier New", monospace;
            --font-display: "Unifont", "Courier New", monospace;

            --radius: 18px;
            --radius-sm: 12px;
            --max: 1180px;
            --space-1: 0.5rem;
            --space-2: 0.75rem;
            --space-3: 1rem;
            --space-4: 1.25rem;
            --space-5: 1.5rem;
            --space-6: 2rem;
            --space-7: 3rem;
            --space-8: 4rem;
            --space-9: 5rem;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            background: linear-gradient(180deg, #fbfcfd 0%, #f6f7f8 100%);
            color: var(--text);
            font-family: var(--font-body);
            line-height: 1.72;
        }

        a {
            color: var(--accent);
            text-decoration: none;
        }

        a:hover {
            color: var(--accent-strong);
            text-decoration: underline;
        }

        .container {
            width: min(calc(100% - 2rem), var(--max));
            margin: 0 auto;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(12px);
            background: rgba(246, 247, 248, 0.9);
            border-bottom: 1px solid rgba(214, 219, 227, 0.85);
        }

        .site-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-4);
            min-height: 74px;
        }

        .brand {
            display: inline-flex;
            flex-direction: column;
            gap: 0.15rem;
            color: var(--text);
            text-decoration: none;
            min-width: 0;
        }

        .brand:hover {
            text-decoration: none;
            color: var(--text);
        }

        .brand-title {
            font-family: var(--font-display);
            font-size: 1rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .brand-subtitle {
            color: var(--muted);
            font-size: 0.84rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .nav a {
            font-size: 0.94rem;
            color: var(--muted);
            text-decoration: none;
        }

        .nav a:hover {
            color: var(--text);
        }

        .nav-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1rem;
            border-radius: 999px;
            background: var(--text);
            color: #fff !important;
            font-weight: 700;
            box-shadow: var(--shadow);
        }

        .nav-cta:hover {
            background: #1f2937;
            text-decoration: none;
        }

        .hero {
            padding: var(--space-8) 0 var(--space-7);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.85fr;
            gap: var(--space-7);
            align-items: start;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent-strong);
            font-weight: 700;
            font-size: 0.84rem;
            margin-bottom: var(--space-4);
        }

        h1, h2, h3, h4 {
            font-family: var(--font-display);
            line-height: 1.28;
        }

        .hero h1 {
            margin: 0 0 var(--space-4);
            font-size: clamp(1.8rem, 4vw, 3.4rem);
        }

        .lead {
            margin: 0 0 var(--space-5);
            font-size: 1.07rem;
            color: var(--muted);
            max-width: 760px;
        }

        .hero-actions {
            display: flex;
            gap: var(--space-3);
            flex-wrap: wrap;
            margin-bottom: var(--space-5);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 48px;
            padding: 0.9rem 1.15rem;
            border-radius: 999px;
            border: 1px solid transparent;
            font-weight: 700;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .btn:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            background: var(--accent-strong);
            color: #fff;
        }

        .btn-secondary {
            background: #fff;
            color: var(--text);
            border-color: var(--line);
        }

        .btn-secondary:hover {
            border-color: #b7c3d4;
            color: var(--text);
        }

        .panel,
        .card,
        .callout,
        .toc {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .panel,
        .card,
        .callout,
        .toc {
            padding: var(--space-5);
        }

        .panel h2,
        .toc h2 {
            margin-top: 0;
            margin-bottom: var(--space-3);
            font-size: 1.08rem;
        }

        .meta-list,
        .toc ul,
        .feature-list {
            margin: 0;
            padding-left: 1.1rem;
        }

        .meta-list li + li,
        .toc li + li,
        .feature-list li + li {
            margin-top: 0.45rem;
        }

        section {
            padding: var(--space-7) 0;
        }

        .section-head {
            margin-bottom: var(--space-6);
            max-width: 920px;
        }

        .section-kicker {
            margin: 0 0 var(--space-2);
            color: var(--accent);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
        }

        .section-title {
            margin: 0 0 var(--space-3);
            font-size: clamp(1.45rem, 3vw, 2.45rem);
        }

        .section-text {
            margin: 0;
            color: var(--muted);
            font-size: 1.02rem;
        }

        .grid-2,
        .grid-3,
        .grid-4 {
            display: grid;
            gap: var(--space-4);
        }

        .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

        .card h3 {
            margin: 0 0 var(--space-2);
            font-size: 1rem;
        }

        .card p {
            margin: 0;
            color: var(--muted);
        }

        .soft {
            background: var(--surface-alt);
            border-color: #d8e0ea;
        }

        .placeholder {
            margin-top: var(--space-4);
            padding: var(--space-5);
            border: 1px dashed #afbccd;
            border-radius: var(--radius-sm);
            background: #f9fbfd;
            color: var(--muted);
            font-size: 0.96rem;
        }

        .placeholder strong {
            color: var(--text);
            display: block;
            margin-bottom: 0.35rem;
        }

        .spec-block {
            display: grid;
            gap: var(--space-4);
        }

        .spec-item {
            padding: var(--space-4);
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
        }

        .spec-item strong {
            display: block;
            margin-bottom: 0.4rem;
        }

        .callout {
            background: var(--warning-soft);
        }

        .callout strong {
            display: block;
            margin-bottom: 0.35rem;
        }

        .callout p {
            margin: 0;
            color: var(--text);
        }

        .site-footer {
            padding: var(--space-7) 0 var(--space-8);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr 1fr 1fr;
            gap: var(--space-5);
        }

        .footer-col h3 {
            margin: 0 0 var(--space-3);
            font-size: 0.98rem;
        }

        .footer-col p,
        .footer-col li {
            color: var(--muted);
            margin: 0;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-col li + li {
            margin-top: 0.55rem;
        }

        .footer-bottom {
            margin-top: var(--space-6);
            padding-top: var(--space-4);
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 0.92rem;
        }

        code {
            font-family: var(--font-display);
            font-size: 0.92em;
            background: #eff4fa;
            border: 1px solid #dbe5f0;
            padding: 0.12rem 0.34rem;
            border-radius: 8px;
        }

        @media (max-width: 1024px) {
            .hero-grid,
            .grid-4,
            .grid-3,
            .grid-2,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .site-header-inner {
                align-items: flex-start;
                padding: 1rem 0;
            }

            .nav {
                gap: var(--space-3);
            }
        }

        @media (max-width: 720px) {
            .site-header {
                position: static;
            }

            .site-header-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .nav {
                justify-content: flex-start;
            }

            .panel,
            .card,
            .callout,
            .toc {
                padding: var(--space-4);
            }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="container site-header-inner">
        <a class="brand" href="/" aria-label="Datamorpho home">
            <span class="brand-title">DATAMORPHO</span>
            <span class="brand-subtitle">Normative core specification · v0.001</span>
        </a>

        <nav class="nav" aria-label="Primary navigation">
            <a href="/">Home</a>
            <a href="/specification">Specification</a>
            <a href="/whitepaper">Whitepaper</a>
            <a href="/examples">Examples</a>
            <a href="/community">Community</a>
            <a href="/tools" class="nav-cta">Tools</a>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="eyebrow">Datamorpho Specification v0.001</div>
                <h1>Normative core specification for multi-state files</h1>
                <p class="lead">
                    This document defines the normative structure of Datamorpho v0.001: the public manifest, concealed payload semantics, reconstruction object model, digest binding, and the initial carrier profiles for JPEG, TXT, and PDF.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#scope">Read the core sections</a>
                    <a class="btn btn-secondary" href="/whitepaper">Open the Whitepaper</a>
                    <a class="btn btn-secondary" href="https://github.com/ariutokintumi/datamorpho/blob/main/docs/specification/Datamorpho-Specification-v0.001.md" target="_blank" rel="noopener noreferrer">Read .md in repository</a>
                    <a class="btn btn-secondary" href="https://github.com/ariutokintumi/datamorpho/raw/main/docs/specification/Datamorpho-Specification-v0.001.pdf" target="_blank" rel="noopener noreferrer">Download PDF</a>
                </div>

                <ul class="meta-list">
                    <li><strong>Status:</strong> Public Draft</li>
                    <li><strong>Version:</strong> 0.001</li>
                    <li><strong>Companion document:</strong> Datamorpho Whitepaper</li>
                    <li><strong>Contact:</strong> <a href="mailto:g@evvm.org">g@evvm.org</a></li>
                </ul>
            </div>

            <aside class="toc" aria-label="Table of contents">
                <h2>On this page</h2>
                <ul>
                    <li><a href="#scope">What the specification defines</a></li>
                    <li><a href="#model">Core object model</a></li>
                    <li><a href="#profiles">Carrier profiles</a></li>
                    <li><a href="#manifest">Public manifest</a></li>
                    <li><a href="#reconstruction">Reconstruction objects</a></li>
                    <li><a href="#layout">Layout strategy</a></li>
                    <li><a href="#boundaries">What the standard does not define</a></li>
                    <li><a href="#review">Discussion and review</a></li>
                </ul>
            </aside>
        </div>
    </section>

    <section id="scope">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Scope</p>
                <h2 class="section-title">What the specification defines</h2>
                <p class="section-text">
                    Datamorpho v0.001 is the first normative public release of the protocol. It defines the file-level structure and semantics required for interoperable Datamorpho creation and reconstruction, while intentionally leaving many deployment-specific behaviors out of scope.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>What is standardized</h3>
                    <ul class="feature-list">
                        <li>public declaration of Datamorphosis</li>
                        <li>state-specific reconstruction object model</li>
                        <li>digest cross-binding</li>
                        <li>canonical payload offset semantics</li>
                        <li>layout strategy semantics</li>
                        <li>JPEG, TXT, and PDF carrier profiles</li>
                    </ul>
                </article>

                <article class="card soft">
                    <h3>What is intentionally out of scope</h3>
                    <ul class="feature-list">
                        <li>viewer UX details</li>
                        <li>trigger execution engines</li>
                        <li>wallet-specific release logic</li>
                        <li>smart contract business logic</li>
                        <li>secret delivery infrastructure beyond the reconstruction object model</li>
                        <li>implementation-specific UI and workflow choices</li>
                    </ul>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem;">
                <strong>Important boundary</strong>
                <p>
                    Datamorpho standardizes the structure of files and reconstruction semantics. It does not attempt to standardize every future viewer, decryption interface, or trigger-verification workflow.
                </p>
            </div>
        </div>
    </section>

    <section id="model">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Core model</p>
                <h2 class="section-title">Four logical layers define a Datamorphed file</h2>
                <p class="section-text">
                    Datamorpho organizes a file into clear protocol layers so implementations can reason about discoverability, hidden bytes, and reconstruction without ambiguity.
                </p>
            </div>

            <div class="grid-4">
                <article class="card">
                    <h3>Base Carrier</h3>
                    <p>The original visible file that remains valid in its native format.</p>
                </article>
                <article class="card">
                    <h3>Public Manifest</h3>
                    <p>The declared metadata layer that identifies states, triggers, MorphoStorage, and reconstruction digests.</p>
                </article>
                <article class="card">
                    <h3>Concealed Payload</h3>
                    <p>The byte region or regions from which hidden states may later be reconstructed.</p>
                </article>
                <article class="card">
                    <h3>Reconstruction Object</h3>
                    <p>The state-specific secret-bearing object that provides fragment map, key material, and reconstruction instructions.</p>
                </article>
            </div>

            <img src="/assets/diagrams/architecture.svg"
                 alt="Datamorpho architecture: a Datamorphed File containing Base Carrier, Public Manifest, and Concealed Payload layers. Combined with a Reconstruction Object it produces a verified Hidden State output. MorphoStorage optionally hosts Reconstruction Objects."
                 style="width:100%;display:block;margin:2rem auto 0;"/>
        </div>
    </section>

    <section id="profiles">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Carrier profiles</p>
                <h2 class="section-title">The first three carrier profiles</h2>
                <p class="section-text">
                    Version 0.001 begins with JPEG, TXT, and PDF. These provide a practical starting point across image, text, and structured document carriers.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3><code>jpeg-trailer</code></h3>
                    <p>A valid JPEG image followed by a Datamorpho Binary Block appended after the final end-of-image marker.</p>
                </article>

                <article class="card">
                    <h3><code>txt-envelope</code></h3>
                    <p>A visible text file followed by a terminal Datamorpho envelope containing the public manifest and encoded payload.</p>
                </article>

                <article class="card">
                    <h3><code>pdf-incremental</code></h3>
                    <p>A valid PDF followed by Datamorpho objects and payload streams appended through an incremental-update section.</p>
                </article>
            </div>

            <img src="/assets/diagrams/carrier-profiles.svg"
                 alt="Carrier profiles: JPEG appends a DMOR binary trailer block after the original image bytes. TXT appends a Datamorpho envelope block after visible text. PDF uses an incremental update structure and is defined in the protocol but not yet in demo tooling."
                 style="width:100%;display:block;margin:2rem auto 0;"/>
        </div>
    </section>

    <section id="manifest">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Public declaration</p>
                <h2 class="section-title">The public manifest makes Datamorphosis explicit</h2>
                <p class="section-text">
                    Datamorpho is not steganography. The standard requires a public declaration that hidden states exist and where reconstruction information may later be found.
                </p>
            </div>

            <div class="spec-block">
                <div class="spec-item">
                    <strong>Required top-level concepts</strong>
                    <p>
                        The public manifest identifies the Datamorpho version, manifest type, carrier, profile, and the declared set of hidden states.
                    </p>
                </div>

                <div class="spec-item">
                    <strong>State descriptors</strong>
                    <p>
                        Each state descriptor identifies a <code>state_id</code>, its declared triggers, one or more MorphoStorage directions, and the expected reconstruction-object digest.
                    </p>
                </div>

                <div class="spec-item">
                    <strong>MorphoStorage</strong>
                    <p>
                        MorphoStorage is a generalized locator model. It may point to a URI, an IPFS CID, an EVM contract call, a textual instruction, or another implementation-defined retrieval direction.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="reconstruction">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Reconstruction semantics</p>
                <h2 class="section-title">A reconstruction object targets exactly one hidden state</h2>
                <p class="section-text">
                    In Datamorpho v0.001, the reconstruction object is a complete secret-bearing artifact for one target state. It contains the fragment map, ordering, layout strategy, digest binding, cryptographic information, and key material required to reconstruct that hidden state.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>What it identifies</h3>
                    <ul class="feature-list">
                        <li>the target <code>state_id</code></li>
                        <li>layout strategy</li>
                        <li>carrier file digest</li>
                        <li>fragment offsets and lengths</li>
                        <li>fragment order</li>
                        <li>state or fragment key material</li>
                    </ul>
                </article>

                <article class="card soft">
                    <h3>What it allows</h3>
                    <ul class="feature-list">
                        <li>independent release of states</li>
                        <li>non-sequential state publication</li>
                        <li>different cryptographic suites within one state</li>
                        <li>shared key material or fragment-level overrides</li>
                        <li>deterministic reconstruction from sparse byte spans</li>
                    </ul>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem;">
                <strong>Normative assumption in v0.001</strong>
                <p>
                    The reconstruction object is treated as the secret object. If it is already sensitive because it reveals the fragment map and suite instructions, there is no strong architectural reason to forbid it from also carrying the key material needed for reconstruction.
                </p>
            </div>
        </div>
    </section>

    <section id="layout">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Layout strategy</p>
                <h2 class="section-title">Sparse and sparse-with-chaff</h2>
                <p class="section-text">
                    Datamorpho v0.001 standardizes two payload layout strategies so implementations can choose between efficiency and additional ambiguity depending on carrier size, bandwidth, and practical constraints.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3><code>sparse</code></h3>
                    <p>
                        Meaningful bytes are non-contiguous and only the referenced spans matter. This option remains useful for very large carriers or environments where payload size, storage, or transfer costs matter significantly.
                    </p>
                </article>

                <article class="card">
                    <h3><code>sparse-with-chaff</code></h3>
                    <p>
                        Meaningful bytes are non-contiguous and unreferenced bytes are intentionally present as ambiguity-increasing material. Those bytes may include chaff, filler, or bytes belonging to other states.
                    </p>
                </article>
            </div>

            <img src="/assets/diagrams/sparse-layout.svg"
                 alt="Sparse vs sparse-with-chaff byte layout. Sparse: fragments in blue with empty gaps. Sparse-with-chaff: same fragments but gaps filled with amber chaff bytes that obscure fragment boundaries. Logical reconstruction order is independent from physical offset order."
                 style="width:100%;display:block;margin:2rem auto 0;"/>
        </div>
    </section>

    <section id="boundaries">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Boundaries</p>
                <h2 class="section-title">What the standard does not try to do</h2>
                <p class="section-text">
                    Datamorpho deliberately keeps the core specification focused. It standardizes the structure of multi-state files and reconstruction semantics, but avoids overreaching into every implementation-specific decision.
                </p>
            </div>

            <div class="grid-3">
                <article class="card soft">
                    <h3>Not a viewer standard</h3>
                    <p>The standard does not define a universal viewer UX or interpretation flow.</p>
                </article>

                <article class="card soft">
                    <h3>Not a trigger engine</h3>
                    <p>Trigger declaration is standardized, but trigger execution logic is not.</p>
                </article>

                <article class="card soft">
                    <h3>Not a wallet-specific protocol</h3>
                    <p>Onchain integrations are possible, but wallet logic and business rules remain implementation-specific.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="review">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Review</p>
                <h2 class="section-title">This specification is meant to be discussed in public</h2>
                <p class="section-text">
                    Datamorpho is an open protocol project. Public review, implementation feedback, examples, and criticism are part of how the standard should mature.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Read the Whitepaper</h3>
                    <p>Use the whitepaper for the conceptual rationale, security framing, and long-term project direction.</p>
                    <p style="margin-top: 1rem;"><a href="/whitepaper">Open whitepaper →</a></p>
                </article>

                <article class="card">
                    <h3>Open the repository</h3>
                    <p>Specification work, tooling, examples, and project structure live in the public repository.</p>
                    <p style="margin-top: 1rem;"><a href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">View GitHub repo →</a></p>
                </article>

                <article class="card">
                    <h3>Join the discussion</h3>
                    <p>Questions, proposals, and design discussion should happen in public and remain easy to review.</p>
                    <p style="margin-top: 1rem;"><a href="https://github.com/ariutokintumi/datamorpho/discussions" target="_blank" rel="noopener noreferrer">Join discussions →</a></p>
                </article>
            </div>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>Datamorpho</h3>
                <p>
                    An open file standard for multi-state concealed content, built as open infrastructure for secure distribution, controlled disclosure, and future-proof digital objects.
                </p>
            </div>

            <div class="footer-col">
                <h3>Pages</h3>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/specification">Specification</a></li>
                    <li><a href="/whitepaper">Whitepaper</a></li>
                    <li><a href="/tools">Tools</a></li>
                    <li><a href="/examples">Examples</a></li>
                    <li><a href="/roadmap">Roadmap</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Community</h3>
                <ul>
                    <li><a href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">GitHub</a></li>
                    <li><a href="https://github.com/ariutokintumi/datamorpho/discussions" target="_blank" rel="noopener noreferrer">Discussions</a></li>
                    <li><a href="https://x.com/datamorpho" target="_blank" rel="noopener noreferrer">Announcements</a></li>
                    <li><a href="/donate">Donate</a></li>
                    <li><a href="mailto:g@evvm.org">g@evvm.org</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>More</h3>
                <ul>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/glossary">Glossary</a></li>
                    <li><a href="/changelog">Changelog</a></li>
                    <li><a href="/security">Security</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; <?php echo htmlspecialchars($year, ENT_QUOTES, 'UTF-8'); ?> Datamorpho. Contact: <a href="mailto:g@evvm.org">g@evvm.org</a>.
        </div>
    </div>
</footer>
</body>
</html>