<?php
declare(strict_types=1);
$year = date('Y');

$terms = [
    [
        'term' => 'Base File',
        'definition' => 'The original visible file used as the carrier input before Datamorpho embedding.'
    ],
    [
        'term' => 'Carrier File',
        'definition' => 'The final Datamorphed file.'
    ],
    [
        'term' => 'Carrier Profile',
        'definition' => 'The file-family-specific embedding rules, such as jpeg-trailer, txt-envelope, or pdf-incremental.'
    ],
    [
        'term' => 'Chaff',
        'definition' => 'Bytes intentionally present in a payload region but not used by the target hidden state, added to increase ambiguity and attack cost.'
    ],
    [
        'term' => 'Concealed Payload',
        'definition' => 'The payload bytes from which one or more hidden states can be reconstructed.'
    ],
    [
        'term' => 'Datamorphed File',
        'definition' => 'A file that conforms to a Datamorpho carrier profile and contains a public manifest plus concealed payload data.'
    ],
    [
        'term' => 'Datamorphosis',
        'definition' => 'The capability of a file to contain one or more hidden states beyond its visible representation.'
    ],
    [
        'term' => 'Fragment',
        'definition' => 'A span of bytes referenced by a reconstruction object as part of one hidden state.'
    ],
    [
        'term' => 'Hidden State',
        'definition' => 'A concealed alternate content state associated with a Datamorphed file.'
    ],
    [
        'term' => 'Layout Strategy',
        'definition' => 'The arrangement model for meaningful bytes in a payload region. In v0.001: sparse or sparse-with-chaff.'
    ],
    [
        'term' => 'MorphoStorage',
        'definition' => 'A locator or direction layer describing where to look for the reconstruction object of a state.'
    ],
    [
        'term' => 'Public Manifest',
        'definition' => 'The intentionally visible metadata declaring Datamorphosis, states, triggers, MorphoStorage, and reconstruction-object digests.'
    ],
    [
        'term' => 'Reconstruction Object',
        'definition' => 'A state-specific secret-bearing artifact containing the instructions and secret material needed to reconstruct one hidden state.'
    ],
    [
        'term' => 'Sparse',
        'definition' => 'A layout strategy in which meaningful bytes are non-contiguous and only referenced spans matter.'
    ],
    [
        'term' => 'Sparse-with-Chaff',
        'definition' => 'A layout strategy in which meaningful bytes are non-contiguous and unreferenced bytes are intentionally present to increase ambiguity.'
    ],
    [
        'term' => 'Trigger',
        'definition' => 'A declared condition associated with a hidden state, such as time, event, action, ownership, or custom logic.'
    ],
    [
        'term' => 'Digest Cross-Binding',
        'definition' => 'The linking model in which public state descriptors reference reconstruction-object digests and reconstruction objects reference the carrier file digest.'
    ],
    [
        'term' => 'Key Material',
        'definition' => 'Secret material included in a reconstruction object and required to recover one or more fragments or a whole hidden state.'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Glossary</title>
    <meta name="description" content="Glossary of Datamorpho protocol terms and definitions.">
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
            --radius-sm: 12px;
            --max: 1100px;
            --space-2: 0.75rem;
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

        .glossary-list {
            display: grid;
            gap: var(--space-4);
        }
        .term-card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: var(--space-5);
        }
        .term-card h2 {
            margin-top: 0;
            margin-bottom: var(--space-3);
            font-size: 1.08rem;
        }
        .term-card p {
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
            .term-card, .callout { padding: var(--space-4); }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="container site-header-inner">
        <a class="brand" href="https://datamorpho.io/index.php" aria-label="Datamorpho home">
            <span class="brand-title">DATAMORPHO</span>
            <span class="brand-subtitle">Glossary</span>
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
        <div class="container">
            <div class="eyebrow">Glossary</div>
            <h1>Core Datamorpho terms and definitions</h1>
            <p class="lead">
                This glossary collects the main terms used across the specification, whitepaper, and website so the protocol can be read with a consistent vocabulary.
            </p>

            <div class="hero-actions">
                <a class="btn btn-primary" href="https://datamorpho.io/specification.php">Read the Specification</a>
                <a class="btn btn-secondary" href="https://datamorpho.io/whitepaper.php">Open the Whitepaper</a>
                <a class="btn btn-secondary" href="https://datamorpho.io/faq.php">Open the FAQ</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="glossary-list">
                <?php foreach ($terms as $item): ?>
                    <article class="term-card" id="<?php echo htmlspecialchars(strtolower(str_replace([' ', '/'], ['-', '-'], $item['term'])), ENT_QUOTES, 'UTF-8'); ?>">
                        <h2><?php echo htmlspecialchars($item['term'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <p><?php echo htmlspecialchars($item['definition'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="callout">
                <h2>Need more context?</h2>
                <p>
                    The glossary is intentionally concise. For formal structure, read the specification. For rationale and conceptual framing, read the whitepaper. For common questions, use the FAQ or open a public discussion.
                </p>

                <div class="hero-actions" style="margin-top: 1.5rem;">
                    <a class="btn btn-primary" href="https://datamorpho.io/specification.php">Read the Specification</a>
                    <a class="btn btn-secondary" href="https://datamorpho.io/whitepaper.php">Open the Whitepaper</a>
                    <a class="btn btn-secondary" href="https://datamorpho.io/community.php">Join the Discussion</a>
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