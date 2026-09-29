<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require_login();

$fields = [
    'contact_phone' => 'Telefon',
    'contact_whatsapp' => 'WhatsApp Numarası',
    'contact_email' => 'E-posta',
    'contact_address' => 'Adres',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    foreach ($fields as $key => $label) {
        set_setting($key, trim($_POST[$key] ?? ''));
    }
    set_flash('ok', 'İletişim bilgileri güncellendi.');
    header('Location: /admin/contact.php');
    exit;
}

$pageTitle = 'İletişim';
require __DIR__ . '/includes/layout_start.php';
?>
<h2>İletişim Bilgileri</h2>
<?php render_flash(); ?>
<div class="ttpa-card">
  <form class="ttpa-form" method="post">
    <?= csrf_field() ?>
    <label>Telefon</label>
    <input type="text" name="contact_phone" value="<?= htmlspecialchars(get_setting('contact_phone')) ?>" placeholder="0212 000 00 00">
    <label>WhatsApp Numarası</label>
    <input type="text" name="contact_whatsapp" value="<?= htmlspecialchars(get_setting('contact_whatsapp')) ?>" placeholder="90555 000 00 00 (başında + olmadan)">
    <label>E-posta</label>
    <input type="email" name="contact_email" value="<?= htmlspecialchars(get_setting('contact_email')) ?>">
    <label>Adres</label>
    <textarea name="contact_address"><?= htmlspecialchars(get_setting('contact_address')) ?></textarea>
    <div class="ttpa-actions"><button type="submit" class="btn">Kaydet</button></div>
  </form>
</div>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
