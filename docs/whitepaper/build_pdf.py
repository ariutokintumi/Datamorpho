"""
Convert Datamorpho whitepaper markdown to PDF via HTML.
Usage: python build_pdf.py
Requires: pip install markdown xhtml2pdf
"""
from __future__ import annotations

import re
import sys
from pathlib import Path

import markdown
from xhtml2pdf import pisa

HERE = Path(__file__).parent

MD_FILE  = HERE / "Datamorpho-Whitepaper-v0.001.md"
PDF_FILE = HERE / "Datamorpho-Whitepaper-v0.001.pdf"

CSS = """
@page {
    size: A4;
    margin: 2.2cm 2cm 2.2cm 2cm;
    @frame footer {
        -pdf-frame-content: footer_content;
        bottom: 1cm;
        height: 0.6cm;
        left: 2cm;
        right: 2cm;
    }
}

body {
    font-family: "Courier New", Courier, monospace;
    font-size: 10pt;
    line-height: 1.6;
    color: #0f172a;
}

h1 {
    font-size: 20pt;
    margin-top: 0;
    margin-bottom: 6pt;
    color: #0f172a;
    border-bottom: 2px solid #0b57d0;
    padding-bottom: 4pt;
}

h2 {
    font-size: 13pt;
    margin-top: 18pt;
    margin-bottom: 4pt;
    color: #0f172a;
    border-bottom: 1px solid #d6dbe3;
    padding-bottom: 2pt;
    page-break-after: avoid;
}

h3 {
    font-size: 11pt;
    margin-top: 12pt;
    margin-bottom: 3pt;
    color: #0f172a;
    page-break-after: avoid;
}

h4 {
    font-size: 10pt;
    margin-top: 8pt;
    margin-bottom: 2pt;
    color: #334155;
    page-break-after: avoid;
}

p {
    margin: 0 0 7pt 0;
}

code {
    font-family: "Courier New", Courier, monospace;
    font-size: 9pt;
    background: #f1f5f9;
    padding: 1pt 3pt;
    border-radius: 2pt;
    color: #0f172a;
}

pre {
    font-family: "Courier New", Courier, monospace;
    font-size: 8.5pt;
    background: #f1f5f9;
    border: 1px solid #d6dbe3;
    border-left: 3px solid #0b57d0;
    padding: 6pt 8pt;
    margin: 6pt 0;
    white-space: pre-wrap;
    word-wrap: break-word;
    page-break-inside: avoid;
}

pre code {
    background: none;
    padding: 0;
    border: none;
    font-size: 8.5pt;
}

blockquote {
    border-left: 3px solid #0b57d0;
    margin: 6pt 0 6pt 10pt;
    padding-left: 8pt;
    color: #475569;
    font-style: italic;
}

ul, ol {
    margin: 4pt 0 6pt 16pt;
    padding: 0;
}

li {
    margin-bottom: 2pt;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 8pt 0;
    font-size: 9pt;
    page-break-inside: avoid;
}

th {
    background: #0f172a;
    color: #ffffff;
    padding: 4pt 6pt;
    text-align: left;
    font-weight: bold;
}

td {
    padding: 3pt 6pt;
    border: 1px solid #d6dbe3;
    vertical-align: top;
}

tr:nth-child(even) td {
    background: #f8fafc;
}

hr {
    border: none;
    border-top: 1px solid #d6dbe3;
    margin: 12pt 0;
}

a {
    color: #0b57d0;
    text-decoration: none;
}

em {
    font-style: italic;
    color: #475569;
}

strong {
    font-weight: bold;
}

#footer_content {
    font-size: 8pt;
    color: #94a3b8;
    text-align: center;
}
"""

