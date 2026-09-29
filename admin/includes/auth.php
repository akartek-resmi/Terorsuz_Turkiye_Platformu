<?php
require_once __DIR__ . '/db.php';

const TTP_SESSION_IDLE_LIMIT     = 7200;
const TTP_SESSION_ABSOLUTE_LIMIT = 43200;
const TTP_LOGIN_MAX_ATTEMPTS     = 5;
const TTP_LOGIN_LOCK_SECONDS     = 900;

function ttp_is_https(): bool {
    if (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') return true;
    if ((string)($_SERVER['SERVER_PORT'] ?? '') === '443') return true;
    if (strtolower((string)($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https') return true;
    return false;
}

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.sid_length', '48');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/admin/',
        'domain'   => '',
        'secure'   => ttp_is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_name('TTPADMINSESS');
    session_start();
}

function ttp_destroy_session(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires'  => time() - 42000,
            'path'     => $p['path'],
            'domain'   => $p['domain'],
            'secure'   => $p['secure'],
            'httponly' => $p['httponly'],
            'samesite' => $p['samesite'] ?? 'Lax',
        ]);
    }
    if (session_status() === PHP_SESSION_ACTIVE) session_destroy();
}

function ttp_fingerprint(): string {
    return hash('sha256', (string)($_SERVER['HTTP_USER_AGENT'] ?? ''));
}

function ttp_session_is_stale(): bool {
    $now = time();
    if (!empty($_SESSION['last_activity']) && ($now - (int)$_SESSION['last_activity']) > TTP_SESSION_IDLE_LIMIT) return true;
    if (!empty($_SESSION['login_time']) && ($now - (int)$_SESSION['login_time']) > TTP_SESSION_ABSOLUTE_LIMIT) return true;
    if (!empty($_SESSION['fingerprint']) && !hash_equals((string)$_SESSION['fingerprint'], ttp_fingerprint())) return true;
    return false;
}

function require_login(): void {
    if (empty($_SESSION['admin_id']) || ttp_session_is_stale()) {
        $expired = !empty($_SESSION['admin_id']);
        ttp_destroy_session();
        header('Location: /admin/login.php' . ($expired ? '?expired=1' : ''));
        exit;
    }
    $_SESSION['last_activity'] = time();
}

function ttp_client_ip(): string {
    return substr((string)($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'), 0, 45);
}

function ttp_ensure_attempts_table(): void {
    static $done = false;
    if ($done) return;
    db()->exec(
        'CREATE TABLE IF NOT EXISTS login_attempts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip VARCHAR(45) NOT NULL,
            username VARCHAR(100) NOT NULL DEFAULT "",
            attempted_at DATETIME NOT NULL,
            INDEX idx_ip_time (ip, attempted_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );
    $done = true;
}

function login_lock_seconds_left(): int {
    ttp_ensure_attempts_table();
    $stmt = db()->prepare(
        'SELECT COUNT(*) AS c, TIMESTAMPDIFF(SECOND, MAX(attempted_at), NOW()) AS age
           FROM login_attempts
          WHERE ip = ? AND attempted_at > (NOW() - INTERVAL ' . (int)TTP_LOGIN_LOCK_SECONDS . ' SECOND)'
    );
    $stmt->execute([ttp_client_ip()]);
    $row = $stmt->fetch();
    if (!$row || (int)$row['c'] < TTP_LOGIN_MAX_ATTEMPTS) return 0;
    $left = TTP_LOGIN_LOCK_SECONDS - (int)$row['age'];
    return $left > 0 ? $left : 0;
}

function record_failed_login(string $username): void {
    ttp_ensure_attempts_table();
    db()->prepare('INSERT INTO login_attempts (ip, username, attempted_at) VALUES (?,?,NOW())')
        ->execute([ttp_client_ip(), substr($username, 0, 100)]);
    db()->exec('DELETE FROM login_attempts WHERE attempted_at < (NOW() - INTERVAL 1 DAY)');
}

function clear_failed_logins(): void {
    ttp_ensure_attempts_table();
    db()->prepare('DELETE FROM login_attempts WHERE ip = ?')->execute([ttp_client_ip()]);
}

function attempt_login(string $username, string $password): bool {
    $stmt = db()->prepare('SELECT id, password_hash FROM admin_users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        password_verify($password, '$2y$10$usesomesillystringforsalt0000000000000000000000000000000000');
        record_failed_login($username);
        return false;
    }

    if (!password_verify($password, $user['password_hash'])) {
        record_failed_login($username);
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['admin_id']       = $user['id'];
    $_SESSION['admin_username'] = $username;
    $_SESSION['login_time']     = time();
    $_SESSION['last_activity']  = time();
    $_SESSION['fingerprint']    = ttp_fingerprint();
    clear_failed_logins();
    return true;
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}

function csrf_verify(): void {
    $token = (string)($_POST['csrf_token'] ?? '');
    if ($token === '' || !hash_equals((string)($_SESSION['csrf_token'] ?? ''), $token)) {
        http_response_code(403);
        die('Geçersiz istek (CSRF). Sayfayı yenileyip tekrar deneyin.');
    }
}

