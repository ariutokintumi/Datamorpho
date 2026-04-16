<?php
declare(strict_types=1);
$year = date('Y');
$repoBase = 'https://github.com/ariutokintumi/datamorpho';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Tools - JPEG and TXT Demo Tooling</title>
    <meta name="description" content="Datamorpho tools portal for the first public JPEG and TXT demo implementation, the Python reference tooling, and the future browser-side JavaScript layer.">
    <meta name="theme-color" content="#0f172a">
    <style>
        @font-face {
            font-family: "Unifont";
            src: url("/assets/fonts/unifont-17.0.04.otf") format("opentype");
            font-display: swap;
        }

        :root {
            --bg:#f6f7f8;
            --surface:#ffffff;
            --surface-alt:#eef2f7;
            --text:#0f172a;
            --muted:#475569;
            --line:#d6dbe3;
            --accent:#0b57d0;
            --accent-strong:#083b8a;
            --accent-soft:#dbeafe;
            --warning-soft:#fef3c7;
            --shadow:0 14px 50px rgba(15,23,42,.08);
            --font-body:"Unifont","Courier New",monospace;
            --font-display:"Unifont","Courier New",monospace;
            --radius:18px;
            --radius-sm:12px;
            --max:1180px;
            --space-1:.5rem;
            --space-2:.75rem;
            --space-3:1rem;
            --space-4:1.25rem;
            --space-5:1.5rem;
            --space-6:2rem;
            --space-7:3rem;
            --space-8:4rem;
        }

        * { box-sizing:border-box; }
        html { scroll-behavior:smooth; }

        body {
            margin:0;
            background:linear-gradient(180deg,#fbfcfd 0%,#f6f7f8 100%);
            color:var(--text);
            font-family:var(--font-body);
            line-height:1.72;
        }

        a { color:var(--accent); text-decoration:none; }
        a:hover { color:var(--accent-strong); text-decoration:underline; }

        .container {
            width:min(calc(100% - 2rem), var(--max));
            margin:0 auto;
        }

        .site-header {
            position:sticky;
            top:0;
            z-index:50;
            backdrop-filter:blur(12px);
            background:rgba(246,247,248,.9);
            border-bottom:1px solid rgba(214,219,227,.85);
        }

        .site-header-inner {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:var(--space-4);
            min-height:74px;
        }

        .brand {
            display:inline-flex;
            flex-direction:column;
            gap:.15rem;
            color:var(--text);
            text-decoration:none;
            min-width:0;
        }

        .brand:hover {
            color:var(--text);
            text-decoration:none;
        }

        .brand-title {
            font-family:var(--font-display);
            font-size:1rem;
            letter-spacing:.04em;
            text-transform:uppercase;
        }

        .brand-subtitle {
            color:var(--muted);
            font-size:.84rem;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .nav {
            display:flex;
            align-items:center;
            gap:var(--space-4);
            flex-wrap:wrap;
            justify-content:flex-end;
        }

        .nav a {
            font-size:.94rem;
            color:var(--muted);
            text-decoration:none;
        }

        .nav a:hover { color:var(--text); }

        .nav-cta {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:.75rem 1rem;
            border-radius:999px;
            background:var(--text);
            color:#fff !important;
            font-weight:700;
            box-shadow:var(--shadow);
        }

        .nav-cta:hover {
            background:#1f2937;
            text-decoration:none;
        }

        .hero {
            padding:var(--space-8) 0 var(--space-7);
        }

        .hero-grid {
            display:grid;
            grid-template-columns:1.2fr .85fr;
            gap:var(--space-7);
            align-items:start;
        }

        .eyebrow {
            display:inline-flex;
            align-items:center;
            gap:.55rem;
            padding:.45rem .8rem;
            border-radius:999px;
            background:var(--accent-soft);
            color:var(--accent-strong);
            font-weight:700;
            font-size:.84rem;
            margin-bottom:var(--space-4);
        }

        h1,h2,h3,h4 {
            font-family:var(--font-display);
            line-height:1.28;
        }

        .hero h1 {
            margin:0 0 var(--space-4);
            font-size:clamp(1.8rem,4vw,3.4rem);
        }

        .lead {
            margin:0 0 var(--space-5);
            font-size:1.08rem;
            color:var(--muted);
            max-width:760px;
        }

        .hero-actions,.section-actions {
            display:flex;
            gap:var(--space-3);
            flex-wrap:wrap;
        }

        .hero-actions { margin-bottom:var(--space-5); }

        .btn {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:.5rem;
            min-height:48px;
            padding:.9rem 1.15rem;
            border-radius:999px;
            border:1px solid transparent;
            font-weight:700;
            text-decoration:none;
            transition:.2s ease;
        }

        .btn:hover {
            text-decoration:none;
            transform:translateY(-1px);
        }

        .btn-primary {
            background:var(--accent);
            color:#fff;
            box-shadow:var(--shadow);
        }

        .btn-primary:hover {
            background:var(--accent-strong);
            color:#fff;
        }

        .btn-secondary {
            background:#fff;
            color:var(--text);
            border-color:var(--line);
        }

        .btn-secondary:hover {
            border-color:#b7c3d4;
            color:var(--text);
        }

        .panel,.card,.callout {
            background:var(--surface);
            border:1px solid var(--line);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            padding:var(--space-5);
        }

        .card h3,.panel h2 {
            margin-top:0;
            margin-bottom:var(--space-3);
        }

        section {
            padding:var(--space-7) 0;
        }

        .section-head {
            margin-bottom:var(--space-6);
            max-width:920px;
        }

        .section-kicker {
            margin:0 0 var(--space-2);
            color:var(--accent);
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:.08em;
            font-size:.78rem;
        }

        .section-title {
            margin:0 0 var(--space-3);
            font-size:clamp(1.45rem,3vw,2.45rem);
        }

        .section-text {
            margin:0;
            color:var(--muted);
            font-size:1.02rem;
        }

        .grid-2,.grid-3 {
            display:grid;
            gap:var(--space-4);
        }

        .grid-2 { grid-template-columns:repeat(2,minmax(0,1fr)); }
        .grid-3 { grid-template-columns:repeat(3,minmax(0,1fr)); }

        .card p,.panel p {
            margin:0;
            color:var(--muted);
        }

        .soft {
            background:var(--surface-alt);
            border-color:#d8e0ea;
        }

        .feature-list {
            margin:0;
            padding-left:1.1rem;
        }

        .feature-list li + li {
            margin-top:.45rem;
        }

        .callout {
            background:var(--warning-soft);
        }

        .callout strong {
            display:block;
            margin-bottom:.35rem;
        }

        .callout p {
            margin:0;
            color:var(--text);
        }

        .placeholder {
            margin-top:var(--space-4);
            padding:var(--space-5);
            border:1px dashed #afbccd;
            border-radius:var(--radius-sm);
            background:#f9fbfd;
            color:var(--muted);
            font-size:.96rem;
        }

        .placeholder strong {
            color:var(--text);
            display:block;
            margin-bottom:.35rem;
        }

        .site-footer {
            padding:var(--space-7) 0 var(--space-8);
        }

        .footer-grid {
            display:grid;
            grid-template-columns:1.3fr 1fr 1fr 1fr;
            gap:var(--space-5);
        }

        .footer-col h3 {
            margin:0 0 var(--space-3);
            font-size:.98rem;
        }

        .footer-col p,.footer-col li {
            color:var(--muted);
            margin:0;
        }

        .footer-col ul {
            list-style:none;
            padding:0;
            margin:0;
        }

        .footer-col li + li {
            margin-top:.55rem;
        }

        .footer-bottom {
            margin-top:var(--space-6);
            padding-top:var(--space-4);
            border-top:1px solid var(--line);
            color:var(--muted);
            font-size:.92rem;
        }

        @media (max-width:1024px) {
            .hero-grid,.grid-3,.grid-2,.footer-grid {
                grid-template-columns:1fr;
            }

            .site-header-inner {
                align-items:flex-start;
                padding:1rem 0;
            }

            .nav { gap:var(--space-3); }
        }

        @media (max-width:720px) {
            .site-header { position:static; }
            .site-header-inner {
                flex-direction:column;
                align-items:stretch;
            }
            .nav { justify-content:flex-start; }
            .panel,.card,.callout { padding:var(--space-4); }
        }
    </style>
</head>
<body>
<header class="site-header">
    <div class="container site-header-inner">
        <a class="brand" href="/" aria-label="Datamorpho home">
            <span class="brand-title">DATAMORPHO</span>
            <span class="brand-subtitle">Free tooling · JPEG and TXT demo scope</span>
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
                <div class="eyebrow">Free tools · Python reference now · Browser JS next</div>
                <h1>Create and reconstruct Datamorphed files</h1>
                <p class="lead">
                    The first usable implementation path is the Python reference tooling. After it is fully tested, the public website tools will be implemented as browser-side JavaScript derived from that Python code, so the final public demo does not need to process user files on the web server.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="/tools-create">Open Creator</a>
                    <a class="btn btn-secondary" href="/tools-reconstruct">Open Reconstructor</a>
                    <a class="btn btn-secondary" href="<?php echo htmlspecialchars($repoBase, ENT_QUOTES, 'UTF-8'); ?>/tree/main/python" target="_blank" rel="noopener noreferrer">Python Reference Code</a>
                </div>
            </div>

            <aside class="panel">
                <h2>Scope of the first public demo</h2>
                <ul class="feature-list">
                    <li>Supported now: JPEG and TXT only</li>
                    <li>PDF intentionally excluded from the first usable implementation</li>
                    <li>Max default carrier file size: 5 MiB</li>
                    <li>Max default hidden states: 5</li>
                    <li>Max default hidden-state file size: 5 MiB each</li>
                    <li>Two browser-compatible suite profiles: simple and hardened</li>
                </ul>
            </aside>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Implementation path</p>
                <h2 class="section-title">Python first, JavaScript next</h2>
                <p class="section-text">
                    The website pages are being prepared now, but the real first implementation work happens in Python. Once the Python creator and reconstructor are stable and tested, they will be ported to front-end JavaScript so the public web demo can run without handing raw file-processing work to the server.
                </p>
            </div>

            <div class="grid-3">
                <article class="card">
                    <h3>Python Creator</h3>
                    <p>Reference tooling to create Datamorphed JPEG and TXT carriers, public manifests, and reconstruction objects.</p>
                    <div class="section-actions" style="margin-top:1.25rem;">
                        <a class="btn btn-primary" href="<?php echo htmlspecialchars($repoBase, ENT_QUOTES, 'UTF-8'); ?>/tree/main/python" target="_blank" rel="noopener noreferrer">View Python</a>
                    </div>
                </article>

                <article class="card">
                    <h3>Python Reconstructor</h3>
                    <p>Reference tooling to validate a Datamorphed carrier and reconstruct one target hidden state from a reconstruction object.</p>
                    <div class="section-actions" style="margin-top:1.25rem;">
                        <a class="btn btn-primary" href="<?php echo htmlspecialchars($repoBase, ENT_QUOTES, 'UTF-8'); ?>/tree/main/python" target="_blank" rel="noopener noreferrer">View Python</a>
                    </div>
                </article>

                <article class="card soft">
                    <h3>Browser JavaScript Layer</h3>
                    <p>Planned next. The future website demo will use browser-side JavaScript derived from the tested Python implementation instead of sending raw file-processing work to the server.</p>
                    <div class="section-actions" style="margin-top:1.25rem;">
                        <a class="btn btn-secondary" href="/roadmap">Roadmap</a>
                    </div>
                </article>
            </div>

            <div class="callout" style="margin-top:1.5rem;">
                <strong>Important</strong>
                <p>
                    The protocol specification still documents JPEG, TXT, and PDF at the standard level. The first public implementation and website demo intentionally narrow the usable scope to JPEG and TXT so the code can be tested and controlled properly before any broader support is advertised.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Cryptography profiles</p>
                <h2 class="section-title">Two browser-compatible starting profiles</h2>
                <p class="section-text">
                    The reference implementation begins with two profiles chosen to map cleanly to browser-native cryptographic primitives later: a fast profile for practical personal use, and a stronger profile with wrapped fragment secrets for more demanding use.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>simple</h3>
                    <p>
                        Alternates randomly by fragment between <code>AES-256-GCM</code> and <code>AES-256-CTR+HMAC-SHA-256</code>. This keeps the demo fast, clear, and aligned with the Datamorpho concept of heterogeneous fragment protection.
                    </p>
                </article>

                <article class="card">
                    <h3>hardened</h3>
                    <p>
                        Alternates randomly by fragment between <code>RSA-OAEP-4096+AES-256-GCM</code> and <code>RSA-OAEP-4096+AES-256-CTR+HMAC-SHA-256</code>. The fragment payload is still encrypted only once; RSA wraps fragment secret material. This is envelope encryption, not payload double-encryption.
                    </p>
                </article>
            </div>

            <div class="callout" style="margin-top:1.5rem;">
                <strong>Important concept</strong>
                <p>
                    In Datamorpho, different fragments of the same hidden state may use different suites. The demo should make that visible and explicit instead of pretending one state always uses one single algorithm.
                </p>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="section-head">
                <p class="section-kicker">Tool pages</p>
                <h2 class="section-title">Creator and Reconstructor pages are ready for future integration</h2>
                <p class="section-text">
                    The dedicated tool pages now expose the intended demo workflow, limits, legal/privacy warnings, and placeholder form layout so the later JavaScript integration can replace the placeholder blocks without redesigning the public pages.
                </p>
            </div>

            <div class="grid-2">
                <article class="card">
                    <h3>Creator page</h3>
                    <p>Carrier input, hidden-state inputs, suite selection, limits, policy acknowledgements, and a placeholder panel for the future browser workflow.</p>
                    <div class="section-actions" style="margin-top:1.25rem;">
                        <a class="btn btn-primary" href="/tools-create">Open Creator</a>
                    </div>
                </article>

                <article class="card">
                    <h3>Reconstructor page</h3>
                    <p>Carrier upload, reconstruction object upload, output expectations, demo logging notice, and a placeholder panel for the future browser workflow.</p>
                    <div class="section-actions" style="margin-top:1.25rem;">
                        <a class="btn btn-primary" href="/tools-reconstruct">Open Reconstructor</a>
                    </div>
                </article>
            </div>

            <div class="placeholder">
                <strong>Planned next after Python validation</strong>
                Port the tested creator and reconstructor flows to browser-side JavaScript, wire the public pages to those libraries, and only then enable the real interactive web demo.
            </div>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3>Datamorpho</h3>
                <p>An open file standard for multi-state concealed content, built as open infrastructure for secure distribution, controlled disclosure, and future-proof digital objects.</p>
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
                    <li><a href="<?php echo htmlspecialchars($repoBase, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">GitHub</a></li>
                    <li><a href="<?php echo htmlspecialchars($repoBase, ENT_QUOTES, 'UTF-8'); ?>/discussions" target="_blank" rel="noopener noreferrer">Discussions</a></li>
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