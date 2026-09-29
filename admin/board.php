<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require_login();
$pdo = db();

$editing = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM board_members WHERE id = ?');
    $stmt->execute([(int)$_GET['edit']]);
    $editing = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    if (isset($_POST['delete_id'])) {
        $pdo->prepare('DELETE FROM board_members WHERE id = ?')->execute([(int)$_POST['delete_id']]);
        set_flash('ok', 'Üye silindi.');
        header('Location: /admin/board.php');
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $org = trim($_POST['org'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $id = (int)($_POST['id'] ?? 0);

    if ($name === '' || $title === '') {
        set_flash('err', 'Ad Soyad ve Unvan zorunludur.');
        header('Location: /admin/board.php' . ($id ? "?edit=$id" : ''));
        exit;
    }

    $photo = handle_upload('photo');

    if ($id) {
        if ($photo) {
            $pdo->prepare('UPDATE board_members SET name=?, title=?, org=?, photo=?, sort_order=? WHERE id=?')
                ->execute([$name, $title, $org, $photo, $sortOrder, $id]);
        } else {
            $pdo->prepare('UPDATE board_members SET name=?, title=?, org=?, sort_order=? WHERE id=?')
                ->execute([$name, $title, $org, $sortOrder, $id]);
        }
        set_flash('ok', 'Üye güncellendi.');
    } else {
        $pdo->prepare('INSERT INTO board_members (name, title, org, photo, sort_order) VALUES (?,?,?,?,?)')
            ->execute([$name, $title, $org, $photo ?? '', $sortOrder]);
        set_flash('ok', 'Üye eklendi.');
    }
    header('Location: /admin/board.php');
    exit;
}

$members = $pdo->query('SELECT * FROM board_members ORDER BY sort_order, id')->fetchAll();

$pageTitle = 'Yönetim Kurulu';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>Yönetim Kurulu</h2>
<?php render_flash(); ?>

<div class="ttpa-card">
  <table class="ttpa-table">
    <tr><th></th><th>Ad Soyad</th><th>Unvan</th><th>Birim</th><th>Sıra</th><th></th></tr>
    <?php foreach ($members as $m): ?>
      <tr>
        <td><?php if ($m['photo']): ?><img class="thumb" src="/<?= htmlspecialchars($m['photo']) ?>" alt=""><?php endif; ?></td>
        <td><?= htmlspecialchars($m['name']) ?></td>
        <td><?= htmlspecialchars($m['title']) ?></td>
        <td><?= htmlspecialchars($m['org']) ?></td>
        <td><?= (int)$m['sort_order'] ?></td>
        <td>
          <a class="btn small secondary" href="/admin/board.php?edit=<?= $m['id'] ?>">Düzenle</a>
          <form method="post" style="display:inline" onsubmit="return confirm('Silinsin mi?');">
            <?= csrf_field() ?>
            <input type="hidden" name="delete_id" value="<?= $m['id'] ?>">
            <button type="submit" class="btn small danger">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$members): ?><tr><td colspan="6" style="color:#94A3B8;">Henüz kayıt yok.</td></tr><?php endif; ?>
  </table>
</div>

<div class="ttpa-card">
  <h3 style="margin-top:0;"><?= $editing ? 'Üyeyi Düzenle' : 'Yeni Üye Ekle' ?></h3>
  <form class="ttpa-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if ($editing): ?><input type="hidden" name="id" value="<?= $editing['id'] ?>"><?php endif; ?>
    <label>Ad Soyad</label>
    <input type="text" name="name" value="<?= htmlspecialchars($editing['name'] ?? '') ?>" required>
    <label>Unvan</label>
    <input type="text" name="title" value="<?= htmlspecialchars($editing['title'] ?? '') ?>" required>
    <label>Birim / Açıklama</label>
    <input type="text" name="org" value="<?= htmlspecialchars($editing['org'] ?? '') ?>">
    <label>Sıra (küçük sayı önce gösterilir)</label>
    <input type="number" name="sort_order" value="<?= (int)($editing['sort_order'] ?? 0) ?>">
    <label>Fotoğraf</label>
    <?= file_field('photo') ?>
    <?php if (!empty($editing['photo'])): ?><img class="ttpa-photo-preview" src="/<?= htmlspecialchars($editing['photo']) ?>" alt=""><?php endif; ?>
    <div class="ttpa-actions">
      <button type="submit" class="btn"><?= $editing ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editing): ?><a class="btn secondary" href="/admin/board.php">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
