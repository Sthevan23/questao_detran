<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function url(string $path = ''): string
{
    $base = BASE_PATH;
    $path = ltrim($path, '/');
    return ($base === '' ? '' : $base) . '/' . $path;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }
    if (!empty($_SESSION['_flash'][$key])) {
        $msg = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $msg;
    }
    return null;
}

function config_get(string $key, ?string $default = null): ?string
{
    static $cache = [];
    if (array_key_exists($key, $cache)) {
        return $cache[$key];
    }
    try {
        $stmt = db()->prepare('SELECT valor FROM configuracoes WHERE chave = ? LIMIT 1');
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        $cache[$key] = $row ? (string) $row['valor'] : $default;
        return $cache[$key];
    } catch (Throwable) {
        return $default;
    }
}

function site_nome(): string
{
    return config_get('site_nome', 'Aprova CNH') ?? 'Aprova CNH';
}

function require_instalado(): void
{
    if (config_get('instalado', '0') !== '1') {
        redirect(url('install.php'));
    }
}

function pagina_atual(): string
{
    return basename($_SERVER['PHP_SELF'] ?? 'index.php');
}

function formatar_tempo(int $segundos): string
{
    $m = intdiv($segundos, 60);
    $s = $segundos % 60;
    return sprintf('%02d:%02d', $m, $s);
}

function slugify(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');
    $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text) ?? '';
    $text = preg_replace('/[\s-]+/', '-', trim($text)) ?? '';
    return $text ?: 'item';
}
