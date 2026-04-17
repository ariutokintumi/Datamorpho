<?php
declare(strict_types=1);
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho - Multi-state files for controlled disclosure</title>
    <meta name="description" content="Datamorpho is an open file standard for multi-state files: valid files with sealed hidden states that can be reconstructed later through state-specific reconstruction objects.">
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
            --space-9: 6rem;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: linear-gradient(180deg, #fbfcfd 0%, #f6f7f8 100%);
            color: var(--text);
            font-family: var(--font-body);
            line-height: 1.65;
        }

        a {
            color: var(--accent);
            text-decoration: none;
        }

        a:hover {
            color: var(--accent-strong);
            text-decoration: underline;
        }

        img {
            max-width: 100%;
            display: block;
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
            background: rgba(246, 247, 248, 0.88);
            border-bottom: 1px solid rgba(214, 219, 227, 0.8);
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
            font-size: 0.96rem;
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
            font-weight: 600;
            box-shadow: var(--shadow);
        }

        .nav-cta:hover {
            background: #1f2937;
            text-decoration: none;
        }

        .hero {
            padding: var(--space-9) 0 var(--space-8);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.25fr 0.9fr;
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

        .hero h1 {
            margin: 0 0 var(--space-4);
            font-family: var(--font-display);
            font-size: clamp(2rem, 4.8vw, 4rem);
            line-height: 1.16;
            letter-spacing: -0.02em;
        }

        .hero p.lead {
            margin: 0 0 var(--space-5);
            font-size: 1.14rem;
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

        .hero-note {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .hero-panel,
        .panel,
        .card,
        .callout {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .hero-panel {
            padding: var(--space-5);
        }

        .hero-panel h2 {
            margin: 0 0 var(--space-3);
            font-family: var(--font-display);
            font-size: 1.15rem;
            line-height: 1.4;
        }

        .hero-panel p {
            margin: 0 0 var(--space-4);
            color: var(--muted);
        }

        .hero-list {
            margin: 0;
            padding-left: 1.15rem;
            color: var(--text);
        }

        .hero-list li + li {
            margin-top: 0.5rem;
        }

        .tool-banner {
            margin-top: var(--space-4);
            padding: var(--space-3);
            border-radius: var(--radius-sm);
            background: var(--surface-alt);
            border: 1px dashed #c5cfdb;
            color: var(--muted);
            font-size: 0.94rem;
        }

        /* Hero panel — dark gradient style */
        .hero-panel {
            background: linear-gradient(180deg, #0f172a 0%, #172554 100%);
            border-color: transparent;
            color: #fff;
            padding: var(--space-6);
        }
        .hero-panel h2 {
            color: #fff;
        }
        .hero-panel p {
            color: rgba(255,255,255,0.84);
        }
        .hero-list {
            color: rgba(255,255,255,0.9);
        }
        .hero-panel .tool-banner {
            background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.78);
        }

        section {
            padding: var(--space-8) 0;
        }

        .section-head {
            margin-bottom: var(--space-6);
            max-width: 900px;
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
            font-family: var(--font-display);
            font-size: clamp(1.6rem, 3vw, 2.6rem);
            line-height: 1.2;
        }

        .section-text {
            margin: 0;
            color: var(--muted);
            font-size: 1.05rem;
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

        .card {
            padding: var(--space-5);
        }

        .card h3 {
            margin: 0 0 var(--space-2);
            font-family: var(--font-display);
            font-size: 1.05rem;
            line-height: 1.4;
        }

        .card p {
            margin: 0;
            color: var(--muted);
        }

        .soft {
            background: var(--surface-alt);
            border-color: #d8e0ea;
        }

        .diagram {
            margin-top: var(--space-4);
            width: 100%;
            height: auto;
            display: block;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
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

        .pill-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin-top: var(--space-4);
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 0.8rem;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: #fff;
            font-size: 0.94rem;
            color: var(--text);
        }

        .steps {
            display: grid;
            gap: var(--space-4);
        }

        .step {
            display: grid;
            grid-template-columns: 54px 1fr;
            gap: var(--space-4);
            align-items: start;
            padding: var(--space-4);
            background: #fff;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: var(--accent-soft);
            color: var(--accent-strong);
            font-family: var(--font-display);
            font-size: 1.1rem;
        }

        .step h3 {
            margin: 0 0 0.35rem;
            font-family: var(--font-display);
            font-size: 1.02rem;
        }

        .step p {
            margin: 0;
            color: var(--muted);
        }

        .callout {
            padding: var(--space-5);
        }

        .callout strong {
            display: block;
            margin-bottom: 0.4rem;
            font-family: var(--font-display);
        }

        .callout p {
            margin: 0;
            color: var(--muted);
        }

        .feature-list {
            margin: 0;
            padding-left: 1.15rem;
        }

        .feature-list li + li {
            margin-top: 0.55rem;
        }

        .section-actions {
            display: flex;
            gap: var(--space-3);
            flex-wrap: wrap;
            margin-top: var(--space-5);
        }

        .roadmap {
            display: grid;
            gap: var(--space-3);
        }

        .roadmap-item {
            padding: var(--space-4);
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
            background: #fff;
        }

        .roadmap-item strong {
            display: block;
            margin-bottom: 0.25rem;
            font-family: var(--font-display);
        }

        .roadmap-item span {
            color: var(--muted);
        }

        .footer-cta {
            padding: var(--space-8) 0;
        }

        .footer-cta-box {
            padding: var(--space-7);
            background: linear-gradient(180deg, #0f172a 0%, #172554 100%);
            color: #fff;
            border-radius: 28px;
            box-shadow: var(--shadow);
        }

        .footer-cta-box h2 {
            margin: 0 0 var(--space-3);
            font-family: var(--font-display);
            font-size: clamp(1.7rem, 3vw, 2.7rem);
            line-height: 1.2;
        }

        .footer-cta-box p {
            margin: 0 0 var(--space-5);
            color: rgba(255,255,255,0.84);
            max-width: 780px;
        }

        .footer-cta-box .btn-secondary {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
            color: #fff;
        }

        .footer-cta-box .btn-secondary:hover {
            background: rgba(255,255,255,0.16);
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
            font-family: var(--font-display);
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
            .hero {
                padding: var(--space-8) 0 var(--space-7);
            }

            section {
                padding: var(--space-7) 0;
            }

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

            .footer-cta-box,
            .hero-panel,
            .card,
            .callout {
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
            <span class="brand-subtitle">Multi-state files for controlled disclosure</span>
        </a>

        <nav class="nav" aria-label="Primary navigation">
            <a href="#what">What it is</a>
            <a href="#profiles">Profiles</a>
            <a href="#developers">For developers</a>
            <a href="/specification">Specification</a>
            <a href="/whitepaper">Whitepaper</a>
            <a href="/community">Community</a>
            <a href="#tools" class="nav-cta">Tools</a>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="eyebrow">Open standard · Open tooling · Public infrastructure</div>

                <h1>Multi-state files for controlled disclosure</h1>

                <p class="lead">
                    Datamorpho is an open file standard for files that remain valid in their original format while containing one or more sealed hidden states. Those states can be reconstructed later through state-specific reconstruction objects.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="/specification">Read the Specification</a>
                    <a class="btn btn-secondary" href="/whitepaper">Open the Whitepaper</a>
                    <a class="btn btn-secondary" href="#tools">Use the Tools</a>
                </div>

                <p class="hero-note">
                    Datamorpho enables staged releases, delayed disclosure, secure distribution, archives, interactive assets, and future-proof digital objects without changing the original carrier file.
                </p>

                <div class="pill-list" aria-label="Key concepts">
                    <span class="pill">JPEG · TXT Demo</span>
                    <span class="pill">Sparse / Sparse-with-Chaff</span>
                    <span class="pill">State-Specific Reconstruction</span>
                    <span class="pill">Cryptographic Agility</span>
                    <span class="pill">Audio / Video Next</span>
                </div>
            </div>

            <aside class="hero-panel" aria-label="Quick overview">
                <h2>What you should understand first</h2>
                <p>
                    This is not steganography and not a metadata trick. A Datamorphed file openly tells you that hidden states exist inside it — and where to look for the reconstruction information when the time comes.
                </p>

                <ul class="hero-list">
                    <li>Still a valid, ordinary file</li>
                    <li>Public manifest anyone can inspect</li>
                    <li>Concealed payload for future states</li>
                    <li>Separate reconstruction object per hidden state</li>
                </ul>

                <div class="tool-banner">
                    <strong>Just want to try it?</strong> Use the free creator and reconstructor tools above.<br>
                    <strong>Writing about it?</strong> The overview section below explains the concept clearly.<br>
                    <strong>Building on it?</strong> Dig into the specification and the developer section.
                </div>
            </aside>
        </div>
    </section>

    <section id="what">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Overview</p>
                <h2 class="section-title">What is Datamorpho?</h2>
                <p class="section-text">
                    Datamorpho is an open standard for multi-state files.
                </p>
                <p class="section-text" style="margin-top: 1rem;">
                    A Datamorphed file keeps its normal visible form while also containing one or more hidden future states. The file can publicly declare that these hidden states exist, indicate where reconstruction information may later be found, and still keep the actual recovery of those states dependent on a separate secret-bearing reconstruction object.
                </p>
                <p class="section-text" style="margin-top: 1rem;">
                    Datamorpho is not a viewer trick, not a metadata swap pattern, and not steganography. It is a declared latent-state file architecture.
                </p>
            </div>

            <div class="grid-4">
                <article class="card">
                    <h3>Base Carrier</h3>
                    <p>The ordinary visible file, such as a JPEG, TXT, or PDF.</p>
                </article>

                <article class="card">
                    <h3>Public Manifest</h3>
                    <p>Declares Datamorphosis, hidden states, triggers, and MorphoStorage directions.</p>
                </article>

                <article class="card">
                    <h3>Concealed Payload</h3>
                    <p>The embedded bytes from which one or more hidden states may later be reconstructed.</p>
                </article>

                <article class="card">
                    <h3>Reconstruction Object</h3>
                    <p>The state-specific secret-bearing object used to reconstruct one hidden state.</p>
                </article>
            </div>

            <img class="diagram"
                 src="/assets/diagrams/architecture.svg"
                 alt="Datamorpho architecture: a Datamorphed File (containing a Base Carrier, Public Manifest, and Concealed Payload) combined with a separately held Reconstruction Object produces the Hidden State output. MorphoStorage is an optional layer for hosting Reconstruction Objects."
                 width="860" height="210">
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Why it matters</p>
                <h2 class="section-title">Files do not need to be static anymore</h2>
                <p class="section-text">
                    Datamorpho makes files capable of carrying sealed hidden future states without breaking their original format. This enables safer and more flexible digital workflows where distribution and reconstruction do not need to happen at the same time.
                </p>
            </div>

            <div class="grid-3">
                <article class="card soft">
                    <h3>Controlled Disclosure</h3>
                    <p>Reveal hidden file states only when the correct reconstruction object becomes available.</p>
                </article>

                <article class="card soft">
                    <h3>Staged Media & Documents</h3>
                    <p>Distribute media or documents early and reconstruct them later at the correct moment.</p>
                </article>

                <article class="card soft">
                    <h3>Archives & Delayed Publication</h3>
                    <p>Preserve files with latent states for future release, access, or recovery.</p>
                </article>

                <article class="card soft">
                    <h3>Games & Interactive Assets</h3>
                    <p>Create items, rewards, unlockables, and hidden assets with file-level latent states.</p>
                </article>

                <article class="card soft">
                    <h3>Financial & Auction Flows</h3>
                    <p>Support information release patterns where some file-linked state should only be reconstructed later.</p>
                </article>

                <article class="card soft">
                    <h3>Censorship-Resistant Lawful Distribution</h3>
                    <p>Spread the carrier file widely first, then release reconstruction material later.</p>
                </article>
            </div>
            <p class="section-text" style="margin-top: 1.5rem;">
                Datamorpho gives files latent states. That is a fundamental new capability.
            </p>
        </div>
    </section>

    <section id="profiles">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Current carrier profiles</p>
                <h2 class="section-title">JPEG, TXT, and PDF first</h2>
                <p class="section-text">
                    Datamorpho v0.001 defines JPEG, TXT, and PDF profiles at the protocol level. The first public demo tooling on Datamorpho.io intentionally supports JPEG and TXT only. Audio and video remain the next immediate targets after the first release.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>JPEG</h3>
                    <p>A valid JPEG image followed by a Datamorpho binary block.</p>
                </article>

                <article class="card">
                    <h3>TXT</h3>
                    <p>A terminal Datamorpho envelope appended after visible text.</p>
                </article>

                <article class="card">
                    <h3>PDF</h3>
                    <p>Defined in the protocol specification, but intentionally excluded from the first public website demo until a controlled implementation is ready.</p>
                </article>
            </div>

            <img src="/assets/diagrams/carrier-profiles.svg"
                 alt="Carrier profiles: JPEG appends a DMOR binary trailer block after the original image bytes. TXT appends a Datamorpho envelope block after visible text. PDF uses an incremental update structure and is defined in the protocol but not yet in demo tooling."
                 style="width:100%;max-width:860px;display:block;margin:2rem auto 0;"/>
        </div>
    </section>

    <section id="tools">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Free tools</p>
                <h2 class="section-title">Use Datamorpho without reading everything first</h2>
                <p class="section-text">
                    Many people will come here to create Datamorphed files or reconstruct hidden states. The tooling layer is meant to make Datamorpho accessible while keeping the protocol itself open and inspectable.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Creator</h3>
                    <p>Create Datamorphed files from supported carrier formats using public manifests, payload layout strategy, and reconstruction objects.</p>
                    <div class="section-actions">
                        <a class="btn btn-primary" href="/tools-create">Open Creator</a>
                    </div>
                </article>

                <article class="card">
                    <h3>Reconstructor</h3>
                    <p>Load a carrier file and a reconstruction object to reconstruct one hidden state and export the recovered output.</p>
                    <div class="section-actions">
                        <a class="btn btn-primary" href="/tools-reconstruct">Open Reconstructor</a>
                    </div>
                </article>

                <article class="card">
                    <h3>MorphoStorage</h3>
                    <p>A future infrastructure layer for hosting or retrieving reconstruction-related data where appropriate, including IPFS-aligned flows.</p>
                    <div class="section-actions">
                        <a class="btn btn-secondary" href="/roadmap">Coming Soon</a>
                    </div>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem;">
                <strong>Important</strong>
                <p>
                    The first tooling focus is correctness, usability, and protocol alignment: open-source Python tooling first, then browser-compatible JavaScript derived from the tested Python reference implementation. The first website demo scope is JPEG and TXT only.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">How it works</p>
                <h2 class="section-title">A simple conceptual flow</h2>
                <p class="section-text">
                    Datamorpho separates a file into distinct logical layers. This makes the system easier to understand, easier to standardize, and more flexible across carriers and implementations.
                </p>
            </div>

            <div class="steps">
                <article class="step">
                    <div class="step-number">1</div>
                    <div>
                        <h3>Start from a valid file</h3>
                        <p>A normal file is used as the visible base carrier.</p>
                    </div>
                </article>

                <article class="step">
                    <div class="step-number">2</div>
                    <div>
                        <h3>Add a public declaration</h3>
                        <p>A public manifest declares that hidden states exist and provides directions for future reconstruction information.</p>
                    </div>
                </article>

                <article class="step">
                    <div class="step-number">3</div>
                    <div>
                        <h3>Embed concealed payload bytes</h3>
                        <p>Hidden-state data is embedded into the carrier according to the selected carrier profile and layout strategy.</p>
                    </div>
                </article>

                <article class="step">
                    <div class="step-number">4</div>
                    <div>
                        <h3>Reconstruct a target state later</h3>
                        <p>A state-specific reconstruction object identifies the relevant payload spans, reassembly order, cryptographic instructions, and secret material needed to reconstruct one hidden state.</p>
                    </div>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem; background: var(--warning-soft);">
                <strong>Not steganography</strong>
                <p>
                    Datamorpho does not deny that hidden states exist. Hidden states are declared, not hidden in a deniable sense.
                </p>
            </div>

            <img src="/assets/diagrams/lifecycle.svg"
                 alt="Datamorpho lifecycle: four steps — start from a valid file, add a public manifest, embed concealed payload, then reconstruct a hidden state later using a reconstruction object."
                 style="width:100%;max-width:860px;display:block;margin:2rem auto 0;"/>
        </div>
    </section>

    <section id="developers">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">For developers</p>
                <h2 class="section-title">Technical properties worth understanding</h2>
                <p class="section-text">
                    Developers, security researchers, and implementers usually need more than the public explanation. The protocol is designed around layered resistance, deterministic reconstruction semantics, and open technical documentation.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Layered resistance</h3>
                    <ul class="feature-list">
                        <li>cryptographic agility</li>
                        <li>sparse and sparse-with-chaff layout</li>
                        <li>non-monotonic physical fragment placement</li>
                        <li>state-specific reconstruction objects</li>
                        <li>digest cross-binding between manifest, file, and reconstruction object</li>
                    </ul>
                </article>

                <article class="card">
                    <h3>Design decisions in v0.001</h3>
                    <ul class="feature-list">
                        <li>public declaration is required</li>
                        <li>the reconstruction object is a secret-bearing artifact</li>
                        <li>different fragments of the same hidden state may use different cryptographic suites</li>
                        <li>states do not need to be sequential</li>
                        <li>the standard does not try to norm every viewer or decryption UX</li>
                    </ul>
                </article>
            </div>

            <div class="section-actions">
                <a class="btn btn-primary" href="/specification">Read the Specification</a>
                <a class="btn btn-secondary" href="/whitepaper">Read the Whitepaper</a>
                <a class="btn btn-secondary" href="/examples">View Examples</a>
            </div>

            <img src="/assets/diagrams/sparse-layout.svg"
                 alt="Sparse vs sparse-with-chaff byte layout. Sparse: fragments in blue with empty gaps between them. Sparse-with-chaff: same fragments but gaps filled with amber chaff bytes that obscure fragment boundaries."
                 style="width:100%;max-width:860px;display:block;margin:2rem auto 0;"/>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Examples</p>
                <h2 class="section-title">Understand the protocol through real carriers</h2>
                <p class="section-text">
                    Datamorpho is easiest to understand through practical examples. Each example should include the base file, Datamorphed file, public manifest, reconstruction object, and expected output.
                </p>
            </div>

            <div class="grid-4">
                <article class="card soft">
                    <h3>JPEG Example</h3>
                    <p>A visible image containing a later reconstructable hidden state.</p>
                </article>

                <article class="card soft">
                    <h3>TXT Example</h3>
                    <p>A visible text file with a Datamorpho envelope and reconstructable hidden content.</p>
                </article>

                <article class="card soft">
                    <h3>PDF Example</h3>
                    <p>A visible PDF with one or more later reconstructable alternate document states.</p>
                </article>

                <article class="card soft">
                    <h3>Static Metadata Reveal Pattern</h3>
                    <p>A Datamorphed JPEG and Datamorphed metadata file working together without moving the public metadata location. A natural fit for NFT-style assets and on-chain pointer patterns where the public metadata URL must stay fixed.</p>
                </article>
            </div>

            <img src="/assets/diagrams/nft-metadata.svg"
                 alt="NFT-style static metadata reveal pattern: four stages (egg, larva, chrysalis, butterfly) unlocked by providing the state-specific reconstruction object. The file at the fixed public URL never changes."
                 style="width:100%;max-width:860px;display:block;margin:2rem auto 0;"/>

            <div class="section-actions">
                <a class="btn btn-secondary" href="/examples">View Examples</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Open protocol</p>
                <h2 class="section-title">Open specification. Open tooling. Public good.</h2>
                <p class="section-text">
                    Datamorpho is being developed as open infrastructure. The goal is not only to publish a specification, but to maintain a reusable protocol, open-source tooling, free documentation, public examples, and free web utilities that benefit the broader ecosystem.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Open Specification</h3>
                    <p>The normative structure of the format is public and inspectable.</p>
                </article>

                <article class="card">
                    <h3>Open Tooling</h3>
                    <p>Reference tooling is intended to remain open source and collaboration-friendly.</p>
                </article>

                <article class="card">
                    <h3>Public Infrastructure</h3>
                    <p>Datamorpho.io is intended to offer free create and reconstruct flows and future MorphoStorage support.</p>
                </article>
            </div>

            <div class="section-actions">
                <a class="btn btn-primary" href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">View on GitHub</a>
                <a class="btn btn-secondary" href="/community">Join the Discussion</a>
                <a class="btn btn-secondary" href="/donate">Support the Project</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Roadmap</p>
                <h2 class="section-title">Where the project goes next</h2>
                <p class="section-text">
                    Datamorpho is currently in the open specification and first tooling phase. The next layers are implementation maturity, browser compatibility, and broader carrier support.
                </p>
            </div>

            <div class="roadmap">
                <div class="roadmap-item">
                    <strong>Phase 1</strong>
                    <span>Specification, whitepaper, examples, public repository.</span>
                </div>
                <div class="roadmap-item">
                    <strong>Phase 2</strong>
                    <span>Python creator and reconstruction tooling.</span>
                </div>
                <div class="roadmap-item">
                    <strong>Phase 3</strong>
                    <span>JavaScript and browser-compatible processing library.</span>
                </div>
                <div class="roadmap-item">
                    <strong>Phase 4</strong>
                    <span>Free Datamorpho.io create and reconstruct tools.</span>
                </div>
                <div class="roadmap-item">
                    <strong>Phase 5</strong>
                    <span>PDF carrier support.</span>
                </div>
                <div class="roadmap-item">
                    <strong>Phase 6</strong>
                    <span>MorphoStorage infrastructure.</span>
                </div>
                <div class="roadmap-item">
                    <strong>Phase 7</strong>
                    <span>Audio and video carrier support.</span>
                </div>
                <div class="roadmap-item">
                    <strong>Phase 8</strong>
                    <span>Expanded infrastructure, interoperability, and broader standardization work.</span>
                </div>
            </div>

            <div class="section-actions">
                <a class="btn btn-secondary" href="/roadmap">View Full Roadmap</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Community</p>
                <h2 class="section-title">Public discussion is part of the protocol process</h2>
                <p class="section-text">
                    Datamorpho is an open technical project. Review the specification, join discussions, open issues, and help shape the future of multi-state file infrastructure.
                </p>
            </div>

            <div class="grid-4">
                <article class="card">
                    <h3>GitHub</h3>
                    <p>Source code, documentation, and collaborative development. <a href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">View on GitHub →</a></p>
                </article>
                <article class="card">
                    <h3>Discussions</h3>
                    <p>Protocol questions, design conversations, and community review. <a href="https://github.com/ariutokintumi/datamorpho/discussions" target="_blank" rel="noopener noreferrer">Open Discussions →</a></p>
                </article>
                <article class="card">
                    <h3>Announcements</h3>
                    <p>Project updates, releases, and public communications. <a href="https://x.com/datamorpho" target="_blank" rel="noopener noreferrer">Follow on X →</a></p>
                </article>
                <article class="card">
                    <h3>Contact</h3>
                    <p>For serious inquiries, collaborations, or media questions, write to <a href="mailto:g@evvm.org">g@evvm.org</a>.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="footer-cta">
        <div class="container">
            <div class="footer-cta-box">
                <h2>Explore the future of multi-state files</h2>
                <p>
                    Read the specification, explore the whitepaper, try the tools, and help shape Datamorpho as an open standard for controlled disclosure and future-proof digital objects.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="/specification">Read the Specification</a>
                    <a class="btn btn-secondary" href="/whitepaper">Open the Whitepaper</a>
                    <a class="btn btn-secondary" href="#tools">Try the Tools</a>
                </div>
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
                <h3>Notes</h3>
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