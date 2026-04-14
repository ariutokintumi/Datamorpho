<?php
declare(strict_types=1);
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datamorpho Creator - Demo Tool</title>
    <meta name="description" content="Datamorpho Creator demo page for JPEG and TXT carriers. Browser-side JS processing will be added after the Python reference tooling is fully tested.">
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
            --max: 1100px;
            --space-3: 1rem;
            --space-4: 1.25rem;
            --space-5: 1.5rem;
            --space-6: 2rem;
            --space-7: 3rem;
            --space-8: 4rem;
        }
        * { box-sizing: border-box; }
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
        .site-header { position: sticky; top: 0; z-index: 50; backdrop-filter: blur(12px); background: rgba(246,247,248,0.9); border-bottom: 1px solid rgba(214,219,227,0.85); }
        .site-header-inner { display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); min-height: 74px; }
        .brand { display: inline-flex; flex-direction: column; gap: 0.15rem; color: var(--text); text-decoration: none; }
        .brand:hover { color: var(--text); text-decoration: none; }
        .brand-title { font-family: var(--font-display); font-size: 1rem; letter-spacing: 0.04em; text-transform: uppercase; }
        .brand-subtitle { color: var(--muted); font-size: 0.84rem; }
        .nav { display: flex; align-items: center; gap: var(--space-4); flex-wrap: wrap; justify-content: flex-end; }
        .nav a { font-size: 0.94rem; color: var(--muted); text-decoration: none; }
        .nav a:hover { color: var(--text); }
        .nav-cta { display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1rem; border-radius: 999px; background: var(--text); color: #fff !important; font-weight: 700; box-shadow: var(--shadow); }
        .hero, section { padding: var(--space-7) 0; }
        .eyebrow { display: inline-flex; align-items: center; gap: 0.55rem; padding: 0.45rem 0.8rem; border-radius: 999px; background: var(--accent-soft); color: var(--accent-strong); font-weight: 700; font-size: 0.84rem; margin-bottom: var(--space-4); }
        h1, h2, h3 { font-family: var(--font-display); line-height: 1.28; }
        h1 { margin: 0 0 var(--space-4); font-size: clamp(1.8rem, 4vw, 3.2rem); }
        .lead { margin: 0 0 var(--space-5); font-size: 1.08rem; color: var(--muted); max-width: 780px; }
        .hero-actions, .section-actions { display: flex; gap: var(--space-3); flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; min-height: 48px; padding: 0.9rem 1.15rem; border-radius: 999px; border: 1px solid transparent; font-weight: 700; text-decoration: none; transition: 0.2s ease; }
        .btn:hover { text-decoration: none; transform: translateY(-1px); }
        .btn-primary { background: var(--accent); color: #fff; box-shadow: var(--shadow); }
        .btn-secondary { background: #fff; color: var(--text); border-color: var(--line); }
        .grid-2 { display: grid; gap: var(--space-4); grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .card, .callout, .form-shell { background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius); box-shadow: var(--shadow); padding: var(--space-5); }
        .card h3, .form-shell h2 { margin-top: 0; margin-bottom: var(--space-3); }
        .card p, .callout p, .field-help, .limit-note { margin: 0; color: var(--muted); }
        .callout { background: var(--warning-soft); }
        .form-grid { display: grid; gap: var(--space-4); }
        .field { display: grid; gap: 0.55rem; }
        label { font-weight: 700; }
        input[type="file"], select, input[type="text"] { width: 100%; padding: 0.85rem 0.95rem; border: 1px solid var(--line); border-radius: 12px; background: #fff; font: inherit; }
        .checks { display: grid; gap: 0.9rem; margin-top: var(--space-4); }
        .check { display: grid; grid-template-columns: 20px 1fr; gap: 0.8rem; align-items: start; }
        .placeholder { margin-top: var(--space-5); padding: var(--space-5); border: 1px dashed #afbccd; border-radius: 12px; background: #f9fbfd; color: var(--muted); }
        .honeypot { position: absolute !important; left: -10000px !important; width: 1px !important; height: 1px !important; overflow: hidden !important; }
        .site-footer { padding: var(--space-7) 0 var(--space-8); }
        .footer-bottom { margin-top: var(--space-6); padding-top: var(--space-4); border-top: 1px solid var(--line); color: var(--muted); font-size: 0.92rem; }
        @media (max-width: 900px) { .grid-2, .site-header-inner { grid-template-columns: 1fr; } .site-header-inner { flex-direction: column; align-items: stretch; padding: 1rem 0; } .nav { justify-content: flex-start; } }
    </style>
</head>
<body>
<header class="site-header">
    <div class="container site-header-inner">
        <a class="brand" href="index.php" aria-label="Datamorpho home">
            <span class="brand-title">DATAMORPHO</span>
            <span class="brand-subtitle">Creator · Demo form · Browser JS coming next</span>
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
        <div class="container">
            <div class="eyebrow">Creator demo form</div>
            <h1>Create a Datamorphed JPEG or TXT file</h1>
            <p class="lead">
                This page is being prepared for the browser-side JavaScript implementation. The first tested reference implementation is Python, and once it is fully validated the same logic will be migrated to JS so files are processed in the browser instead of on the server.
            </p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="https://github.com/ariutokintumi/datamorpho" target="_blank" rel="noopener noreferrer">Reference code on GitHub</a>
                <a class="btn btn-secondary" href="tools-reconstruct.php">Open Reconstructor</a>
            </div>
        </div>
    </section>

    <section>
        <div class="container grid-2">
            <article class="form-shell">
                <h2>Planned creator interface</h2>
                <form action="#" method="post" enctype="multipart/form-data" novalidate>
                    <div class="form-grid">
                        <div class="field">
                            <label for="carrier_file">Base carrier file</label>
                            <input id="carrier_file" name="carrier_file" type="file" accept=".jpg,.jpeg,.txt">
                            <p class="field-help">Supported in this first demo implementation: JPEG and TXT only. Maximum 5 MiB per file.</p>
                        </div>

                        <div class="field">
                            <label for="state_files">Hidden state files</label>
                            <input id="state_files" name="state_files[]" type="file" multiple accept=".jpg,.jpeg,.txt,.bin,.json,.md,.csv,.pdf">
                            <p class="field-help">Maximum 5 hidden states in this first demo implementation. Each file maximum: 5 MiB.</p>
                        </div>

                        <div class="field">
                            <label for="suite_profile">Cryptographic profile</label>
                            <select id="suite_profile" name="suite_profile">
                                <option value="simple">simple — alternates AES-256-GCM and AES-256-CTR+HMAC-SHA-256</option>
                                <option value="hardened">hardened — alternates RSA-OAEP-4096+AES-256-GCM and RSA-OAEP-4096+AES-256-CTR+HMAC-SHA-256</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="layout_strategy">Layout strategy</label>
                            <select id="layout_strategy" name="layout_strategy">
                                <option value="sparse-with-chaff">sparse-with-chaff</option>
                                <option value="sparse">sparse</option>
                            </select>
                        </div>

                        <div class="honeypot" aria-hidden="true">
                            <label for="website_field">Leave this field empty</label>
                            <input id="website_field" name="website_field" type="text" autocomplete="off">
                        </div>
                    </div>

                    <div class="checks">
                        <label class="check"><input type="checkbox" required> <span>I understand this public website demo is not private. Successful website-tool usage will log original file hashes, output file hash, and reconstruction object data for security purposes.</span></label>
                        <label class="check"><input type="checkbox" required> <span>I understand this demo should not be used for illegal activity and that Datamorpho does not permit or endorse unlawful use.</span></label>
                        <label class="check"><input type="checkbox" required> <span>I understand the operators of this public demo may cooperate with lawful authority requests regarding files processed through this website demo.</span></label>
                        <label class="check"><input type="checkbox" required> <span>I understand that for privacy-sensitive use I should run my own implementation locally instead of relying on this public demo website.</span></label>
                    </div>

                    <div class="placeholder">
                        <strong>Browser-side processing placeholder</strong><br>
                        The real JS creator flow will appear here after the Python reference implementation is finalized and tested. For now this form is informational only and does not process or upload files.
                    </div>
                </form>
            </article>

            <aside class="card">
                <h3>Current implementation scope</h3>
                <p class="limit-note">The first reference implementation is intentionally limited.</p>
                <ul>
                    <li>JPEG and TXT only for the usable demo</li>
                    <li>5 MiB maximum per input file by default</li>
                    <li>5 hidden states maximum by default</li>
                    <li>No processing of carriers that already contain Datamorpho data</li>
                    <li>Python first, browser-side JS immediately after</li>
                </ul>
                <div class="callout" style="margin-top: 1.5rem;">
                    <p><strong>Important</strong><br>In the hardened profile, RSA is used only to wrap per-fragment secret material. The fragment payload itself is encrypted once with its symmetric suite. That is envelope encryption, not double-encrypting the fragment payload.</p>
                </div>
            </aside>
        </div>
    </section>
</main>
<footer class="site-footer">
    <div class="container">
        <div class="footer-bottom">&copy; <?php echo htmlspecialchars($year, ENT_QUOTES, 'UTF-8'); ?> Datamorpho. Contact: <a href="mailto:g@evvm.org">g@evvm.org</a>.</div>
    </div>
</footer>
</body>
</html>