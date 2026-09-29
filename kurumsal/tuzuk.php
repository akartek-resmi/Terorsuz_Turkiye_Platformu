<?php
require __DIR__ . "/../includes/bootstrap.php";

$ttpPageTitle = "Tüzüğümüz";
$ttpTitle = "Tüzüğümüz — Terörsüz Türkiye Platformu";
$ttpHeaderStyle = "solid";

require __DIR__ . "/../includes/head.php";
require __DIR__ . "/../includes/header.php";
?>

  <style>
    .ttp-header-unified-wrapper { border-bottom: 3px solid #A81C1C !important; }
    .ttp-page-header { background: transparent; padding: 0; }
    .ttp-page-header-inner { padding: 0 0 10px 7px; } 
    .ttp-page-title { font-size: 34px; font-weight: 800; color: #FFFFFF; margin: 0; letter-spacing: -0.01em; line-height: 1.15; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .ttp-page-date { display: inline-block; font-size: 13px; color: #D4AF37; font-weight: 700; margin: 12px 0 0 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    @media (max-width: 1024px) {
      .ttp-page-header-inner { padding: 2px 0 8px 0; }
      .ttp-page-title { font-size: 26px; }
    }
    @media (max-width: 480px) {
      .ttp-page-title { font-size: 22px; }
    }
    .ttp-page-back { display: flex; width: fit-content; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; color: #94A3B8; text-decoration: none; margin: 0 0 18px 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .ttp-page-back:hover { color: #FFFFFF; }
    .ttp-article-band { background: #FFFFFF; padding: 30px 0 4px 0; }
    .ttp-article-band-inner { max-width: 900px; margin: 0 auto; padding: 0 15px; }
    .ttp-article-back { display: inline-block; font-size: 13px; font-weight: 700; color: #64748B; text-decoration: none; margin: 0 0 16px 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .ttp-article-back:hover { color: #A81C1C; }
    .ttp-article-title { font-size: 30px; font-weight: 800; color: #0F172A; margin: 0; line-height: 1.25; letter-spacing: -0.01em; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .ttp-article-date { display: inline-block; font-size: 13px; font-weight: 700; color: #E30A17; margin-top: 12px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .ttp-article-band + .haber-wrap { padding-top: 20px; }
    @media (max-width: 767px) {
      .ttp-article-band { padding: 22px 0 2px 0; }
      .ttp-article-title { font-size: 23px; }
    }
    .haber-wrap { max-width: 900px; margin: 0 auto; padding: 44px 15px 70px 15px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .haber-search-form { display: flex; gap: 0; margin-bottom: 34px; max-width: 480px; border: 1px solid #E2E8F0; }
    .haber-search-form input { flex: 1; padding: 13px 16px; border: none; font-size: 14px; font-family: inherit; }
    .haber-search-form input:focus { outline: none; }
    .haber-search-form button { background: #A81C1C; color: #fff; border: none; padding: 0 24px; font-weight: 700; font-size: 13px; letter-spacing: .04em; text-transform: uppercase; cursor: pointer; transition: background .15s ease; }
    .haber-search-form button:hover { background: #881313; }
    .haber-card { display: block; background: #FFFFFF; border: 1px solid #E8EDF2; border-top: 3px solid #A81C1C; margin-bottom: 26px; text-decoration: none; color: inherit; box-shadow: 0 1px 2px rgba(15,23,42,.04); transition: box-shadow .2s ease, transform .2s ease; }
    .haber-card:hover { box-shadow: 0 14px 34px rgba(15,23,42,.12); transform: translateY(-4px); }
    .haber-card img { width: 100%; height: 280px; object-fit: cover; display: block; background: #F1F5F9; }
    .haber-card-body { padding: 24px 26px; }
    .haber-card-tag { display: inline-block; font-size: 10.5px; font-weight: 800; letter-spacing: .07em; text-transform: uppercase; color: #E30A17; margin: 0 0 10px 0; }
    .haber-card-title { font-size: 21px; font-weight: 800; color: #0F172A; margin: 0 0 12px 0; line-height: 1.35; }
    .haber-card:hover .haber-card-title { color: #A81C1C; }
    .haber-card-excerpt { font-size: 14.5px; color: #64748B; line-height: 1.65; margin: 0 0 14px 0; }
    .haber-card-cta { font-size: 12.5px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: #0F172A; }
    .haber-card:hover .haber-card-cta { color: #A81C1C; }
    .haber-article-body { font-size: 16px; color: #334155; line-height: 1.85; }
    .haber-article-body p { margin: 0 0 20px 0; }
    .haber-article-body img { max-width: 100%; height: auto; }
    .haber-empty { color: #94A3B8; font-size: 14.5px; background: #FAFBFC; border: 1px dashed #E2E8F0; padding: 28px; text-align: center; }
    .doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
    .doc-card { background: #FFFFFF; border: 1px solid #E8EDF2; border-top: 3px solid #D4AF37; padding: 22px 20px; text-align: center; transition: box-shadow .2s ease, transform .2s ease; }
    .doc-card:hover { box-shadow: 0 12px 28px rgba(15,23,42,.10); transform: translateY(-3px); }
    .doc-card-title { font-size: 14.5px; font-weight: 700; color: #0F172A; margin: 0 0 14px 0; line-height: 1.4; }
    .doc-card a { display: inline-block; font-size: 12px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: #A81C1C; text-decoration: none; border-bottom: 2px solid #A81C1C; padding-bottom: 2px; }
    .contact-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
    .contact-info-card { background: #FFFFFF; border: 1px solid #E8EDF2; border-top: 3px solid #A81C1C; padding: 26px 22px; text-align: center; transition: box-shadow .2s ease, transform .2s ease; }
    .contact-info-card:hover { box-shadow: 0 14px 30px rgba(15,23,42,.10); transform: translateY(-3px); }
    .ci-label { display: block; font-size: 11px; font-weight: 800; color: #94A3B8; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 10px; }
    .ci-value { font-size: 16px; font-weight: 700; color: #0F172A; text-decoration: none; word-break: break-word; }
    a.ci-value:hover { color: #A81C1C; }
  </style>
    <main id="content" class="site-main">
      <div class="haber-wrap">
        <?php $t = get_setting('tuzuk'); ?>
        <div class="haber-article-body"><?php if ($t): echo $t; else: ?><p class="haber-empty">İçerik yakında eklenecektir.</p><?php endif; ?></div>
      </div>
    </main>

<?php
require __DIR__ . "/../includes/footer.php";
require __DIR__ . "/../includes/scripts.php";
