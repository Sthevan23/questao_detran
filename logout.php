<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
auth_logout();
redirect(url('simulados.php'));
