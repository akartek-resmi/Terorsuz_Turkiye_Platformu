<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/includes/helpers.php';
require __DIR__ . '/includes/map_generator.php';
require_login();
$pdo = db();
$provinces = require __DIR__ . '/includes/provinces.php';

function ttp_flatten_members(array $rows, ?int $parentId = null, int $depth = 0): array {
    $out = [];
    foreach ($rows as $row) {
        $rowParent = $row['parent_id'] !== null ? (int)$row['parent_id'] : null;
        if ($rowParent !== $parentId) continue;
        $row['_depth'] = $depth;
        $out[] = $row;
        $out = array_merge($out, ttp_flatten_members($rows, (int)$row['id'], $depth + 1));
    }
    return $out;
}

$isNew = !empty($_GET['new']);
$plate = $_GET['plate'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    if (isset($_POST['save_president'])) {
        $postPlate = $_POST['plate'] ?? '';
        $name = trim($_POST['name'] ?? '');
        $title = trim($_POST['title'] ?? '') ?: 'İl Başkanı';
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isEdit = !empty($_POST['is_edit']);

        if (!isset($provinces[$postPlate]) || $name === '') {
            set_flash('err', 'İl ve Ad Soyad zorunludur.');
            header('Location: /admin/province.php?' . ($isEdit ? 'plate=' . urlencode($postPlate) : 'new=1'));
            exit;
        }

        $photo = handle_upload('photo');
        $cert = handle_upload('certificate');

        if ($isEdit) {
            $existing = $pdo->prepare('SELECT photo, certificate FROM representatives WHERE plate=?');
            $existing->execute([$postPlate]);
            $existing = $existing->fetch();
            $photo = $photo ?? ($existing['photo'] ?? '');
            $cert = $cert ?? ($existing['certificate'] ?? '');
            $pdo->prepare('UPDATE representatives SET name=?, title=?, photo=?, certificate=?, sort_order=? WHERE plate=?')
                ->execute([$name, $title, $photo, $cert, $sortOrder, $postPlate]);
            set_flash('ok', 'İl başkanı bilgileri güncellendi, harita yenilendi.');
        } else {
            $dup = $pdo->prepare('SELECT 1 FROM representatives WHERE plate=?');
            $dup->execute([$postPlate]);
            if ($dup->fetchColumn()) {
                set_flash('err', 'Bu ilin başkanlığı zaten var. Listeden “Düzenle” ile açabilirsiniz.');
                header('Location: /admin/representatives.php');
                exit;
            }
            $pdo->prepare('INSERT INTO representatives (plate, name, title, photo, certificate, sort_order) VALUES (?,?,?,?,?,?)')
                ->execute([$postPlate, $name, $title, $photo ?? '', $cert ?? '', $sortOrder]);
            set_flash('ok', 'İl başkanlığı eklendi. Şimdi aşağıdan altına kişi ekleyebilirsiniz.');
        }
        regenerate_turkey_map_data();
        header('Location: /admin/province.php?plate=' . urlencode($postPlate));
        exit;
    }

    if (isset($_POST['delete_member_id'])) {
        $postPlate = $_POST['member_plate'] ?? '';
        $pdo->prepare('DELETE FROM representative_members WHERE id = ?')->execute([(int)$_POST['delete_member_id']]);
        regenerate_turkey_map_data();
        set_flash('ok', 'Kişi (ve varsa altındakiler) silindi, harita güncellendi.');
        header('Location: /admin/province.php?plate=' . urlencode($postPlate));
        exit;
    }

    if (isset($_POST['save_member'])) {
        $postPlate = $_POST['member_plate'] ?? '';
        $name = trim($_POST['member_name'] ?? '');
        $title = trim($_POST['member_title'] ?? '');
        $sortOrder = (int)($_POST['member_sort_order'] ?? 0);
        $memberId = (int)($_POST['member_id'] ?? 0);
        $parentId = (int)($_POST['member_parent_id'] ?? 0) ?: null;

        if (!isset($provinces[$postPlate]) || $name === '') {
            set_flash('err', 'Ad Soyad zorunludur.');
            header('Location: /admin/province.php?plate=' . urlencode($postPlate));
            exit;
        }

        if ($parentId) {
            $chk = $pdo->prepare('SELECT plate FROM representative_members WHERE id = ?');
            $chk->execute([$parentId]);
            if ($chk->fetchColumn() !== $postPlate) {
                $parentId = null;
            }
        }
        if ($memberId && $parentId) {
            $cursor = $parentId; $guard = 0;
            while ($cursor && $guard++ < 50) {
                if ((int)$cursor === $memberId) {
                    set_flash('err', 'Bir kişi kendisinin ya da altındaki birinin altına bağlanamaz.');
                    header('Location: /admin/province.php?plate=' . urlencode($postPlate) . '&edit_member=' . $memberId);
                    exit;
                }
                $up = $pdo->prepare('SELECT parent_id FROM representative_members WHERE id = ?');
                $up->execute([$cursor]);
                $cursor = $up->fetchColumn() ?: null;
            }
        }

        $photo = handle_upload('member_photo');
        $cert = handle_upload('member_certificate');

        if ($memberId) {
            $existing = $pdo->prepare('SELECT photo, certificate FROM representative_members WHERE id = ?');
            $existing->execute([$memberId]);
            $existing = $existing->fetch();
            $photo = $photo ?? ($existing['photo'] ?? '');
            $cert = $cert ?? ($existing['certificate'] ?? '');
            $pdo->prepare('UPDATE representative_members SET parent_id=?, name=?, title=?, photo=?, certificate=?, sort_order=? WHERE id=?')
                ->execute([$parentId, $name, $title, $photo, $cert, $sortOrder, $memberId]);
            set_flash('ok', 'Kişi güncellendi, harita yenilendi.');
        } else {
            $pdo->prepare('INSERT INTO representative_members (plate, parent_id, name, title, photo, certificate, sort_order) VALUES (?,?,?,?,?,?,?)')
                ->execute([$postPlate, $parentId, $name, $title, $photo ?? '', $cert ?? '', $sortOrder]);
            set_flash('ok', 'Kişi eklendi, harita yenilendi.');
        }
        regenerate_turkey_map_data();
        header('Location: /admin/province.php?plate=' . urlencode($postPlate));
        exit;
    }
}

