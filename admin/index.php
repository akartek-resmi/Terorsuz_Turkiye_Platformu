<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require_login();

$pdo = db();

$cards = [

    [
        'label' => 'Yönetim Kurulu',
        'count' => $pdo->query('SELECT COUNT(*) FROM board_members')->fetchColumn(),
        'unit'  => 'üye',
        'where' => 'Anasayfa → “Yönetim Kurulu” bölümü',
        'href'  => '/admin/board.php',
    ],
    [
        'label' => 'İl Başkanlıkları',
        'count' => $pdo->query('SELECT COUNT(*) FROM representatives')->fetchColumn(),
        'unit'  => 'il',
        'where' => 'Anasayfa → Türkiye haritasında kırmızı iller',
        'href'  => '/admin/representatives.php',
    ],
    [
        'label' => 'Bölge Sorumluları',
        'count' => $pdo->query('SELECT COUNT(*) FROM region_coordinators')->fetchColumn(),
        'unit'  => 'kişi',
        'where' => 'Anasayfa → haritanın altı',
        'href'  => '/admin/region-coordinators.php',
    ],
    [
        'label' => 'Haberler',
        'count' => $pdo->query('SELECT COUNT(*) FROM news')->fetchColumn(),
        'unit'  => 'haber',
        'where' => 'Anasayfa → “Haberler” + /haberler sayfası',
        'href'  => '/admin/news.php',
    ],
    [
        'label' => 'Instagram Gönderisi',
        'count' => $pdo->query('SELECT COUNT(*) FROM instagram_posts')->fetchColumn(),
        'unit'  => 'gönderi',
        'where' => 'Anasayfa → Instagram ızgarası (20 gönderi gösterilir)',
        'href'  => '/admin/instagram.php',
    ],
];

$pageTitle = 'Panel';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>Hoş geldiniz, <?= htmlspecialchars($_SESSION['admin_username']) ?></h2>
<p class="ttpa-hint">
  Aşağıdaki kutular sitede şu an yayında olan içeriği gösterir. Düzenlemek için kutuya ya da soldaki menüye tıklayın.
  <strong>Teşkilat</strong> bölümündeki her kayıt, kaydettiğiniz anda anasayfadaki haritaya otomatik yansır.
</p>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px;">
  <?php foreach ($cards as $c): ?>
    <a href="<?= $c['href'] ?>" class="ttpa-card"
       style="display:block;text-decoration:none;color:inherit;margin:0;transition:border-color .15s ease;"
       onmouseover="this.style.borderColor='#A81C1C'" onmouseout="this.style.borderColor='#E2E8F0'">
      <div style="font-size:26px;font-weight:800;line-height:1;"><?= (int)$c['count'] ?>
        <span style="font-size:13px;font-weight:600;color:#64748B;"><?= htmlspecialchars($c['unit']) ?></span>
      </div>
      <div style="font-size:14.5px;font-weight:700;margin-top:6px;"><?= htmlspecialchars($c['label']) ?></div>
      <div style="font-size:12px;color:#94A3B8;margin-top:4px;line-height:1.45;"><?= htmlspecialchars($c['where']) ?></div>
    </a>
  <?php endforeach; ?>
</div>

<div class="ttpa-card" style="margin-top:22px;">
  <h3>Hangi sayfa neyi düzenler?</h3>
  <table class="ttpa-table">
    <tr><td style="width:200px;"><strong>Yönetim Kurulu</strong></td><td>Anasayfadaki kurul kartları.</td></tr>
    <tr><td><strong>İl Başkanlıkları</strong></td><td>Haritadaki iller. Bir ile tıklayıp o ilin başkanını ve <em>altındaki teşkilat ağacını</em> düzenlersiniz.</td></tr>
    <tr><td><strong>Bölge Sorumluları</strong></td><td>Belirli bir ile bağlı olmayan, harita altındaki sorumlular.</td></tr>
    <tr><td><strong>Haberler</strong></td><td>Haber listesi ve haber detay sayfaları.</td></tr>
    <tr><td><strong>Sayfa Metinleri &amp; Kapak</strong></td><td>Kurucu mesajı, Hakkımızda, Vizyon, Misyon, Tüzük metinleri; belgeler; anasayfa kapak görselleri.</td></tr>
    <tr><td><strong>Instagram Akışı</strong></td><td>Anasayfadaki Instagram ızgarası; gönderileri günceller.</td></tr>
    <tr><td><strong>İletişim / Sosyal Medya</strong></td><td>Header ve footer’daki telefon, e-posta, adres ve sosyal medya bağlantıları.</td></tr>
  </table>
</div>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
