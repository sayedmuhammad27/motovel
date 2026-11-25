import os
import re
import base64
import subprocess
import time

MD_PATH = r"D:\Xampp\htdocs\motovel\docs\LAPORAN_PRAKTIKUM_MOTOVEL.md"
HTML_PATH = r"D:\Xampp\htdocs\motovel\docs\LAPORAN_PRAKTIKUM_MOTOVEL.html"
PDF_PATH = r"D:\Xampp\htdocs\motovel\docs\LAPORAN_PRAKTIKUM_MOTOVEL.pdf"
CHROME_PATH = r"C:\Program Files (x86)\Google\Chrome\Application\chrome.exe"
TEMP_USER_DATA = r"D:\Xampp\htdocs\motovel\docs\chrome_temp"

os.makedirs(TEMP_USER_DATA, exist_ok=True)

with open(MD_PATH, 'r', encoding='utf-8') as f:
    md_text = f.read()

def format_inline(text):
    text = re.sub(r'\*\*(.*?)\*\*', r'<b>\1</b>', text)
    text = re.sub(r'\*(.*?)\*', r'<i>\1</i>', text)
    text = re.sub(r'`(.*?)`', r'<code class="inline-code">\1</code>', text)
    return text

def get_image_base64(rel_path):
    abs_path = os.path.normpath(os.path.join(os.path.dirname(MD_PATH), rel_path))
    if os.path.exists(abs_path):
        with open(abs_path, 'rb') as img_f:
            b64_data = base64.b64encode(img_f.read()).decode('utf-8')
            return f"data:image/png;base64,{b64_data}"
    return rel_path

lines = md_text.split('\n')
html_body = []
in_code = False
code_lang = ""
code_buffer = []

in_table = False
table_buffer = []

def flush_table(buffer):
    if not buffer:
        return ""
    # Filter separator row
    rows = []
    for r in buffer:
        cells = [c.strip() for c in r.split('|')[1:-1]]
        # check if it is separator row (e.g. ---, :---:)
        if all(re.match(r'^:?-+:?$', c) for c in cells if c):
            continue
        rows.append(cells)
    if not rows:
        return ""
    
    out = ['<div class="table-responsive"><table class="report-table">']
    # header
    out.append('<thead><tr>')
    for h in rows[0]:
        out.append(f'<th>{format_inline(h)}</th>')
    out.append('</tr></thead><tbody>')
    # body
    for row in rows[1:]:
        out.append('<tr>')
        for c in row:
            out.append(f'<td>{format_inline(c)}</td>')
        out.append('</tr>')
    out.append('</tbody></table></div>')
    return "\n".join(out)

