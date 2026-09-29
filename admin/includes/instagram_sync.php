<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

const TTP_IG_DIR = 'wp-content/uploads/instagram/';

function ttp_ig_upload_dir(): string
{
    $dir = dirname(__DIR__, 2) . '/' . TTP_IG_DIR;
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    return $dir;
}

function ttp_ig_http_get(string $url, int $timeout = 30): ?string
{
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; TTP-Site/1.0)',
        ]);
        $body = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($body !== false && $code >= 200 && $code < 400) ? $body : null;
    }
    $ctx = stream_context_create(['http' => [
        'timeout' => $timeout,
        'header' => "User-Agent: Mozilla/5.0 (compatible; TTP-Site/1.0)\r\n",
    ]]);
    $body = @file_get_contents($url, false, $ctx);
    return $body === false ? null : $body;
}

function ttp_ig_store_image(string $url, string $key): ?string
{
    $data = ttp_ig_http_get($url, 45);
    if ($data === null || strlen($data) < 1024) {
        return null;
    }
    $tmp = tempnam(sys_get_temp_dir(), 'ttpig');
    file_put_contents($tmp, $data);
    $info = @getimagesize($tmp);
    if (!$info) {
        @unlink($tmp);
        return null;
    }
    $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$info['mime']] ?? null;
    if ($ext === null) {
        @unlink($tmp);
        return null;
    }
    $filename = 'ig-' . preg_replace('/[^A-Za-z0-9_-]/', '', $key) . '.' . $ext;
    if (!@rename($tmp, ttp_ig_upload_dir() . $filename)) {
        @copy($tmp, ttp_ig_upload_dir() . $filename);
        @unlink($tmp);
    }
    return TTP_IG_DIR . $filename;
}

function ttp_ig_upsert(array $post, int $order): bool
{
    $existing = null;
    if (!empty($post['ig_id'])) {
        $stmt = db()->prepare('SELECT * FROM instagram_posts WHERE ig_id = ?');
        $stmt->execute([$post['ig_id']]);
        $existing = $stmt->fetch();
    }

    $image = $existing['image'] ?? null;
    $absolute = $image ? dirname(__DIR__, 2) . '/' . $image : null;
    if (!$image || !$absolute || !is_file($absolute)) {
        $image = ttp_ig_store_image($post['image_url'], $post['ig_id'] ?: md5($post['permalink']));
        if ($image === null) {
            return false;
        }
    }

    if ($existing) {
        $stmt = db()->prepare('UPDATE instagram_posts SET permalink=?, image=?, caption=?, media_type=?, posted_at=?, sort_order=? WHERE id=?');
        return $stmt->execute([
            $post['permalink'], $image, $post['caption'], $post['media_type'],
            $post['posted_at'], $order, $existing['id'],
        ]);
    }

    $stmt = db()->prepare('INSERT INTO instagram_posts (ig_id, permalink, image, caption, media_type, posted_at, sort_order) VALUES (?,?,?,?,?,?,?)');
    return $stmt->execute([
        $post['ig_id'] ?: null, $post['permalink'], $image, $post['caption'],
        $post['media_type'], $post['posted_at'], $order,
    ]);
}

