<?php

function set_flash(string $type, string $message): void {
    if ($type === 'ok' && ($_SESSION['flash']['type'] ?? '') === 'err') {
        return;
    }
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function render_flash(): void {
    if (empty($_SESSION['flash'])) return;
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $cls = $f['type'] === 'ok' ? 'ok' : 'err';
    echo '<div class="ttpa-flash ' . $cls . '">' . htmlspecialchars($f['message']) . '</div>';
}

function handle_upload(string $fieldName, array $allowedExt = ['jpg', 'jpeg', 'png', 'webp']): ?string {
    if (empty($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES[$fieldName];
    if (!is_uploaded_file($file['tmp_name'] ?? '')) {
        set_flash('err', 'Geçersiz dosya yüklemesi.');
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        set_flash('err', 'Dosya yüklenirken hata oluştu.');
        return null;
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        set_flash('err', 'Dosya 5MB\'dan büyük olamaz.');
        return null;
    }

    $ext = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt, true)) {
        set_flash('err', 'Desteklenmeyen dosya türü: .' . htmlspecialchars($ext));
        return null;
    }

    if ($ext === 'pdf') {
        if ((string)@file_get_contents($file['tmp_name'], false, null, 0, 5) !== '%PDF-') {
            set_flash('err', 'Dosya geçerli bir PDF değil.');
            return null;
        }
    } else {
        $imageTypes = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG  => 'png',
            IMAGETYPE_WEBP => 'webp',
            IMAGETYPE_GIF  => 'gif',
        ];
        $info = @getimagesize($file['tmp_name']);
        if (!$info || !isset($imageTypes[$info[2]])) {
            set_flash('err', 'Dosya geçerli bir görsel değil.');
            return null;
        }
        $ext = $imageTypes[$info[2]];
        if (!in_array($ext, $allowedExt, true)) {
            set_flash('err', 'Desteklenmeyen görsel türü.');
            return null;
        }
    }

    $uploadDir = dirname(__DIR__, 2) . '/wp-content/uploads/admin/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        set_flash('err', 'Dosya kaydedilemedi.');
        return null;
    }
    @chmod($uploadDir . $filename, 0644);
    return 'wp-content/uploads/admin/' . $filename;
}

function asset_url(?string $path): string {
    $path = trim((string)$path);
    if ($path === '') return '';
    $path = str_replace(chr(92), "/", $path);
    if (str_starts_with($path, '//')) return '';
    if (preg_match('~^[a-z][a-z0-9+.\-]*:~i', $path)) return '';
    if (str_contains($path, '..')) return '';
    return '/' . ltrim($path, '/');
}

function safe_url(?string $url): string {
    $url = trim((string)$url);
    if ($url === '') return '';
    if (preg_match('~^[a-z][a-z0-9+.\-]*:~i', $url)) {
        return preg_match('~^(https?|mailto|tel):~i', $url) ? $url : '';
    }
    if (str_starts_with($url, '//')) return 'https:' . $url;
    if (str_starts_with($url, '/'))  return $url;
    return 'https://' . $url;
}

function get_setting(string $key, string $default = ''): string {
    $stmt = db()->prepare('SELECT setting_value FROM site_settings WHERE setting_key = ?');
    $stmt->execute([$key]);
    $val = $stmt->fetchColumn();
    return $val !== false ? $val : $default;
}

function set_setting(string $key, string $value): void {
    db()->prepare('REPLACE INTO site_settings (setting_key, setting_value) VALUES (?,?)')->execute([$key, $value]);
}

function slugify(string $text): string {
    $map = ['ç'=>'c','Ç'=>'c','ğ'=>'g','Ğ'=>'g','ı'=>'i','I'=>'i','İ'=>'i','ö'=>'o','Ö'=>'o','ş'=>'s','Ş'=>'s','ü'=>'u','Ü'=>'u'];
    $text = strtr($text, $map);
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function file_field(string $name, string $accept = 'image/*', bool $required = false, string $buttonText = 'Dosya Seç'): string {
    $id = 'ttpafile_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $name);
    return '<div class="ttpa-file">'
         . '<input type="file" class="ttpa-file-input" id="' . htmlspecialchars($id) . '"'
         . ' name="' . htmlspecialchars($name) . '"'
         . ' accept="' . htmlspecialchars($accept) . '"'
         . ($required ? ' required' : '') . '>'
         . '<label class="ttpa-file-btn" for="' . htmlspecialchars($id) . '">' . htmlspecialchars($buttonText) . '</label>'
         . '<span class="ttpa-file-name">Dosya seçilmedi</span>'
         . '</div>';
}

const TTP_ALLOWED_HTML = [
    'p' => [], 'br' => [], 'strong' => [], 'b' => [], 'em' => [], 'i' => [], 'u' => [],
    'ul' => [], 'ol' => [], 'li' => [], 'blockquote' => [],
    'h2' => [], 'h3' => [], 'h4' => [],
    'a' => ['href', 'title', 'target', 'rel'],
    'img' => ['src', 'alt', 'width', 'height'],
];

function ttp_sanitize_html(string $html): string {
    $html = trim($html);
    if ($html === '') return '';

    $dangerous = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input',
                  'button', 'select', 'textarea', 'link', 'meta', 'base', 'svg', 'math'];

    $doc = new DOMDocument('1.0', 'UTF-8');
    $prev = libxml_use_internal_errors(true);
    $doc->loadHTML(
        '<?xml encoding="UTF-8"><!DOCTYPE html><html><body>' . $html . '</body></html>',
        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET
    );
    libxml_clear_errors();
    libxml_use_internal_errors($prev);

    $body = $doc->getElementsByTagName('body')->item(0);
    if (!$body) return '';

    $elements = iterator_to_array($doc->getElementsByTagName('*'), false);
    foreach (array_reverse($elements) as $el) {
        /** @var DOMElement $el */
        if (!$el->parentNode) continue;
        $tag = strtolower($el->nodeName);
        if ($tag === 'body' || $tag === 'html') continue;

        if (in_array($tag, $dangerous, true)) {
            $el->parentNode->removeChild($el);
            continue;
        }

        if (!isset(TTP_ALLOWED_HTML[$tag])) {
            while ($el->firstChild) {
                $el->parentNode->insertBefore($el->firstChild, $el);
            }
            $el->parentNode->removeChild($el);
            continue;
        }

        $allowedAttrs = TTP_ALLOWED_HTML[$tag];
        foreach (iterator_to_array($el->attributes, false) as $attr) {
            $an = strtolower($attr->nodeName);
            if (!in_array($an, $allowedAttrs, true)) {
                $el->removeAttribute($attr->nodeName);
                continue;
            }
            if ($an === 'href') {
                $safe = safe_url($attr->nodeValue);
                if ($safe === '') { $el->removeAttribute('href'); }
                else { $el->setAttribute('href', $safe); }
            }
            if ($an === 'src') {
                $v = trim((string)$attr->nodeValue);
                if (!preg_match('~^(https?://|/)~i', $v)) $el->removeAttribute('src');
            }
        }
        if ($tag === 'img' && !$el->getAttribute('src')) {
            $el->parentNode->removeChild($el);
            continue;
        }
        if ($tag === 'a' && $el->getAttribute('target') === '_blank') {
            $el->setAttribute('rel', 'noopener noreferrer');
        }
    }

    $out = '';
    foreach ($body->childNodes as $child) {
        $out .= $doc->saveHTML($child);
    }
    return trim($out);
}