COVER_HTML = """
<div style="margin-top:50pt; text-align:center;">
  <p style="font-size:26pt; font-weight:bold; color:#0f172a; margin-bottom:4pt; letter-spacing:0.08em;">
    DATAMORPHO
  </p>
  <p style="font-size:14pt; color:#0b57d0; margin-bottom:4pt;">
    Whitepaper
  </p>
  <p style="font-size:10pt; color:#475569; margin-bottom:28pt;">
    A Publication-Ready Technical Release for Datamorpho v0.001
  </p>
  <hr style="border-top:2px solid #0b57d0; margin:0 40pt 28pt 40pt;"/>
  <table style="width:72%; margin:0 auto; font-size:10pt; border:none;">
    <tr>
      <td style="border:none; color:#475569; width:42%; text-align:right; padding:3pt 8pt;">Author</td>
      <td style="border:none; color:#0f172a; text-align:left; padding:3pt 8pt;">Germ&#225;n Abal &lt;g@evvm.org&gt;</td>
    </tr>
    <tr>
      <td style="border:none; color:#475569; text-align:right; padding:3pt 8pt;">Version</td>
      <td style="border:none; color:#0f172a; text-align:left; padding:3pt 8pt;">0.001</td>
    </tr>
    <tr>
      <td style="border:none; color:#475569; text-align:right; padding:3pt 8pt;">Status</td>
      <td style="border:none; color:#0f172a; text-align:left; padding:3pt 8pt;">Public Draft</td>
    </tr>
    <tr>
      <td style="border:none; color:#475569; text-align:right; padding:3pt 8pt;">Document Type</td>
      <td style="border:none; color:#0f172a; text-align:left; padding:3pt 8pt;">Whitepaper</td>
    </tr>
    <tr>
      <td style="border:none; color:#475569; text-align:right; padding:3pt 8pt;">Companion</td>
      <td style="border:none; color:#0f172a; text-align:left; padding:3pt 8pt; font-style:italic;">Datamorpho Specification v0.001</td>
    </tr>
    <tr>
      <td style="border:none; color:#475569; text-align:right; padding:3pt 8pt;">Website</td>
      <td style="border:none; color:#0b57d0; text-align:left; padding:3pt 8pt;">https://datamorpho.io</td>
    </tr>
    <tr>
      <td style="border:none; color:#475569; text-align:right; padding:3pt 8pt;">Repository</td>
      <td style="border:none; color:#0b57d0; text-align:left; padding:3pt 8pt;">github.com/ariutokintumi/datamorpho</td>
    </tr>
  </table>
</div>
<pdf:nextpage/>
"""

FOOTER_HTML = """
<div id="footer_content">
  Datamorpho Whitepaper v0.001 — Public Draft — datamorpho.io
</div>
"""


def md_to_html(md_text: str) -> str:
    lines = md_text.splitlines()
    # Skip the cover block (title, author, metadata) — replaced by COVER_HTML
    # Find where the abstract/intro section begins (first h3 or first hr)
    start = 0
    for i, line in enumerate(lines):
        if line.strip() == "---" and i > 10:
            start = i + 1
            break

    body_md = "\n".join(lines[start:])

    html_body = markdown.markdown(
        body_md,
        extensions=["tables", "fenced_code", "toc", "nl2br"],
    )

    # Clean up backslash-escaped characters
    html_body = html_body.replace("\\===", "===")
    html_body = html_body.replace("\\<", "&lt;")
    html_body = html_body.replace("\\_", "_")
    html_body = re.sub(r"\\([^\\])", r"\1", html_body)

    return html_body


def build_pdf() -> None:
    print(f"Reading  {MD_FILE}")
    md_text = MD_FILE.read_text(encoding="utf-8")

    print("Converting markdown to HTML ...")
    body_html = md_to_html(md_text)

    full_html = f"""<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <style>{CSS}</style>
</head>
<body>
{FOOTER_HTML}
{COVER_HTML}
{body_html}
</body>
</html>"""

    print(f"Writing  {PDF_FILE}")
    with PDF_FILE.open("wb") as fh:
        result = pisa.CreatePDF(full_html, dest=fh)

    if result.err:
        print(f"ERROR: xhtml2pdf reported {result.err} error(s).", file=sys.stderr)
        sys.exit(1)
    else:
        size_kb = PDF_FILE.stat().st_size // 1024
        print(f"Done -- {PDF_FILE.name} ({size_kb} KB)")


if __name__ == "__main__":
    build_pdf()
