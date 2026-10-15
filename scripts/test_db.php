<?php
define('APP_ROOT', dirname(__DIR__) . '/public_html');
require APP_ROOT . '/includes/database.php';
try {
    $pdo = db();
    echo "OK\n";
    echo 'questoes=' . $pdo->query('SELECT COUNT(*) FROM questoes')->fetchColumn() . "\n";
} catch (Throwable $e) {
    echo 'FAIL: ' . $e->getMessage() . "\n";
    exit(1);
}
