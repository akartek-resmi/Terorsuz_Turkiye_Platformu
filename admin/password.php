<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require_login();

const TTP_MIN_PASSWORD_LEN = 12;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $current = (string)($_POST['current_password'] ?? '');
    $new     = (string)($_POST['new_password'] ?? '');
    $repeat  = (string)($_POST['new_password_repeat'] ?? '');

    $stmt = db()->prepare('SELECT password_hash FROM admin_users WHERE id = ?');
    $stmt->execute([$_SESSION['admin_id']]);
    $hash = (string)$stmt->fetchColumn();

    if (!$hash || !password_verify($current, $hash)) {
        set_flash('err', 'Mevcut şifre hatalı.');
    } elseif (mb_strlen($new) < TTP_MIN_PASSWORD_LEN) {
        set_flash('err', 'Yeni şifre en az ' . TTP_MIN_PASSWORD_LEN . ' karakter olmalı.');
    } elseif ($new !== $repeat) {
        set_flash('err', 'Yeni şifre tekrarı eşleşmiyor.');
    } elseif (hash_equals($current, $new)) {
        set_flash('err', 'Yeni şifre mevcut şifreyle aynı olamaz.');
    } else {
        db()->prepare('UPDATE admin_users SET password_hash = ? WHERE id = ?')
            ->execute([password_hash($new, PASSWORD_DEFAULT), $_SESSION['admin_id']]);
        session_regenerate_id(true);
        $_SESSION['login_time'] = time();
        set_flash('ok', 'Şifre güncellendi.');
    }
    header('Location: /admin/password.php');
    exit;
}

$pageTitle = 'Şifre Değiştir';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>Şifre Değiştir</h2>
<?php render_flash(); ?>
<div class="ttpa-card">
  <form class="ttpa-form" method="post" autocomplete="off">
    <?= csrf_field() ?>
    <label>Mevcut Şifre</label>
    <input type="password" name="current_password" autocomplete="current-password" required>
    <label>Yeni Şifre</label>
    <input type="password" name="new_password" autocomplete="new-password" minlength="<?= TTP_MIN_PASSWORD_LEN ?>" required>
    <label>Yeni Şifre (Tekrar)</label>
    <input type="password" name="new_password_repeat" autocomplete="new-password" minlength="<?= TTP_MIN_PASSWORD_LEN ?>" required>
    <p style="font-size:12.5px; color:var(--muted); margin:12px 0 0 0;">
      En az <?= TTP_MIN_PASSWORD_LEN ?> karakter. Büyük/küçük harf, rakam ve sembol karıştırın;
      başka bir sitede kullandığınız şifreyi tekrar kullanmayın.
    </p>
    <div class="ttpa-actions"><button type="submit" class="btn">Şifreyi Güncelle</button></div>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
