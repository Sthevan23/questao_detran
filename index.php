<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

try {
    require_instalado();
} catch (Throwable) {
    redirect(url('install.php'));
}

redirect(url('simulados.php'));
