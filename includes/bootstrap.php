<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_samesite', 'Lax');
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        ini_set('session.cookie_secure', '1');
    }
    session_start();
}

define('APP_ROOT', dirname(__DIR__));

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
foreach (['/admin', '/aluno', '/api'] as $suffix) {
    if (str_ends_with($scriptDir, $suffix)) {
        $scriptDir = substr($scriptDir, 0, -strlen($suffix));
        break;
    }
}
define('BASE_PATH', rtrim($scriptDir, '/'));

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/auth.php';
