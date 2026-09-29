<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require __DIR__ . '/includes/map_generator.php';
require_login();
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    if (isset($_POST['delete_coord_id'])) {
        $pdo->prepare('DELETE FROM region_coordinators WHERE id = ?')->execute([(int)$_POST['delete_coord_id']]);
        regenerate_turkey_map_data();
        set_flash('ok', 'Bölge sorumlusu silindi, site güncellendi.');
        header('Location: /admin/region-coordinators.php');
        exit;
    }

    if (isset($_POST['save_coordinator'])) {
        $title = trim($_POST['coord_title'] ?? '');
        $name = trim($_POST['coord_name'] ?? '');
        $sortOrder = (int)($_POST['coord_sort_order'] ?? 0);
        $coordId = (int)($_POST['coord_id'] ?? 0);

        if ($title === '' || $name === '') {
            set_flash('err', 'Unvan ve Ad Soyad zorunludur.');
            header('Location: /admin/region-coordinators.php' . ($coordId ? "?edit=$coordId" : ''));
            exit;
        }

        $photo = handle_upload('coord_photo');
        $cert = handle_upload('coord_certificate');

        if ($coordId) {
            $existing = $pdo->prepare('SELECT photo, certificate FROM region_coordinators WHERE id=?');
            $existing->execute([$coordId]);
            $existing = $existing->fetch();
            $photo = $photo ?? ($existing['photo'] ?? '');
            $cert = $cert ?? ($existing['certificate'] ?? '');
            $pdo->prepare('UPDATE region_coordinators SET title=?, name=?, photo=?, certificate=?, sort_order=? WHERE id=?')
                ->execute([$title, $name, $photo, $cert, $sortOrder, $coordId]);
            set_flash('ok', 'Bölge sorumlusu güncellendi, site yenilendi.');
        } else {
            $pdo->prepare('INSERT INTO region_coordinators (title, name, photo, certificate, sort_order) VALUES (?,?,?,?,?)')
                ->execute([$title, $name, $photo ?? '', $cert ?? '', $sortOrder]);
            set_flash('ok', 'Bölge sorumlusu eklendi, site yenilendi.');
        }
        regenerate_turkey_map_data();
        header('Location: /admin/region-coordinators.php');
        exit;
    }
}

$coordinators = $pdo->query('SELECT * FROM region_coordinators ORDER BY sort_order, id')->fetchAll();
$editingId = (int)($_GET['edit'] ?? 0);
$editing = null;
foreach ($coordinators as $c) { if ((int)$c['id'] === $editingId) { $editing = $c; break; } }

$pageTitle = 'Bölge Sorumluları';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>Bölge Sorumluları</h2>
<p class="ttpa-hint">
  Anasayfada haritanın <strong>altında</strong>, “Bölge Sorumlularımız” başlığı altında görünürler.
  Belirli bir ile bağlı değildirler (ör. “Doğu ve Güneydoğu Sorumlusu”). Hiç kayıt yoksa o bölüm sitede hiç görünmez.
</p>
<?php render_flash(); ?>

<div class="ttpa-card">
  <table class="ttpa-table">
    <tr><th></th><th>Ad Soyad</th><th>Unvan</th><th>Sıra</th><th style="width:150px;"></th></tr>
    <?php foreach ($coordinators as $c): ?>
      <tr<?= ($editing && (int)$editing['id'] === (int)$c['id']) ? ' style="background:#FFFBEB;"' : '' ?>>
        <td><?php if ($c['photo']): ?><img class="thumb" src="/<?= htmlspecialchars($c['photo']) ?>" alt=""><?php endif; ?></td>
        <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
        <td><?= htmlspecialchars($c['title']) ?></td>
        <td><?= (int)$c['sort_order'] ?></td>
        <td>
          <a class="btn small secondary" href="/admin/region-coordinators.php?edit=<?= $c['id'] ?>">Düzenle</a>
          <form method="post" style="display:inline" onsubmit="return confirm('<?= htmlspecialchars($c['name']) ?> silinsin mi?');">
            <?= csrf_field() ?>
            <input type="hidden" name="delete_coord_id" value="<?= $c['id'] ?>">
            <button type="submit" class="btn small danger">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$coordinators): ?>
      <tr><td colspan="5" class="ttpa-empty">Henüz bölge sorumlusu yok.</td></tr>
    <?php endif; ?>
  </table>
</div>

<div class="ttpa-card">
  <h3><?= $editing ? 'Düzenle: ' . htmlspecialchars($editing['name']) : 'Yeni Bölge Sorumlusu Ekle' ?></h3>
  <form class="ttpa-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="save_coordinator" value="1">
    <?php if ($editing): ?><input type="hidden" name="coord_id" value="<?= $editing['id'] ?>"><?php endif; ?>
    <div class="ttpa-form-grid">
      <div>
        <label>Ad Soyad</label>
        <input type="text" name="coord_name" value="<?= htmlspecialchars($editing['name'] ?? '') ?>" required>
      </div>
      <div>
        <label>Unvan</label>
        <input type="text" name="coord_title" value="<?= htmlspecialchars($editing['title'] ?? 'Bölge Sorumlusu') ?>" required>
      </div>
      <div>
        <label>Fotoğraf</label>
        <?= file_field('coord_photo') ?>
        <?php if (!empty($editing['photo'])): ?><img class="ttpa-photo-preview" src="/<?= htmlspecialchars($editing['photo']) ?>" alt=""><?php endif; ?>
      </div>
      <div>
        <label>Yetki Belgesi</label>
        <?= file_field('coord_certificate') ?>
        <?php if (!empty($editing['certificate'])): ?><img class="ttpa-photo-preview" src="/<?= htmlspecialchars($editing['certificate']) ?>" alt=""><?php endif; ?>
      </div>
      <div>
        <label>Sıra</label>
        <input type="number" name="coord_sort_order" value="<?= (int)($editing['sort_order'] ?? 0) ?>">
      </div>
    </div>
    <div class="ttpa-actions">
      <button type="submit" class="btn"><?= $editing ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editing): ?><a class="btn secondary" href="/admin/region-coordinators.php">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
