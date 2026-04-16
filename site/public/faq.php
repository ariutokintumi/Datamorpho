<?php
declare(strict_types=1);
$year = date('Y');

$faqItems = [
    [
        'q' => 'Is Datamorpho steganography?',
        'a' => 'No. Datamorpho requires a public declaration that hidden states exist. That is fundamentally different from a system designed to deny or conceal the existence of hidden content.'
    ],
    [
        'q' => 'Does Datamorpho require one algorithm for the whole file?',
        'a' => 'No. A single hidden state may use different cryptographic suites across different fragments, and different states may use different combinations.'
    ],
    [
        'q' => 'Does the reconstruction object contain the key?',
        'a' => 'In v0.001, yes. The reconstruction object is a complete secret-bearing artifact and may include the key material needed to reconstruct the target hidden state.'
    ],
    [
        'q' => 'Does Datamorpho require states to be sequential?',
        'a' => 'No. States can be treated as an unordered set. They do not need to follow a linear release sequence.'
    ],
    [
        'q' => 'Can bytes from different states coexist in the same payload region?',
        'a' => 'Yes. In Datamorpho, the same payload region may contain bytes relevant to different states, along with chaff.'
    ],
    [
        'q' => 'Is Datamorpho limited to NFTs?',
        'a' => 'No. NFTs are only one important use case. Datamorpho is also relevant for games, publishing, archives, financial workflows, auctions, documents, news releases, and staged media.'
    ],
    [
        'q' => 'Why allow sparse without chaff?',
        'a' => 'Because in some large-file or bandwidth-sensitive deployments, sparse non-contiguous layout may already be sufficient while avoiding payload growth and transfer overhead.'
    ],
    [
        'q' => 'Does Datamorpho standardize viewers or trigger execution?',
        'a' => 'No. Datamorpho v0.001 standardizes the file structure and reconstruction semantics, not every possible viewer or trigger-validation mechanism.'
    ],
    [
        'q' => 'Why start with JPEG, TXT, and PDF?',
        'a' => 'Because they give a strong initial set of carriers across media, text, and structured documents.'
    ],
    [
        'q' => 'Why is the version 0.001 and not 0.002?',
        'a' => 'Because this is the first formal open specification release. The 2022 ETHGlobal Mexico project is the origin story and prototype lineage, not a prior published normative spec.'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho FAQ - Frequently Asked Questions</title>
    <meta name="description" content="Frequently asked questions about Datamorpho, multi-state files, reconstruction objects, carriers, and protocol boundaries.">
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

        h1, h2, h3 {
            font-family: var(--font-display);
            line-height: 1.28;
        }

        h1 {
            margin: 0 0 var(--space-4);
            font-size: clamp(1.8rem, 4vw, 3.2rem);
        }

        .lead {
            margin: 0 0 var(--space-5);
            font-size: 1.08rem;
            color: var(--muted);
            max-width: 780px;
        }

        .hero-actions,
        .section-actions {
            display: flex;
            gap: var(--space-3);
            flex-wrap: wrap;
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

        section {
            padding: var(--space-7) 0;
        }

        .faq-list {
            display: grid;
            gap: var(--space-4);
        }

        .faq-item {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: var(--space-5);
        }

        .faq-item h2 {
            margin-top: 0;
            margin-bottom: var(--space-3);
            font-size: 1.08rem;
        }

        .faq-item p {
            margin: 0;
            color: var(--muted);
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

            .faq-item,
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
            <span class="brand-subtitle">Frequently asked questions</span>
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
            <div class="eyebrow">FAQ</div>
            <h1>Frequently asked questions about Datamorpho</h1>
            <p class="lead">
                This short FAQ covers the most common conceptual questions about Datamorpho, reconstruction objects, carriers, layout strategy, and the boundaries of the standard.
            </p>

            <div class="hero-actions">
                <a class="btn btn-primary" href="/specification">Read the Specification</a>
                <a class="btn btn-secondary" href="/whitepaper">Open the Whitepaper</a>
                <a class="btn btn-secondary" href="/community">Join the Discussion</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="faq-list">
                <?php foreach ($faqItems as $index => $item): ?>
                    <article class="faq-item" id="faq-<?php echo (int)($index + 1); ?>">
                        <h2><?php echo htmlspecialchars(($index + 1) . '. ' . $item['q'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <p><?php echo htmlspecialchars($item['a'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="callout">
                <h2>Need a deeper answer?</h2>
                <p>
                    The FAQ is intentionally short. For the formal structure of the protocol, read the specification. For the conceptual rationale and security framing, read the whitepaper. For questions, critiques, or proposals, use the public discussion channels or write to <a href="mailto:g@evvm.org">g@evvm.org</a>.
                </p>

                <div class="hero-actions" style="margin-top: 1.5rem;">
                    <a class="btn btn-primary" href="/specification">Read the Specification</a>
                    <a class="btn btn-secondary" href="/whitepaper">Open the Whitepaper</a>
                    <a class="btn btn-secondary" href="/community">Open Community</a>
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