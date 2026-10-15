<?php
declare(strict_types=1);

/** App público sem login — funções mantidas para compatibilidade. */
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
    return false;
}
