<?php
$DB_HOST = getenv('DB_HOST') ?: (getenv('MYSQLHOST') ?: 'localhost');
$DB_PORT = getenv('DB_PORT') ?: (getenv('MYSQLPORT') ?: '3306');
$DB_NAME = getenv('DB_NAME') ?: (getenv('MYSQLDATABASE') ?: 'ttp_admin');
$DB_USER = getenv('DB_USER') ?: (getenv('MYSQLUSER') ?: 'root');
$DB_PASS = getenv('DB_PASS') !== false ? getenv('DB_PASS') : (getenv('MYSQLPASSWORD') !== false ? getenv('MYSQLPASSWORD') : '');

// If Railway/PaaS provides a single DATABASE_URL or MYSQL_URL
$dbUrl = getenv('MYSQL_URL') ?: (getenv('DATABASE_URL') ?: '');
if (!empty($dbUrl)) {
    $parsed = parse_url($dbUrl);
    if (!empty($parsed['host'])) {
        $DB_HOST = $parsed['host'];
        $DB_PORT = $parsed['port'] ?? '3306';
        $DB_USER = $parsed['user'] ?? 'root';
        $DB_PASS = $parsed['pass'] ?? '';
        if (!empty($parsed['path'])) {
            $DB_NAME = ltrim($parsed['path'], '/');
        }
    }
}

$ttpIsLocalRequest = PHP_SAPI === 'cli'
    || in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
ini_set('display_errors', $ttpIsLocalRequest ? '1' : '0');
ini_set('display_startup_errors', $ttpIsLocalRequest ? '1' : '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        global $DB_HOST, $DB_PORT, $DB_NAME, $DB_USER, $DB_PASS;
        $pdo = new PDO(
            "mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=utf8mb4",
            $DB_USER,
            $DB_PASS,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]
        );
    }
    return $pdo;
}

