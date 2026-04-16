<?php
declare(strict_types=1);
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Whitepaper v0.001 - Public Technical Release</title>
    <meta name="description" content="Datamorpho Whitepaper v0.001 - a public technical whitepaper for an open file standard for multi-state concealed content.">
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
            --success-soft: #dcfce7;
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
            line-height: 1.76;
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
            font-size: 1.08rem;
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
            padding: var(--space-5);
        }

        .panel h2,
        .toc h2 {
            margin-top: 0;
            margin-bottom: var(--space-3);
            font-size: 1.08rem;
        }

        .toc ul,
        .feature-list {
            margin: 0;
            padding-left: 1.1rem;
        }

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

        .highlight {
            padding: var(--space-4);
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
            background: #fff;
        }

        .highlight strong {
            display: block;
            margin-bottom: 0.35rem;
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

        .quote {
            padding: var(--space-5);
            border-left: 4px solid var(--accent);
            background: #fff;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            box-shadow: var(--shadow);
        }

        .quote p {
            margin: 0;
            font-size: 1.02rem;
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
            <span class="brand-subtitle">Whitepaper · Public technical release · v0.001</span>
        </a>

        <nav class="nav" aria-label="Primary navigation">
            <a href="/">Home</a>
            <a href="/specification">Specification</a>
            <a href="/whitepaper">Whitepaper</a>
            <a href="/tools">Tools</a>
            <a href="/examples">Examples</a>
            <a href="/community" class="nav-cta">Community</a>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="eyebrow">Datamorpho Whitepaper v0.001</div>
                <h1>A public technical release for multi-state files</h1>
                <p class="lead">
                    Datamorpho is an open file standard and protocol model for files that remain valid in their original format while also containing one or more sealed hidden states. These hidden states can later be reconstructed through state-specific reconstruction objects.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#abstract">Start reading</a>
                    <a class="btn btn-secondary" href="/specification">Open the Specification</a>
                    <a class="btn btn-secondary" href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">View on GitHub</a>
                </div>

                <div class="quote">
                    <p>
                        Datamorpho is not steganography. Hidden states are declared, not denied.
                    </p>
                </div>
            </div>

            <aside class="toc" aria-label="Whitepaper contents">
                <h2>On this page</h2>
                <ul>
                    <li><a href="#abstract">Abstract</a></li>
                    <li><a href="#why">Why Datamorpho exists</a></li>
                    <li><a href="#model">The Datamorpho model</a></li>
                    <li><a href="#security">Security and layered resistance</a></li>
                    <li><a href="#use-cases">Use cases</a></li>
                    <li><a href="#public-good">Open protocol and public good</a></li>
                    <li><a href="#origin">Origin and acknowledgements</a></li>
                    <li><a href="#next">What comes next</a></li>
                </ul>
            </aside>
        </div>
    </section>

    <section id="abstract">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Abstract</p>
                <h2 class="section-title">A declared latent-state file architecture</h2>
                <p class="section-text">
                    Datamorpho is a file standard and protocol model for creating files that preserve an ordinary visible representation while also containing one or more concealed alternate states. These states are not merely appended encrypted blobs, and Datamorpho is not steganography. A Datamorphed file is expected to declare that hidden states exist and to indicate where reconstruction information may later be found, while still withholding the structural and secret material needed to recover those states.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>What it combines</h3>
                    <ul class="feature-list">
                        <li>public declaration</li>
                        <li>concealed payloads</li>
                        <li>state-specific reconstruction objects</li>
                        <li>cryptographic agility</li>
                        <li>sparse and sparse-with-chaff layout</li>
                    </ul>
                </article>

                <article class="card soft">
                    <h3>What it claims</h3>
                    <p>
                        Datamorpho does not claim magical invulnerability. It claims layered resistance: structured composition of cryptography, payload layout, reconstruction secrecy, and digest binding.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section id="why">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Motivation</p>
                <h2 class="section-title">Why Datamorpho exists</h2>
                <p class="section-text">
                    Traditional files are static. Traditional encrypted files are often monolithic. Traditional reveal patterns frequently require changing the public metadata location. Datamorpho addresses a different need: files that can remain ordinary and valid while also carrying hidden future states that can only be reconstructed later.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Controlled disclosure</h3>
                    <p>Distribute or preserve the carrier first, then release reconstruction later.</p>
                </article>

                <article class="card">
                    <h3>Static location, changing meaning</h3>
                    <p>Keep the file in place while allowing its reconstructable state to change over time.</p>
                </article>

                <article class="card">
                    <h3>Long-lived latent content</h3>
                    <p>Create digital objects that can survive and evolve without replacing the carrier itself.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="model">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Model</p>
                <h2 class="section-title">The four-layer Datamorpho model</h2>
                <p class="section-text">
                    The protocol is easiest to understand as four coordinated layers: a base carrier, a public manifest, a concealed payload, and one or more state-specific reconstruction objects.
                </p>
            </div>

            <div class="grid-4">
                <article class="card">
                    <h3>Base Carrier</h3>
                    <p>The visible file that remains valid and ordinary to standard readers.</p>
                </article>
                <article class="card">
                    <h3>Public Manifest</h3>
                    <p>The explicit declaration that hidden states exist and where reconstruction may later be found.</p>
                </article>
                <article class="card">
                    <h3>Concealed Payload</h3>
                    <p>The bytes from which hidden states can later be reconstructed.</p>
                </article>
                <article class="card">
                    <h3>Reconstruction Object</h3>
                    <p>The secret-bearing artifact that reconstructs one target state.</p>
                </article>
            </div>

            <div class="placeholder">
                <strong>Diagram placeholder: Datamorpho conceptual model</strong>
                Show the base carrier, public manifest, concealed payload, reconstruction object, and MorphoStorage as a clean conceptual architecture diagram.
            </div>
        </div>
    </section>

    <section id="security">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Security model</p>
                <h2 class="section-title">Layered resistance instead of one secret trick</h2>
                <p class="section-text">
                    Datamorpho’s strength comes from composition. It is strongest when cryptography, sparse layout, optional chaff, non-monotonic fragment ordering, state-specific reconstruction, and digest cross-binding work together.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Why it can be highly resistant</h3>
                    <ul class="feature-list">
                        <li>cryptography protects meaning</li>
                        <li>sparse placement avoids one obvious contiguous hidden blob</li>
                        <li>chaff increases ambiguity and attack cost</li>
                        <li>logical reconstruction order is independent from physical byte order</li>
                        <li>each state may have its own reconstruction object and release timing</li>
                    </ul>
                </article>

                <article class="card soft">
                    <h3>What it does not claim</h3>
                    <ul class="feature-list">
                        <li>not impossible to break</li>
                        <li>not a substitute for sound cryptography</li>
                        <li>not a defense against compromised endpoints</li>
                        <li>not a guarantee against operational mistakes</li>
                        <li>not dependent on “secret algorithms” for credibility</li>
                    </ul>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem;">
                <strong>v0.001 position</strong>
                <p>
                    The reconstruction object is a complete secret-bearing artifact. If it already reveals the fragment map, ordering, and suite instructions, there is no strong architectural reason to prohibit it from also carrying the key material required for reconstruction.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Layout strategy</p>
                <h2 class="section-title">Sparse and sparse-with-chaff</h2>
                <p class="section-text">
                    Datamorpho v0.001 standardizes two layout strategies. Both avoid a single obvious monolithic hidden object, but they optimize for different practical constraints.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Sparse</h3>
                    <p>
                        Useful when a creator wants non-contiguous hidden spans without paying the storage or transfer cost of additional chaff. This can matter for very large files and bandwidth-sensitive environments.
                    </p>
                </article>

                <article class="card">
                    <h3>Sparse-with-Chaff</h3>
                    <p>
                        Useful when additional ambiguity matters. Unreferenced bytes may be filler, chaff, or bytes belonging to other states, increasing the cost of naïve extraction.
                    </p>
                </article>
            </div>

            <div class="placeholder">
                <strong>Diagram placeholder: sparse vs sparse-with-chaff</strong>
                Show a technical byte-field example with meaningful spans, unrelated bytes, optional chaff, and logical order separate from physical order.
            </div>
        </div>
    </section>

    <section id="use-cases">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Use cases</p>
                <h2 class="section-title">Where Datamorpho matters in practice</h2>
                <p class="section-text">
                    Datamorpho is broader than any one niche. It can support controlled disclosure across media, documents, games, archives, and other digital systems that benefit from early distribution and later reconstruction.
                </p>
            </div>

            <div class="grid-3">
                <article class="card soft">
                    <h3>Games & Interactive Assets</h3>
                    <p>Unlockable items, rewards, lore objects, and latent assets.</p>
                </article>
                <article class="card soft">
                    <h3>Archives & Delayed Publication</h3>
                    <p>Long-lived files whose additional states are reconstructable later.</p>
                </article>
                <article class="card soft">
                    <h3>Documents & Controlled Releases</h3>
                    <p>Reports, certificates, policies, and alternate document states.</p>
                </article>
                <article class="card soft">
                    <h3>Financial & Auction Flows</h3>
                    <p>State-linked disclosure patterns where some information should emerge later.</p>
                </article>
                <article class="card soft">
                    <h3>Static Metadata Reveal Patterns</h3>
                    <p>Reveal without moving the public metadata location or replacing the carrier file.</p>
                </article>
                <article class="card soft">
                    <h3>Wide Distribution with Later Reveal</h3>
                    <p>Distribute the file broadly first, then release the reconstruction object at the correct time.</p>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Current carriers</p>
                <h2 class="section-title">JPEG, TXT, and PDF now. Audio and video next.</h2>
                <p class="section-text">
                    Version 0.001 focuses on JPEG, TXT, and PDF. The next immediate targets after the first tooling release are audio and video, where Datamorpho’s distribution-first, reconstruction-later model becomes especially powerful.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Why audio and video are natural next targets</h3>
                    <p>
                        They benefit strongly from staged distribution, synchronized reveal, and future-proof handling of media states.
                    </p>
                </article>

                <article class="card">
                    <h3>Why they are not in v0.001 yet</h3>
                    <p>
                        They introduce larger payload sizes, streaming constraints, re-encoding issues, and more demanding implementation work.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section id="public-good">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Public good</p>
                <h2 class="section-title">Open standard, open tooling, open infrastructure</h2>
                <p class="section-text">
                    Datamorpho is being developed as a public protocol project: an open specification, an open whitepaper, open-source reference tooling, free examples, and a free public tooling layer through datamorpho.io.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Open specification</h3>
                    <p>The protocol is publicly documented and discussable.</p>
                </article>
                <article class="card">
                    <h3>Open-source tooling</h3>
                    <p>Python and JavaScript tooling are intended to remain collaboration-friendly and reusable.</p>
                </article>
                <article class="card">
                    <h3>Free public service layer</h3>
                    <p>Datamorpho.io is intended to offer free create and reconstruct flows and future MorphoStorage support.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="origin">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Origin</p>
                <h2 class="section-title">From early prototype to open protocol</h2>
                <p class="section-text">
                    Datamorpho’s public origin traces back to an early prototype showcased at ETHMexico 2022, where the project appeared as a finalist and already framed the idea of dynamic files and static-location reveal patterns. The present whitepaper and specification are the first formal open protocol releases.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Author</h3>
                    <p>Germán Abal — <a href="mailto:g@evvm.org">g@evvm.org</a></p>
                </article>

                <article class="card soft">
                    <h3>Early prototype contributors</h3>
                    <p>
                        Ben Dumoulin — early PoC implementation support<br>
                        R. Benson Evans — early PoC research support<br>
                        Eduardo — early PoC design support
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section id="next">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">What comes next</p>
                <h2 class="section-title">The project now moves through implementation, examples, and public review</h2>
                <p class="section-text">
                    Datamorpho is currently in the public specification and first tooling phase. The next steps are practical tooling, browser compatibility, examples, testing, and broader ecosystem feedback.
                </p>
            </div>

            <div class="grid-4">
                <article class="card">
                    <h3>1. Specification</h3>
                    <p>Freeze the first public protocol release.</p>
                </article>
                <article class="card">
                    <h3>2. Tooling</h3>
                    <p>Release Python and JavaScript implementations.</p>
                </article>
                <article class="card">
                    <h3>3. Public Tools</h3>
                    <p>Offer free create and reconstruct flows on Datamorpho.io.</p>
                </article>
                <article class="card">
                    <h3>4. Expansion</h3>
                    <p>Move into audio, video, interoperability, and broader review.</p>
                </article>
            </div>

            <div class="hero-actions" style="margin-top: 2rem;">
                <a class="btn btn-primary" href="/specification">Read the Specification</a>
                <a class="btn btn-secondary" href="/tools">Open the Tools</a>
                <a class="btn btn-secondary" href="/community">Join the Discussion</a>
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
                    <li><a href="https://datamorpho.io/security.php">Security</a></li>
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