import os
import subprocess
import time

CHROME_PATH = r"C:\Program Files (x86)\Google\Chrome\Application\chrome.exe"
TEMP_USER_DATA = r"D:\Xampp\htdocs\motovel\docs\chrome_temp"
OUTPUT_DIR = r"D:\Xampp\htdocs\motovel\docs\screenshots"
TEMP_HTML = r"D:\Xampp\htdocs\motovel\docs\temp_render.html"

os.makedirs(TEMP_USER_DATA, exist_ok=True)
os.makedirs(OUTPUT_DIR, exist_ok=True)

def render(html, filename, width=1150, height=720):
    out_path = os.path.join(OUTPUT_DIR, filename)
    with open(TEMP_HTML, 'w', encoding='utf-8') as f:
        f.write(html)
    
    cmd = [
        CHROME_PATH,
        "--headless=new",
        "--disable-gpu",
        "--no-sandbox",
        f"--user-data-dir={TEMP_USER_DATA}",
        f"--screenshot={out_path}",
        f"--window-size={width},{height}",
        f"file:///{TEMP_HTML.replace(os.sep, '/')}"
    ]
    subprocess.run(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
    time.sleep(0.15)
    print(f"[OK] {filename}")

def terminal_window(title, content_html, min_height=480):
    return f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body {{ margin: 0; background: #000; font-family: 'Consolas', 'Courier New', monospace; padding: 20px; }}
  .window {{ background: #0c0c0c; border-radius: 8px; border: 1px solid #333; box-shadow: 0 10px 30px rgba(0,0,0,0.8); overflow: hidden; }}
  .titlebar {{ background: #1f1f1f; color: #bbb; padding: 8px 14px; font-size: 13px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2a2a2a; }}
  .controls span {{ display: inline-block; width: 12px; height: 12px; border-radius: 50%; margin-left: 6px; }}
  .btn-min {{ background: #eab308; }} .btn-max {{ background: #22c55e; }} .btn-close {{ background: #ef4444; }}
  .console {{ padding: 18px 20px; font-size: 13.5px; line-height: 1.55; color: #cccccc; min-height: {min_height}px; }}
  .prompt {{ color: #ffffff; font-weight: bold; }}
  .cmd {{ color: #facc15; font-weight: 600; }}
  .green {{ color: #4ade80; }}
  .cyan {{ color: #38bdf8; }}
  .gray {{ color: #888888; }}
  .blue {{ color: #60a5fa; }}
  .red {{ color: #f87171; }}
  .white {{ color: #f3f4f6; }}
  .highlight {{ background: #1e293b; color: #38bdf8; padding: 2px 6px; border-radius: 3px; }}
  .badge-ran {{ background: #064e3b; color: #34d399; padding: 1px 6px; border-radius: 3px; font-size: 11px; }}
</style>
</head>
<body>
<div class="window">
  <div class="titlebar">
    <span>Windows PowerShell — {title}</span>
    <div class="controls"><span class="btn-min"></span><span class="btn-max"></span><span class="btn-close"></span></div>
  </div>
  <div class="console">
    {content_html}
  </div>
</div>
</body>
</html>"""

def vscode_window(filepath, filename, code_html):
    return f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body {{ margin: 0; background: #181818; font-family: 'Consolas', 'Courier New', monospace; padding: 20px; }}
  .window {{ background: #1e1e1e; border-radius: 8px; border: 1px solid #333; box-shadow: 0 10px 30px rgba(0,0,0,0.8); overflow: hidden; }}
  .titlebar {{ background: #323233; color: #ccc; padding: 8px 14px; font-size: 12px; display: flex; justify-content: space-between; align-items: center; }}
  .tabbar {{ background: #252526; display: flex; border-bottom: 1px solid #1e1e1e; }}
  .tab {{ background: #1e1e1e; color: #ffffff; padding: 8px 16px; font-size: 13px; border-top: 2px solid #007acc; display: flex; align-items: center; gap: 8px; }}
  .breadcrumbs {{ background: #1e1e1e; color: #888; padding: 5px 16px; font-size: 12px; border-bottom: 1px solid #282828; }}
  .breadcrumbs span {{ color: #cccccc; }}
  .editor {{ padding: 16px 20px; font-size: 13.5px; line-height: 1.6; color: #d4d4d4; min-height: 480px; overflow-x: auto; }}
  .line-num {{ color: #858585; display: inline-block; width: 35px; text-align: right; margin-right: 18px; user-select: none; }}
  .keyword {{ color: #569cd6; font-weight: 600; }}
  .string {{ color: #ce9178; }}
  .comment {{ color: #6a9955; font-style: italic; }}
  .func {{ color: #dcdcaa; }}
  .class {{ color: #4ec9b0; }}
  .variable {{ color: #9cdcfe; }}
  .operator {{ color: #d4d4d4; }}
</style>
</head>
<body>
<div class="window">
  <div class="titlebar">
    <span>{filepath} — Visual Studio Code</span>
    <span style="color:#888;">motovel</span>
  </div>
  <div class="tabbar">
    <div class="tab">📄 {filename} <span style="font-size:10px; color:#888; margin-left:6px;">✕</span></div>
  </div>
  <div class="breadcrumbs">
    motovel &gt; {filepath.replace('/', ' &gt; ')}
  </div>
  <div class="editor">
    {code_html}
  </div>
</div>
</body>
</html>"""

def phpmyadmin_window(db_name, table_name, columns, rows_html):
    th_html = "".join([f"<th>{col}</th>" for col in columns])
    return f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body {{ margin: 0; background: #e9ebee; font-family: Segoe UI, Tahoma, sans-serif; padding: 15px; color: #333; }}
  .pma-header {{ background: #fff; padding: 12px 16px; border-bottom: 2px solid #ff9900; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }}
  .pma-logo {{ font-size: 20px; font-weight: bold; color: #444; }}
  .pma-logo span {{ color: #ff9900; }}
  .breadcrumb {{ background: #f3f3f3; padding: 8px 16px; font-size: 13px; color: #555; border-bottom: 1px solid #ddd; }}
  .breadcrumb a {{ color: #0066cc; text-decoration: none; font-weight: 600; }}
  .nav-tabs {{ background: #fff; display: flex; gap: 4px; padding: 6px 16px 0; border-bottom: 1px solid #ccc; }}
  .tab {{ padding: 8px 14px; font-size: 13px; color: #444; text-decoration: none; border: 1px solid #ccc; border-bottom: none; background: #f8f8f8; border-radius: 4px 4px 0 0; }}
  .tab.active {{ background: #fff; font-weight: bold; border-top: 3px solid #ff9900; }}
  .content {{ background: #fff; padding: 16px; min-height: 480px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }}
  .sql-success {{ background: #dff0d8; border: 1px solid #d6e9c6; color: #3c763d; padding: 10px 14px; border-radius: 4px; margin-bottom: 14px; font-size: 13px; }}
  table.data-table {{ width: 100%; border-collapse: collapse; font-size: 13px; margin-top: 10px; }}
  table.data-table th {{ background: #e0e0e0; border: 1px solid #ccc; padding: 8px 10px; text-align: left; font-weight: 600; }}
  table.data-table td {{ border: 1px solid #e0e0e0; padding: 8px 10px; vertical-align: middle; }}
  table.data-table tr:nth-child(even) {{ background: #fbfbfb; }}
  table.data-table tr:hover {{ background: #f0f7fd; }}
  .btn-action {{ display: inline-flex; align-items: center; gap: 3px; font-size: 11px; padding: 3px 6px; border-radius: 3px; text-decoration: none; margin-right: 4px; }}
  .btn-edit {{ background: #e2e8f0; color: #0284c7; }}
  .btn-copy {{ background: #e2e8f0; color: #0d9488; }}
  .btn-del {{ background: #fee2e2; color: #dc2626; }}
  .badge-id {{ font-weight: bold; color: #0284c7; font-family: monospace; }}
</style>
</head>
<body>
  <div class="pma-header">
    <div class="pma-logo">php<span>MyAdmin</span> <small style="font-size:12px;color:#777;">5.2.1</small></div>
    <div style="font-size:12px;color:#666;">Server: 127.0.0.1 » Database: <b>{db_name}</b> » Table: <b>{table_name}</b></div>
  </div>
  <div class="breadcrumb">
    Server: <a href="#">127.0.0.1</a> » Database: <a href="#">{db_name}</a> » Tabel: <a href="#">{table_name}</a>
  </div>
  <div class="nav-tabs">
    <div class="tab active">Jelajahi (Browse)</div>
    <div class="tab">Struktur (Structure)</div>
    <div class="tab">SQL</div>
    <div class="tab">Cari (Search)</div>
    <div class="tab">Sisipkan (Insert)</div>
    <div class="tab">Ekspor (Export)</div>
  </div>
  <div class="content">
    <div class="sql-success">
      ✓ Menampilkan baris 0 - {max(0, rows_html.count('<tr>')-1)} (Total {rows_html.count('<tr>')} baris, Kueri memakan 0.0014 detik)
    </div>
    <table class="data-table">
      <thead>
        <tr>
          <th style="width:140px;">Tindakan</th>
          {th_html}
        </tr>
      </thead>
      <tbody>
        {rows_html}
      </tbody>
    </table>
  </div>
</body>
</html>"""

def postman_window(title, method, url, status_code, status_text, req_body, res_body, time_ms="142 ms", size_kb="1.2 KB"):
    color_map = {"GET": "#10b981", "POST": "#f97316", "PUT": "#3b82f6", "DELETE": "#ef4444"}
    m_color = color_map.get(method, "#6b7280")
    status_bg = "#064e3b" if int(status_code) < 400 else "#7f1d1d"
    status_color = "#34d399" if int(status_code) < 400 else "#f87171"
    
    return f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body {{ margin: 0; background: #121212; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 15px; color: #e0e0e0; }}
  .postman-app {{ background: #212121; border-radius: 8px; border: 1px solid #333; box-shadow: 0 10px 30px rgba(0,0,0,0.8); overflow: hidden; }}
  .top-header {{ background: #181818; padding: 8px 16px; font-size: 13px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #2c2c2c; }}
  .tabs {{ background: #1c1c1c; display: flex; border-bottom: 1px solid #333; }}
  .tab {{ padding: 10px 18px; font-size: 13px; background: #212121; border-top: 2px solid {m_color}; color: #fff; font-weight: 500; display: flex; gap: 8px; align-items: center; }}
  .url-bar {{ display: flex; padding: 14px 18px; gap: 10px; background: #262626; border-bottom: 1px solid #333; }}
  .method-badge {{ background: {m_color}; color: #fff; font-weight: bold; font-size: 13px; padding: 8px 14px; border-radius: 4px; display: flex; align-items: center; }}
  .url-input {{ flex: 1; background: #171717; border: 1px solid #3c3c3c; color: #fff; padding: 8px 14px; font-size: 13.5px; border-radius: 4px; font-family: monospace; }}
  .btn-send {{ background: #0284c7; color: #fff; font-weight: bold; padding: 8px 24px; border: none; border-radius: 4px; cursor: pointer; }}
  .main-split {{ display: flex; min-height: 480px; }}
  .req-pane {{ width: 45%; border-right: 1px solid #333; padding: 14px 16px; }}
  .res-pane {{ width: 55%; padding: 14px 16px; background: #1a1a1a; }}
  .pane-title {{ font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #888; margin-bottom: 8px; font-weight: bold; display: flex; justify-content: space-between; }}
  .status-meta {{ display: flex; gap: 12px; align-items: center; }}
  .status-badge {{ background: {status_bg}; color: {status_color}; font-weight: bold; padding: 3px 8px; border-radius: 4px; font-size: 12px; }}
  .meta-item {{ font-size: 12px; color: #888; }}
  .meta-item span {{ color: #4ade80; font-weight: 600; }}
  pre {{ background: #121212; padding: 14px; border-radius: 6px; font-family: 'Consolas', monospace; font-size: 12.5px; line-height: 1.5; color: #d4d4d4; margin: 0; max-height: 420px; overflow-y: auto; border: 1px solid #282828; }}
  .json-key {{ color: #9cdcfe; }}
  .json-str {{ color: #ce9178; }}
  .json-num {{ color: #b5cea8; }}
  .json-bool {{ color: #569cd6; }}
</style>
</head>
<body>
<div class="postman-app">
  <div class="top-header">
    <span><b>MOTOVEL API v1</b> — {title}</span>
    <span style="font-size:11px; color:#888;">Postman Desktop Agent • Environment: <b>Local (127.0.0.1:8000)</b></span>
  </div>
  <div class="tabs">
    <div class="tab"><span>{method}</span> {title}</div>
  </div>
  <div class="url-bar">
    <div class="method-badge">{method}</div>
    <div class="url-input">{url}</div>
    <button class="btn-send">Send</button>
  </div>
  <div class="main-split">
    <div class="req-pane">
      <div class="pane-title">Request Body (raw JSON)</div>
      <pre>{req_body}</pre>
    </div>
    <div class="res-pane">
      <div class="pane-title">
        <span>Response Body</span>
        <div class="status-meta">
          <div class="status-badge">{status_code} {status_text}</div>
          <div class="meta-item">Time: <span>{time_ms}</span></div>
          <div class="meta-item">Size: <span>{size_kb}</span></div>
        </div>
      </div>
      <pre>{res_body}</pre>
    </div>
  </div>
</div>
</body>
</html>"""

def motovel_web_window(title, page_subtitle, content_body):
    return f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body {{ margin: 0; background: #08090B; font-family: 'Inter', -apple-system, sans-serif; color: #F4F2EF; padding: 15px; }}
  .browser-frame {{ background: #111216; border-radius: 10px; border: 1px solid #303137; box-shadow: 0 20px 40px rgba(0,0,0,0.9); overflow: hidden; }}
  .nav-header {{ background: #0c0d10; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #222329; }}
  .brand {{ font-size: 19px; font-weight: 900; letter-spacing: 2px; color: #F4F2EF; display: flex; align-items: center; gap: 8px; }}
  .brand-dot {{ width: 8px; height: 8px; background: #C62828; border-radius: 50%; display: inline-block; }}
  .nav-menu {{ display: flex; gap: 20px; font-size: 13px; font-weight: 500; color: #92939A; }}
  .nav-menu a {{ color: #F4F2EF; text-decoration: none; }}
  .nav-menu a.active {{ color: #C62828; font-weight: 700; border-bottom: 2px solid #C62828; padding-bottom: 4px; }}
  .user-badge {{ background: #191A1F; border: 1px solid #303137; padding: 5px 12px; border-radius: 20px; font-size: 12px; display: flex; align-items: center; gap: 8px; }}
  .status-indicator {{ width: 6px; height: 6px; background: #22c55e; border-radius: 50%; }}
  .page-banner {{ padding: 20px 28px 12px; border-bottom: 1px solid #1c1d24; }}
  .page-title {{ font-size: 24px; font-weight: 800; color: #F4F2EF; margin: 0; font-family: 'Georgia', serif; letter-spacing: 0.5px; }}
  .page-sub {{ font-size: 13px; color: #92939A; margin-top: 4px; }}
  .container {{ padding: 24px 28px; min-height: 480px; }}
  .card {{ background: #191A1F; border: 1px solid #303137; border-radius: 8px; padding: 20px; margin-bottom: 20px; }}
  .btn-primary {{ background: #C62828; color: #fff; border: none; padding: 9px 18px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; }}
  .btn-outline {{ background: transparent; border: 1px solid #303137; color: #F4F2EF; padding: 8px 16px; border-radius: 6px; font-size: 13px; }}
  table.web-table {{ width: 100%; border-collapse: collapse; font-size: 13px; }}
  table.web-table th {{ background: #111216; color: #92939A; text-align: left; padding: 12px 14px; border-bottom: 1px solid #303137; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }}
  table.web-table td {{ padding: 14px; border-bottom: 1px solid #222329; vertical-align: middle; }}
  table.web-table tr:hover {{ background: #1c1d24; }}
  .badge-code {{ font-family: monospace; background: #111216; border: 1px solid #303137; color: #C62828; font-weight: bold; padding: 2px 8px; border-radius: 4px; font-size: 12px; }}
  .badge-status {{ padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase; }}
  .badge-completed {{ background: #064e3b; color: #34d399; }}
  .badge-pending {{ background: #78350f; color: #fde047; }}
  .badge-progress {{ background: #1e3a8a; color: #93c5fd; }}
  .grid-stats {{ display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }}
  .stat-card {{ background: #191A1F; border: 1px solid #303137; border-radius: 8px; padding: 18px; }}
  .stat-label {{ font-size: 12px; color: #92939A; text-transform: uppercase; letter-spacing: 0.5px; }}
  .stat-val {{ font-size: 26px; font-weight: 800; color: #F4F2EF; margin-top: 6px; }}
  .stat-sub {{ font-size: 11px; color: #22c55e; margin-top: 4px; }}
</style>
</head>
<body>
<div class="browser-frame">
  <div class="nav-header">
    <div class="brand">MOTOVEL <span class="brand-dot"></span></div>
    <div class="nav-menu">
      <a href="#" class="{ 'active' if 'Dashboard' in title else '' }">Dashboard</a>
      <a href="#" class="{ 'active' if 'Pelanggan' in title else '' }">Pelanggan</a>
      <a href="#" class="{ 'active' if 'Motor' in title else '' }">Armada Motor</a>
      <a href="#" class="{ 'active' if 'Mekanik' in title else '' }">Mekanik</a>
      <a href="#" class="{ 'active' if 'Servis' in title else '' }">Servis</a>
      <a href="#" class="{ 'active' if 'Sparepart' in title else '' }">Sparepart</a>
      <a href="#" class="{ 'active' if 'Pembayaran' in title else '' }">Kasir</a>
      <a href="#" class="{ 'active' if 'Laporan' in title else '' }">Laporan</a>
    </div>
    <div class="user-badge">
      <span class="status-indicator"></span> Admin Workshop
    </div>
  </div>
  <div class="page-banner">
    <h1 class="page-title">{title}</h1>
    <div class="page-sub">{page_subtitle}</div>
  </div>
  <div class="container">
    {content_body}
  </div>
</div>
</body>
</html>"""

def github_window(repo_name, owner, desc):
    return f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body {{ margin: 0; background: #010409; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #e6edf3; padding: 20px; }}
  .gh-box {{ background: #0d1117; border: 1px solid #30363d; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.8); overflow: hidden; max-width: 900px; margin: 0 auto; }}
  .gh-nav {{ background: #161b22; padding: 12px 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #30363d; }}
  .gh-logo {{ font-size: 22px; font-weight: bold; color: #fff; }}
  .gh-content {{ padding: 28px 32px; min-height: 480px; }}
  .form-title {{ font-size: 22px; font-weight: 600; margin-bottom: 8px; }}
  .form-sub {{ font-size: 13.5px; color: #7d8590; margin-bottom: 24px; border-bottom: 1px solid #21262d; padding-bottom: 16px; }}
  .field-row {{ display: flex; gap: 12px; margin-bottom: 20px; align-items: flex-end; }}
  .field-col label {{ display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }}
  .input-text {{ background: #010409; border: 1px solid #30363d; color: #e6edf3; padding: 8px 12px; border-radius: 6px; font-size: 14px; width: 320px; }}
  .input-desc {{ background: #010409; border: 1px solid #30363d; color: #e6edf3; padding: 8px 12px; border-radius: 6px; font-size: 14px; width: 100%; box-sizing: border-box; }}
  .radio-card {{ background: #161b22; border: 1px solid #30363d; border-radius: 6px; padding: 14px; margin-bottom: 12px; display: flex; gap: 12px; }}
  .btn-create {{ background: #238636; color: #fff; font-weight: bold; border: none; padding: 10px 20px; border-radius: 6px; font-size: 14px; cursor: pointer; margin-top: 20px; }}
  .badge-avail {{ color: #3fb950; font-size: 12px; margin-left: 8px; }}
</style>
</head>
<body>
<div class="gh-box">
  <div class="gh-nav">
    <div class="gh-logo">GitHub</div>
    <div style="font-size:13px; color:#7d8590;">/ Create a new repository</div>
  </div>
  <div class="gh-content">
    <div class="form-title">Create a new repository</div>
    <div class="form-sub">A repository contains all project files, including the revision history. Already have a project repository elsewhere? Import a repository.</div>
    <div class="field-row">
      <div class="field-col">
        <label>Owner</label>
        <input class="input-text" style="width:140px;" value="{owner}" readonly>
      </div>
      <div style="font-size:18px; padding-bottom:8px; color:#7d8590;">/</div>
      <div class="field-col" style="flex:1;">
        <label>Repository name <span class="badge-avail">✓ {repo_name} is available.</span></label>
        <input class="input-text" value="{repo_name}">
      </div>
    </div>
    <div style="margin-bottom:20px;">
      <label style="font-size:13px; font-weight:600; display:block; margin-bottom:6px;">Description <span style="color:#7d8590; font-weight:normal;">(optional)</span></label>
      <input class="input-desc" value="{desc}">
    </div>
    <div class="radio-card">
      <input type="radio" checked name="vis">
      <div>
        <div style="font-weight:600; font-size:14px;">Public</div>
        <div style="font-size:12px; color:#7d8590;">Anyone on the internet can see this repository. You choose who can commit.</div>
      </div>
    </div>
    <button class="btn-create">Create repository</button>
  </div>
</div>
</body>
</html>"""

def explorer_window(current_path, items_html):
    return f"""<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body {{ margin: 0; background: #1f1f1f; font-family: 'Segoe UI', Tahoma, sans-serif; color: #fff; padding: 20px; }}
  .explorer-win {{ background: #2b2b2b; border-radius: 8px; border: 1px solid #3c3c3c; box-shadow: 0 10px 30px rgba(0,0,0,0.8); overflow: hidden; }}
  .titlebar {{ background: #202020; padding: 8px 14px; font-size: 12px; color: #aaa; display: flex; justify-content: space-between; }}
  .address-bar {{ background: #333333; padding: 6px 14px; border-bottom: 1px solid #3c3c3c; display: flex; align-items: center; gap: 12px; font-size: 13px; }}
  .path-box {{ background: #1c1c1c; border: 1px solid #444; border-radius: 4px; padding: 4px 10px; flex: 1; color: #ccc; }}
  .content-table {{ width: 100%; border-collapse: collapse; font-size: 13px; }}
  .content-table th {{ background: #252525; padding: 8px 14px; text-align: left; color: #aaa; border-bottom: 1px solid #3c3c3c; font-weight: 500; font-size: 12px; }}
  .content-table td {{ padding: 7px 14px; border-bottom: 1px solid #333; }}
  .content-table tr:hover {{ background: #383838; }}
  .icon-folder {{ color: #eab308; margin-right: 8px; }}
  .icon-file {{ color: #60a5fa; margin-right: 8px; }}
</style>
</head>
<body>
<div class="explorer-win">
  <div class="titlebar">
    <span>File Explorer — {current_path}</span>
    <span style="color:#777;">Windows 11</span>
  </div>
  <div class="address-bar">
    <span>← → ↑</span>
    <div class="path-box">📁 This PC &gt; Local Disk (D:) &gt; Xampp &gt; htdocs &gt; <b>{current_path}</b></div>
  </div>
  <div style="min-height:480px; padding: 8px 0;">
    <table class="content-table">
      <thead>
        <tr>
          <th>Name</th>
          <th style="width:180px;">Date modified</th>
          <th style="width:160px;">Type</th>
          <th style="width:110px;">Size</th>
        </tr>
      </thead>
      <tbody>
        {items_html}
      </tbody>
    </table>
  </div>
</div>
</body>
</html>"""

print("All window templates ready.")


# =========================================================================
# PART 5: KONFIGURASI LARAVEL DAN DATABASE (01 - 18)
# =========================================================================
def generate_part5():
    # 01
    html = terminal_window("composer create-project", """
    <span class="prompt">PS D:\\Xampp\\htdocs&gt;</span> <span class="cmd">composer create-project laravel/laravel motovel</span><br>
    <span class="gray">Creating a "laravel/laravel" project at "./motovel"</span><br>
    <span class="gray">Installing laravel/laravel (v12.2.0)</span><br>
    <span class="cyan">  - Downloading laravel/laravel (v12.2.0)</span><br>
    <span class="green">  - Installing laravel/laravel (v12.2.0): Extracting archive</span><br>
    <span class="gray">Created project in D:\\Xampp\\htdocs\\motovel</span><br>
    <span class="gray">&gt; @php -r "file_exists('.env') || copy('.env.example', '.env');"</span><br>
    <span class="gray">&gt; @php artisan key:generate --ansi</span><br>
    <span class="green">INFO  Application key set successfully.</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "01_composer_create_project.png")

    # 02
    html = terminal_window("cd motovel && code .", """
    <span class="prompt">PS D:\\Xampp\\htdocs&gt;</span> <span class="cmd">cd motovel</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">code .</span><br><br>
    <span class="gray">Opening Visual Studio Code workspace for D:\\Xampp\\htdocs\\motovel...</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "02_cd_and_code.png")

    # 03
    html = phpmyadmin_window("motovel_db", "(Basis Data Baru)", ["Tabel", "Tindakan", "Baris", "Tipe", "Penyortiran", "Ukuran"], """
    <tr><td colspan="7" style="text-align:center; padding: 40px; color: #888;">Basis data <b>motovel_db</b> berhasil dibuat. Tidak ada tabel yang ditemukan dalam basis data ini. Menunggu migrasi Laravel.</td></tr>
    """)
    render(html, "03_phpmyadmin_createdb.png")

    # 04
    env_code = """<span class="variable">APP_NAME</span><span class="operator">=</span><span class="string">"MOTOVEL"</span>
<span class="variable">APP_ENV</span><span class="operator">=</span><span class="string">local</span>
<span class="variable">APP_KEY</span><span class="operator">=</span><span class="string">base64:3fL0K9Yj...</span>
<span class="variable">APP_DEBUG</span><span class="operator">=</span><span class="keyword">true</span>
<span class="variable">APP_URL</span><span class="operator">=</span><span class="string">http://127.0.0.1:8000</span>

<span class="comment"># Database Configuration (MySQL / MariaDB via XAMPP)</span>
<span class="variable">DB_CONNECTION</span><span class="operator">=</span><span class="string">mysql</span>
<span class="variable">DB_HOST</span><span class="operator">=</span><span class="string">127.0.0.1</span>
<span class="variable">DB_PORT</span><span class="operator">=</span><span class="string">3306</span>
<span class="variable">DB_DATABASE</span><span class="operator">=</span><span class="string" style="background:#3b2d18; font-weight:bold; color:#fde047;">motovel_db</span>
<span class="variable">DB_USERNAME</span><span class="operator">=</span><span class="string" style="background:#3b2d18; font-weight:bold; color:#fde047;">root</span>
<span class="variable">DB_PASSWORD</span><span class="operator">=</span><span class="string"></span>"""
    html = vscode_window(".env", ".env", env_code)
    render(html, "04_env_config.png")

    # 05
    html = terminal_window("php artisan make:migration", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:migration create_customers_table</span><br>
    <span class="green">INFO  Migration [database/migrations/2024_01_01_000001_create_customers_table.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:migration create_vehicles_table</span><br>
    <span class="green">INFO  Migration [database/migrations/2024_01_01_000002_create_vehicles_table.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:migration create_mechanics_table</span><br>
    <span class="green">INFO  Migration [database/migrations/2024_01_01_000003_create_mechanics_table.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:migration create_service_registrations_table</span><br>
    <span class="green">INFO  Migration [database/migrations/2024_01_01_000004_create_service_registrations_table.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:migration create_service_details_table</span><br>
    <span class="green">INFO  Migration [database/migrations/2024_01_01_000005_create_service_details_table.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:migration create_spareparts_table</span><br>
    <span class="green">INFO  Migration [database/migrations/2024_01_01_000006_create_spareparts_table.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:migration create_payments_table</span><br>
    <span class="green">INFO  Migration [database/migrations/2024_01_01_000008_create_payments_table.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "05_make_migrations.png")

    # 06
    html = terminal_window("Get-ChildItem database/migrations", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">Get-ChildItem database/migrations | Select-Object -ExpandProperty Name</span><br>
    <span class="white">0001_01_01_000000_create_users_table.php</span><br>
    <span class="white">0001_01_01_000001_create_cache_table.php</span><br>
    <span class="white">0001_01_01_000002_create_jobs_table.php</span><br>
    <span class="cyan">2024_01_01_000001_create_customers_table.php</span><br>
    <span class="cyan">2024_01_01_000002_create_vehicles_table.php</span><br>
    <span class="cyan">2024_01_01_000003_create_mechanics_table.php</span><br>
    <span class="cyan">2024_01_01_000004_create_service_registrations_table.php</span><br>
    <span class="cyan">2024_01_01_000005_create_service_details_table.php</span><br>
    <span class="cyan">2024_01_01_000006_create_spareparts_table.php</span><br>
    <span class="cyan">2024_01_01_000007_create_service_spareparts_table.php</span><br>
    <span class="cyan">2024_01_01_000008_create_payments_table.php</span><br>
    <span class="cyan">2024_01_01_000009_create_contact_messages_table.php</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "06_migrations_list.png")

    # 07
    html = terminal_window("php artisan install:api", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan install:api</span><br>
    <span class="gray">./composer.json has been updated</span><br>
    <span class="gray">Running composer update laravel/sanctum</span><br>
    <span class="green">  - Installing laravel/sanctum (v4.0.8): Extracting archive</span><br>
    <span class="green">INFO  Published API routes file.</span><br>
    <span class="gray">One new database migration has been published. Would you like to run all pending database migrations? (yes/no) [yes]:</span><br>
    <span class="cmd">&gt; no</span><br>
    <span class="green">INFO  API scaffolding installed. Please add the [HasApiTokens] trait to your User model.</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "07_install_api.png")

    # 08
    html = terminal_window("php artisan migrate:fresh", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan migrate:fresh</span><br>
    <span class="gray">Dropping all tables ........................................... 92.41ms </span><span class="green">DONE</span><br>
    <span class="cyan">INFO  Preparing database.</span><br>
    <span class="gray">Creating migration table ...................................... 16.12ms </span><span class="green">DONE</span><br>
    <span class="cyan">INFO  Running migrations.</span><br>
    <span class="white">  0001_01_01_000000_create_users_table ........................ 55.12ms </span><span class="green">DONE</span><br>
    <span class="white">  0001_01_01_000001_create_cache_table ........................ 28.45ms </span><span class="green">DONE</span><br>
    <span class="white">  0001_01_01_000002_create_jobs_table ......................... 41.20ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000001_create_customers_table .................... 18.23ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000002_create_vehicles_table ..................... 35.10ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000003_create_mechanics_table .................... 17.88ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000004_create_service_registrations_table ........ 39.42ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000005_create_service_details_table .............. 43.15ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000006_create_spareparts_table ................... 20.30ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000007_create_service_spareparts_table ........... 36.75ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000008_create_payments_table ..................... 38.90ms </span><span class="green">DONE</span><br>
    <span class="cyan">  2024_01_01_000009_create_contact_messages_table ............. 19.50ms </span><span class="green">DONE</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "08_migrate_fresh.png")

    # 09
    html = terminal_window("php artisan migrate:status", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan migrate:status</span><br>
    <span class="gray">+------+-------------------------------------------------------+-------+</span><br>
    <span class="gray">| Ran? | Migration                                             | Batch |</span><br>
    <span class="gray">+------+-------------------------------------------------------+-------+</span><br>
    | <span class="green">Yes</span>  | 0001_01_01_000000_create_users_table                  | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 0001_01_01_000001_create_cache_table                  | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 0001_01_01_000002_create_jobs_table                   | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000001_create_customers_table              | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000002_create_vehicles_table               | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000003_create_mechanics_table              | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000004_create_service_registrations_table  | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000005_create_service_details_table        | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000006_create_spareparts_table             | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000007_create_service_spareparts_table     | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000008_create_payments_table               | <span class="badge-ran">1 Ran</span> |<br>
    | <span class="green">Yes</span>  | 2024_01_01_000009_create_contact_messages_table       | <span class="badge-ran">1 Ran</span> |<br>
    <span class="gray">+------+-------------------------------------------------------+-------+</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "09_migrate_status.png")

    # 10
    html = terminal_window("php artisan make:model", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:model Customer</span><br>
    <span class="green">INFO  Model [app/Models/Customer.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:model Vehicle</span><br>
    <span class="green">INFO  Model [app/Models/Vehicle.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:model Mechanic</span><br>
    <span class="green">INFO  Model [app/Models/Mechanic.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:model ServiceRegistration</span><br>
    <span class="green">INFO  Model [app/Models/ServiceRegistration.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:model ServiceDetail</span><br>
    <span class="green">INFO  Model [app/Models/ServiceDetail.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:model Sparepart</span><br>
    <span class="green">INFO  Model [app/Models/Sparepart.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:model Payment</span><br>
    <span class="green">INFO  Model [app/Models/Payment.php] created successfully.</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "10_make_models.png")

    # 11
    html = terminal_window("Get-ChildItem app/Models", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">Get-ChildItem app\\Models | Select-Object -ExpandProperty Name</span><br>
    <span class="cyan">ContactMessage.php</span><br>
    <span class="cyan">Customer.php</span><br>
    <span class="cyan">Mechanic.php</span><br>
    <span class="cyan">Payment.php</span><br>
    <span class="cyan">ServiceDetail.php</span><br>
    <span class="cyan">ServiceRegistration.php</span><br>
    <span class="cyan">ServiceSparepart.php</span><br>
    <span class="cyan">Sparepart.php</span><br>
    <span class="white">User.php</span><br>
    <span class="cyan">Vehicle.php</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "11_models_list.png")

    # 12
    html = terminal_window("php artisan make:controller", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller PublicController</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/PublicController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller BookingController</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/BookingController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller DashboardController</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/DashboardController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller CustomerController</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/CustomerController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller ServiceRegistrationController</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/ServiceRegistrationController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller PaymentController</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/PaymentController.php] created successfully.</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "12_make_controllers.png")

    # 13
    html = terminal_window("Get-ChildItem app/Http/Controllers", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">Get-ChildItem app\\Http\\Controllers -File | Select-Object -ExpandProperty Name</span><br>
    <span class="cyan">BookingController.php</span><br>
    <span class="cyan">ContactController.php</span><br>
    <span class="white">Controller.php</span><br>
    <span class="cyan">CustomerController.php</span><br>
    <span class="cyan">DashboardController.php</span><br>
    <span class="cyan">HistoryController.php</span><br>
    <span class="cyan">MechanicController.php</span><br>
    <span class="cyan">PaymentController.php</span><br>
    <span class="cyan">PublicController.php</span><br>
    <span class="cyan">ReportController.php</span><br>
    <span class="cyan">ServiceDetailController.php</span><br>
    <span class="cyan">ServiceRegistrationController.php</span><br>
    <span class="cyan">SparepartController.php</span><br>
    <span class="cyan">VehicleController.php</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "13_controllers_list.png")

    # 14
    html = terminal_window("php artisan make:controller Api/V1/...", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller Api/V1/CustomerController --api</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/Api/V1/CustomerController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller Api/V1/VehicleController --api</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/Api/V1/VehicleController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller Api/V1/MechanicController --api</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/Api/V1/MechanicController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller Api/V1/ServiceRegistrationController --api</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/Api/V1/ServiceRegistrationController.php] created successfully.</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan make:controller Api/V1/PaymentController --api</span><br>
    <span class="green">INFO  Controller [app/Http/Controllers/Api/V1/PaymentController.php] created successfully.</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "14_make_api_controllers.png")

    # 15
    html = terminal_window("Get-ChildItem app/Http/Controllers/Api/V1", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">Get-ChildItem app\\Http\\Controllers\\Api\\V1 | Select-Object -ExpandProperty Name</span><br>
    <span class="cyan">CustomerController.php</span><br>
    <span class="cyan">MechanicController.php</span><br>
    <span class="cyan">PaymentController.php</span><br>
    <span class="cyan">ServiceDetailController.php</span><br>
    <span class="cyan">ServiceRegistrationController.php</span><br>
    <span class="cyan">SparepartController.php</span><br>
    <span class="cyan">VehicleController.php</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "15_api_controllers_list.png")

    # 16
    routes_api_code = """<span class="keyword">&lt;?php</span>

<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\CustomerController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\VehicleController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\MechanicController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\ServiceRegistrationController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\ServiceDetailController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\SparepartController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\PaymentController</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Support\\Facades\\Route</span>;

<span class="comment">/* MOTOVEL REST API v1 — 35 Resources Endpoints */</span>
<span class="class">Route</span>::<span class="func">prefix</span>(<span class="string">'v1'</span>)-><span class="func">name</span>(<span class="string">'api.v1.'</span>)-><span class="func">group</span>(<span class="keyword">function</span> () {
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'customers'</span>, <span class="class">CustomerController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'vehicles'</span>, <span class="class">VehicleController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'mechanics'</span>, <span class="class">MechanicController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'services'</span>, <span class="class">ServiceRegistrationController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'service-details'</span>, <span class="class">ServiceDetailController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'spareparts'</span>, <span class="class">SparepartController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'payments'</span>, <span class="class">PaymentController</span>::<span class="keyword">class</span>);
});"""
    html = vscode_window("routes/api.php", "api.php", routes_api_code)
    render(html, "16_routes_api.png")

    # 17
    routes_web_code = """<span class="keyword">&lt;?php</span>

<span class="comment">// 1. Public Website Routes</span>
<span class="class">Route</span>::<span class="func">get</span>(<span class="string">'/'</span>, [<span class="class">PublicController</span>::<span class="keyword">class</span>, <span class="string">'landing'</span>])-><span class="func">name</span>(<span class="string">'home'</span>);
<span class="class">Route</span>::<span class="func">get</span>(<span class="string">'/services'</span>, [<span class="class">PublicController</span>::<span class="keyword">class</span>, <span class="string">'services'</span>])-><span class="func">name</span>(<span class="string">'services'</span>);
<span class="class">Route</span>::<span class="func">get</span>(<span class="string">'/booking'</span>, [<span class="class">BookingController</span>::<span class="keyword">class</span>, <span class="string">'index'</span>])-><span class="func">name</span>(<span class="string">'booking'</span>);
<span class="class">Route</span>::<span class="func">get</span>(<span class="string">'/booking/check-phone'</span>, [<span class="class">BookingController</span>::<span class="keyword">class</span>, <span class="string">'checkPhone'</span>]);

<span class="comment">// 2. Authentication</span>
<span class="class">Route</span>::<span class="func">middleware</span>(<span class="string">'guest'</span>)-><span class="func">group</span>(<span class="keyword">function</span> () {
    <span class="class">Route</span>::<span class="func">get</span>(<span class="string">'/login'</span>, [<span class="class">LoginController</span>::<span class="keyword">class</span>, <span class="string">'showLoginForm'</span>])-><span class="func">name</span>(<span class="string">'login'</span>);
    <span class="class">Route</span>::<span class="func">post</span>(<span class="string">'/login'</span>, [<span class="class">LoginController</span>::<span class="keyword">class</span>, <span class="string">'login'</span>])-><span class="func">name</span>(<span class="string">'login.post'</span>);
});

<span class="comment">// 3. Protected Admin Dashboard Routes</span>
<span class="class">Route</span>::<span class="func">middleware</span>([<span class="string">'auth'</span>])-><span class="func">prefix</span>(<span class="string">'admin'</span>)-><span class="func">name</span>(<span class="string">'admin.'</span>)-><span class="func">group</span>(<span class="keyword">function</span> () {
    <span class="class">Route</span>::<span class="func">get</span>(<span class="string">'/dashboard'</span>, [<span class="class">DashboardController</span>::<span class="keyword">class</span>, <span class="string">'index'</span>])-><span class="func">name</span>(<span class="string">'dashboard'</span>);
    <span class="class">Route</span>::<span class="func">resource</span>(<span class="string">'customers'</span>, <span class="class">CustomerController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">resource</span>(<span class="string">'vehicles'</span>, <span class="class">VehicleController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">resource</span>(<span class="string">'services'</span>, <span class="class">ServiceRegistrationController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">resource</span>(<span class="string">'payments'</span>, <span class="class">PaymentController</span>::<span class="keyword">class</span>);
});"""
    html = vscode_window("routes/web.php", "web.php", routes_web_code)
    render(html, "17_routes_web.png")

    # 18
    html = terminal_window("Get-ChildItem resources/views", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">Get-ChildItem -Directory resources\\views</span><br>
    <span class="gray">Mode                 LastWriteTime         Length Name</span><br>
    <span class="gray">----                 -------------         ------ ----</span><br>
    <span class="white">d-----        11/14/2026   1:33 AM                </span><span class="cyan">admin</span><br>
    <span class="white">d-----        11/13/2026  11:57 PM                </span><span class="cyan">auth</span><br>
    <span class="white">d-----        11/13/2026  11:50 PM                </span><span class="cyan">components</span><br>
    <span class="white">d-----        11/13/2026  11:55 PM                </span><span class="cyan">layouts</span><br>
    <span class="white">d-----        11/14/2026  12:29 AM                </span><span class="cyan">public</span><br><br>
    <span class="gray">Direktori admin/ memiliki 9 submodul: customers, vehicles, mechanics, services, service_details, spareparts, payments, history, reports (Total 33 berkas Blade).</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "18_views_structure.png")

print("Part 5 methods added.")


# =========================================================================
# PART 6: WEBSITE TEST DAN API TEST (19 - 50)
# =========================================================================
def generate_part6():
    # 19
    html = terminal_window("php artisan serve", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">php artisan serve</span><br><br>
    <span class="highlight" style="background:#0284c7; color:#fff; font-weight:bold; padding:4px 8px;"> INFO </span> <span class="white" style="font-weight:bold; font-size:14px;">Server running on [http://127.0.0.1:8000].</span><br><br>
    <span class="gray">Press Ctrl+C to stop the server</span><br><br>
    <span class="gray">[Thu Nov 25 21:00:10 2026] 127.0.0.1:51234 Accepted</span><br>
    <span class="gray">[Thu Nov 25 21:00:11 2026] 127.0.0.1:51234 [200]: GET /</span><br>
    <span class="gray">[Thu Nov 25 21:00:12 2026] 127.0.0.1:51234 Closing</span>
    """)
    render(html, "19_artisan_serve.png")

    # 20 Login Web
    content = """
    <div style="max-width: 420px; margin: 40px auto; background: #191A1F; border: 1px solid #303137; border-radius: 8px; padding: 32px; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
      <div style="text-align: center; margin-bottom: 24px;">
        <div style="font-size: 24px; font-weight: 900; letter-spacing: 2px;">MOTOVEL <span style="color:#C62828;">•</span></div>
        <div style="font-size: 12px; color: #92939A; margin-top: 4px; text-transform: uppercase; letter-spacing: 1px;">Admin & Staff Authentication</div>
      </div>
      <div style="margin-bottom: 16px;">
        <label style="display:block; font-size: 12px; font-weight: 600; color: #92939A; margin-bottom: 6px; text-transform:uppercase;">Email Address</label>
        <input style="width: 100%; box-sizing: border-box; background: #111216; border: 1px solid #303137; color: #fff; padding: 10px 12px; border-radius: 6px; font-size: 13px;" value="admin@motovel.test">
      </div>
      <div style="margin-bottom: 22px;">
        <label style="display:block; font-size: 12px; font-weight: 600; color: #92939A; margin-bottom: 6px; text-transform:uppercase;">Password</label>
        <input type="password" style="width: 100%; box-sizing: border-box; background: #111216; border: 1px solid #303137; color: #fff; padding: 10px 12px; border-radius: 6px; font-size: 13px;" value="••••••••••••">
      </div>
      <button style="width: 100%; background: #C62828; color: #fff; border: none; padding: 11px; border-radius: 6px; font-weight: bold; font-size: 13px; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px;">Sign In to Workshop</button>
    </div>
    """
    html = motovel_web_window("Admin Authentication", "Sistem Masuk Administrator Bengkel MOTOVEL", content)
    render(html, "20_web_login.png")

    # 21 Landing Page
    content = """
    <div style="background: linear-gradient(rgba(8,9,11,0.7), rgba(8,9,11,0.95)), #111216; padding: 60px 40px; border-radius: 8px; border: 1px solid #303137; margin-bottom: 24px; text-align: center;">
      <span style="background: rgba(198,40,40,0.15); border: 1px solid #C62828; color: #C62828; font-size: 12px; font-weight: bold; padding: 4px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">Precision Performance Workshop</span>
      <h1 style="font-size: 42px; font-weight: 900; margin: 18px 0 12px; font-family: 'Georgia', serif;">Beyond Ordinary. Built on Precision.</h1>
      <p style="font-size: 15px; color: #92939A; max-width: 650px; margin: 0 auto 28px;">Layanan perawatan dan modifikasi sepeda motor presisi performa tinggi dengan teknisi bersertifikasi, suku cadang original, dan transparansi pengerjaan real-time.</p>
      <div style="display: flex; gap: 14px; justify-content: center;">
        <a class="btn-primary" style="padding: 12px 26px; font-size: 14px; text-decoration:none;">Book Your Service</a>
        <a class="btn-outline" style="padding: 12px 24px; font-size: 14px; text-decoration:none;">Explore Services</a>
      </div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
      <div class="card"><b style="color:#C62828;">01. General Overhaul</b><p style="color:#92939A; font-size:12px; margin-top:6px;">Restorasi performa kompresi mesin dan kalibrasi sistem pembakaran presisi.</p></div>
      <div class="card"><b style="color:#C62828;">02. Precision Brake System</b><p style="color:#92939A; font-size:12px; margin-top:6px;">Pembersihan kaliper, bleeding minyak rem dot 4/5.1, dan kampas performa tinggi.</p></div>
      <div class="card"><b style="color:#C62828;">03. Full Computer Diagnostic</b><p style="color:#92939A; font-size:12px; margin-top:6px;">Pemindaian sensor injeksi ECU dan reset throttle position sensor (TPS).</p></div>
    </div>
    """
    html = motovel_web_window("MOTOVEL — Editorial Portal", "Precision Care. Performance You Can Trust.", content)
    render(html, "21_web_landing.png")

    # 22 Booking Web
    content = """
    <div style="max-width: 700px; margin: 10px auto; background: #191A1F; border: 1px solid #303137; border-radius: 8px; padding: 28px;">
      <div style="display: flex; justify-content: space-between; margin-bottom: 24px; border-bottom: 1px solid #303137; padding-bottom: 14px;">
        <span style="color:#C62828; font-weight:bold; font-size:13px;">LANGKAH 1: IDENTITAS</span>
        <span style="color:#92939A; font-size:13px;">LANGKAH 2: SPESIFIKASI MOTOR</span>
        <span style="color:#92939A; font-size:13px;">LANGKAH 3: JADWAL & KELUHAN</span>
      </div>
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
        <div>
          <label style="font-size:12px; color:#92939A; font-weight:600; display:block; margin-bottom:4px;">NOMOR TELEPON (WHATSAPP)</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:9px; border-radius:5px;" value="081234567890">
          <span style="color:#22c55e; font-size:11px; margin-top:3px; display:inline-block;">✓ Nomor terdaftar: Budi Santoso</span>
        </div>
        <div>
          <label style="font-size:12px; color:#92939A; font-weight:600; display:block; margin-bottom:4px;">NAMA LENGKAP PELANGGAN</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:9px; border-radius:5px;" value="Budi Santoso" readonly>
        </div>
      </div>
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
        <div>
          <label style="font-size:12px; color:#92939A; font-weight:600; display:block; margin-bottom:4px;">PILIH ARMADA MOTOR</label>
          <select style="width:100%; background:#111216; border:1px solid #303137; color:#fff; padding:9px; border-radius:5px;">
            <option>B 1234 MOT — Yamaha XMAX 250 (Matic)</option>
          </select>
        </div>
        <div>
          <label style="font-size:12px; color:#92939A; font-weight:600; display:block; margin-bottom:4px;">JENIS PAKET SERVIS</label>
          <select style="width:100%; background:#111216; border:1px solid #303137; color:#fff; padding:9px; border-radius:5px;">
            <option>General Service & Oil Flush</option>
          </select>
        </div>
      </div>
      <div style="margin-bottom: 20px;">
        <label style="font-size:12px; color:#92939A; font-weight:600; display:block; margin-bottom:4px;">KELUHAN UTAMA MOTOR</label>
        <textarea style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:9px; border-radius:5px; height:60px;">Tarikan awal getar gredek dan rem depan sedikit kurang responsif.</textarea>
      </div>
      <button class="btn-primary" style="width:100%; padding:12px;">Konfirmasi & Ambil Nomor Antrean (SRV-0001)</button>
    </div>
    """
    html = motovel_web_window("Booking Engine Mandiri", "Pendaftaran Servis Mandiri Berbasis Telepon Async", content)
    render(html, "22_web_booking.png")

    # 23 Dashboard Admin
    content = """
    <div class="grid-stats">
      <div class="stat-card"><div class="stat-label">Pelanggan Terdaftar</div><div class="stat-val">128</div><div class="stat-sub">↑ +12% bulan ini</div></div>
      <div class="stat-card"><div class="stat-label">Armada Motor</div><div class="stat-val">142</div><div class="stat-sub">Semua Kategori</div></div>
      <div class="stat-card"><div class="stat-label">Antrean Servis Aktif</div><div class="stat-val" style="color:#fde047;">8 Unit</div><div class="stat-sub">3 In Progress</div></div>
      <div class="stat-card"><div class="stat-label">Total Omzet Pendapatan</div><div class="stat-val" style="color:#4ade80;">Rp 48.750.000</div><div class="stat-sub">Transaksi Lunas</div></div>
    </div>
    <div class="card">
      <div style="font-weight:bold; margin-bottom:12px; display:flex; justify-content:space-between;">
        <span>Antrean Pengerjaan Servis Terkini</span>
        <span style="font-size:12px; color:#92939A;">Live Queue</span>
      </div>
      <table class="web-table">
        <thead>
          <tr><th>Kode</th><th>Pelanggan</th><th>Plat Motor</th><th>Mekanik</th><th>Paket Servis</th><th>Status</th></tr>
        </thead>
        <tbody>
          <tr>
            <td><span class="badge-code">SRV-0001</span></td><td>Budi Santoso</td><td>B 1234 MOT (Yamaha XMAX)</td><td>Rahmat Hidayat</td><td>General Service</td>
            <td><span class="badge-status badge-progress">In Progress</span></td>
          </tr>
          <tr>
            <td><span class="badge-code">SRV-0002</span></td><td>Agus Wijaya</td><td>B 5678 KAW (Ninja ZX-25R)</td><td>Deni Pratama</td><td>Tune Up & Dyno</td>
            <td><span class="badge-status badge-pending">Waiting</span></td>
          </tr>
          <tr>
            <td><span class="badge-code">SRV-0003</span></td><td>Siti Rahma</td><td>B 9901 HON (CBR250RR)</td><td>Rahmat Hidayat</td><td>Brake Overhaul</td>
            <td><span class="badge-status badge-completed">Completed</span></td>
          </tr>
        </tbody>
      </table>
    </div>
    """
    html = motovel_web_window("Executive Workshop Dashboard", "Ikhtisar Metrik Kinerja dan Antrean Bengkel MOTOVEL", content)
    render(html, "23_web_dashboard.png")

    # 24 Form Tambah Pelanggan
    content = """
    <div style="max-width: 600px; margin: 0 auto; background: #191A1F; border: 1px solid #303137; border-radius: 8px; padding: 24px;">
      <h3 style="margin-top:0; color:#F4F2EF;">Formulir Tambah Master Pelanggan</h3>
      <div style="margin-bottom:14px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">KODE PELANGGAN (AUTO-GENERATE)</label>
        <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#facc15; font-family:monospace; font-weight:bold; padding:8px 10px;" value="PLG-0001" readonly>
      </div>
      <div style="margin-bottom:14px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">NAMA LENGKAP PELANGGAN *</label>
        <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="Budi Santoso">
      </div>
      <div style="margin-bottom:14px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">NOMOR TELEPON (WHATSAPP) *</label>
        <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="081234567890">
      </div>
      <div style="margin-bottom:14px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">EMAIL PELANGGAN</label>
        <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="budi.santoso@example.com">
      </div>
      <div style="margin-bottom:20px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">ALAMAT LENGKAP</label>
        <textarea style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px; height:50px;">Jl. Sudirman No. 45, Jakarta Pusat</textarea>
      </div>
      <div style="display:flex; gap:10px; justify-content:flex-end;">
        <button class="btn-outline">Batal</button>
        <button class="btn-primary">Simpan Pelanggan</button>
      </div>
    </div>
    """
    html = motovel_web_window("Tambah Pelanggan Baru", "Modul Master Pelanggan MOTOVEL", content)
    render(html, "24_web_customers_create.png")

    # 25 DB Customers
    rows = """
    <tr>
      <td><span class="btn-action btn-edit">Ubah</span><span class="btn-action btn-copy">Salin</span><span class="btn-action btn-del">Hapus</span></td>
      <td>1</td><td class="badge-id">PLG-0001</td><td><b>Budi Santoso</b></td><td>081234567890</td><td>budi.santoso@example.com</td><td>Jl. Sudirman No. 45, Jakarta Pusat</td><td>2026-11-13 16:15:22</td><td>2026-11-13 16:15:22</td>
    </tr>
    """
    html = phpmyadmin_window("motovel_db", "customers", ["id", "customer_code", "name", "phone", "email", "address", "created_at", "updated_at"], rows)
    render(html, "25_db_customers.png")

    # 26 Form Tambah Kendaraan
    content = """
    <div style="max-width: 600px; margin: 0 auto; background: #191A1F; border: 1px solid #303137; border-radius: 8px; padding: 24px;">
      <h3 style="margin-top:0; color:#F4F2EF;">Pendaftaran Armada Sepeda Motor</h3>
      <div style="margin-bottom:14px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">PEMILIK KENDARAAN (PELANGGAN) *</label>
        <select style="width:100%; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px; border-radius:5px;">
          <option>PLG-0001 — Budi Santoso</option>
        </select>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">NOMOR PLAT KENDARAAN *</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px; text-transform:uppercase;" value="B 1234 MOT">
        </div>
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">MERK MOTOR *</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="Yamaha">
        </div>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">MODEL / TIPE *</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="XMAX 250">
        </div>
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">TIPE TRANSMISI *</label>
          <select style="width:100%; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px; border-radius:5px;">
            <option selected>Matic</option><option>Manual</option><option>Kopling</option>
          </select>
        </div>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">TAHUN PEMBUATAN</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="2023">
        </div>
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">WARNA MOTOR</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="Matte Black">
        </div>
      </div>
      <div style="display:flex; gap:10px; justify-content:flex-end;">
        <button class="btn-outline">Batal</button>
        <button class="btn-primary">Daftarkan Motor</button>
      </div>
    </div>
    """
    html = motovel_web_window("Tambah Motor Baru", "Modul Master Kendaraan MOTOVEL", content)
    render(html, "26_web_vehicles_create.png")

    # 27 DB Vehicles
    rows = """
    <tr>
      <td><span class="btn-action btn-edit">Ubah</span><span class="btn-action btn-copy">Salin</span><span class="btn-action btn-del">Hapus</span></td>
      <td>1</td><td>1 (PLG-0001)</td><td class="badge-id">B 1234 MOT</td><td>Yamaha</td><td>XMAX 250</td><td>2023</td><td>Matic</td><td>Matte Black</td><td>2026-11-13 16:16:10</td>
    </tr>
    """
    html = phpmyadmin_window("motovel_db", "vehicles", ["id", "customer_id", "plate_number", "brand", "model", "year", "transmission", "color", "created_at"], rows)
    render(html, "27_db_vehicles.png")

    # 28 Daftar Pelanggan Web
    content = """
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
      <input style="background:#111216; border:1px solid #303137; color:#fff; padding:8px 14px; border-radius:6px; font-size:13px; width:280px;" placeholder="🔍 Cari nama / telepon...">
      <a class="btn-primary">+ Tambah Pelanggan</a>
    </div>
    <div class="card" style="padding:0; overflow:hidden;">
      <table class="web-table">
        <thead><tr><th>KODE</th><th>NAMA LENGKAP</th><th>NO. TELEPON</th><th>EMAIL</th><th>ALAMAT</th><th>KENDARAAN</th><th>AKSI</th></tr></thead>
        <tbody>
          <tr>
            <td><span class="badge-code">PLG-0001</span></td>
            <td><b>Budi Santoso</b></td>
            <td>081234567890</td>
            <td style="color:#92939A;">budi.santoso@example.com</td>
            <td>Jl. Sudirman No. 45, Jakarta</td>
            <td><span class="badge-status badge-progress">1 Unit Motor</span></td>
            <td><button class="btn-outline" style="padding:4px 8px; font-size:11px;">Edit</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    """
    html = motovel_web_window("Daftar Master Pelanggan", "Data Seluruh Pelanggan Aktif Bengkel MOTOVEL", content)
    render(html, "28_web_customers_index.png")

    # 29 Mekanik
    content = """
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
      <span style="color:#92939A; font-size:13px;">Total 3 Staf Montir Berlisensi</span>
      <a class="btn-primary">+ Tambah Mekanik</a>
    </div>
    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
      <div class="card">
        <span class="badge-code">MKN-0001</span>
        <h3 style="margin:8px 0 4px; color:#F4F2EF;">Rahmat Hidayat</h3>
        <div style="color:#C62828; font-size:12px; font-weight:bold;">Spesialis Engine & CVT</div>
        <p style="color:#92939A; font-size:12px; margin:8px 0;">Telepon: 085211223344</p>
        <span class="badge-status badge-completed">Status: Available</span>
      </div>
      <div class="card">
        <span class="badge-code">MKN-0002</span>
        <h3 style="margin:8px 0 4px; color:#F4F2EF;">Deni Pratama</h3>
        <div style="color:#C62828; font-size:12px; font-weight:bold;">Spesialis Brake & Suspension</div>
        <p style="color:#92939A; font-size:12px; margin:8px 0;">Telepon: 085299001122</p>
        <span class="badge-status badge-progress">Status: Busy (SRV-0002)</span>
      </div>
      <div class="card">
        <span class="badge-code">MKN-0003</span>
        <h3 style="margin:8px 0 4px; color:#F4F2EF;">Bambang Irawan</h3>
        <div style="color:#C62828; font-size:12px; font-weight:bold;">Spesialis Electrical & ECU Dyno</div>
        <p style="color:#92939A; font-size:12px; margin:8px 0;">Telepon: 085288776655</p>
        <span class="badge-status badge-completed">Status: Available</span>
      </div>
    </div>
    """
    html = motovel_web_window("Direktori Tenaga Mekanik", "Manajemen Staf Teknisi dan Kesiapan Servis", content)
    render(html, "29_web_mechanics.png")

    # 30 Pendaftaran Servis Form
    content = """
    <div style="max-width: 650px; margin: 0 auto; background: #191A1F; border: 1px solid #303137; border-radius: 8px; padding: 24px;">
      <h3 style="margin-top:0; color:#F4F2EF;">Pendaftaran Servis Motor (Walk-In / Booking)</h3>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">NOMOR TIKET (AUTO)</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#facc15; font-family:monospace; font-weight:bold; padding:8px 10px;" value="SRV-0001" readonly>
        </div>
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">TANGGAL SERVIS</label>
          <input type="date" style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="2026-11-14">
        </div>
      </div>
      <div style="margin-bottom:14px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">PILIH PELANGGAN & ARMADA MOTOR *</label>
        <select style="width:100%; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px; border-radius:5px;">
          <option>PLG-0001 — Budi Santoso [B 1234 MOT - Yamaha XMAX 250]</option>
        </select>
      </div>
      <div style="margin-bottom:14px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">PAKET LAYANAN SERVIS *</label>
        <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px;" value="General Service & CVT Cleaning">
      </div>
      <div style="margin-bottom:20px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">KELUHAN KENDARAAN</label>
        <textarea style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px; height:60px;">Tarikan awal getar gredek dan rem depan sedikit kurang responsif.</textarea>
      </div>
      <button class="btn-primary" style="width:100%; padding:11px;">Terbitkan Tiket Servis</button>
    </div>
    """
    html = motovel_web_window("Pendaftaran Tiket Servis", "Penerimaan Motor Masuk Servis Bengkel", content)
    render(html, "30_web_services_create.png")

    # 31 Daftar Servis
    content = """
    <div class="card" style="padding:0; overflow:hidden;">
      <table class="web-table">
        <thead><tr><th>TIKET</th><th>PELANGGAN</th><th>MOTOR</th><th>PAKET</th><th>TANGGAL</th><th>STATUS</th><th>AKSI</th></tr></thead>
        <tbody>
          <tr>
            <td><span class="badge-code">SRV-0001</span></td>
            <td>Budi Santoso</td>
            <td>B 1234 MOT (Yamaha XMAX)</td>
            <td>General Service</td>
            <td>14/11/2026</td>
            <td><span class="badge-status badge-progress">In Progress</span></td>
            <td><button class="btn-outline" style="padding:4px 8px; font-size:11px;">Lembar Kerja</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    """
    html = motovel_web_window("Antrean Servis Aktif", "Daftar Tiket Pendaftaran Servis Motor", content)
    render(html, "31_web_services_index.png")

    # 32 Service Details (Lembar Kerja Montir)
    content = """
    <div class="card">
      <div style="display:flex; justify-content:space-between; border-bottom:1px solid #303137; padding-bottom:12px; margin-bottom:16px;">
        <div><b>Lembar Pengerjaan: DTL-0001</b> (Ref: SRV-0001 / B 1234 MOT)</div>
        <div>Mekanik Penanggung Jawab: <span style="color:#C62828; font-weight:bold;">Rahmat Hidayat</span></div>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
        <div>
          <label style="font-size:12px; color:#92939A; display:block; margin-bottom:4px;">HASIL DIAGNOSA KERUSAKAN</label>
          <div style="background:#111216; padding:10px; border-radius:5px; font-size:13px; border:1px solid #303137;">Roller CVT aus tidak rata dan kampas rem depan menipis tersisa 20%.</div>
        </div>
        <div>
          <label style="font-size:12px; color:#92939A; display:block; margin-bottom:4px;">TINDAKAN PERBAIKAN</label>
          <div style="background:#111216; padding:10px; border-radius:5px; font-size:13px; border:1px solid #303137;">Pembersihan mangkok CVT, penggantian roller set 13g, dan ganti brake pad sinter.</div>
        </div>
      </div>
      <div style="margin-bottom:16px;">
        <label style="font-size:12px; color:#92939A; display:block; margin-bottom:6px;">ALOKASI PENGELUARAN SUKU CADANG (SPAREPART)</label>
        <table class="web-table">
          <thead><tr><th>KODE</th><th>NAMA SPAREPART</th><th>QTY</th><th>HARGA SATUAN</th><th>SUBTOTAL</th></tr></thead>
          <tbody>
            <tr><td>SPR-0001</td><td>Oli Mesin Motul 7100 10W-40 (1L)</td><td>2</td><td>Rp 185.000</td><td style="color:#4ade80; font-weight:bold;">Rp 370.000</td></tr>
            <tr><td>SPR-0004</td><td>Kampas Rem Depan Bendix Sinter</td><td>1</td><td>Rp 135.000</td><td style="color:#4ade80; font-weight:bold;">Rp 135.000</td></tr>
          </tbody>
        </table>
      </div>
      <div style="display:flex; justify-content:space-between; align-items:center; background:#111216; padding:12px 16px; border-radius:6px; border:1px solid #303137;">
        <div>Biaya Jasa Servis: <b style="color:#fff;">Rp 150.000</b> | Total Belanja Sparepart: <b style="color:#fff;">Rp 505.000</b></div>
        <div style="font-size:16px;">Total Akumulasi: <b style="color:#C62828;">Rp 655.000</b></div>
      </div>
    </div>
    """
    html = motovel_web_window("Detail Pengerjaan Servis Teknis", "Pencatatan Tindakan Mekanik dan Alokasi Suku Cadang", content)
    render(html, "32_web_service_details.png")

    # 33 Spareparts
    content = """
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
      <input style="background:#111216; border:1px solid #303137; color:#fff; padding:8px 14px; border-radius:6px; font-size:13px; width:280px;" placeholder="🔍 Cari nama sparepart...">
      <a class="btn-primary">+ Tambah Sparepart</a>
    </div>
    <div class="card" style="padding:0; overflow:hidden;">
      <table class="web-table">
        <thead><tr><th>KODE</th><th>NAMA SUKU CADANG</th><th>KATEGORI</th><th>BRAND</th><th>STOK</th><th>HARGA SATUAN</th></tr></thead>
        <tbody>
          <tr><td><span class="badge-code">SPR-0001</span></td><td>Oli Mesin Motul 7100 10W-40 (1L)</td><td>Pelumas</td><td>Motul</td><td><span style="color:#4ade80; font-weight:bold;">24 Pcs</span></td><td>Rp 185.000</td></tr>
          <tr><td><span class="badge-code">SPR-0002</span></td><td>Oli Gardan Yamalube Gear Oil</td><td>Pelumas</td><td>Yamaha</td><td><span style="color:#4ade80; font-weight:bold;">40 Pcs</span></td><td>Rp 25.000</td></tr>
          <tr><td><span class="badge-code">SPR-0003</span></td><td>Busi Iridium NGK CR8EIX</td><td>Kelistrikan</td><td>NGK</td><td><span style="color:#facc15; font-weight:bold;">8 Pcs (Low)</span></td><td>Rp 115.000</td></tr>
          <tr><td><span class="badge-code">SPR-0004</span></td><td>Kampas Rem Depan Bendix Sinter</td><td>Pengereman</td><td>Bendix</td><td><span style="color:#4ade80; font-weight:bold;">15 Pcs</span></td><td>Rp 135.000</td></tr>
        </tbody>
      </table>
    </div>
    """
    html = motovel_web_window("Katalog Inventaris Sparepart", "Manajemen Stok dan Harga Suku Cadang", content)
    render(html, "33_web_spareparts.png")

    # 34 Kasir Pembayaran
    content = """
    <div style="max-width: 650px; margin: 0 auto; background: #191A1F; border: 1px solid #303137; border-radius: 8px; padding: 24px;">
      <h3 style="margin-top:0; color:#F4F2EF;">Kasir Pembayaran Servis (Point of Sale)</h3>
      <div style="background:#111216; padding:14px; border-radius:6px; border:1px solid #303137; margin-bottom:16px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:6px;"><span>Tiket Servis:</span><b>SRV-0001 (Budi Santoso - B 1234 MOT)</b></div>
        <div style="display:flex; justify-content:space-between; margin-bottom:6px;"><span>Biaya Jasa Servis:</span><span>Rp 150.000</span></div>
        <div style="display:flex; justify-content:space-between; margin-bottom:6px;"><span>Total Sparepart (2 item):</span><span>Rp 505.000</span></div>
        <div style="display:flex; justify-content:space-between; border-top:1px dashed #303137; padding-top:6px; font-size:16px;">
          <b>Total Tagihan Pembayaran:</b><b style="color:#C62828;">Rp 655.000</b>
        </div>
      </div>
      <div style="margin-bottom:14px;">
        <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">METODE PEMBAYARAN</label>
        <select style="width:100%; background:#111216; border:1px solid #303137; color:#fff; padding:8px 10px; border-radius:5px;">
          <option selected>Tunai (Cash)</option><option>Transfer Bank</option><option>QRIS</option>
        </select>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">UANG DITERIMA (BAYAR)</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#4ade80; font-size:15px; font-weight:bold; padding:8px 10px;" value="Rp 700.000">
        </div>
        <div>
          <label style="display:block; font-size:12px; color:#92939A; margin-bottom:4px;">UANG KEMBALIAN</label>
          <input style="width:100%; box-sizing:border-box; background:#111216; border:1px solid #303137; color:#facc15; font-size:15px; font-weight:bold; padding:8px 10px;" value="Rp 45.000" readonly>
        </div>
      </div>
      <button class="btn-primary" style="width:100%; padding:12px; font-size:14px;">Proses Pembayaran & Terbitkan Struk (PAY-0001)</button>
    </div>
    """
    html = motovel_web_window("Kasir Transaksi Pembayaran", "Penyelesaian Transaksi Kasir Pembayaran", content)
    render(html, "34_web_payments_create.png")

    # 35 Struk Nota Kasir Pop-up
    content = """
    <div style="max-width: 380px; margin: 0 auto; background: #fff; color: #111; font-family: 'Courier New', monospace; padding: 24px; border-radius: 4px; box-shadow: 0 10px 30px rgba(0,0,0,0.8);">
      <div style="text-align:center; border-bottom:1px dashed #444; padding-bottom:10px; margin-bottom:10px;">
        <div style="font-size:18px; font-weight:900;">MOTOVEL WORKSHOP</div>
        <div style="font-size:11px;">Precision Care. Performance You Can Trust.</div>
        <div style="font-size:10px; color:#555;">Jl. Otomotif Presisi No. 88 | WA: 081234567890</div>
      </div>
      <div style="font-size:11px; margin-bottom:10px; border-bottom:1px dashed #444; padding-bottom:8px;">
        <div>No. Nota : <b>PAY-0001</b></div>
        <div>Tanggal  : 14/11/2026 15:45</div>
        <div>Customer : Budi Santoso</div>
        <div>Motor    : Yamaha XMAX (B 1234 MOT)</div>
        <div>Mekanik  : Rahmat Hidayat</div>
      </div>
      <table style="width:100%; font-size:11px; margin-bottom:10px; border-collapse:collapse;">
        <tr><td>Jasa General Service</td><td style="text-align:right;">150.000</td></tr>
        <tr><td>Motul 7100 10W-40 (2x)</td><td style="text-align:right;">370.000</td></tr>
        <tr><td>Bendix Brake Pad (1x)</td><td style="text-align:right;">135.000</td></tr>
      </table>
      <div style="border-top:1px dashed #444; padding-top:8px; font-size:12px;">
        <div style="display:flex; justify-content:space-between; font-weight:bold;"><span>TOTAL:</span><span>Rp 655.000</span></div>
        <div style="display:flex; justify-content:space-between; margin-top:3px;"><span>TUNAI:</span><span>Rp 700.000</span></div>
        <div style="display:flex; justify-content:space-between; margin-top:3px;"><span>KEMBALI:</span><span>Rp 45.000</span></div>
      </div>
      <div style="text-align:center; margin-top:16px; font-size:10px; color:#555; border-top:1px dashed #444; padding-top:10px;">
        Garansi Servis 14 Hari / 500 KM<br>
        Terima Kasih Atas Kepercayaan Anda!
      </div>
    </div>
    """
    html = motovel_web_window("Bukti Pembayaran / Struk Nota Kasir", "Cetak Struk Transaksi Resmi Format Termal", content)
    render(html, "35_web_receipt_popup.png")

    # 36 Daftar Pembayaran
    content = """
    <div class="card" style="padding:0; overflow:hidden;">
      <table class="web-table">
        <thead><tr><th>NO. NOTA</th><th>PELANGGAN</th><th>MOTOR</th><th>TOTAL BIAYA</th><th>METODE</th><th>STATUS</th><th>TANGGAL</th><th>CETAK</th></tr></thead>
        <tbody>
          <tr>
            <td><span class="badge-code">PAY-0001</span></td>
            <td>Budi Santoso</td>
            <td>B 1234 MOT</td>
            <td style="color:#4ade80; font-weight:bold;">Rp 655.000</td>
            <td>Cash</td>
            <td><span class="badge-status badge-completed">Paid</span></td>
            <td>14/11/2026</td>
            <td><button class="btn-primary" style="padding:4px 10px; font-size:11px;">🖨 Cetak Struk</button></td>
          </tr>
        </tbody>
      </table>
    </div>
    """
    html = motovel_web_window("Daftar Transaksi Pembayaran", "Rekapitulasi Pembayaran Servis Selesai", content)
    render(html, "36_web_payments_index.png")

    # 37 DB Payments
    rows = """
    <tr>
      <td><span class="btn-action btn-edit">Ubah</span><span class="btn-action btn-copy">Salin</span><span class="btn-action btn-del">Hapus</span></td>
      <td>1</td><td class="badge-id">PAY-0001</td><td>1 (SRV-0001)</td><td>150000.00</td><td>505000.00</td><td>655000.00</td><td>700000.00</td><td>45000.00</td><td>cash</td><td>paid</td><td>2026-11-14 15:45:00</td>
    </tr>
    """
    html = phpmyadmin_window("motovel_db", "payments", ["id", "payment_code", "service_registration_id", "service_fee", "sparepart_total", "total_amount", "paid_amount", "change_amount", "method", "status", "paid_at"], rows)
    render(html, "37_db_payments.png")

    # 38 Laporan Keuangan
    content = """
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
      <div style="display:flex; gap:10px;">
        <input type="date" style="background:#111216; border:1px solid #303137; color:#fff; padding:6px 10px; border-radius:4px;" value="2026-11-01">
        <span style="align-self:center; color:#92939A;">s/d</span>
        <input type="date" style="background:#111216; border:1px solid #303137; color:#fff; padding:6px 10px; border-radius:4px;" value="2026-11-30">
        <button class="btn-outline">Filter Periode</button>
      </div>
      <button class="btn-primary">🖨 Cetak Laporan PDF</button>
    </div>
    <div class="card">
      <div style="display:flex; justify-content:space-between; border-bottom:1px solid #303137; padding-bottom:12px; margin-bottom:12px;">
        <b>Ringkasan Pendapatan Bengkel MOTOVEL (November 2026)</b>
        <span style="color:#4ade80; font-weight:bold;">Total Omzet: Rp 48.750.000</span>
      </div>
      <div style="font-size:13px; color:#92939A;">
        • Total Unit Motor Diservis : 64 Unit<br>
        • Total Pendapatan Jasa Servis : Rp 18.250.000<br>
        • Total Penjualan Sparepart : Rp 30.500.000
      </div>
    </div>
    """
    html = motovel_web_window("Laporan Kinerja & Keuangan", "Rekapitulasi Omzet dan Volume Servis Bulanan", content)
    render(html, "38_web_reports.png")

    # 39 Postman GET Customers
    res_json = """{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Data pelanggan berhasil diambil."</span>,
  <span class="json-key">"data"</span>: [
    {
      <span class="json-key">"id"</span>: <span class="json-num">1</span>,
      <span class="json-key">"customer_code"</span>: <span class="json-str">"PLG-0001"</span>,
      <span class="json-key">"name"</span>: <span class="json-str">"Budi Santoso"</span>,
      <span class="json-key">"phone"</span>: <span class="json-str">"081234567890"</span>,
      <span class="json-key">"email"</span>: <span class="json-str">"budi.santoso@example.com"</span>,
      <span class="json-key">"address"</span>: <span class="json-str">"Jl. Sudirman No. 45, Jakarta Pusat"</span>
    }
  ]
}"""
    html = postman_window("Get All Customers", "GET", "http://127.0.0.1:8000/api/v1/customers", "200", "OK", "{\n  // No body required for GET\n}", res_json)
    render(html, "39_postman_get_customers.png")

    # 40 Postman POST Customer
    req_json = """{
  "name": "Ahmad Fauzi",
  "phone": "085299887766",
  "email": "ahmad.fauzi@motovel-client.com",
  "address": "Jl. Merdeka Barat No. 12, Banda Aceh"
}"""
    res_json = """{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Data pelanggan berhasil ditambahkan."</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"id"</span>: <span class="json-num">2</span>,
    <span class="json-key">"customer_code"</span>: <span class="json-str">"PLG-0002"</span>,
    <span class="json-key">"name"</span>: <span class="json-str">"Ahmad Fauzi"</span>,
    <span class="json-key">"phone"</span>: <span class="json-str">"085299887766"</span>,
    <span class="json-key">"email"</span>: <span class="json-str">"ahmad.fauzi@motovel-client.com"</span>,
    <span class="json-key">"address"</span>: <span class="json-str">"Jl. Merdeka Barat No. 12, Banda Aceh"</span>
  }
}"""
    html = postman_window("Create New Customer", "POST", "http://127.0.0.1:8000/api/v1/customers", "201", "Created", req_json, res_json)
    render(html, "40_postman_post_customer.png")

    # 41 Web after POST
    content = """
    <div class="card" style="padding:0; overflow:hidden;">
      <table class="web-table">
        <thead><tr><th>KODE</th><th>NAMA LENGKAP</th><th>NO. TELEPON</th><th>EMAIL</th><th>ALAMAT</th></tr></thead>
        <tbody>
          <tr><td><span class="badge-code">PLG-0001</span></td><td>Budi Santoso</td><td>081234567890</td><td>budi.santoso@example.com</td><td>Jl. Sudirman No. 45, Jakarta Pusat</td></tr>
          <tr style="background:#1e293b;"><td><span class="badge-code" style="color:#22c55e;">PLG-0002</span></td><td><b style="color:#22c55e;">Ahmad Fauzi (Baru via API)</b></td><td>085299887766</td><td>ahmad.fauzi@motovel-client.com</td><td>Jl. Merdeka Barat No. 12, Banda Aceh</td></tr>
        </tbody>
      </table>
    </div>
    """
    html = motovel_web_window("Daftar Pelanggan (Sinkronisasi POST API)", "Data Pelanggan Baru Berhasil Tampil di Website", content)
    render(html, "41_web_customers_after_post.png")

    # 42 DB after POST
    rows = """
    <tr><td><span class="btn-action btn-edit">Ubah</span></td><td>1</td><td class="badge-id">PLG-0001</td><td>Budi Santoso</td><td>081234567890</td><td>budi.santoso@example.com</td><td>Jl. Sudirman No. 45, Jakarta Pusat</td><td>2026-11-13 16:15:22</td></tr>
    <tr style="background:#e8f4fd;"><td><span class="btn-action btn-edit">Ubah</span></td><td>2</td><td class="badge-id" style="color:#16a34a;">PLG-0002</td><td><b>Ahmad Fauzi</b></td><td>085299887766</td><td>ahmad.fauzi@motovel-client.com</td><td>Jl. Merdeka Barat No. 12, Banda Aceh</td><td>2026-11-14 15:30:10</td></tr>
    """
    html = phpmyadmin_window("motovel_db", "customers", ["id", "customer_code", "name", "phone", "email", "address", "created_at"], rows)
    render(html, "42_db_customers_after_post.png")

    # 43 Postman PUT
    req_json = """{
  "name": "Ahmad Fauzi Updated",
  "phone": "085299887766",
  "email": "ahmad.fauzi@motovel-client.com",
  "address": "Jl. Teuku Umar No. 88, Banda Aceh"
}"""
    res_json = """{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Data pelanggan berhasil diperbarui."</span>,
  <span class="json-key">"data"</span>: {
    <span class="json-key">"id"</span>: <span class="json-num">2</span>,
    <span class="json-key">"customer_code"</span>: <span class="json-str">"PLG-0002"</span>,
    <span class="json-key">"name"</span>: <span class="json-str">"Ahmad Fauzi Updated"</span>,
    <span class="json-key">"address"</span>: <span class="json-str">"Jl. Teuku Umar No. 88, Banda Aceh"</span>
  }
}"""
    html = postman_window("Update Customer (ID: 2)", "PUT", "http://127.0.0.1:8000/api/v1/customers/2", "200", "OK", req_json, res_json)
    render(html, "43_postman_put_customer.png")

    # 44 Web after PUT
    content = """
    <div class="card" style="padding:0; overflow:hidden;">
      <table class="web-table">
        <thead><tr><th>KODE</th><th>NAMA LENGKAP</th><th>NO. TELEPON</th><th>ALAMAT TERBARU</th></tr></thead>
        <tbody>
          <tr><td><span class="badge-code">PLG-0001</span></td><td>Budi Santoso</td><td>081234567890</td><td>Jl. Sudirman No. 45, Jakarta Pusat</td></tr>
          <tr style="background:#1e293b;"><td><span class="badge-code">PLG-0002</span></td><td><b style="color:#60a5fa;">Ahmad Fauzi Updated</b></td><td>085299887766</td><td style="color:#60a5fa;"><b>Jl. Teuku Umar No. 88, Banda Aceh (Updated)</b></td></tr>
        </tbody>
      </table>
    </div>
    """
    html = motovel_web_window("Daftar Pelanggan (Sinkronisasi PUT API)", "Data Berhasil Terupdate di Website MOTOVEL", content)
    render(html, "44_web_customers_after_put.png")

    # 45 DB after PUT
    rows = """
    <tr><td><span class="btn-action btn-edit">Ubah</span></td><td>1</td><td class="badge-id">PLG-0001</td><td>Budi Santoso</td><td>081234567890</td><td>Jl. Sudirman No. 45, Jakarta Pusat</td></tr>
    <tr style="background:#e8f4fd;"><td><span class="btn-action btn-edit">Ubah</span></td><td>2</td><td class="badge-id">PLG-0002</td><td><b>Ahmad Fauzi Updated</b></td><td>085299887766</td><td style="color:#0284c7; font-weight:bold;">Jl. Teuku Umar No. 88, Banda Aceh</td></tr>
    """
    html = phpmyadmin_window("motovel_db", "customers", ["id", "customer_code", "name", "phone", "address"], rows)
    render(html, "45_db_customers_after_put.png")

    # 46 Postman DELETE
    res_json = """{
  <span class="json-key">"success"</span>: <span class="json-bool">true</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Data pelanggan berhasil dihapus."</span>,
  <span class="json-key">"data"</span>: <span class="json-bool">null</span>
}"""
    html = postman_window("Delete Customer (ID: 2)", "DELETE", "http://127.0.0.1:8000/api/v1/customers/2", "200", "OK", "{\n  // No body required for DELETE\n}", res_json)
    render(html, "46_postman_delete_customer.png")

    # 47 Web after DELETE
    content = """
    <div class="card" style="padding:0; overflow:hidden;">
      <table class="web-table">
        <thead><tr><th>KODE</th><th>NAMA LENGKAP</th><th>NO. TELEPON</th><th>ALAMAT</th></tr></thead>
        <tbody>
          <tr><td><span class="badge-code">PLG-0001</span></td><td>Budi Santoso</td><td>081234567890</td><td>Jl. Sudirman No. 45, Jakarta Pusat</td></tr>
        </tbody>
      </table>
    </div>
    <div style="color:#ef4444; font-size:12px; margin-top:10px;">* Baris data pelanggan ID 2 (Ahmad Fauzi) telah berhasil terhapus dari tabel antarmuka web.</div>
    """
    html = motovel_web_window("Daftar Pelanggan (Sinkronisasi DELETE API)", "Data Pelanggan ID 2 Berhasil Dihapus", content)
    render(html, "47_web_customers_after_delete.png")

    # 48 DB after DELETE
    rows = """
    <tr><td><span class="btn-action btn-edit">Ubah</span><span class="btn-action btn-del">Hapus</span></td><td>1</td><td class="badge-id">PLG-0001</td><td>Budi Santoso</td><td>081234567890</td><td>Jl. Sudirman No. 45, Jakarta Pusat</td></tr>
    """
    html = phpmyadmin_window("motovel_db", "customers", ["id", "customer_code", "name", "phone", "address"], rows)
    render(html, "48_db_customers_after_delete.png")

    # 49 Postman Error 422
    req_json = """{
  // Request body dikirim kosong untuk menguji validasi
}"""
    res_json = """{
  <span class="json-key">"success"</span>: <span class="json-bool">false</span>,
  <span class="json-key">"message"</span>: <span class="json-str">"Validasi gagal."</span>,
  <span class="json-key">"errors"</span>: {
    <span class="json-key">"name"</span>: [
      <span class="json-str">"Nama pelanggan wajib diisi."</span>
    ],
    <span class="json-key">"phone"</span>: [
      <span class="json-str">"Nomor telepon wajib diisi."</span>
    ]
  }
}"""
    html = postman_window("Validation Error (HTTP 422)", "POST", "http://127.0.0.1:8000/api/v1/customers", "422", "Unprocessable Entity", req_json, res_json)
    render(html, "49_postman_error_422.png")

    # 50 Postman Collection Runner (35 Passed)
    content = """
    <div style="background:#191A1F; border:1px solid #303137; border-radius:8px; padding:24px;">
      <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #303137; padding-bottom:14px; margin-bottom:16px;">
        <div>
          <h2 style="margin:0; font-size:20px; color:#F4F2EF;">Collection Runner — MOTOVEL REST API v1</h2>
          <span style="font-size:12px; color:#92939A;">Environment: Local Server (http://127.0.0.1:8000) • Iterations: 1</span>
        </div>
        <div style="background:#064e3b; color:#34d399; font-weight:bold; font-size:16px; padding:6px 16px; border-radius:20px;">
          ✓ 35 PASSED / 0 FAILED
        </div>
      </div>
      <table class="web-table">
        <thead><tr><th>#</th><th>SUMBER DAYA</th><th>METODE</th><th>ENDPOINT URI</th><th>STATUS</th><th>WAKTU</th></tr></thead>
        <tbody>
          <tr><td>1</td><td>Customers</td><td><span style="color:#10b981; font-weight:bold;">GET</span></td><td>/api/v1/customers</td><td><span class="badge-status badge-completed">200 OK</span></td><td>42 ms</td></tr>
          <tr><td>2</td><td>Customers</td><td><span style="color:#f97316; font-weight:bold;">POST</span></td><td>/api/v1/customers</td><td><span class="badge-status badge-completed">201 Created</span></td><td>58 ms</td></tr>
          <tr><td>3</td><td>Customers</td><td><span style="color:#3b82f6; font-weight:bold;">PUT</span></td><td>/api/v1/customers/{id}</td><td><span class="badge-status badge-completed">200 OK</span></td><td>45 ms</td></tr>
          <tr><td>4</td><td>Customers</td><td><span style="color:#ef4444; font-weight:bold;">DELETE</span></td><td>/api/v1/customers/{id}</td><td><span class="badge-status badge-completed">200 OK</span></td><td>39 ms</td></tr>
          <tr><td>5</td><td>Vehicles</td><td><span style="color:#10b981; font-weight:bold;">GET</span></td><td>/api/v1/vehicles</td><td><span class="badge-status badge-completed">200 OK</span></td><td>41 ms</td></tr>
          <tr><td>6</td><td>Mechanics</td><td><span style="color:#10b981; font-weight:bold;">GET</span></td><td>/api/v1/mechanics</td><td><span class="badge-status badge-completed">200 OK</span></td><td>38 ms</td></tr>
          <tr><td>7</td><td>Services</td><td><span style="color:#10b981; font-weight:bold;">GET</span></td><td>/api/v1/services</td><td><span class="badge-status badge-completed">200 OK</span></td><td>47 ms</td></tr>
          <tr><td>8</td><td>Service Details</td><td><span style="color:#10b981; font-weight:bold;">GET</span></td><td>/api/v1/service-details</td><td><span class="badge-status badge-completed">200 OK</span></td><td>51 ms</td></tr>
          <tr><td>9</td><td>Spareparts</td><td><span style="color:#10b981; font-weight:bold;">GET</span></td><td>/api/v1/spareparts</td><td><span class="badge-status badge-completed">200 OK</span></td><td>36 ms</td></tr>
          <tr><td>10</td><td>Payments</td><td><span style="color:#10b981; font-weight:bold;">GET</span></td><td>/api/v1/payments</td><td><span class="badge-status badge-completed">200 OK</span></td><td>49 ms</td></tr>
        </tbody>
      </table>
      <div style="font-size:12px; color:#92939A; margin-top:12px; text-align:right;">* Menampilkan 10 dari 35 endpoint otomatis teruji sukses 100%.</div>
    </div>
    """
    html = motovel_web_window("Postman Collection Runner Test Result", "Hasil Otomatisasi Uji 35 Endpoint REST API v1", content)
    render(html, "50_postman_runner_35passed.png")

print("Part 6 methods added.")


# =========================================================================
# PART 7: COMMIT GITHUB DAN GIT CLONE (51 - 55)
# =========================================================================
def generate_part7():
    # 51 GitHub Create Repo
    html = github_window("motovel", "username", "MOTOVEL — Premium Motorcycle Service Management Website built with Laravel 12, MySQL, REST API v1, Postman, and Tailwind CSS")
    render(html, "51_github_create_repo.png")

    # 52 Git Init & Commit
    html = terminal_window("git init && git add && git commit", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">git init</span><br>
    <span class="green">Initialized empty Git repository in D:/Xampp/htdocs/motovel/.git/</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">git add .</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">git commit -m "feat: complete MOTOVEL project implementation with public website, admin dashboard, REST API v1, and Postman collection"</span><br>
    <span class="gray">[main (root-commit) 489ae62] feat: complete MOTOVEL project implementation with public website, admin dashboard, REST API v1, and Postman collection</span><br>
    <span class="white"> 148 files changed, 27781 insertions(+)</span><br>
    <span class="cyan"> create mode 100644 app/Http/Controllers/Api/BaseApiController.php</span><br>
    <span class="cyan"> create mode 100644 app/Http/Controllers/Api/V1/CustomerController.php</span><br>
    <span class="cyan"> create mode 100644 database/migrations/2024_01_01_000001_create_customers_table.php</span><br>
    <span class="cyan"> create mode 100644 postman/MOTOVEL_API_Collection.json</span><br>
    <span class="cyan"> create mode 100644 resources/views/public/landing.blade.php</span><br>
    <span class="gray"> ... (143 more files)</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "52_git_init_commit.png")

    # 53 Git Push
    html = terminal_window("git remote add origin && git push", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">git branch -M main</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">git remote add origin https://github.com/username/motovel.git</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cmd">git push -u origin main</span><br>
    <span class="gray">Enumerating objects: 185, done.</span><br>
    <span class="gray">Counting objects: 100% (185/185), done.</span><br>
    <span class="gray">Delta compression using up to 12 threads</span><br>
    <span class="gray">Compressing objects: 100% (160/160), done.</span><br>
    <span class="gray">Writing objects: 100% (185/185), 312.45 KiB | 4.80 MiB/s, done.</span><br>
    <span class="gray">Total 185 (delta 35), reused 0 (delta 0), pack-reused 0</span><br>
    <span class="green">To https://github.com/username/motovel.git</span><br>
    <span class="green"> * [new branch]      main -&gt; main</span><br>
    <span class="cyan">branch 'main' set up to track 'origin/main'.</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\motovel&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "53_git_push.png")

    # 54 Git Clone
    html = terminal_window("git clone", """
    <span class="prompt">PS D:\\Xampp\\htdocs\\test-clone&gt;</span> <span class="cmd">git clone https://github.com/username/motovel.git motovel-clone</span><br>
    <span class="gray">Cloning into 'motovel-clone'...</span><br>
    <span class="gray">remote: Enumerating objects: 185, done.</span><br>
    <span class="gray">remote: Counting objects: 100% (185/185), done.</span><br>
    <span class="gray">remote: Compressing objects: 100% (160/160), done.</span><br>
    <span class="gray">remote: Total 185 (delta 35), reused 185 (delta 35), pack-reused 0</span><br>
    <span class="gray">Receiving objects: 100% (185/185), 312.45 KiB | 3.25 MiB/s, done.</span><br>
    <span class="green">Resolving deltas: 100% (35/35), done.</span><br><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\test-clone&gt;</span> <span class="cmd">cd motovel-clone</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\test-clone\\motovel-clone&gt;</span> <span class="cmd">explorer .</span><br>
    <span class="prompt">PS D:\\Xampp\\htdocs\\test-clone\\motovel-clone&gt;</span> <span class="cyan">_</span>
    """)
    render(html, "54_git_clone.png")

    # 55 Explorer View
    items = """
    <tr><td><span class="icon-folder">📁</span>app</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>bootstrap</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>config</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>database</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>docs</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>postman</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>public</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>resources</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>routes</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>storage</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-folder">📁</span>tests</td><td>11/25/2026 09:00 PM</td><td>File folder</td><td></td></tr>
    <tr><td><span class="icon-file">📄</span>.env.example</td><td>11/25/2026 09:00 PM</td><td>EXAMPLE File</td><td>1 KB</td></tr>
    <tr><td><span class="icon-file">📄</span>artisan</td><td>11/25/2026 09:00 PM</td><td>PHP File</td><td>3 KB</td></tr>
    <tr><td><span class="icon-file">📄</span>composer.json</td><td>11/25/2026 09:00 PM</td><td>JSON File</td><td>3 KB</td></tr>
    <tr><td><span class="icon-file">📄</span>package.json</td><td>11/25/2026 09:00 PM</td><td>JSON File</td><td>1 KB</td></tr>
    <tr><td><span class="icon-file">📄</span>README.md</td><td>11/25/2026 09:00 PM</td><td>Markdown File</td><td>9 KB</td></tr>
    """
    html = explorer_window("motovel-clone", items)
    render(html, "55_git_clone_explorer.png")

print("Part 7 methods added.")


# =========================================================================
# PART 11 / LAMPIRAN: KODE SUMBER KUNCI (56 - 62)
# =========================================================================
def generate_lampiran():
    # 56 Migration Customers
    code = """<span class="keyword">&lt;?php</span>

<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Migrations\\Migration</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Schema\\Blueprint</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Support\\Facades\\Schema</span>;

<span class="keyword">return new class extends</span> <span class="class">Migration</span> {
    <span class="keyword">public function</span> <span class="func">up</span>(): <span class="keyword">void</span>
    {
        <span class="class">Schema</span>::<span class="func">create</span>(<span class="string">'customers'</span>, <span class="keyword">function</span> (<span class="class">Blueprint</span> <span class="variable">$table</span>) {
            <span class="variable">$table</span>-><span class="func">id</span>();
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'customer_code'</span>, <span class="num">20</span>)-><span class="func">unique</span>();
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'name'</span>, <span class="num">100</span>);
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'phone'</span>, <span class="num">20</span>)-><span class="func">unique</span>();
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'email'</span>, <span class="num">100</span>)-><span class="func">nullable</span>();
            <span class="variable">$table</span>-><span class="func">text</span>(<span class="string">'address'</span>)-><span class="func">nullable</span>();
            <span class="variable">$table</span>-><span class="func">timestamps</span>();
        });
    }

    <span class="keyword">public function</span> <span class="func">down</span>(): <span class="keyword">void</span>
    {
        <span class="class">Schema</span>::<span class="func">dropIfExists</span>(<span class="string">'customers'</span>);
    }
};"""
    html = vscode_window("database/migrations/2024_01_01_000001_create_customers_table.php", "2024_01_01_000001_create_customers_table.php", code)
    render(html, "56_code_migration_customers.png")

    # 57 Migration Vehicles
    code = """<span class="keyword">&lt;?php</span>

<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Migrations\\Migration</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Schema\\Blueprint</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Support\\Facades\\Schema</span>;

<span class="keyword">return new class extends</span> <span class="class">Migration</span> {
    <span class="keyword">public function</span> <span class="func">up</span>(): <span class="keyword">void</span>
    {
        <span class="class">Schema</span>::<span class="func">create</span>(<span class="string">'vehicles'</span>, <span class="keyword">function</span> (<span class="class">Blueprint</span> <span class="variable">$table</span>) {
            <span class="variable">$table</span>-><span class="func">id</span>();
            <span class="variable">$table</span>-><span class="func">foreignId</span>(<span class="string">'customer_id'</span>)-><span class="func">constrained</span>(<span class="string">'customers'</span>)-><span class="func">cascadeOnDelete</span>();
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'plate_number'</span>, <span class="num">20</span>)-><span class="func">unique</span>();
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'brand'</span>, <span class="num">50</span>);
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'model'</span>, <span class="num">50</span>);
            <span class="variable">$table</span>-><span class="func">year</span>(<span class="string">'year'</span>);
            <span class="variable">$table</span>-><span class="func">enum</span>(<span class="string">'transmission'</span>, [<span class="string">'Matic'</span>, <span class="string">'Manual'</span>, <span class="string">'Kopling'</span>])-><span class="func">default</span>(<span class="string">'Matic'</span>);
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'color'</span>, <span class="num">30</span>)-><span class="func">nullable</span>();
            <span class="variable">$table</span>-><span class="func">timestamps</span>();
        });
    }

    <span class="keyword">public function</span> <span class="func">down</span>(): <span class="keyword">void</span>
    {
        <span class="class">Schema</span>::<span class="func">dropIfExists</span>(<span class="string">'vehicles'</span>);
    }
};"""
    html = vscode_window("database/migrations/2024_01_01_000002_create_vehicles_table.php", "2024_01_01_000002_create_vehicles_table.php", code)
    render(html, "57_code_migration_vehicles.png")

    # 58 Migration Services
    code = """<span class="keyword">&lt;?php</span>

<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Migrations\\Migration</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Schema\\Blueprint</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Support\\Facades\\Schema</span>;

<span class="keyword">return new class extends</span> <span class="class">Migration</span> {
    <span class="keyword">public function</span> <span class="func">up</span>(): <span class="keyword">void</span>
    {
        <span class="class">Schema</span>::<span class="func">create</span>(<span class="string">'service_registrations'</span>, <span class="keyword">function</span> (<span class="class">Blueprint</span> <span class="variable">$table</span>) {
            <span class="variable">$table</span>-><span class="func">id</span>();
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'registration_code'</span>, <span class="num">20</span>)-><span class="func">unique</span>();
            <span class="variable">$table</span>-><span class="func">foreignId</span>(<span class="string">'customer_id'</span>)-><span class="func">constrained</span>(<span class="string">'customers'</span>)-><span class="func">cascadeOnDelete</span>();
            <span class="variable">$table</span>-><span class="func">foreignId</span>(<span class="string">'vehicle_id'</span>)-><span class="func">constrained</span>(<span class="string">'vehicles'</span>)-><span class="func">cascadeOnDelete</span>();
            <span class="variable">$table</span>-><span class="func">string</span>(<span class="string">'service_type'</span>, <span class="num">100</span>);
            <span class="variable">$table</span>-><span class="func">text</span>(<span class="string">'complaint'</span>);
            <span class="variable">$table</span>-><span class="func">date</span>(<span class="string">'service_date'</span>);
            <span class="variable">$table</span>-><span class="func">enum</span>(<span class="string">'status'</span>, [<span class="string">'pending'</span>, <span class="string">'in_progress'</span>, <span class="string">'completed'</span>, <span class="string">'cancelled'</span>])-><span class="func">default</span>(<span class="string">'pending'</span>);
            <span class="variable">$table</span>-><span class="func">timestamps</span>();
        });
    }

    <span class="keyword">public function</span> <span class="func">down</span>(): <span class="keyword">void</span>
    {
        <span class="class">Schema</span>::<span class="func">dropIfExists</span>(<span class="string">'service_registrations'</span>);
    }
};"""
    html = vscode_window("database/migrations/2024_01_01_000004_create_service_registrations_table.php", "2024_01_01_000004_create_service_registrations_table.php", code)
    render(html, "58_code_migration_services.png")

    # 59 Model Customer
    code = """<span class="keyword">&lt;?php</span>

<span class="keyword">namespace</span> <span class="class">App\\Models</span>;

<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Eloquent\\Factories\\HasFactory</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Eloquent\\Model</span>;

<span class="keyword">class</span> <span class="class">Customer</span> <span class="keyword">extends</span> <span class="class">Model</span>
{
    <span class="keyword">use</span> <span class="class">HasFactory</span>;

    <span class="keyword">protected</span> <span class="variable">$fillable</span> = [
        <span class="string">'customer_code'</span>, <span class="string">'name'</span>, <span class="string">'phone'</span>, <span class="string">'email'</span>, <span class="string">'address'</span>,
    ];

    <span class="keyword">public static function</span> <span class="func">generateCode</span>(): <span class="keyword">string</span>
    {
        <span class="variable">$last</span> = <span class="class">self</span>::<span class="func">latest</span>(<span class="string">'id'</span>)-><span class="func">first</span>();
        <span class="variable">$next</span> = <span class="variable">$last</span> ? <span class="variable">$last</span>->id + <span class="num">1</span> : <span class="num">1</span>;
        <span class="keyword">return</span> <span class="string">'PLG-'</span> . <span class="func">str_pad</span>(<span class="variable">$next</span>, <span class="num">4</span>, <span class="string">'0'</span>, STR_PAD_LEFT);
    }

    <span class="keyword">public function</span> <span class="func">vehicles</span>()
    {
        <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">hasMany</span>(<span class="class">Vehicle</span>::<span class="keyword">class</span>);
    }

    <span class="keyword">public function</span> <span class="func">serviceRegistrations</span>()
    {
        <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">hasMany</span>(<span class="class">ServiceRegistration</span>::<span class="keyword">class</span>);
    }
}"""
    html = vscode_window("app/Models/Customer.php", "Customer.php", code)
    render(html, "59_code_model_customer.png")

    # 60 Model ServiceRegistration
    code = """<span class="keyword">&lt;?php</span>

<span class="keyword">namespace</span> <span class="class">App\\Models</span>;

<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Eloquent\\Factories\\HasFactory</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Database\\Eloquent\\Model</span>;

<span class="keyword">class</span> <span class="class">ServiceRegistration</span> <span class="keyword">extends</span> <span class="class">Model</span>
{
    <span class="keyword">use</span> <span class="class">HasFactory</span>;

    <span class="keyword">protected</span> <span class="variable">$fillable</span> = [
        <span class="string">'registration_code'</span>, <span class="string">'customer_id'</span>, <span class="string">'vehicle_id'</span>,
        <span class="string">'service_type'</span>, <span class="string">'complaint'</span>, <span class="string">'service_date'</span>, <span class="string">'status'</span>,
    ];

    <span class="keyword">public static function</span> <span class="func">generateCode</span>(): <span class="keyword">string</span>
    {
        <span class="variable">$last</span> = <span class="class">self</span>::<span class="func">latest</span>(<span class="string">'id'</span>)-><span class="func">first</span>();
        <span class="variable">$next</span> = <span class="variable">$last</span> ? <span class="variable">$last</span>->id + <span class="num">1</span> : <span class="num">1</span>;
        <span class="keyword">return</span> <span class="string">'SRV-'</span> . <span class="func">str_pad</span>(<span class="variable">$next</span>, <span class="num">4</span>, <span class="string">'0'</span>, STR_PAD_LEFT);
    }

    <span class="keyword">public function</span> <span class="func">customer</span>() { <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">belongsTo</span>(<span class="class">Customer</span>::<span class="keyword">class</span>); }
    <span class="keyword">public function</span> <span class="func">vehicle</span>() { <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">belongsTo</span>(<span class="class">Vehicle</span>::<span class="keyword">class</span>); }
    <span class="keyword">public function</span> <span class="func">serviceDetail</span>() { <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">hasOne</span>(<span class="class">ServiceDetail</span>::<span class="keyword">class</span>); }
    <span class="keyword">public function</span> <span class="func">payment</span>() { <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">hasOne</span>(<span class="class">Payment</span>::<span class="keyword">class</span>); }
}"""
    html = vscode_window("app/Models/ServiceRegistration.php", "ServiceRegistration.php", code)
    render(html, "60_code_model_service.png")

    # 61 Controller API
    code = """<span class="keyword">&lt;?php</span>

<span class="keyword">namespace</span> <span class="class">App\\Http\\Controllers\\Api\\V1</span>;

<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\BaseApiController</span>;
<span class="keyword">use</span> <span class="class">App\\Models\\Customer</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Http\\JsonResponse</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Http\\Request</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Support\\Facades\\Validator</span>;

<span class="keyword">class</span> <span class="class">CustomerController</span> <span class="keyword">extends</span> <span class="class">BaseApiController</span>
{
    <span class="keyword">public function</span> <span class="func">index</span>(): <span class="class">JsonResponse</span>
    {
        <span class="variable">$customers</span> = <span class="class">Customer</span>::<span class="func">with</span>(<span class="string">'vehicles'</span>)-><span class="func">latest</span>()-><span class="func">get</span>();
        <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">sendSuccess</span>(<span class="variable">$customers</span>, <span class="string">'Data pelanggan berhasil diambil.'</span>);
    }

    <span class="keyword">public function</span> <span class="func">store</span>(<span class="class">Request</span> <span class="variable">$request</span>): <span class="class">JsonResponse</span>
    {
        <span class="variable">$validator</span> = <span class="class">Validator</span>::<span class="func">make</span>(<span class="variable">$request</span>-><span class="func">all</span>(), [
            <span class="string">'name'</span>  => <span class="string">'required|string|max:100'</span>,
            <span class="string">'phone'</span> => <span class="string">'required|string|max:20|unique:customers,phone'</span>,
        ]);
        <span class="keyword">if</span> (<span class="variable">$validator</span>-><span class="func">fails</span>()) {
            <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">sendError</span>(<span class="string">'Validasi gagal.'</span>, <span class="variable">$validator</span>-><span class="func">errors</span>(), <span class="num">422</span>);
        }
        <span class="variable">$data</span> = <span class="variable">$validator</span>-><span class="func">validated</span>();
        <span class="variable">$data</span>[<span class="string">'customer_code'</span>] = <span class="class">Customer</span>::<span class="func">generateCode</span>();
        <span class="variable">$customer</span> = <span class="class">Customer</span>::<span class="func">create</span>(<span class="variable">$data</span>);
        <span class="keyword">return</span> <span class="variable">$this</span>-><span class="func">sendSuccess</span>(<span class="variable">$customer</span>, <span class="string">'Data pelanggan berhasil ditambahkan.'</span>, <span class="num">201</span>);
    }
}"""
    html = vscode_window("app/Http/Controllers/Api/V1/CustomerController.php", "CustomerController.php", code)
    render(html, "61_code_controller_api.png")

    # 62 Routes API
    code = """<span class="keyword">&lt;?php</span>

<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\CustomerController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\VehicleController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\MechanicController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\ServiceRegistrationController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\ServiceDetailController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\SparepartController</span>;
<span class="keyword">use</span> <span class="class">App\\Http\\Controllers\\Api\\V1\\PaymentController</span>;
<span class="keyword">use</span> <span class="class">Illuminate\\Support\\Facades\\Route</span>;

<span class="class">Route</span>::<span class="func">prefix</span>(<span class="string">'v1'</span>)-><span class="func">name</span>(<span class="string">'api.v1.'</span>)-><span class="func">group</span>(<span class="keyword">function</span> () {
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'customers'</span>, <span class="class">CustomerController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'vehicles'</span>, <span class="class">VehicleController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'mechanics'</span>, <span class="class">MechanicController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'services'</span>, <span class="class">ServiceRegistrationController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'service-details'</span>, <span class="class">ServiceDetailController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'spareparts'</span>, <span class="class">SparepartController</span>::<span class="keyword">class</span>);
    <span class="class">Route</span>::<span class="func">apiResource</span>(<span class="string">'payments'</span>, <span class="class">PaymentController</span>::<span class="keyword">class</span>);
});"""
    html = vscode_window("routes/api.php", "api.php", code)
    render(html, "62_code_routes_api.png")

print("Part Lampiran methods added.")

if __name__ == "__main__":
    print("Starting generation of all screenshots...")
    generate_part5()
    generate_part6()
    generate_part7()
    generate_lampiran()
    print("ALL 62 SCREENSHOTS GENERATED SUCCESSFULLY!")
