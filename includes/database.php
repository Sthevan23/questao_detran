<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $configPath = APP_ROOT . '/config/database.php';
    if (!is_readable($configPath)) {
        throw new RuntimeException('Arquivo config/database.php não encontrado. Copie database.example.php.');
    }

    $cfg = require $configPath;
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $cfg['host'],
        $cfg['dbname'],
        $cfg['charset'] ?? 'utf8mb4'
    );

    $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    return $pdo;
}
