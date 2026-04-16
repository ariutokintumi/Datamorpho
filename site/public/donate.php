<?php
declare(strict_types=1);
$year = date('Y');

$givethUrl = 'https://giveth.io/project/datamorpho-protocol-and-free-security-tooling';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Support Datamorpho - Public Goods Funding</title>
    <meta name="description" content="Support Datamorpho as open infrastructure: specification, tooling, examples, free web utilities, and future carrier support.">
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
            --success-soft: #dcfce7;
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
        .callout,
        .tier {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: var(--space-5);
        }

        .panel h2,
        .card h3,
        .tier h3 {
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

        .card p,
        .panel p,
        .tier p {
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

        .note {
            font-size: 0.94rem;
            color: var(--muted);
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
            .callout,
            .tier {
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
            <span class="brand-subtitle">Support · public goods funding</span>
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
                <div class="eyebrow">Open protocol · Open tooling · Public good</div>
                <h1>Support Datamorpho as public infrastructure</h1>
                <p class="lead">
                    Datamorpho is being developed as an open file standard, open-source tooling suite, free documentation layer, and free public service layer for controlled disclosure, secure distribution, and future-proof digital objects.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="<?php echo htmlspecialchars($givethUrl, ENT_QUOTES, 'UTF-8'); ?>">Support via Giveth</a>
                    <a class="btn btn-secondary" href="/community">Join the Discussion</a>
                    <a class="btn btn-secondary" href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">View on GitHub</a>
                </div>

                <p class="note">
                    Donations support protocol maintenance, contributor hours, free tools, public documentation, interoperability assets, and future carrier development.
                </p>
            </div>

            <aside class="panel">
                <h2>What support helps sustain</h2>
                <ul class="feature-list">
                    <li>specification and whitepaper maintenance</li>
                    <li>open-source Python and JavaScript tooling</li>
                    <li>free Datamorpho.io create and reconstruct flows</li>
                    <li>examples, vectors, and documentation</li>
                    <li>future MorphoStorage-related public infrastructure</li>
                    <li>future carrier support, starting with audio and video</li>
                </ul>
            </aside>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Why support Datamorpho</p>
                <h2 class="section-title">An open protocol needs long-term maintenance</h2>
                <p class="section-text">
                    The goal is not only to publish a standard, but to keep it alive: documentation, tooling, examples, web utilities, public review, and future contributors all require sustained work.
                </p>
            </div>

            <div class="grid-3">
                <article class="card soft">
                    <h3>Protocol maintenance</h3>
                    <p>Keep the specification, whitepaper, glossary, FAQ, and roadmap coherent as the project evolves.</p>
                </article>

                <article class="card soft">
                    <h3>Open tooling</h3>
                    <p>Build and maintain Python and JavaScript tooling that stays aligned with the protocol instead of drifting into undocumented behavior.</p>
                </article>

                <article class="card soft">
                    <h3>Public service layer</h3>
                    <p>Offer free web utilities and future public infrastructure that make Datamorpho accessible without sacrificing openness.</p>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Ethereum and security relevance</p>
                <h2 class="section-title">Why Datamorpho matters beyond one file format</h2>
                <p class="section-text">
                    Datamorpho contributes to the ecosystem as open security-oriented infrastructure: an open file standard, cryptographic tooling model, public documentation layer, and future-proof architecture for controlled disclosure.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Security-oriented value</h3>
                    <ul class="feature-list">
                        <li>controlled disclosure workflows</li>
                        <li>open security standards and best practices</li>
                        <li>cryptographic file handling model</li>
                        <li>future post-quantum-oriented implementation paths</li>
                    </ul>
                </article>

                <article class="card">
                    <h3>Public-good value</h3>
                    <ul class="feature-list">
                        <li>open specification</li>
                        <li>open-source tooling</li>
                        <li>free public web utilities</li>
                        <li>documentation, examples, diagrams, and reviewability</li>
                    </ul>
                </article>
            </div>

            <div class="callout" style="margin-top: 1.5rem;">
                <strong>Support is not only for code</strong>
                <p>
                    Sustaining Datamorpho also means supporting documentation, technical communication, example-building, ecosystem education, and the public infrastructure that helps people use the protocol correctly.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Use of funds</p>
                <h2 class="section-title">What different funding levels unlock</h2>
                <p class="section-text">
                    Support helps at every level. The roadmap expands as more maintenance, implementation, and public infrastructure become sustainable.
                </p>
            </div>

            <div class="grid-2">
                <article class="tier">
                    <h3>Less than $5,000</h3>
                    <p>Specification and whitepaper polish, repo maintenance, examples, docs, and continuation of the first Python tooling wave.</p>
                </article>

                <article class="tier">
                    <h3>$5,000–$10,000</h3>
                    <p>First creator and reconstruction tooling releases, stronger examples, clearer validation, and better public documentation.</p>
                </article>

                <article class="tier">
                    <h3>$10,000–$25,000</h3>
                    <p>Free Datamorpho.io flows, browser-compatible JavaScript baseline, better interoperability assets, and contributor support.</p>
                </article>

                <article class="tier">
                    <h3>$25,000–$50,000</h3>
                    <p>Improved public infrastructure, MorphoStorage-related support, future carrier acceleration, and technical education / workshops where relevant.</p>
                </article>

                <article class="tier">
                    <h3>More than $50,000</h3>
                    <p>Deeper research, better tooling reliability, broader carrier support, stronger validation assets, and more sustainable long-term maintenance.</p>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">What support enables</p>
                <h2 class="section-title">The next practical outcomes</h2>
                <p class="section-text">
                    Donations help move Datamorpho through its next concrete steps: better tooling, better examples, better accessibility, and broader carrier support.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Free create and reconstruct tools</h3>
                    <p>Public tooling so more people can use Datamorpho without installing local software first.</p>
                </article>

                <article class="card">
                    <h3>Examples and vectors</h3>
                    <p>Better fixtures, walkthroughs, and interoperability assets for implementers and reviewers.</p>
                </article>

                <article class="card">
                    <h3>Future carriers</h3>
                    <p>Support for audio and video after the first public implementation wave is stable.</p>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Transparency</p>
                <h2 class="section-title">Public work should stay public</h2>
                <p class="section-text">
                    Datamorpho is intended to remain a public protocol project. Support should strengthen public documentation, open-source tooling, free public utilities, and future contributor capacity.
                </p>
            </div>

            <div class="grid-2">
                <article class="card soft">
                    <h3>Where to review progress</h3>
                    <p>Use GitHub, the specification, the whitepaper, the roadmap, and the examples to follow the project in public.</p>
                </article>

                <article class="card soft">
                    <h3>How to ask questions</h3>
                    <p>Open discussions in public, follow announcements, or write to <a href="mailto:g@evvm.org">g@evvm.org</a> for serious collaboration or media inquiries.</p>
                </article>
            </div>

            <div class="section-actions" style="margin-top: 2rem;">
                <a class="btn btn-primary" href="<?php echo htmlspecialchars($givethUrl, ENT_QUOTES, 'UTF-8'); ?>">Support via Giveth</a>
                <a class="btn btn-secondary" href="/roadmap">View the Roadmap</a>
                <a class="btn btn-secondary" href="/community">Open Community</a>
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