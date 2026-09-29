<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require __DIR__ . '/includes/instagram_sync.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = $_POST['action'] ?? '';

    if ($action === 'save_token') {
        set_setting('instagram_access_token', trim($_POST['instagram_access_token'] ?? ''));
        set_flash('ok', 'Erişim anahtarı kaydedildi.');
    } elseif ($action === 'sync') {
        [$ok, $msg] = ttp_ig_sync_auto();
        set_flash($ok ? 'ok' : 'err', $msg);
    } elseif ($action === 'delete') {
        $stmt = db()->prepare('SELECT image FROM instagram_posts WHERE id = ?');
        $stmt->execute([(int)$_POST['id']]);
        if ($row = $stmt->fetch()) {
            $file = dirname(__DIR__) . '/' . $row['image'];
            if (is_file($file)) @unlink($file);
        }
        db()->prepare('DELETE FROM instagram_posts WHERE id = ?')->execute([(int)$_POST['id']]);
        set_flash('ok', 'Gönderi kaldırıldı.');
    } elseif ($action === 'add') {
        $permalink = trim($_POST['permalink'] ?? '');
        $image = handle_upload('image');
        if ($permalink === '' || $image === null) {
            set_flash('err', 'Gönderi bağlantısı ve görsel zorunlu.');
        } else {
            $stmt = db()->prepare('INSERT INTO instagram_posts (ig_id, permalink, image, caption, media_type, posted_at, sort_order) VALUES (NULL,?,?,?,?,NOW(),-1)');
            $stmt->execute([$permalink, $image, trim($_POST['caption'] ?? ''), 'image']);
            set_flash('ok', 'Gönderi eklendi.');
        }
    }
    header('Location: /admin/instagram.php');
    exit;
}

$posts = db()->query('SELECT * FROM instagram_posts ORDER BY sort_order, posted_at DESC, id DESC')->fetchAll();
$token = get_setting('instagram_access_token');
$lastSync = get_setting('instagram_last_sync');

$pageTitle = 'Instagram Akışı';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>Instagram Akışı</h2>
<?php render_flash(); ?>

<div class="ttpa-card">
  <p style="margin-top:0;font-size:13.5px;color:#64748B;line-height:1.6">
    Anasayfadaki &ldquo;Son Gönderiler&rdquo; bölümü buradaki kayıtlardan beslenir.
    Görseller sunucuya indirilerek saklanır — Instagram'ın kendi görsel bağlantıları
    süreli olduğu için doğrudan bağlantı verildiğinde birkaç gün sonra kırılır.
  </p>
  <p style="font-size:13.5px;color:#64748B;margin-bottom:0">
    <strong>Son güncelleme:</strong>
    <?= $lastSync ? htmlspecialchars($lastSync) : 'henüz yapılmadı' ?>
    &nbsp;·&nbsp; <strong>Kayıtlı gönderi:</strong> <?= count($posts) ?>
  </p>
  <form method="post" style="margin-top:16px">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="sync">
    <button type="submit" class="btn">Gönderileri Şimdi Güncelle</button>
  </form>
</div>

<div class="ttpa-card">
  <h3 style="margin-top:0;font-size:15px">Otomatik Güncelleme (Instagram Erişim Anahtarı)</h3>
  <p style="font-size:13px;color:#64748B;line-height:1.6">
    Anahtar girilirse gönderiler doğrudan Instagram'dan çekilir.
    Anahtar boş bırakılırsa, eski WordPress sitesi yayında olduğu sürece
    gönderiler oradan alınır — site kapandığında bu yol çalışmaz, o yüzden
    yayına geçmeden önce anahtarın girilmesi gerekir.<br>
    Anahtar, Instagram hesabının bağlı olduğu Meta/Facebook geliştirici panelinden
    &ldquo;Instagram Basic Display / Graph API&rdquo; uzun ömürlü erişim anahtarı olarak alınır.
  </p>
  <form class="ttpa-form" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="save_token">
    <label>Erişim Anahtarı (Access Token)</label>
    <input type="password" name="instagram_access_token" value="<?= htmlspecialchars($token) ?>" placeholder="IGQVJ..." autocomplete="off" spellcheck="false">
    <div class="ttpa-actions"><button type="submit" class="btn secondary">Anahtarı Kaydet</button></div>
  </form>
</div>

<div class="ttpa-card">
  <h3 style="margin-top:0;font-size:15px">Elle Gönderi Ekle</h3>
  <form class="ttpa-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="add">
    <label>Gönderi Bağlantısı</label>
    <input type="url" name="permalink" placeholder="https://www.instagram.com/p/..." required>
    <label>Görsel</label>
    <?= file_field('image', 'image/*', true) ?>
    <label>Açıklama (isteğe bağlı)</label>
    <input type="text" name="caption">
    <div class="ttpa-actions"><button type="submit" class="btn secondary">Ekle</button></div>
  </form>
</div>

<div class="ttpa-card">
  <h3 style="margin-top:0;font-size:15px">Gönderiler</h3>
  <?php if (!$posts): ?>
    <p style="color:#64748B;font-size:13.5px">Henüz gönderi yok. &ldquo;Gönderileri Şimdi Güncelle&rdquo; ile çekebilirsiniz.</p>
  <?php else: ?>
    <table class="ttpa-table">
      <tr><th>Görsel</th><th>Tür</th><th>Tarih</th><th>Bağlantı</th><th></th></tr>
      <?php foreach ($posts as $p): ?>
        <tr>
          <td><img class="thumb" src="<?= htmlspecialchars(asset_url($p['image'])) ?>" alt=""></td>
          <td><?= htmlspecialchars($p['media_type']) ?></td>
          <td><?= htmlspecialchars($p['posted_at'] ? date('d.m.Y', strtotime($p['posted_at'])) : '-') ?></td>
          <td><a href="<?= htmlspecialchars($p['permalink']) ?>" target="_blank" rel="noopener">Instagram'da aç</a></td>
          <td>
            <form method="post" onsubmit="return confirm('Bu gönderi kaldırılsın mı?')">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
              <button type="submit" class="btn danger small">Sil</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
