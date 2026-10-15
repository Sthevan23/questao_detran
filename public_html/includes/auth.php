<?php
declare(strict_types=1);

function auth_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function auth_id(): ?int
{
    $u = auth_user();
    return $u ? (int) $u['id'] : null;
}

function auth_check(): bool
{
    return auth_user() !== null;
}

function auth_is_admin(): bool
{
    $u = auth_user();
    return $u && ($u['papel'] ?? '') === 'admin';
}

function require_login(): void
{
    if (!auth_check()) {
        flash('error', 'Faça login para continuar.');
        redirect(url('login.php?redirect=' . rawurlencode($_SERVER['REQUEST_URI'] ?? '')));
    }
}

function require_admin(): void
{
    require_login();
    if (!auth_is_admin()) {
        http_response_code(403);
        exit('Acesso negado.');
    }
}

function auth_login(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id'    => (int) $user['id'],
        'nome'  => $user['nome'],
        'email' => $user['email'],
        'papel' => $user['papel'],
    ];
}

function auth_logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], (bool) $p['secure'], (bool) $p['httponly']);
    }
    session_destroy();
}

function login_max_tentativas(): int
{
    return (int) (config_get('max_login_tentativas', '5') ?? 5);
}

function login_bloqueio_minutos(): int
{
    return (int) (config_get('bloqueio_minutos', '15') ?? 15);
}

function tentar_login(string $email, string $senha): array
{
    $pdo = db();
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ? AND ativo = 1 LIMIT 1');
    $stmt->execute([mb_strtolower(trim($email))]);
    $user = $stmt->fetch();

    if (!$user) {
        return ['ok' => false, 'msg' => 'E-mail ou senha incorretos.'];
    }

    if (!empty($user['bloqueado_ate']) && strtotime($user['bloqueado_ate']) > time()) {
        return ['ok' => false, 'msg' => 'Conta temporariamente bloqueada. Tente novamente mais tarde.'];
    }

    if (!password_verify($senha, $user['senha_hash'])) {
        $tent = (int) $user['login_tentativas'] + 1;
        $bloqueio = null;
        if ($tent >= login_max_tentativas()) {
            $bloqueio = date('Y-m-d H:i:s', time() + login_bloqueio_minutos() * 60);
            $tent = 0;
        }
        $upd = $pdo->prepare('UPDATE usuarios SET login_tentativas = ?, bloqueado_ate = ? WHERE id = ?');
        $upd->execute([$tent, $bloqueio, $user['id']]);
        return ['ok' => false, 'msg' => 'E-mail ou senha incorretos.'];
    }

    $pdo->prepare('UPDATE usuarios SET login_tentativas = 0, bloqueado_ate = NULL WHERE id = ?')->execute([$user['id']]);
    auth_login($user);
    return ['ok' => true, 'msg' => 'Login realizado.'];
}