$president = null;
if (!$isNew) {
    if (!isset($provinces[$plate])) {
        set_flash('err', 'İl bulunamadı.');
        header('Location: /admin/representatives.php');
        exit;
    }
    $stmt = $pdo->prepare('SELECT * FROM representatives WHERE plate = ?');
    $stmt->execute([$plate]);
    $president = $stmt->fetch();
    if (!$president) {
        set_flash('err', 'Bu ilin başkanlığı henüz eklenmemiş.');
        header('Location: /admin/representatives.php');
        exit;
    }
}

$members = [];
if ($president) {
    $stmt = $pdo->prepare('SELECT * FROM representative_members WHERE plate = ? ORDER BY sort_order, id');
    $stmt->execute([$plate]);
    $members = $stmt->fetchAll();
}
$memberTree = ttp_flatten_members($members);

$editingMemberId = (int)($_GET['edit_member'] ?? 0);
$editingMember = null;
foreach ($memberTree as $m) { if ((int)$m['id'] === $editingMemberId) { $editingMember = $m; break; } }

$takenPlates = $pdo->query('SELECT plate FROM representatives')->fetchAll(PDO::FETCH_COLUMN);
$availableProvinces = array_diff_key($provinces, array_flip($takenPlates));
uasort($availableProvinces, fn($a, $b) => strcoll($a['name'], $b['name']));

$pageTitle = $isNew ? 'Yeni İl Başkanlığı' : $provinces[$plate]['name'];
require __DIR__ . '/includes/layout_start.php';
?>
<a class="ttpa-back" href="/admin/representatives.php">← İl Başkanlıkları</a>
<h2><?= $isNew ? 'Yeni İl Başkanlığı Ekle' : htmlspecialchars($provinces[$plate]['name']) . ' İl Başkanlığı' ?></h2>
<?php render_flash(); ?>

