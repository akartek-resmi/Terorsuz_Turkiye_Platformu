<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require __DIR__ . '/includes/editor.php';
require_login();
$pdo = db();

$textFields = [
    'founder_message' => ['Kurucu Genel Başkan Mesajı', 'Anasayfada başkanın fotoğrafının yanındaki metin.', 'founder'],
    'hakkimizda' => ['Hakkımızda', '/kurumsal/hakkimizda.php sayfasının içeriği.', 'page'],
    'vizyon' => ['Vizyonumuz', 'Anasayfa → “Misyon ve Vizyonumuz” bölümündeki Vizyon kartı.', 'mv'],
    'misyon' => ['Misyonumuz', 'Anasayfa → “Misyon ve Vizyonumuz” bölümündeki Misyon kartı.', 'mv'],
    'temel_degerler' => ['Temel Değerlerimiz', 'Anasayfa → Misyon/Vizyon’un altındaki numaralı kartlar. <strong>Her satır bir madde olur</strong>; satır silerseniz kart da kalkar, hepsini silerseniz bölüm sitede hiç görünmez.', null],
    'tuzuk' => ['Tüzüğümüz', '/kurumsal/tuzuk.php sayfasının içeriği.', 'page'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_texts'])) {
    csrf_verify();
    foreach ($textFields as $key => $meta) {
        $raw = (string)($_POST[$key] ?? '');
        set_setting($key, isset($meta[2]) && $meta[2] !== null ? ttp_sanitize_html($raw) : $raw);
    }
    set_flash('ok', 'Site bilgileri güncellendi.');
    header('Location: /admin/site-settings.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_hero'])) {
    csrf_verify();
    foreach (['hero_image_desktop', 'hero_image_mobile'] as $key) {
        if (!empty($_POST['clear_' . $key])) {
            set_setting($key, '');
            continue;
        }
        $uploaded = handle_upload($key);
        if ($uploaded) {
            set_setting($key, $uploaded);
        }
    }
    set_flash('ok', 'Kapak görselleri güncellendi.');
    header('Location: /admin/site-settings.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_doc_id'])) {
    csrf_verify();
    $pdo->prepare('DELETE FROM documents WHERE id = ?')->execute([(int)$_POST['delete_doc_id']]);
    set_flash('ok', 'Belge silindi.');
    header('Location: /admin/site-settings.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_doc'])) {
    csrf_verify();
    $title = trim($_POST['doc_title'] ?? '');
    $file = handle_upload('doc_file', ['pdf', 'jpg', 'jpeg', 'png', 'webp']);
    if ($title === '' || !$file) {
        set_flash('err', 'Belge başlığı ve dosyası zorunludur.');
    } else {
        $pdo->prepare('INSERT INTO documents (title, file, sort_order) VALUES (?,?,0)')->execute([$title, $file]);
        set_flash('ok', 'Belge eklendi.');
    }
    header('Location: /admin/site-settings.php');
    exit;
}

$documents = $pdo->query('SELECT * FROM documents ORDER BY sort_order, id')->fetchAll();

$pageTitle = 'Site Bilgileri';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>Site Bilgileri</h2>
<?php render_flash(); ?>

<div class="ttpa-card">
  <form class="ttpa-form" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="save_texts" value="1">
    <?php foreach ($textFields as $key => $meta):
            [$label, $hint] = $meta;
            $preview = $meta[2] ?? null; ?>
      <label><?= htmlspecialchars($label) ?></label>
      <p class="ttpa-hint" style="margin:0 0 6px 0;font-size:12px;"><?= $hint ?></p>
      <?php if ($preview): ?>
        <?= rich_editor($key, get_setting($key), ['preview' => $preview, 'min_height' => $preview === 'mv' ? 180 : 260]) ?>
      <?php else: ?>
        <textarea name="<?= $key ?>" style="min-height:200px;"><?= htmlspecialchars(get_setting($key)) ?></textarea>
      <?php endif; ?>
    <?php endforeach; ?>
    <div class="ttpa-actions"><button type="submit" class="btn">Kaydet</button></div>
  </form>
</div>

<div class="ttpa-card">
  <h3 style="margin-top:0;">Anasayfa Kapak Görseli</h3>
  <p style="color:#64748B;font-size:13px;margin-top:0;">
    Ziyaretçinin ekranı <strong>yatay</strong>ken (masaüstü, telefon yan çevrilmiş) masaüstü görseli;
    <strong>dikey</strong>ken (telefon/tablet dik) mobil görsel gösterilir.
    Yalnızca birini yüklerseniz her iki durumda da o kullanılır. Boş bırakılırsa mevcut varsayılan kapak kalır.
  </p>
  <form class="ttpa-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="save_hero" value="1">
    <?php foreach ([
      'hero_image_desktop' => ['Masaüstü / Yatay Görsel', 'Geniş (yatay) bir görsel önerilir — ör. 1920x1080'],
      'hero_image_mobile'  => ['Mobil / Dikey Görsel', 'Dikey bir görsel önerilir — ör. 1080x1920'],
    ] as $key => [$label, $hint]):
      $current = get_setting($key); ?>
      <label><?= htmlspecialchars($label) ?></label>
      <?php if ($current !== ''): ?>
        <div style="margin-bottom:8px;">
          <img src="<?= htmlspecialchars(asset_url($current)) ?>" alt=""
               style="max-width:220px;max-height:130px;object-fit:cover;border:1px solid #E2E8F0;display:block;margin-bottom:6px;">
          <label style="font-weight:400;font-size:13px;">
            <input type="checkbox" name="clear_<?= $key ?>" value="1"> Bu görseli kaldır (varsayılana dön)
          </label>
        </div>
      <?php endif; ?>
      <?= file_field($key) ?>
      <small style="color:#94A3B8;display:block;margin-bottom:14px;"><?= htmlspecialchars($hint) ?></small>
    <?php endforeach; ?>
    <div class="ttpa-actions"><button type="submit" class="btn">Kapak Görsellerini Kaydet</button></div>
  </form>
</div>

<div class="ttpa-card">
  <h3 style="margin-top:0;">Belgeler</h3>
  <table class="ttpa-table">
    <tr><th>Başlık</th><th>Dosya</th><th></th></tr>
    <?php foreach ($documents as $d): ?>
      <tr>
        <td><?= htmlspecialchars($d['title']) ?></td>
        <td><a href="/<?= htmlspecialchars($d['file']) ?>" target="_blank">görüntüle</a></td>
        <td>
          <form method="post" style="display:inline" onsubmit="return confirm('Silinsin mi?');">
            <?= csrf_field() ?>
            <input type="hidden" name="delete_doc_id" value="<?= $d['id'] ?>">
            <button type="submit" class="btn small danger">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$documents): ?><tr><td colspan="3" style="color:#94A3B8;">Henüz belge yok.</td></tr><?php endif; ?>
  </table>
  <form class="ttpa-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="add_doc" value="1">
    <label>Belge Başlığı</label>
    <input type="text" name="doc_title" required>
    <label>Dosya (PDF veya görsel)</label>
    <?= file_field('doc_file', '.pdf,image/*', true, 'Belge Seç') ?>
    <div class="ttpa-actions"><button type="submit" class="btn">Belge Ekle</button></div>
  </form>
</div>
<?php rich_editor_assets(); ?>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
