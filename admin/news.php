<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require __DIR__ . '/includes/editor.php';
require_login();
$pdo = db();

$editing = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
    $stmt->execute([(int)$_GET['edit']]);
    $editing = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    if (isset($_POST['delete_id'])) {
        $pdo->prepare('DELETE FROM news WHERE id = ?')->execute([(int)$_POST['delete_id']]);
        set_flash('ok', 'Haber silindi.');
        header('Location: /admin/news.php');
        exit;
    }

    $title = trim($_POST['title'] ?? '');
    $body = ttp_sanitize_html((string)($_POST['body_html'] ?? ''));
    $publishedAt = $_POST['published_at'] ?? date('Y-m-d');
    $id = (int)($_POST['id'] ?? 0);
    $slug = trim($_POST['slug'] ?? '');
    if ($slug === '') $slug = slugify($title);
    else $slug = slugify($slug);

    if ($title === '' || $slug === '') {
        set_flash('err', 'Başlık zorunludur.');
        header('Location: /admin/news.php' . ($id ? "?edit=$id" : ''));
        exit;
    }

    $check = $pdo->prepare('SELECT id FROM news WHERE slug = ? AND id != ?');
    $check->execute([$slug, $id]);
    if ($check->fetch()) {
        $slug .= '-' . substr(md5((string)microtime(true)), 0, 5);
    }

    $cover = handle_upload('cover_image');

    if ($id) {
        if ($cover) {
            $pdo->prepare('UPDATE news SET slug=?, title=?, body_html=?, cover_image=?, published_at=? WHERE id=?')
                ->execute([$slug, $title, $body, $cover, $publishedAt, $id]);
        } else {
            $pdo->prepare('UPDATE news SET slug=?, title=?, body_html=?, published_at=? WHERE id=?')
                ->execute([$slug, $title, $body, $publishedAt, $id]);
        }
        set_flash('ok', 'Haber güncellendi.');
    } else {
        $pdo->prepare('INSERT INTO news (slug, title, body_html, cover_image, published_at) VALUES (?,?,?,?,?)')
            ->execute([$slug, $title, $body, $cover ?? '', $publishedAt]);
        set_flash('ok', 'Haber eklendi.');
    }
    header('Location: /admin/news.php');
    exit;
}

$items = $pdo->query('SELECT * FROM news ORDER BY published_at DESC, id DESC')->fetchAll();

$pageTitle = 'Haberler';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>Haberler</h2>
<?php render_flash(); ?>

<div class="ttpa-card">
  <table class="ttpa-table">
    <tr><th></th><th>Başlık</th><th>Tarih</th><th>Slug</th><th></th></tr>
    <?php foreach ($items as $n): ?>
      <tr>
        <td><?php if ($n['cover_image']): ?><img class="thumb" src="/<?= htmlspecialchars($n['cover_image']) ?>" alt=""><?php endif; ?></td>
        <td><?= htmlspecialchars($n['title']) ?></td>
        <td><?= htmlspecialchars($n['published_at']) ?></td>
        <td style="color:#94A3B8;"><?= htmlspecialchars($n['slug']) ?></td>
        <td>
          <a class="btn small secondary" href="/admin/news.php?edit=<?= $n['id'] ?>">Düzenle</a>
          <form method="post" style="display:inline" onsubmit="return confirm('Silinsin mi?');">
            <?= csrf_field() ?>
            <input type="hidden" name="delete_id" value="<?= $n['id'] ?>">
            <button type="submit" class="btn small danger">Sil</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$items): ?><tr><td colspan="5" style="color:#94A3B8;">Henüz haber yok.</td></tr><?php endif; ?>
  </table>
</div>

<div class="ttpa-card">
  <h3 style="margin-top:0;"><?= $editing ? 'Haberi Düzenle' : 'Yeni Haber Ekle' ?></h3>
  <form class="ttpa-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if ($editing): ?><input type="hidden" name="id" value="<?= $editing['id'] ?>"><?php endif; ?>
    <label>Başlık</label>
    <input type="text" name="title" value="<?= htmlspecialchars($editing['title'] ?? '') ?>" required>
    <label>Slug (URL — boş bırakılırsa başlıktan üretilir)</label>
    <input type="text" name="slug" value="<?= htmlspecialchars($editing['slug'] ?? '') ?>" placeholder="ornek-haber-basligi">
    <label>Yayın Tarihi</label>
    <input type="date" name="published_at" value="<?= htmlspecialchars($editing['published_at'] ?? date('Y-m-d')) ?>">
    <label>İçerik</label>
    <p class="ttpa-hint" style="margin:0 0 6px 0;font-size:12px;">Yazıyı doğrudan yazın; HTML bilmeniz gerekmez. Kutu, haberin sitede görüneceği biçimle gösterilir.</p>
    <?= rich_editor('body_html', (string)($editing['body_html'] ?? ''), ['preview' => 'page', 'min_height' => 300]) ?>
    <label>Kapak Görseli</label>
    <?= file_field('cover_image') ?>
    <?php if (!empty($editing['cover_image'])): ?><img class="ttpa-photo-preview" src="/<?= htmlspecialchars($editing['cover_image']) ?>" alt=""><?php endif; ?>
    <div class="ttpa-actions">
      <button type="submit" class="btn"><?= $editing ? 'Güncelle' : 'Ekle' ?></button>
      <?php if ($editing): ?><a class="btn secondary" href="/admin/news.php">Vazgeç</a><?php endif; ?>
    </div>
  </form>
</div>
<?php rich_editor_assets(); ?>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