i = 0
while i < len(lines):
    line = lines[i]

    # Handle Table
    if line.strip().startswith('|') and line.strip().endswith('|'):
        if not in_table:
            in_table = True
            table_buffer = []
        table_buffer.append(line.strip())
        i += 1
        continue
    else:
        if in_table:
            html_body.append(flush_table(table_buffer))
            in_table = False
            table_buffer = []

    # Handle Code Block
    if line.startswith('```'):
        if not in_code:
            in_code = True
            code_lang = line.replace('```', '').strip()
            code_buffer = []
        else:
            in_code = False
            code_content = "\n".join(code_buffer)
            code_content = code_content.replace('&', '&amp;').replace('<', '&lt;').replace('>', '&gt;')
            html_body.append(f'''
            <div class="code-wrapper">
                <div class="code-header">
                    <span class="code-lang-badge">{code_lang or "code"}</span>
                </div>
                <pre><code>{code_content}</code></pre>
            </div>
            ''')
        i += 1
        continue

    if in_code:
        code_buffer.append(line)
        i += 1
        continue

    # Image markdown: ![alt](src)
    img_match = re.match(r'!\[(.*?)\]\((.*?)\)', line.strip())
    if img_match:
        alt_text = img_match.group(1)
        raw_src = img_match.group(2)
        b64_src = get_image_base64(raw_src)
        html_body.append(f'''
        <div class="figure-container">
            <div class="figure-card">
                <img src="{b64_src}" alt="{alt_text}" />
            </div>
            <p class="figure-caption"><b>{alt_text}</b></p>
        </div>
        ''')
        i += 1
        continue

    # Check for BAB Header combination: # BAB X followed by # TITLE
    if line.startswith('# BAB '):
        bab_num = line.replace('# ', '').strip()
        next_title = ""
        if i + 1 < len(lines) and lines[i + 1].startswith('# '):
            next_title = lines[i + 1].replace('# ', '').strip()
            i += 1
        html_body.append(f'''
        <div class="bab-header-box">
            <h1 class="bab-number">{bab_num}</h1>
            {f'<h2 class="bab-title">{next_title}</h2>' if next_title else ''}
        </div>
        ''')
        i += 1
        continue

    # Top Title
    if line.startswith('# LAPORAN PRAKTIKUM'):
        i += 1
        continue

    # Other Headers
    if line.startswith('# '):
        html_body.append(f'<h1 class="chapter-title">{format_inline(line[2:])}</h1>')
    elif line.startswith('## '):
        html_body.append(f'<h2 class="sub-title">{format_inline(line[3:])}</h2>')
    elif line.startswith('### '):
        html_body.append(f'<h3 class="section-title">{format_inline(line[4:])}</h3>')
    elif line.startswith('#### '):
        html_body.append(f'<h4 class="sub-section-title">{format_inline(line[5:])}</h4>')
    elif line.startswith('---'):
        html_body.append('<hr class="divider" />')
    elif line.startswith('- ') or line.startswith('* '):
        html_body.append(f'<li class="bullet-item">{format_inline(line[2:])}</li>')
    elif re.match(r'^\d+\.\s', line):
        num_content = re.sub(r'^\d+\.\s', '', line)
        html_body.append(f'<li class="numbered-item">{format_inline(num_content)}</li>')
    elif line.strip() == '':
        html_body.append('<div class="spacer"></div>')
    else:
        html_body.append(f'<p class="para">{format_inline(line)}</p>')

    i += 1

if in_table:
    html_body.append(flush_table(table_buffer))

final_body = "\n".join(html_body)

