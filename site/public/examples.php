<?php
declare(strict_types=1);
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Examples - Carriers, Reconstruction Objects, and Test Vectors</title>
    <meta name="description" content="Datamorpho examples for JPEG, TXT, PDF, static metadata reveal patterns, and future interoperability vectors.">
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
            font-size: 1.08rem;
            color: var(--muted);
            max-width: 760px;
        }

        .hero-actions,
        .section-actions {
            display: flex;
            gap: var(--space-3);
            flex-wrap: wrap;
        }

        .hero-actions {
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
        .callout {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: var(--space-5);
        }

        .card h3,
        .panel h2 {
            margin-top: 0;
            margin-bottom: var(--space-3);
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

        .card p,
        .panel p {
            margin: 0;
            color: var(--muted);
        }

        .soft {
            background: var(--surface-alt);
            border-color: #d8e0ea;
        }

        .feature-list {
            margin: 0;
            padding-left: 1.1rem;
        }

        .feature-list li + li {
            margin-top: 0.45rem;
        }

        .example-meta {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 0.95rem;
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
            .callout {
                padding: var(--space-4);
            }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="container site-header-inner">
        <a class="brand" href="https://datamorpho.io/index.php" aria-label="Datamorpho home">
            <span class="brand-title">DATAMORPHO</span>
            <span class="brand-subtitle">Examples · carriers · vectors</span>
        </a>

        <nav class="nav" aria-label="Primary navigation">
            <a href="https://datamorpho.io/index.php">Home</a>
            <a href="https://datamorpho.io/specification.php">Specification</a>
            <a href="https://datamorpho.io/whitepaper.php">Whitepaper</a>
            <a href="https://datamorpho.io/tools.php">Tools</a>
            <a href="https://datamorpho.io/examples.php">Examples</a>
            <a href="https://datamorpho.io/community.php" class="nav-cta">Community</a>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="eyebrow">Examples and interoperability vectors</div>
                <h1>Real carriers make the protocol easier to understand</h1>
                <p class="lead">
                    Datamorpho is easiest to understand through concrete examples. Each example should pair a visible carrier with a public manifest, a reconstruction object, and a clearly defined expected output.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#carrier-examples">View Carrier Examples</a>
                    <a class="btn btn-secondary" href="https://datamorpho.io/tools.php">Open the Tools</a>
                    <a class="btn btn-secondary" href="https://datamorpho.io/specification.php">Read the Specification</a>
                </div>
            </div>

            <aside class="panel">
                <h2>What a complete example should include</h2>
                <ul class="feature-list">
                    <li>base file</li>
                    <li>Datamorphed file</li>
                    <li>public manifest</li>
                    <li>reconstruction object</li>
                    <li>expected output</li>
                    <li>hashes or validation notes where relevant</li>
                </ul>
            </aside>
        </div>
    </section>

    <section id="carrier-examples">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Carrier examples</p>
                <h2 class="section-title">The first four example families</h2>
                <p class="section-text">
                    These examples are meant for developers, reviewers, implementers, and anyone trying to understand Datamorpho through practical carrier-specific cases.
                </p>
            </div>

            <div class="grid-4">
                <article class="card">
                    <h3>JPEG Example</h3>
                    <p>A visible image containing a later reconstructable hidden state.</p>
                    <div class="example-meta">
                        Includes: base JPEG, Datamorphed JPEG, manifest, reconstruction object, expected hidden output.
                    </div>
                </article>

                <article class="card">
                    <h3>TXT Example</h3>
                    <p>A visible text file with a Datamorpho envelope and reconstructable hidden content.</p>
                    <div class="example-meta">
                        Includes: base TXT, Datamorphed TXT, envelope inspection, manifest, reconstruction object.
                    </div>
                </article>

                <article class="card">
                    <h3>PDF Example</h3>
                    <p>A visible PDF with one or more later reconstructable alternate document states.</p>
                    <div class="example-meta">
                        Includes: base PDF, Datamorphed PDF, manifest object, payload stream reference, expected output.
                    </div>
                </article>

                <article class="card soft">
                    <h3>Static Metadata Reveal Pattern</h3>
                    <p>A Datamorphed JPEG and Datamorphed metadata file working together without moving the public metadata location.</p>
                    <div class="example-meta">
                        Includes: image + metadata pair, dual manifests, reconstruction objects, reveal pattern explanation.
                    </div>
                </article>
            </div>

            <div class="placeholder">
                <strong>Diagram placeholder: example families</strong>
                Show four clear example tracks: JPEG, TXT, PDF, and static metadata reveal pattern, each with base file → Datamorphed file → reconstruction object → expected output.
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Why examples matter</p>
                <h2 class="section-title">Examples are not decoration</h2>
                <p class="section-text">
                    In Datamorpho, examples serve technical purposes. They are not just demos. They help explain carrier semantics, reveal edge cases, test implementations, and make the protocol easier to review in public.
                </p>
            </div>

            <div class="grid-3">
                <article class="card soft">
                    <h3>Protocol understanding</h3>
                    <p>Examples make it easier to understand the difference between public declaration, concealed payload, and reconstruction semantics.</p>
                </article>

                <article class="card soft">
                    <h3>Implementation testing</h3>
                    <p>Examples provide stable inputs and expected outputs for early tooling and future interoperability checks.</p>
                </article>

                <article class="card soft">
                    <h3>Public review</h3>
                    <p>Examples make it easier for developers, researchers, and reviewers to discuss the protocol with concrete artifacts.</p>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Interoperability</p>
                <h2 class="section-title">Vectors and validation should grow with the tooling</h2>
                <p class="section-text">
                    Beyond human-readable examples, Datamorpho should also maintain structured vectors for deterministic validation and future interoperable implementations.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Human-oriented examples</h3>
                    <ul class="feature-list">
                        <li>annotated carrier examples</li>
                        <li>clear explanation of what each file contains</li>
                        <li>walkthroughs for creators and reconstructors</li>
                        <li>diagrams where helpful</li>
                    </ul>
                </article>

                <article class="card">
                    <h3>Machine-oriented vectors</h3>
                    <ul class="feature-list">
                        <li>expected hashes</li>
                        <li>expected reconstruction outputs</li>
                        <li>manifest and reconstruction object fixtures</li>
                        <li>interoperability-oriented validation assets</li>
                    </ul>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem;">
                <strong>Good examples should be reusable</strong>
                <p>
                    A strong Datamorpho example should help three audiences at once: users learning the concept, developers implementing the protocol, and reviewers trying to validate correctness.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">How to use these examples</p>
                <h2 class="section-title">A practical review flow</h2>
                <p class="section-text">
                    The examples page is meant to support a simple workflow: understand the carrier, inspect the declaration layer, examine the reconstruction object, and compare the final output with the expected result.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>For readers and journalists</h3>
                    <p>
                        Start with the landing page, then use the examples to understand what a Datamorphed carrier looks like in practice.
                    </p>
                </article>

                <article class="card">
                    <h3>For developers and implementers</h3>
                    <p>
                        Read the specification, inspect the examples, compare the outputs, and use them as fixtures when building or reviewing tooling.
                    </p>
                </article>
            </div>

            <div class="section-actions" style="margin-top: 2rem;">
                <a class="btn btn-secondary" href="https://datamorpho.io/specification.php">Read the Specification</a>
                <a class="btn btn-secondary" href="https://datamorpho.io/whitepaper.php">Open the Whitepaper</a>
                <a class="btn btn-secondary" href="https://datamorpho.io/tools.php">Open the Tools</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Next examples</p>
                <h2 class="section-title">Audio and video examples will follow the first release</h2>
                <p class="section-text">
                    JPEG, TXT, and PDF are the first public carrier profiles. Audio and video are the next immediate targets, and future example sets should expand accordingly once the first tooling release is stable.
                </p>
            </div>

            <div class="grid-2">
                <article class="card soft">
                    <h3>Why audio and video matter</h3>
                    <p>They are strong demonstrations of early distribution and later reconstruction for media-heavy use cases.</p>
                </article>

                <article class="card soft">
                    <h3>Why they come later</h3>
                    <p>They require more work around size, streaming, re-encoding, and tooling complexity than the first carrier set.</p>
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
                    <li><a href="https://datamorpho.io/index.php">Home</a></li>
                    <li><a href="https://datamorpho.io/specification.php">Specification</a></li>
                    <li><a href="https://datamorpho.io/whitepaper.php">Whitepaper</a></li>
                    <li><a href="https://datamorpho.io/tools.php">Tools</a></li>
                    <li><a href="https://datamorpho.io/examples.php">Examples</a></li>
                    <li><a href="https://datamorpho.io/roadmap.php">Roadmap</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Community</h3>
                <ul>
                    <li><a href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">GitHub</a></li>
                    <li><a href="https://github.com/ariutokintumi/datamorpho/discussions" target="_blank" rel="noopener noreferrer">Discussions</a></li>
                    <li><a href="https://x.com/datamorpho" target="_blank" rel="noopener noreferrer">Announcements</a></li>
                    <li><a href="https://datamorpho.io/donate.php">Donate</a></li>
                    <li><a href="mailto:g@evvm.org">g@evvm.org</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>More</h3>
                <ul>
                    <li><a href="https://datamorpho.io/faq.php">FAQ</a></li>
                    <li><a href="https://datamorpho.io/glossary.php">Glossary</a></li>
                    <li><a href="https://datamorpho.io/changelog.php">Changelog</a></li>
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