<!-- 1. ADIM: İL BAŞKANI -->
<div class="ttpa-card">
  <h3><?= $isNew ? '1. Adım — İl Başkanı' : 'İl Başkanı' ?></h3>
  <p class="ttpa-hint">
    Haritada bu ile tıklandığında en üstte görünen kişi. Teşkilat ağacının kökü budur.
  </p>
  <form class="ttpa-form" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="save_president" value="1">
    <?php if ($president): ?>
      <input type="hidden" name="is_edit" value="1">
      <input type="hidden" name="plate" value="<?= htmlspecialchars($plate) ?>">
    <?php endif; ?>
    <div class="ttpa-form-grid">
      <div<?= $president ? ' class="full"' : '' ?>>
        <?php if (!$president): ?>
          <label>İl</label>
          <select name="plate" required>
            <option value="">Seçiniz…</option>
            <?php foreach ($availableProvinces as $pl => $p): ?>
              <option value="<?= $pl ?>"><?= htmlspecialchars($p['name']) ?></option>
            <?php endforeach; ?>
          </select>
        <?php endif; ?>
      </div>
      <div>
        <label>Ad Soyad</label>
        <input type="text" name="name" value="<?= htmlspecialchars($president['name'] ?? '') ?>" required>
      </div>
      <div>
        <label>Unvan</label>
        <input type="text" name="title" value="<?= htmlspecialchars($president['title'] ?? 'İl Başkanı') ?>">
      </div>
      <div>
        <label>Fotoğraf</label>
        <?= file_field('photo') ?>
        <?php if (!empty($president['photo'])): ?><img class="ttpa-photo-preview" src="/<?= htmlspecialchars($president['photo']) ?>" alt=""><?php endif; ?>
      </div>
      <div>
        <label>Yetki Belgesi</label>
        <?= file_field('certificate') ?>
        <?php if (!empty($president['certificate'])): ?><img class="ttpa-photo-preview" src="/<?= htmlspecialchars($president['certificate']) ?>" alt=""><?php endif; ?>
      </div>
      <div>
        <label>Sıra</label>
        <input type="number" name="sort_order" value="<?= (int)($president['sort_order'] ?? 0) ?>">
      </div>
    </div>
    <div class="ttpa-actions">
      <button type="submit" class="btn"><?= $president ? 'Kaydet' : 'Kaydet ve Devam Et' ?></button>
      <a class="btn secondary" href="/admin/representatives.php">Vazgeç</a>
    </div>
  </form>
</div>

<!-- 2. ADIM: TEŞKİLAT AĞACI -->
<?php if (!$president): ?>
  <div class="ttpa-card" style="opacity:.6;">
    <h3>2. Adım — Başkanın Altındaki Teşkilat</h3>
    <p class="ttpa-hint">Önce yukarıdan il başkanını kaydedin; ardından bu bölüm açılacak.</p>
  </div>
