<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require __DIR__ . '/includes/map_generator.php';
require_login();
$pdo = db();
$provinces = require __DIR__ . '/includes/provinces.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_plate'])) {
    csrf_verify();
    $pdo->prepare('DELETE FROM representatives WHERE plate = ?')->execute([$_POST['delete_plate']]);
    regenerate_turkey_map_data();
    set_flash('ok', 'İl başkanlığı ve altındaki teşkilat silindi, harita güncellendi.');
    header('Location: /admin/representatives.php');
    exit;
}

$reps = $pdo->query('SELECT * FROM representatives ORDER BY sort_order, plate')->fetchAll();
$memberCounts = [];
foreach ($pdo->query('SELECT plate, COUNT(*) AS c FROM representative_members GROUP BY plate') as $row) {
    $memberCounts[$row['plate']] = (int)$row['c'];
}

$pageTitle = 'İl Başkanlıkları';
require __DIR__ . '/includes/layout_start.php';
?>
<div class="ttpa-page-head">
  <h2>İl Başkanlıkları</h2>
  <a class="btn" href="/admin/province.php?new=1">+ Yeni İl Ekle</a>
</div>
<p class="ttpa-hint">
  Buradaki iller anasayfadaki Türkiye haritasında <strong>kırmızı</strong> görünür; ziyaretçi ile tıkladığında
  o ilin başkanı ve altındaki teşkilat açılır. Bir ilin başkanını ya da teşkilatını düzenlemek için
  satırdaki <strong>Düzenle</strong>'ye basın.
</p>
<?php render_flash(); ?>

<div class="ttpa-card">
  <table class="ttpa-table">
    <tr>
      <th></th><th>İl</th><th>İl Başkanı</th><th>Teşkilat</th><th style="width:150px;"></th>
    </tr>
    <?php foreach ($reps as $r): $p = $provinces[$r['plate']]; $mc = $memberCounts[$r['plate']] ?? 0; ?>
      <tr>
        <td><?php if ($r['photo']): ?><img class="thumb" src="/<?= htmlspecialchars($r['photo']) ?>" alt=""><?php endif; ?></td>
        <td>
          <strong><?= htmlspecialchars($p['name']) ?></strong>
          <span style="color:#94A3B8;">(<?= htmlspecialchars($r['plate']) ?>)</span>
        </td>
        <td>
          <?= htmlspecialchars($r['name']) ?><br>
          <span style="color:#94A3B8;font-size:12px;"><?= htmlspecialchars($r['title']) ?></span>
        </td>
        <td>
          <span class="ttpa-count"><?= $mc ?></span>
          <span style="color:#94A3B8;font-size:12px;">kişi</span>
        </td>
        <td>
          <a class="btn small" href="/admin/province.php?plate=<?= $r['plate'] ?>">Düzenle</a>
          <form method="post" style="display:inline"
                onsubmit="return confirm('<?= htmlspecialchars($p['name']) ?> başkanlığı ve altındaki <?= $mc ?> kişi silinecek. Emin misiniz?');">
            <?= csrf_field() ?>
            <input type="hidden" name="delete_plate" value="<?= $r['plate'] ?>">
            <button type="submit" class="btn small danger">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$reps): ?>
      <tr><td colspan="5" class="ttpa-empty">Henüz il başkanlığı eklenmemiş. Sağ üstteki “Yeni İl Ekle” ile başlayın.</td></tr>
    <?php endif; ?>
  </table>
</div>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