function ttp_ig_sync_from_api(int $limit = 20): array
{
    $token = trim(get_setting('instagram_access_token'));
    if ($token === '') {
        return [false, 'Instagram erişim anahtarı (access token) girilmemiş.'];
    }

    $url = 'https://graph.instagram.com/me/media?fields=' .
        rawurlencode('id,caption,media_type,media_url,thumbnail_url,permalink,timestamp') .
        '&limit=' . (int)$limit . '&access_token=' . rawurlencode($token);

    $body = ttp_ig_http_get($url);
    if ($body === null) {
        return [false, 'Instagram API\'sine ulaşılamadı.'];
    }
    $json = json_decode($body, true);
    if (isset($json['error'])) {
        return [false, 'Instagram API hatası: ' . ($json['error']['message'] ?? 'bilinmeyen hata')];
    }
    if (empty($json['data'])) {
        return [false, 'Instagram API boş yanıt döndürdü.'];
    }

    $posts = [];
    foreach ($json['data'] as $item) {
        $img = ($item['media_type'] ?? '') === 'VIDEO'
            ? ($item['thumbnail_url'] ?? $item['media_url'] ?? '')
            : ($item['media_url'] ?? '');
        if ($img === '') continue;
        $posts[] = [
            'ig_id' => (string)($item['id'] ?? ''),
            'permalink' => $item['permalink'] ?? '',
            'image_url' => $img,
            'caption' => $item['caption'] ?? '',
            'media_type' => strtolower(str_replace('CAROUSEL_ALBUM', 'carousel', $item['media_type'] ?? 'image')),
            'posted_at' => !empty($item['timestamp']) ? date('Y-m-d H:i:s', strtotime($item['timestamp'])) : null,
        ];
    }
    return ttp_ig_replace_all($posts, 'Instagram API');
}

function ttp_ig_sync_from_legacy_site(string $pageUrl = 'https://www.terorsuzturkiyeplatformu.org/', int $limit = 20): array
{
    $html = ttp_ig_http_get($pageUrl, 45);
    if ($html === null) {
        return [false, 'Eski siteye ulaşılamadı: ' . $pageUrl];
    }

    $re = '/<div class="sbi_item sbi_type_(\w+)[^"]*"[^>]*id="sbi_([0-9_]+)"[^>]*data-date="(\d+)"[\s\S]{0,4000}?' .
          '<a class="sbi_photo" href="([^"]+)"[^>]*data-full-res="([^"]+)"/';
    if (!preg_match_all($re, $html, $m, PREG_SET_ORDER)) {
        return [false, 'Eski sitede Instagram gönderisi bulunamadı (sayfa yapısı değişmiş olabilir).'];
    }

    $posts = [];
    foreach (array_slice($m, 0, $limit) as $row) {
        $posts[] = [
            'ig_id' => $row[2],
            'permalink' => html_entity_decode($row[4], ENT_QUOTES),
            'image_url' => html_entity_decode($row[5], ENT_QUOTES),
            'caption' => '',
            'media_type' => $row[1],
            'posted_at' => date('Y-m-d H:i:s', (int)$row[3]),
        ];
    }
    return ttp_ig_replace_all($posts, 'eski site');
}

function ttp_ig_replace_all(array $posts, string $source): array
{
    $saved = [];
    $order = 0;
    foreach ($posts as $post) {
        if (ttp_ig_upsert($post, $order)) {
            $saved[] = $post['ig_id'] ?: md5($post['permalink']);
            $order++;
        }
    }
    if (!$saved) {
        return [false, 'Hiçbir gönderi görseli indirilemedi, mevcut kayıtlar korundu.'];
    }

    $placeholders = implode(',', array_fill(0, count($saved), '?'));
    $stmt = db()->prepare("SELECT id, image FROM instagram_posts WHERE ig_id IS NULL OR ig_id NOT IN ($placeholders)");
    $stmt->execute($saved);
    foreach ($stmt->fetchAll() as $stale) {
        $file = dirname(__DIR__, 2) . '/' . $stale['image'];
        if (is_file($file)) @unlink($file);
        db()->prepare('DELETE FROM instagram_posts WHERE id = ?')->execute([$stale['id']]);
    }

    set_setting('instagram_last_sync', date('Y-m-d H:i:s'));
    return [true, count($saved) . ' gönderi güncellendi (kaynak: ' . $source . ').'];
}

function ttp_ig_sync_auto(): array
{
    if (trim(get_setting('instagram_access_token')) !== '') {
        return ttp_ig_sync_from_api();
    }
    return ttp_ig_sync_from_legacy_site();
}

