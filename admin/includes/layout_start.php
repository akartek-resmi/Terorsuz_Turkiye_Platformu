<?php
$ttpaNavGroups = [

    '' => [
        'index.php' => 'Panel',
    ],
    'Teşkilat' => [
        'board.php' => 'Yönetim Kurulu',
        'representatives.php' => 'İl Başkanlıkları',
        'region-coordinators.php' => 'Bölge Sorumluları',
    ],
    'İçerik' => [
        'news.php' => 'Haberler',
        'site-settings.php' => 'Sayfa Metinleri & Kapak',
        'instagram.php' => 'Instagram Akışı',
    ],
    'Ayarlar' => [
        'contact.php' => 'İletişim Bilgileri',
        'social.php' => 'Sosyal Medya',
        'password.php' => 'Şifre Değiştir',
    ],
];
$ttpaNavCurrent = basename($_SERVER['SCRIPT_NAME']);
// İl detay sayfasındayken menüde "İl Başkanlıkları" işaretli kalsın
$ttpaNavActive = $ttpaNavCurrent === 'province.php' ? 'representatives.php' : $ttpaNavCurrent;
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — TTP Admin</title>
<style>
  :root { --red:#A81C1C; --red-dark:#881313; --gold:#D4AF37; --bg:#F4F5F7; --card:#fff; --border:#E2E8F0; --text:#0F172A; --muted:#64748B; }
  * { box-sizing: border-box; }
  body { margin:0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: var(--bg); color: var(--text); }
  .ttpa-shell { display:flex; min-height:100vh; }
  .ttpa-sidebar { width:230px; background:#151B2B; color:#fff; padding:20px 0; flex-shrink:0; }
  .ttpa-sidebar h1 { font-size:14px; padding:0 20px 16px 20px; margin:0 0 8px 0; border-bottom:1px solid rgba(255,255,255,.1); }
  .ttpa-sidebar a { display:block; padding:10px 20px; color:#CBD5E1; text-decoration:none; font-size:13.5px; }
  .ttpa-sidebar a:hover { background:rgba(255,255,255,.06); color:#fff; }
  .ttpa-sidebar a.active { background: var(--red); color:#fff; font-weight:600; }
  .ttpa-sidebar .logout { margin-top:20px; border-top:1px solid rgba(255,255,255,.1); padding-top:14px; }
  .ttpa-main { flex:1; padding: 28px 32px; max-width: 980px; }
  .ttpa-main h2 { margin-top:0; }
  .ttpa-card { background: var(--card); border:1px solid var(--border); border-radius:6px; padding:20px; margin-bottom:20px; }
  table.ttpa-table { width:100%; border-collapse: collapse; font-size: 13.5px; }
  table.ttpa-table th, table.ttpa-table td { text-align:left; padding:9px 10px; border-bottom:1px solid var(--border); vertical-align: middle; }
  table.ttpa-table th { color: var(--muted); font-weight:700; font-size:11.5px; text-transform:uppercase; letter-spacing:.04em; }
  .ttpa-table img.thumb { width:40px; height:40px; object-fit:cover; border-radius:4px; background:#eee; }
  .btn { display:inline-block; padding:8px 16px; background: var(--red); color:#fff; border:none; border-radius:4px; font-size:13px; font-weight:700; text-decoration:none; cursor:pointer; }
  .btn:hover { background: var(--red-dark); }
  .btn.secondary { background:#fff; color:var(--text); border:1px solid var(--border); }
  .btn.danger { background:#fff; color:var(--red); border:1px solid var(--red); }
  .btn.small { padding:5px 10px; font-size:12px; }
  form.ttpa-form label { display:block; font-size:12.5px; font-weight:700; color:var(--muted); margin: 14px 0 5px 0; text-transform:uppercase; letter-spacing:.03em; }
  form.ttpa-form input[type=text], form.ttpa-form input[type=email], form.ttpa-form input[type=tel],
  form.ttpa-form input[type=date], form.ttpa-form input[type=url], form.ttpa-form input[type=number],
  form.ttpa-form input[type=password], form.ttpa-form textarea, form.ttpa-form select {
    width:100%; padding:9px 11px; border:1px solid var(--border); border-radius:4px; font-size:14px; font-family:inherit;
  }
  form.ttpa-form textarea { min-height:140px; resize:vertical; }
  .ttpa-flash { padding:10px 14px; border-radius:4px; margin-bottom:16px; font-size:13.5px; }
  .ttpa-flash.ok { background:#ECFDF5; color:#065F46; border:1px solid #A7F3D0; }
  .ttpa-flash.err { background:#FEF2F2; color:#991B1B; border:1px solid #FECACA; }
  .ttpa-actions { margin-top:16px; display:flex; gap:8px; }
  .ttpa-photo-preview { width:60px; height:60px; object-fit:cover; border-radius:6px; border:1px solid var(--border); margin-top:6px; }
  /* --- sadeleştirme yardımcıları --- */
  .ttpa-navgroup { padding:16px 20px 5px 20px; font-size:10.5px; font-weight:800; letter-spacing:.09em; text-transform:uppercase; color:#64748B; }
  .ttpa-page-head { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:6px; }
  .ttpa-page-head h2 { margin:0; }
  .ttpa-hint { color:var(--muted); font-size:13px; line-height:1.55; margin:0 0 20px 0; max-width:70ch; }
  .ttpa-back { display:inline-block; font-size:13px; font-weight:700; color:var(--muted); text-decoration:none; margin-bottom:10px; }
  .ttpa-back:hover { color:var(--red); }
  .ttpa-card h3 { margin:0 0 4px 0; font-size:15.5px; }
  .ttpa-card .ttpa-hint { margin-bottom:14px; }
  .ttpa-empty { color:#94A3B8; font-size:13.5px; padding:14px 0; }
  .ttpa-count { display:inline-block; min-width:20px; padding:1px 7px; border-radius:999px; background:#EEF2F7; color:var(--muted); font-size:12px; font-weight:700; text-align:center; }
  .ttpa-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:0 18px; }
  .ttpa-form-grid .full { grid-column:1 / -1; }
  @media (max-width: 700px) { .ttpa-form-grid { grid-template-columns:1fr; } }
  /* --- Türkçe dosya seçme alanı ---
     Tarayıcının kendi "Choose File / No file chosen" butonu OS diline göre yazılır
     ve CSS ile değiştirilemez; gerçek input gizlenip <label> buton olarak kullanılıyor.
     Script: layout_end.php */
  .ttpa-file { display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:6px; }
  .ttpa-file-input { position:absolute; width:1px; height:1px; padding:0; margin:-1px;
    overflow:hidden; clip:rect(0 0 0 0); white-space:nowrap; border:0; }
  .ttpa-file-btn { display:inline-flex; align-items:center; min-height:38px; padding:0 18px;
    background:#0F172A; color:#fff; border-radius:4px; font-size:13px; font-weight:600;
    cursor:pointer; transition:background .15s ease; }
  .ttpa-file-btn:hover { background:#1E293B; }
  .ttpa-file-input:focus-visible + .ttpa-file-btn { outline:2px solid var(--red); outline-offset:2px; }
  .ttpa-file-name { color:var(--muted); font-size:13px; word-break:break-all; }
  .ttpa-file-name.has-file { color:var(--text); font-weight:600; }

</style>
</head>
<body>
<div class="ttpa-shell">
  <nav class="ttpa-sidebar">
    <h1>TTP Admin</h1>
    <?php foreach ($ttpaNavGroups as $ttpaNavGroupLabel => $ttpaNavLinks): ?>
      <?php if ($ttpaNavGroupLabel !== ''): ?><div class="ttpa-navgroup"><?= htmlspecialchars($ttpaNavGroupLabel) ?></div><?php endif; ?>
      <?php foreach ($ttpaNavLinks as $ttpaNavFile => $ttpaNavLabel): ?>
        <a href="/admin/<?= $ttpaNavFile ?>" class="<?= $ttpaNavActive === $ttpaNavFile ? 'active' : '' ?>"><?= htmlspecialchars($ttpaNavLabel) ?></a>
      <?php endforeach; ?>
    <?php endforeach; ?>
    <div class="logout"><a href="/admin/logout.php">Çıkış Yap</a></div>
  </nav>
  <main class="ttpa-main">
