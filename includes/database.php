<?php
declare(strict_types=1);

function db_config_paths(): array
{
    return [
        'config'  => APP_ROOT . '/config/database.php',
        'example' => APP_ROOT . '/config/database.example.php',
    ];
}

function db_write_config(string $path, array $cfg): bool
{
    $data = [
        'host'     => (string) ($cfg['host'] ?? 'localhost'),
        'dbname'   => (string) ($cfg['dbname'] ?? ''),
        'username' => (string) ($cfg['username'] ?? ''),
        'password' => (string) ($cfg['password'] ?? ''),
        'charset'  => (string) ($cfg['charset'] ?? 'utf8mb4'),
    ];
    $content = "<?php\nreturn " . var_export($data, true) . ";\n";

    return file_put_contents($path, $content) !== false;
}

/** Mescla example + database.php; corrige senha vazia no servidor após deploy. */
function db_resolve_config(): array
{
    $paths = db_config_paths();
    $cfg = [
        'host'     => 'localhost',
        'dbname'   => '',
        'username' => '',
        'password' => '',
        'charset'  => 'utf8mb4',
    ];

    if (is_readable($paths['example'])) {
        $ex = require $paths['example'];
        if (is_array($ex)) {
            $cfg = array_merge($cfg, $ex);
        }
    }

    if (is_readable($paths['config'])) {
        $local = require $paths['config'];
        if (is_array($local)) {
            foreach ($local as $key => $value) {
                if ($value === '' || $value === null) {
                    continue;
                }
                $cfg[$key] = $value;
            }
        }
    } elseif (is_readable($paths['example']) && ($cfg['password'] ?? '') !== '') {
        @db_write_config($paths['config'], $cfg);
    }

    if (is_readable($paths['config']) && ($cfg['password'] ?? '') !== '') {
        $onDisk = require $paths['config'];
        if (is_array($onDisk) && ($onDisk['password'] ?? '') === '') {
            @db_write_config($paths['config'], $cfg);
        }
    }

    return $cfg;
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $cfg = db_resolve_config();
    if (($cfg['dbname'] ?? '') === '' || ($cfg['username'] ?? '') === '') {
        throw new RuntimeException('Arquivo config/database.php não encontrado. Copie database.example.php.');
    }

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
