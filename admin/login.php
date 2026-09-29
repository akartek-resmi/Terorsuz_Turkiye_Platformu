<?php
require __DIR__ . '/includes/auth.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: /admin/index.php');
    exit;
}

$error = '';
$notice = isset($_GET['expired']) ? 'Oturum süresi doldu, lütfen tekrar giriş yapın.' : '';
$lockLeft = login_lock_seconds_left();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    if ($lockLeft > 0) {
        $error = 'Çok fazla hatalı deneme. ' . ceil($lockLeft / 60) . ' dakika sonra tekrar deneyin.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if (attempt_login($username, $password)) {
            header('Location: /admin/index.php');
            exit;
        }
        $error = 'Kullanıcı adı veya şifre hatalı.';
        $lockLeft = login_lock_seconds_left();
        if ($lockLeft > 0) {
            $error = 'Çok fazla hatalı deneme. Hesap ' . ceil($lockLeft / 60) . ' dakika kilitlendi.';
        }
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<meta name="referrer" content="same-origin">
<title>Giriş — TTP Admin</title>
<style>
  body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; background:#151B2B; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif; }
  .box { background:#fff; border-radius:8px; padding:32px 30px; width:100%; max-width:340px; }
  .box h1 { font-size:18px; margin:0 0 20px 0; color:#0F172A; }
  .box label { display:block; font-size:12.5px; font-weight:700; color:#64748B; margin:14px 0 5px 0; text-transform:uppercase; }
  .box input { width:100%; padding:10px 12px; border:1px solid #E2E8F0; border-radius:4px; font-size:14px; box-sizing:border-box; }
  .box button { width:100%; margin-top:20px; padding:11px; background:#A81C1C; color:#fff; border:none; border-radius:4px; font-weight:700; cursor:pointer; }
  .box button:hover { background:#881313; }
  .err { background:#FEF2F2; color:#991B1B; border:1px solid #FECACA; padding:10px 12px; border-radius:4px; font-size:13px; margin-top:14px; }
  .notice { background:#EFF6FF; color:#1E40AF; border:1px solid #BFDBFE; padding:10px 12px; border-radius:4px; font-size:13px; margin-top:14px; }
</style>
</head>
<body>
  <form class="box" method="post">
    <h1>Terörsüz Türkiye Platformu — Yönetim Paneli</h1>
    <?php echo csrf_field(); ?>
    <label>Kullanıcı Adı</label>
    <input type="text" name="username" autocomplete="username" maxlength="100" autofocus required>
    <label>Şifre</label>
    <input type="password" name="password" autocomplete="current-password" required>
    <?php if ($notice): ?><div class="notice"><?= htmlspecialchars($notice) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="err"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <button type="submit">Giriş Yap</button>
  </form>
</body>
</html>