<?php else: ?>
  <div class="ttpa-card">
    <h3>Başkanın Altındaki Teşkilat</h3>
    <p class="ttpa-hint">
      Başkanın altına kişi ekleyin; eklediğiniz kişinin altına da başkalarını bağlayabilirsiniz (derinlik sınırı yok).
      Haritadaki panelde kademe kademe görünür. Bir kişiyi silerseniz <strong>altındaki tüm kademeler de silinir</strong>.
    </p>

    <table class="ttpa-table">
      <tr><th></th><th>Kişi</th><th>Unvan</th><th>Sıra</th><th style="width:150px;"></th></tr>
      <tr style="background:#F8FAFC;">
        <td><?php if ($president['photo']): ?><img class="thumb" src="/<?= htmlspecialchars($president['photo']) ?>" alt=""><?php endif; ?></td>
        <td><strong><?= htmlspecialchars($president['name']) ?></strong></td>
        <td><?= htmlspecialchars($president['title']) ?></td>
        <td>—</td>
        <td style="color:#94A3B8;font-size:12px;">kök — yukarıdan düzenlenir</td>
      </tr>
      <?php foreach ($memberTree as $m): ?>
        <tr<?= ($editingMember && (int)$editingMember['id'] === (int)$m['id']) ? ' style="background:#FFFBEB;"' : '' ?>>
          <td><?php if ($m['photo']): ?><img class="thumb" src="/<?= htmlspecialchars($m['photo']) ?>" alt=""><?php endif; ?></td>
          <td>
            <span style="color:#CBD5E1;letter-spacing:2px;"><?= str_repeat('└', 1) ?><?= str_repeat('──', (int)$m['_depth']) ?></span>
            <?= htmlspecialchars($m['name']) ?>
          </td>
          <td><?= htmlspecialchars($m['title']) ?: '<span style="color:#CBD5E1;">—</span>' ?></td>
          <td><?= (int)$m['sort_order'] ?></td>
          <td>
            <a class="btn small secondary" href="/admin/province.php?plate=<?= $plate ?>&edit_member=<?= $m['id'] ?>">Düzenle</a>
            <form method="post" style="display:inline" onsubmit="return confirm('<?= htmlspecialchars($m['name']) ?> ve altındaki tüm kademeler silinsin mi?');">
              <?= csrf_field() ?>
              <input type="hidden" name="delete_member_id" value="<?= $m['id'] ?>">
              <input type="hidden" name="member_plate" value="<?= $plate ?>">
              <button type="submit" class="btn small danger">Sil</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$memberTree): ?>
        <tr><td colspan="5" class="ttpa-empty">Başkanın altında henüz kimse yok. Aşağıdaki formla ekleyin.</td></tr>
      <?php endif; ?>
    </table>

    <h4 style="margin-bottom:0;"><?= $editingMember ? 'Kişiyi Düzenle: ' . htmlspecialchars($editingMember['name']) : 'Yeni Kişi Ekle' ?></h4>
    <form class="ttpa-form" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="save_member" value="1">
      <input type="hidden" name="member_plate" value="<?= $plate ?>">
      <?php if ($editingMember): ?><input type="hidden" name="member_id" value="<?= $editingMember['id'] ?>"><?php endif; ?>
      <div class="ttpa-form-grid">
        <div class="full">
          <label>Kimin altında yer alacak?</label>
          <select name="member_parent_id">
            <option value="0">İl Başkanı — <?= htmlspecialchars($president['name']) ?></option>
            <?php foreach ($memberTree as $m):
              if ($editingMember && (int)$m['id'] === (int)$editingMember['id']) continue; ?>
              <option value="<?= $m['id'] ?>" <?= ($editingMember && (int)$editingMember['parent_id'] === (int)$m['id']) ? 'selected' : '' ?>>
                <?= str_repeat('— ', (int)$m['_depth'] + 1) ?><?= htmlspecialchars($m['name']) ?><?= $m['title'] ? ' (' . htmlspecialchars($m['title']) . ')' : '' ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label>Ad Soyad</label>
          <input type="text" name="member_name" value="<?= htmlspecialchars($editingMember['name'] ?? '') ?>" required>
        </div>
        <div>
          <label>Unvan</label>
          <input type="text" name="member_title" value="<?= htmlspecialchars($editingMember['title'] ?? '') ?>" placeholder="ör. Başkan Yardımcısı">
        </div>
        <div>
          <label>Fotoğraf</label>
          <?= file_field('member_photo') ?>
          <?php if (!empty($editingMember['photo'])): ?><img class="ttpa-photo-preview" src="/<?= htmlspecialchars($editingMember['photo']) ?>" alt=""><?php endif; ?>
        </div>
        <div>
          <label>Yetki Belgesi</label>
          <?= file_field('member_certificate') ?>
          <?php if (!empty($editingMember['certificate'])): ?><img class="ttpa-photo-preview" src="/<?= htmlspecialchars($editingMember['certificate']) ?>" alt=""><?php endif; ?>
        </div>
        <div>
          <label>Sıra</label>
          <input type="number" name="member_sort_order" value="<?= (int)($editingMember['sort_order'] ?? 0) ?>">
        </div>
      </div>
      <div class="ttpa-actions">
        <button type="submit" class="btn"><?= $editingMember ? 'Güncelle' : 'Ekle' ?></button>
        <?php if ($editingMember): ?><a class="btn secondary" href="/admin/province.php?plate=<?= $plate ?>">Vazgeç</a><?php endif; ?>
      </div>
    </form>
  </div>
<?php endif; ?>
<?php require __DIR__ . '/includes/layout_end.php'; ?>
