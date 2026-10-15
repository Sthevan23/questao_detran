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
    require_db();
}

function require_db(): void
{
    static $ok = false;
    if ($ok) {
        return;
    }
    $configPath = APP_ROOT . '/config/database.php';
    $examplePath = APP_ROOT . '/config/database.example.php';
    if (!is_readable($configPath) && is_readable($examplePath)) {
        @copy($examplePath, $configPath);
    }
    try {
        if (!is_readable($configPath)) {
            throw new RuntimeException('config');
        }
        db()->query('SELECT 1');
        $ok = true;
    } catch (Throwable) {
        http_response_code(503);
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
        echo '<title>Configuração</title><link rel="stylesheet" href="' . e(url('assets/css/style.css')) . '"></head><body>';
        echo '<div class="container form-card" style="margin:2rem auto;"><h1>Ajuste rápido</h1>';
        echo '<p>Edite no Gerenciador de arquivos: <strong>config/database.php</strong> (host, banco, usuário e senha MySQL da Hostinger).</p>';
        echo '<p class="form-hint">Depois recarregue esta página.</p></div></body></html>';
        exit;
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
