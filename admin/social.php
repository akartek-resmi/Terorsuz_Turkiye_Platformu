<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require_login();

$fields = [
    'social_facebook' => 'Facebook',
    'social_twitter' => 'X (Twitter)',
    'social_instagram' => 'Instagram',
    'social_linkedin' => 'LinkedIn',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    foreach ($fields as $key => $label) {
        set_setting($key, trim($_POST[$key] ?? ''));
    }
    set_flash('ok', 'Sosyal medya bağlantıları güncellendi.');
    header('Location: /admin/social.php');
    exit;
}

$pageTitle = 'Sosyal Medya';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>Sosyal Medya Bağlantıları</h2>
<?php render_flash(); ?>
<div class="ttpa-card">
  <form class="ttpa-form" method="post">
    <?= csrf_field() ?>
    <?php foreach ($fields as $key => $label): ?>
      <label><?= htmlspecialchars($label) ?></label>
      <input type="url" name="<?= $key ?>" value="<?= htmlspecialchars(get_setting($key)) ?>" placeholder="https://...">
    <?php endforeach; ?>
    <div class="ttpa-actions"><button type="submit" class="btn">Kaydet</button></div>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
