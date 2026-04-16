<?php
declare(strict_types=1);
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Roadmap - Specification, Tooling, and Future Carriers</title>
    <meta name="description" content="Datamorpho roadmap: specification, whitepaper, examples, Python tooling, JavaScript/browser support, free web tools, and future carrier profiles.">
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
        .phase,
        .card,
        .callout {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: var(--space-5);
        }

        .panel h2,
        .phase h3,
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

        .timeline {
            display: grid;
            gap: var(--space-4);
        }

        .phase {
            position: relative;
        }

        .phase-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: var(--accent-soft);
            color: var(--accent-strong);
            font-family: var(--font-display);
            margin-bottom: 1rem;
        }

        .phase p,
        .card p,
        .panel p {
            margin: 0;
            color: var(--muted);
        }

        .feature-list {
            margin: 0;
            padding-left: 1.1rem;
        }

        .feature-list li + li {
            margin-top: 0.45rem;
        }

        .soft {
            background: var(--surface-alt);
            border-color: #d8e0ea;
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
            .phase,
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
            <span class="brand-subtitle">Roadmap · phases · next steps</span>
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
                <div class="eyebrow">Roadmap</div>
                <h1>From open specification to long-term protocol infrastructure</h1>
                <p class="lead">
                    Datamorpho is currently in the open specification and first tooling phase. The roadmap is intentionally staged so the protocol can mature through documentation, examples, tooling, public review, and future carrier expansion.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#phases">View the roadmap phases</a>
                    <a class="btn btn-secondary" href="/tools">Open the Tools</a>
                    <a class="btn btn-secondary" href="/community">Join the Discussion</a>
                </div>
            </div>

            <aside class="panel">
                <h2>Roadmap principles</h2>
                <ul class="feature-list">
                    <li>correctness before polish</li>
                    <li>open documentation before closed assumptions</li>
                    <li>examples and vectors alongside tooling</li>
                    <li>browser compatibility where practical</li>
                    <li>future carrier growth without breaking the core model</li>
                </ul>
            </aside>
        </div>
    </section>

    <section id="phases">
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Phases</p>
                <h2 class="section-title">The eight current roadmap phases</h2>
                <p class="section-text">
                    These phases reflect the public plan already introduced on the landing page. They are meant to be practical, sequential enough to guide work, and open enough to evolve with public review.
                </p>
            </div>

            <div class="timeline">
                <article class="phase">
                    <div class="phase-number">1</div>
                    <h3>Specification, whitepaper, examples, public repository</h3>
                    <p>
                        Establish the public foundation of the project: the normative specification, the whitepaper, the repository structure, the glossary, FAQ, roadmap, and the first example set.
                    </p>
                </article>

                <article class="phase">
                    <div class="phase-number">2</div>
                    <h3>Python creator and reconstruction tooling</h3>
                    <p>
                        Release the first reference tooling for creating Datamorphed files and reconstructing hidden states with protocol-correct outputs and deterministic behavior.
                    </p>
                </article>

                <article class="phase">
                    <div class="phase-number">3</div>
                    <h3>JavaScript and browser-compatible processing library</h3>
                    <p>
                        Build the browser-compatible layer for detection, validation, and practical reconstruction workflows, especially for carriers that fit well in web environments.
                    </p>
                </article>

                <article class="phase">
                    <div class="phase-number">4</div>
                    <h3>Free Datamorpho.io create and reconstruct tools</h3>
                    <p>
                        Offer free web tooling for users who want to work with Datamorpho without installing local code first, while keeping the protocol itself open and inspectable.
                    </p>
                </article>

                <article class="phase">
                    <div class="phase-number">5</div>
                    <h3>PDF carrier support</h3>
                    <p>
                        Add full PDF carrier support to both the reference tooling and the web tools. PDF is already defined at the protocol level in v0.001; this phase delivers the production implementation.
                    </p>
                </article>

                <article class="phase">
                    <div class="phase-number">6</div>
                    <h3>MorphoStorage infrastructure</h3>
                    <p>
                        Build the MorphoStorage layer for hosting, discovery, and retrieval of reconstruction-related data, including IPFS-aligned flows and decentralized storage options.
                    </p>
                </article>

                <article class="phase">
                    <div class="phase-number">7</div>
                    <h3>Audio and video carrier support</h3>
                    <p>
                        Expand beyond JPEG, TXT, and PDF into media-heavy carriers that strongly benefit from early distribution and later reconstruction.
                    </p>
                </article>

                <article class="phase">
                    <div class="phase-number">8</div>
                    <h3>Expanded infrastructure, interoperability, and broader standardization work</h3>
                    <p>
                        Strengthen public infrastructure, improve interoperability vectors, refine documentation, and move toward broader open standards discussion as the protocol matures.
                    </p>
                </article>
            </div>

            <div class="placeholder">
                <strong>Diagram placeholder: roadmap timeline</strong>
                Show the eight phases as a clean vertical or horizontal roadmap timeline, suitable for both protocol readers and general visitors.
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Near-term priorities</p>
                <h2 class="section-title">What matters most right now</h2>
                <p class="section-text">
                    Not every roadmap item has the same urgency. The current priority is to stabilize the public protocol layer and the first implementation wave.
                </p>
            </div>

            <div class="grid-3">
                <article class="card soft">
                    <h3>Protocol clarity</h3>
                    <p>Specification quality, language precision, and internal consistency remain foundational.</p>
                </article>

                <article class="card soft">
                    <h3>Working tooling</h3>
                    <p>Python creator and reconstructor flows should become reliable before larger expansion.</p>
                </article>

                <article class="card soft">
                    <h3>Public examples</h3>
                    <p>Examples and vectors must grow alongside tooling to support review and interoperability.</p>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Why audio and video come later</p>
                <h2 class="section-title">The next carriers are obvious, but they are not trivial</h2>
                <p class="section-text">
                    Audio and video are the next immediate targets after the first release, but they require more careful engineering than the first carrier set.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Why they are strategically important</h3>
                    <ul class="feature-list">
                        <li>strong fit for staged distribution</li>
                        <li>strong fit for synchronized reveal</li>
                        <li>high-value demonstration of latent-state media</li>
                        <li>broad public and developer interest</li>
                    </ul>
                </article>

                <article class="card">
                    <h3>Why they require more work</h3>
                    <ul class="feature-list">
                        <li>much larger payload sizes</li>
                        <li>streaming and partial-access concerns</li>
                        <li>re-encoding and compatibility issues</li>
                        <li>more demanding tooling and testing needs</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Future infrastructure</p>
                <h2 class="section-title">MorphoStorage, interoperability, and public service layers</h2>
                <p class="section-text">
                    The protocol roadmap is not only about new carriers. It is also about making the ecosystem around the protocol stronger and easier to use.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>MorphoStorage</h3>
                    <p>Future support for secure public or semi-public reconstruction-related retrieval flows where appropriate.</p>
                </article>

                <article class="card">
                    <h3>Interoperability assets</h3>
                    <p>More examples, vectors, validation notes, and reusable fixtures for future implementations.</p>
                </article>

                <article class="card">
                    <h3>Public web tooling</h3>
                    <p>Free Datamorpho.io tools for creation, reconstruction, and future protocol education.</p>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem;">
                <strong>Public-good direction</strong>
                <p>
                    Datamorpho is intended to grow as reusable open infrastructure: not only a specification, but also a tooling stack, public service layer, and documentation ecosystem.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Open review</p>
                <h2 class="section-title">The roadmap should stay discussable</h2>
                <p class="section-text">
                    The roadmap is a public working direction, not a closed promise. It should evolve through implementation experience, public critique, developer feedback, and future carrier research.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>What can change</h3>
                    <p>
                        sequencing, implementation detail, carrier order, and infrastructure priorities may all evolve as the project matures.
                    </p>
                </article>

                <article class="card">
                    <h3>What should remain stable</h3>
                    <p>
                        the core Datamorpho philosophy: declared latent states, reconstruction semantics, open documentation, and reusable public infrastructure.
                    </p>
                </article>
            </div>

            <div class="section-actions" style="margin-top: 2rem;">
                <a class="btn btn-primary" href="/community">Join the Discussion</a>
                <a class="btn btn-secondary" href="/specification">Read the Specification</a>
                <a class="btn btn-secondary" href="/examples">View Examples</a>
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