full_html = f"""<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>LAPORAN PRAKTIKUM TEKNOLOGI SISTEM TERINTEGRASI — MOTOVEL</title>
<style>
  @page {{
    size: A4;
    margin: 25mm 20mm 25mm 25mm;
  }}

  * {{
    box-sizing: border-box;
  }}

  body {{
    font-family: 'Times New Roman', Times, serif;
    font-size: 12pt;
    line-height: 1.6;
    color: #111;
    background: #eef2f6;
    margin: 0;
    padding: 20px 0;
  }}

  .page-container {{
    max-width: 900px;
    margin: 0 auto;
    padding: 50px 60px;
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border-radius: 4px;
  }}

  /* COVER PAGE */
  .cover-page {{
    text-align: center;
    min-height: 980px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    page-break-after: always;
    padding: 30px 20px;
  }}

  .cover-title-main {{
    font-size: 16pt;
    font-weight: bold;
    letter-spacing: 1px;
    line-height: 1.4;
    margin-bottom: 16px;
    text-transform: uppercase;
  }}

  .cover-subtitle {{
    font-size: 12.5pt;
    font-weight: bold;
    color: #2b2b2b;
    line-height: 1.5;
    margin-bottom: 25px;
    text-transform: uppercase;
  }}

  .cover-logo-box {{
    margin: 35px auto;
    width: 150px;
    height: 150px;
    border: 3.5px solid #C62828;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #0f172a;
    box-shadow: 0 8px 24px rgba(198, 40, 40, 0.25);
  }}

  .logo-text {{
    font-family: 'Georgia', serif;
    font-size: 20pt;
    font-weight: 900;
    letter-spacing: 2px;
    color: #ffffff;
  }}

  .logo-sub {{
    font-size: 8pt;
    color: #EF4444;
    letter-spacing: 1.5px;
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 4px;
  }}

  .cover-meta {{
    text-align: left;
    margin: 25px auto;
    width: 82%;
    font-size: 11.5pt;
    line-height: 1.9;
  }}

  .cover-meta table {{
    width: 100%;
    border-collapse: collapse;
  }}

  .cover-meta td {{
    padding: 3px 0;
    vertical-align: top;
  }}

  .cover-footer {{
    margin-top: 30px;
    font-weight: bold;
    font-size: 11.5pt;
    line-height: 1.5;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }}

  /* BAB HEADINGS */
  .bab-header-box {{
    text-align: center;
    margin-top: 45px;
    margin-bottom: 25px;
    page-break-before: always;
  }}

  .bab-number {{
    font-size: 15pt;
    font-weight: bold;
    text-transform: uppercase;
    margin: 0;
    letter-spacing: 1px;
  }}

  .bab-title {{
    font-size: 14pt;
    font-weight: bold;
    text-transform: uppercase;
    margin: 4px 0 0 0;
    letter-spacing: 0.8px;
  }}

  .chapter-title {{
    font-size: 15pt;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
    margin-top: 40px;
    margin-bottom: 20px;
    page-break-before: always;
  }}

  .sub-title {{
    font-size: 13pt;
    font-weight: bold;
    margin-top: 26px;
    margin-bottom: 12px;
    border-bottom: 1.5px solid #111;
    padding-bottom: 4px;
    text-transform: uppercase;
  }}

  .section-title {{
    font-size: 12pt;
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 8px;
    color: #1a1a1a;
  }}

  .sub-section-title {{
    font-size: 11.5pt;
    font-weight: bold;
    margin-top: 15px;
    margin-bottom: 6px;
    color: #262626;
  }}

  .para {{
    text-align: justify;
    text-indent: 32px;
    margin-top: 0;
    margin-bottom: 12px;
    line-height: 1.6;
  }}

  .bullet-item, .numbered-item {{
    text-align: justify;
    margin-left: 36px;
    margin-bottom: 6px;
    line-height: 1.55;
  }}

  /* FIGURES & SCREENSHOTS */
  .figure-container {{
    text-align: center;
    margin: 22px auto 28px auto;
    page-break-inside: avoid;
  }}

  .figure-card {{
    display: inline-block;
    max-width: 98%;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
    overflow: hidden;
  }}

  .figure-card img {{
    display: block;
    max-width: 100%;
    height: auto;
    margin: 0 auto;
  }}

  .figure-caption {{
    font-size: 10.5pt;
    font-style: italic;
    color: #374151;
    margin-top: 9px;
    margin-bottom: 4px;
    text-align: center;
  }}

  /* CODE BLOCKS */
  .code-wrapper {{
    background: #0f172a;
    border: 1px solid #1e293b;
    border-radius: 6px;
    margin: 14px 0 20px 0;
    overflow: hidden;
    page-break-inside: avoid;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  }}

  .code-header {{
    background: #1e293b;
    padding: 4px 12px;
    display: flex;
    justify-content: flex-start;
  }}

  .code-lang-badge {{
    font-family: 'Consolas', 'Courier New', monospace;
    font-size: 8.5pt;
    font-weight: bold;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }}

  pre {{
    margin: 0;
    padding: 12px 16px;
    font-family: 'Consolas', 'Courier New', monospace;
    font-size: 9.5pt;
    line-height: 1.45;
    color: #f1f5f9;
    overflow-x: auto;
    white-space: pre-wrap;
    word-break: break-all;
  }}

  code.inline-code {{
    font-family: 'Consolas', monospace;
    font-size: 10pt;
    background: #f1f5f9;
    color: #b91c1c;
    padding: 2px 5px;
    border-radius: 3px;
    border: 1px solid #e2e8f0;
  }}

  /* TABLES */
  .table-responsive {{
    margin: 16px 0 22px 0;
    page-break-inside: avoid;
    overflow-x: auto;
  }}

  .report-table {{
    width: 100%;
    border-collapse: collapse;
    font-size: 10pt;
    font-family: 'Times New Roman', serif;
  }}

  .report-table th {{
    background: #1e293b;
    color: #ffffff;
    padding: 8px 10px;
    text-align: left;
    border: 1px solid #334155;
    font-weight: bold;
  }}

  .report-table td {{
    padding: 7px 10px;
    border: 1px solid #cbd5e1;
    color: #1e293b;
  }}

  .report-table tr:nth-child(even) {{
    background: #f8fafc;
  }}

  .divider {{
    border: none;
    border-top: 1px solid #e2e8f0;
    margin: 28px 0;
  }}

  .spacer {{
    height: 8px;
  }}

  @media print {{
    body {{
      background: #ffffff;
      padding: 0;
    }}

    .page-container {{
      max-width: 100%;
      padding: 0;
      box-shadow: none;
      border-radius: 0;
    }}

    .bab-header-box {{
      page-break-before: always;
    }}

    .figure-container {{
      page-break-inside: avoid;
    }}

    .code-wrapper {{
      page-break-inside: avoid;
    }}

    .table-responsive {{
      page-break-inside: avoid;
    }}
  }}
</style>
</head>
<body>
<div class="page-container">

  <!-- COVER PAGE -->
  <div class="cover-page">
    <div>
      <div class="cover-title-main">
        LAPORAN PRAKTIKUM TEKNOLOGI SISTEM TERINTEGRASI
      </div>
      <div class="cover-subtitle">
        PENGEMBANGAN SISTEM INFORMASI MANAJEMEN SERVIS SEPEDA MOTOR (MOTOVEL)<br>
        BERBASIS LARAVEL 12, MYSQL, REST API, POSTMAN, DAN GITHUB
      </div>
    </div>

    <div class="cover-logo-box">
      <div class="logo-text">MOTOVEL</div>
      <div class="logo-sub">Precision Care</div>
    </div>

    <div class="cover-meta">
      <table>
        <tr><td style="width:160px;"><b>DISUSUN OLEH</b></td><td style="width:15px;">:</td><td></td></tr>
        <tr><td><b>NIM</b></td><td>:</td><td>202590343008</td></tr>
        <tr><td><b>NAMA</b></td><td>:</td><td>MUHAMMAD ARSYA AZZAIDI</td></tr>
        <tr><td><b>KELAS</b></td><td>:</td><td>TRKJ.2A</td></tr>
        <tr><td><b>JURUSAN</b></td><td>:</td><td>TEKNOLOGI INFORMASI DAN KOMPUTER</td></tr>
        <tr><td><b>PROGRAM STUDI</b></td><td>:</td><td>TEKNOLOGI REKAYASA KOMPUTER JARINGAN</td></tr>
        <tr><td><b>DOSEN PENGAMPU</b></td><td>:</td><td>Hari Toha Hidayat, S.Si., M.Cs</td></tr>
      </table>
    </div>

    <div class="cover-footer">
      PROGRAM STUDI TEKNOLOGI REKAYASA KOMPUTER JARINGAN<br>
      JURUSAN TEKNOLOGI INFORMASI DAN KOMPUTER<br>
      POLITEKNIK NEGERI LHOKSEUMAWE<br>
      2026
    </div>
  </div>

  <!-- REPORT BODY -->
  {final_body}

</div>
</body>
</html>
"""

with open(HTML_PATH, 'w', encoding='utf-8') as f:
    f.write(full_html)

html_size_mb = os.path.getsize(HTML_PATH) / (1024 * 1024)
print(f"[OK] Generated standalone HTML: {HTML_PATH} ({html_size_mb:.2f} MB)")

# Render to PDF using Chrome headless
print("Generating PDF from HTML via Chrome...")
cmd = [
    CHROME_PATH,
    "--headless=new",
    "--disable-gpu",
    "--no-sandbox",
    "--allow-file-access-from-files",
    f"--user-data-dir={TEMP_USER_DATA}",
    f"--print-to-pdf={PDF_PATH}",
    "--no-pdf-header-footer",
    f"file:///{HTML_PATH.replace(os.sep, '/')}"
]
proc = subprocess.run(cmd, capture_output=True, text=True)
time.sleep(3)

if os.path.exists(PDF_PATH):
    size_mb = os.path.getsize(PDF_PATH) / (1024 * 1024)
    print(f"[SUCCESS] PDF generated: {PDF_PATH} ({size_mb:.2f} MB)")
else:
    print(f"[ERROR] PDF generation failed: {proc.stderr}")
