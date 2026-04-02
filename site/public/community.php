<?php
declare(strict_types=1);
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Community - Discussion, Collaboration, and Support</title>
    <meta name="description" content="Join the Datamorpho community through GitHub, discussions, announcements, public review, and project support.">
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
        .grid-3,
        .grid-4 {
            display: grid;
            gap: var(--space-4);
        }

        .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

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
        <a class="brand" href="index.php" aria-label="Datamorpho home">
            <span class="brand-title">DATAMORPHO</span>
            <span class="brand-subtitle">Community · Discussion · Collaboration</span>
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
                <div class="eyebrow">Community and discussion</div>
                <h1>Public discussion is part of the protocol process</h1>
                <p class="lead">
                    Datamorpho is an open technical project and public discussion is part of how the protocol should evolve. Review the specification, join discussions, open issues, contribute examples, and help shape the future of multi-state file infrastructure.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">GitHub</a>
                    <a class="btn btn-secondary" href="https://github.com/ariutokintumi/datamorpho/discussions" target="_blank" rel="noopener noreferrer">Discussions</a>
                    <a class="btn btn-secondary" href="donate.php">Support the Project</a>
                </div>
            </div>

            <aside class="panel">
                <h2>What belongs where</h2>
                <ul class="feature-list">
                    <li><strong>GitHub Issues:</strong> concrete bugs, spec defects, and implementation tasks</li>
                    <li><strong>GitHub Discussions:</strong> protocol debate, design rationale, use cases, and roadmap</li>
                    <li><strong>Announcements:</strong> releases, updates, and public calls</li>
                    <li><strong>Contact:</strong> serious inquiries, collaboration, and media questions</li>
                </ul>
            </aside>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Join the project</p>
                <h2 class="section-title">The main public channels</h2>
                <p class="section-text">
                    Datamorpho is intended to grow through open review, open implementation, open examples, and open discussion.
                </p>
            </div>

            <div class="grid-4">
                <article class="card">
                    <h3>GitHub</h3>
                    <p>Source code, documentation, repository structure, tooling, and public collaboration.</p>
                    <div class="section-actions" style="margin-top: 1.25rem;">
                        <a class="btn btn-primary" href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">Open GitHub</a>
                    </div>
                </article>

                <article class="card">
                    <h3>Discussions</h3>
                    <p>Protocol questions, design conversations, rationale, use cases, and long-form technical debate.</p>
                    <div class="section-actions" style="margin-top: 1.25rem;">
                        <a class="btn btn-primary" href="https://github.com/ariutokintumi/datamorpho/discussions" target="_blank" rel="noopener noreferrer">Open Discussions</a>
                    </div>
                </article>

                <article class="card">
                    <h3>Announcements</h3>
                    <p>Project updates, releases, public milestones, and future calls for review.</p>
                    <div class="section-actions" style="margin-top: 1.25rem;">
                        <a class="btn btn-primary" href="https://x.com/datamorpho" target="_blank" rel="noopener noreferrer">Open X</a>
                    </div>
                </article>

                <article class="card soft">
                    <h3>Contact</h3>
                    <p>For serious inquiries, collaborations, or media questions, write to <a href="mailto:g@evvm.org">g@evvm.org</a>.</p>
                    <div class="section-actions" style="margin-top: 1.25rem;">
                        <a class="btn btn-secondary" href="mailto:g@evvm.org">Write to g@evvm.org</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">How to contribute</p>
                <h2 class="section-title">There are many valid entry points</h2>
                <p class="section-text">
                    Datamorpho is not only a specification project and not only a tooling project. There are multiple ways to contribute meaningfully.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Specification review</h3>
                    <p>Read the normative specification and challenge unclear language, edge cases, or extension points.</p>
                </article>

                <article class="card">
                    <h3>Implementation feedback</h3>
                    <p>Help improve Python and JavaScript tooling, error handling, examples, and protocol correctness.</p>
                </article>

                <article class="card">
                    <h3>Examples and vectors</h3>
                    <p>Create concrete test cases, interoperability vectors, carrier examples, and annotated sample files.</p>
                </article>

                <article class="card">
                    <h3>Documentation</h3>
                    <p>Improve explanations, glossary entries, diagrams, FAQs, and onboarding material.</p>
                </article>

                <article class="card">
                    <h3>Security review</h3>
                    <p>Examine assumptions, layout semantics, reconstruction-object handling, and cryptographic clarity.</p>
                </article>

                <article class="card">
                    <h3>Ecosystem adoption</h3>
                    <p>Help connect Datamorpho with real-world use cases, developer communities, research, and future interoperability work.</p>
                </article>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Open review</p>
                <h2 class="section-title">What to do first if you are new here</h2>
                <p class="section-text">
                    The best way to enter the project depends on what you care about most: protocol design, tooling, examples, or future use cases.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>If you want to understand the protocol</h3>
                    <ul class="feature-list">
                        <li>read the landing page</li>
                        <li>read the whitepaper</li>
                        <li>read the specification</li>
                        <li>open a discussion thread with questions or critiques</li>
                    </ul>
                </article>

                <article class="card">
                    <h3>If you want to build with it</h3>
                    <ul class="feature-list">
                        <li>review the specification</li>
                        <li>study the examples</li>
                        <li>test the tooling</li>
                        <li>open issues or propose improvements in public</li>
                    </ul>
                </article>
            </div>

            <div class="section-actions" style="margin-top: 2rem;">
                <a class="btn btn-secondary" href="specification.php">Read the Specification</a>
                <a class="btn btn-secondary" href="whitepaper.php">Open the Whitepaper</a>
                <a class="btn btn-secondary" href="examples.php">View Examples</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Support</p>
                <h2 class="section-title">Support the protocol as a public good</h2>
                <p class="section-text">
                    Datamorpho is being developed as open infrastructure: an open standard, open-source tooling suite, public documentation, public examples, and free web utilities. Support helps sustain maintenance, future contributors, public tooling, research, and ecosystem education.
                </p>
            </div>

            <div class="callout">
                <strong>Public-good framing</strong>
                <p>
                    The goal is to maintain Datamorpho as reusable public infrastructure for secure distribution, controlled disclosure, and future-proof digital objects, not as a closed private system.
                </p>
            </div>

            <div class="section-actions" style="margin-top: 1.5rem;">
                <a class="btn btn-primary" href="donate.php">Support the Project</a>
                <a class="btn btn-secondary" href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">View on GitHub</a>
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