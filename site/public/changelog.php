<?php
declare(strict_types=1);
$year = date('Y');

$entries = [
    [
        'version' => 'v0.001',
        'title' => 'First formal public protocol release',
        'items' => [
            'First public specification release aligned with Datamorpho Specification v0.001.',
            'First public whitepaper release aligned with the current specification.',
            'Definition of Datamorpho as an open file standard for multi-state concealed content.',
            'Public declaration model formalized: Datamorpho is not steganography.',
            'Initial carrier profiles established: JPEG, TXT, and PDF.',
            'Layout strategies established: sparse and sparse-with-chaff.',
            'Reconstruction object model clarified as a complete secret-bearing artifact in v0.001.',
            'Support for heterogeneous cryptographic suites across fragments within the same state.',
            'Digest cross-binding between state descriptors, reconstruction objects, and carrier files.',
            'Public website structure initiated: landing, specification, whitepaper, tools, examples, roadmap, FAQ, glossary, donate, community, security.',
            'Initial roadmap published, including future audio and video support.',
        ],
    ],
    [
        'version' => 'Historical origin',
        'title' => 'Prototype lineage before the formal public spec',
        'items' => [
            'Datamorpho was publicly showcased as a prototype in the ETHGlobal / ETHMexico 2022 context.',
            'That earlier work represents the project origin and prototype lineage, not a prior normative public specification release.',
            'The current v0.001 release is the first formal open specification-era publication of Datamorpho.',
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Changelog</title>
    <meta name="description" content="Changelog for Datamorpho specification, whitepaper, website, tooling direction, and public releases.">
    <meta name="theme-color" content="#0f172a">

    <style>
        @font-face {
            font-family: "Unifont";
            src: url("/assets/fonts/unifont-17.0.04.otf") format("opentype");
            font-display: swap;
        }

        :root {
            --surface: #ffffff;
            --surface-alt: #eef2f7;
            --text: #0f172a;
            --muted: #475569;
            --line: #d6dbe3;
            --accent: #0b57d0;
            --accent-strong: #083b8a;
            --accent-soft: #dbeafe;
            --shadow: 0 14px 50px rgba(15, 23, 42, 0.08);
            --font-body: "Unifont", "Courier New", monospace;
            --font-display: "Unifont", "Courier New", monospace;
            --radius: 18px;
            --max: 1180px;
            --space-3: 1rem;
            --space-4: 1.25rem;
            --space-5: 1.5rem;
            --space-6: 2rem;
            --space-7: 3rem;
            --space-8: 4rem;
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
        a { color: var(--accent); text-decoration: none; }
        a:hover { color: var(--accent-strong); text-decoration: underline; }
        .container { width: min(calc(100% - 2rem), var(--max)); margin: 0 auto; }

        .site-header {
            position: sticky; top: 0; z-index: 50;
            backdrop-filter: blur(12px);
            background: rgba(246, 247, 248, 0.9);
            border-bottom: 1px solid rgba(214, 219, 227, 0.85);
        }
        .site-header-inner {
            display: flex; align-items: center; justify-content: space-between;
            gap: var(--space-4); min-height: 74px;
        }
        .brand {
            display: inline-flex; flex-direction: column; gap: 0.15rem;
            color: var(--text); text-decoration: none;
        }
        .brand:hover { color: var(--text); text-decoration: none; }
        .brand-title {
            font-family: var(--font-display);
            font-size: 1rem; letter-spacing: 0.04em; text-transform: uppercase;
        }
        .brand-subtitle { color: var(--muted); font-size: 0.84rem; }

        .nav {
            display: flex; align-items: center; gap: var(--space-4);
            flex-wrap: wrap; justify-content: flex-end;
        }
        .nav a { font-size: 0.94rem; color: var(--muted); text-decoration: none; }
        .nav a:hover { color: var(--text); }
        .nav-cta {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 0.75rem 1rem; border-radius: 999px;
            background: var(--text); color: #fff !important; font-weight: 700;
            box-shadow: var(--shadow);
        }
        .nav-cta:hover { background: #1f2937; text-decoration: none; }

        .hero { padding: var(--space-8) 0 var(--space-7); }
        .eyebrow {
            display: inline-flex; align-items: center; gap: 0.55rem;
            padding: 0.45rem 0.8rem; border-radius: 999px;
            background: var(--accent-soft); color: var(--accent-strong);
            font-weight: 700; font-size: 0.84rem; margin-bottom: var(--space-4);
        }
        h1, h2, h3 { font-family: var(--font-display); line-height: 1.28; }
        h1 { margin: 0 0 var(--space-4); font-size: clamp(1.8rem, 4vw, 3.2rem); }
        .lead {
            margin: 0 0 var(--space-5); font-size: 1.08rem;
            color: var(--muted); max-width: 780px;
        }

        .hero-actions {
            display: flex; gap: var(--space-3); flex-wrap: wrap;
        }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 0.5rem; min-height: 48px; padding: 0.9rem 1.15rem;
            border-radius: 999px; border: 1px solid transparent;
            font-weight: 700; text-decoration: none; transition: 0.2s ease;
        }
        .btn:hover { text-decoration: none; transform: translateY(-1px); }
        .btn-primary { background: var(--accent); color: #fff; box-shadow: var(--shadow); }
        .btn-primary:hover { background: var(--accent-strong); color: #fff; }
        .btn-secondary { background: #fff; color: var(--text); border-color: var(--line); }
        .btn-secondary:hover { border-color: #b7c3d4; color: var(--text); }

        section { padding: var(--space-7) 0; }

        .entry-list {
            display: grid;
            gap: var(--space-5);
        }
        .entry {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: var(--space-5);
        }
        .entry h2 {
            margin-top: 0;
            margin-bottom: 0.35rem;
            font-size: 1.2rem;
        }
        .entry h3 {
            margin: 0 0 var(--space-4);
            color: var(--muted);
            font-size: 1rem;
            font-family: var(--font-body);
        }
        .entry ul {
            margin: 0;
            padding-left: 1.1rem;
        }
        .entry li + li {
            margin-top: 0.5rem;
        }

        .callout {
            margin-top: var(--space-6);
            background: var(--surface-alt);
            border: 1px solid #d8e0ea;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: var(--space-5);
        }
        .callout h2 {
            margin-top: 0;
            margin-bottom: var(--space-3);
        }
        .callout p {
            margin: 0;
            color: var(--muted);
        }

        .site-footer { padding: var(--space-7) 0 var(--space-8); }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.3fr 1fr 1fr 1fr;
            gap: var(--space-5);
        }
        .footer-col h3 { margin: 0 0 var(--space-3); font-size: 0.98rem; }
        .footer-col p, .footer-col li { color: var(--muted); margin: 0; }
        .footer-col ul { list-style: none; padding: 0; margin: 0; }
        .footer-col li + li { margin-top: 0.55rem; }
        .footer-bottom {
            margin-top: var(--space-6);
            padding-top: var(--space-4);
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 0.92rem;
        }

        @media (max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr; }
            .site-header-inner { align-items: flex-start; padding: 1rem 0; }
            .nav { gap: var(--space-3); }
        }

        @media (max-width: 720px) {
            .site-header { position: static; }
            .site-header-inner { flex-direction: column; align-items: stretch; }
            .nav { justify-content: flex-start; }
            .entry, .callout { padding: var(--space-4); }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="container site-header-inner">
        <a class="brand" href="/" aria-label="Datamorpho home">
            <span class="brand-title">DATAMORPHO</span>
            <span class="brand-subtitle">Changelog</span>
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
        <div class="container">
            <div class="eyebrow">Changelog</div>
            <h1>Public release history</h1>
            <p class="lead">
                This page tracks the main public release milestones of Datamorpho across the specification, whitepaper, website, and protocol-facing public materials.
            </p>

            <div class="hero-actions">
                <a class="btn btn-primary" href="/specification">Read the Specification</a>
                <a class="btn btn-secondary" href="/whitepaper">Open the Whitepaper</a>
                <a class="btn btn-secondary" href="/roadmap">View the Roadmap</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="entry-list">
                <?php foreach ($entries as $entry): ?>
                    <article class="entry">
                        <h2><?php echo htmlspecialchars($entry['version'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <h3><?php echo htmlspecialchars($entry['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <ul>
                            <?php foreach ($entry['items'] as $item): ?>
                                <li><?php echo htmlspecialchars($item, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="callout">
                <h2>Why this changelog matters</h2>
                <p>
                    Datamorpho is an open protocol project. Public release history helps keep the specification, whitepaper, tooling direction, and website aligned as the project evolves.
                </p>
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