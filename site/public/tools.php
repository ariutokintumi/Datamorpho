<?php
declare(strict_types=1);
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Tools - Create and Reconstruct Multi-State Files</title>
    <meta name="description" content="Datamorpho tools for creating Datamorphed files, reconstructing hidden states, and future MorphoStorage flows.">
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

        .hero-panel h2,
        .card h3 {
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
        .grid-3 {
            display: grid;
            gap: var(--space-4);
        }

        .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

        .card p {
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
        <a class="brand" href="index.php" aria-label="Datamorpho home">
            <span class="brand-title">DATAMORPHO</span>
            <span class="brand-subtitle">Free tooling · Create and reconstruct</span>
        </a>

        <nav class="nav" aria-label="Primary navigation">
            <a href="index.php">Home</a>
            <a href="specification.php">Specification</a>
            <a href="whitepaper.php">Whitepaper</a>
            <a href="tools.php">Tools</a>
            <a href="examples.php">Examples</a>
            <a href="community.php" class="nav-cta">Community</a>
        </nav>
    </div>
</header>

<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="eyebrow">Free tools</div>
                <h1>Create and reconstruct Datamorphed files</h1>
                <p class="lead">
                    Datamorpho.io will provide free tools to help developers and users work with Datamorphed files. The first tooling focus is correctness, usability, and accessibility: open-source Python tooling, browser-compatible JavaScript support, and free web utilities.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="tools-create.php">Open Creator</a>
                    <a class="btn btn-secondary" href="tools-reconstruct.php">Open Reconstructor</a>
                    <a class="btn btn-secondary" href="specification.php">Read the Specification</a>
                </div>
            </div>

            <aside class="panel">
                <h2>Tooling priorities in the first phase</h2>
                <ul class="feature-list">
                    <li>protocol alignment with Specification v0.001</li>
                    <li>clear create and reconstruct flows</li>
                    <li>support for JPEG, TXT, and PDF first</li>
                    <li>developer-friendly outputs and validation</li>
                    <li>open-source Python and JavaScript implementations</li>
                </ul>
            </aside>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Tool portal</p>
                <h2 class="section-title">The first three tool paths</h2>
                <p class="section-text">
                    Datamorpho tooling is organized around the actual protocol lifecycle: creating files, reconstructing hidden states, and later supporting MorphoStorage-related retrieval flows.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Creator</h3>
                    <p>Create Datamorphed files from supported carrier formats using hidden state inputs, manifests, layout strategy, and reconstruction objects.</p>
                    <div class="section-actions" style="margin-top: 1.25rem;">
                        <a class="btn btn-primary" href="tools-create.php">Open Creator</a>
                    </div>
                </article>

                <article class="card">
                    <h3>Reconstructor</h3>
                    <p>Load a Datamorphed carrier file and a matching reconstruction object to reconstruct one target hidden state and export the recovered output.</p>
                    <div class="section-actions" style="margin-top: 1.25rem;">
                        <a class="btn btn-primary" href="tools-reconstruct.php">Open Reconstructor</a>
                    </div>
                </article>

                <article class="card soft">
                    <h3>MorphoStorage</h3>
                    <p>A future secure public infrastructure layer for hosting or retrieving reconstruction-related data where appropriate, including IPFS-aligned flows.</p>
                    <div class="section-actions" style="margin-top: 1.25rem;">
                        <a class="btn btn-secondary" href="roadmap.php">Coming Soon</a>
                    </div>
                </article>
            </div>

            <div class="placeholder">
                <strong>Diagram placeholder: tooling map</strong>
                Show the relationship among Creator, Reconstructor, carrier files, public manifests, reconstruction objects, and future MorphoStorage support.
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Supported carriers</p>
                <h2 class="section-title">JPEG, TXT, and PDF first</h2>
                <p class="section-text">
                    The first tooling wave follows the protocol roadmap: JPEG, TXT, and PDF first, then audio and video as the next immediate carrier targets after the first release.
                </p>
            </div>

            <div class="grid-3">
                <article class="card soft">
                    <h3>JPEG</h3>
                    <p>Image carriers with Datamorpho binary data appended after the valid JPEG end-of-image marker.</p>
                </article>

                <article class="card soft">
                    <h3>TXT</h3>
                    <p>Text carriers using the terminal Datamorpho envelope with public manifest and payload content.</p>
                </article>

                <article class="card soft">
                    <h3>PDF</h3>
                    <p>Document carriers using PDF incremental-update objects and Datamorpho payload streams.</p>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Implementation layers</p>
                <h2 class="section-title">Python, browser-compatible JavaScript, and free web utilities</h2>
                <p class="section-text">
                    The public tools page is only one layer. Datamorpho is also being built as an open tooling stack for developers who need local, scriptable, or browser-based workflows.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Python Creator</h3>
                    <p>Reference tooling to create Datamorphed files, manifests, and reconstruction objects with protocol-correct outputs.</p>
                </article>

                <article class="card">
                    <h3>Python Reconstructor</h3>
                    <p>Reference tooling to validate, reconstruct, decrypt, and output hidden states from supported carriers.</p>
                </article>

                <article class="card">
                    <h3>JavaScript / Browser Layer</h3>
                    <p>Browser-compatible processing for detection, validation, and reconstruction where practical, especially for image-first workflows.</p>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem;">
                <strong>Important</strong>
                <p>
                    The tooling is intended to make Datamorpho easier to use, not to replace the underlying protocol. The specification remains the source of truth for structure and semantics.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Safe use</p>
                <h2 class="section-title">Correctness first</h2>
                <p class="section-text">
                    Early Datamorpho tooling should prioritize protocol correctness, clear validation, deterministic outputs, and transparent error handling. This matters more than interface polish in the first public implementation phase.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Creator-side expectations</h3>
                    <ul class="feature-list">
                        <li>clear carrier selection</li>
                        <li>manifest and reconstruction-object generation</li>
                        <li>layout strategy selection</li>
                        <li>digest validation and output traceability</li>
                    </ul>
                </article>

                <article class="card">
                    <h3>Reconstructor-side expectations</h3>
                    <ul class="feature-list">
                        <li>carrier file input</li>
                        <li>reconstruction object input</li>
                        <li>digest and state validation</li>
                        <li>hidden-state output and clear error reporting</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Examples and testing</p>
                <h2 class="section-title">Tools should always connect to real examples</h2>
                <p class="section-text">
                    Datamorpho is easiest to understand when the tooling is paired with concrete examples: base file, Datamorphed file, public manifest, reconstruction object, and expected output.
                </p>
            </div>

            <div class="section-actions">
                <a class="btn btn-secondary" href="examples.php">View Examples</a>
                <a class="btn btn-secondary" href="specification.php">Read the Specification</a>
                <a class="btn btn-secondary" href="whitepaper.php">Open the Whitepaper</a>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="specification.php">Specification</a></li>
                    <li><a href="whitepaper.php">Whitepaper</a></li>
                    <li><a href="tools.php">Tools</a></li>
                    <li><a href="examples.php">Examples</a></li>
                    <li><a href="roadmap.php">Roadmap</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>Community</h3>
                <ul>
                    <li><a href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">GitHub</a></li>
                    <li><a href="https://github.com/ariutokintumi/datamorpho/discussions" target="_blank" rel="noopener noreferrer">Discussions</a></li>
                    <li><a href="https://x.com/datamorpho" target="_blank" rel="noopener noreferrer">Announcements</a></li>
                    <li><a href="donate.php">Donate</a></li>
                    <li><a href="mailto:g@evvm.org">g@evvm.org</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h3>More</h3>
                <ul>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="glossary.php">Glossary</a></li>
                    <li><a href="changelog.php">Changelog</a></li>
                    <li><a href="security.php">Security</a></li>
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