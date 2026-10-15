<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

$erro = null;

if (config_get('instalado', '0') === '1') {
    redirect(url('simulados.php'));
}

try {
    db()->query('SELECT 1');
} catch (Throwable $e) {
    $erro = 'Não foi possível conectar ao banco. Verifique config/database.php e importe database.sql no phpMyAdmin.';
}

if (is_post() && !$erro) {
    csrf_verify();
    db()->prepare('INSERT INTO configuracoes (chave, valor) VALUES ("instalado", "1") ON DUPLICATE KEY UPDATE valor = "1"')->execute();
    redirect(url('simulados.php'));
}

$pageTitle = 'Configuração — ' . site_nome();
require __DIR__ . '/includes/header.php';
?>
<div class="container">
    <div class="form-card">
        <h1>Quase pronto</h1>
        <p class="text-muted">Confirme que o banco de dados está configurado. Não é necessário criar conta nem senha.</p>
        <?php if ($erro): ?><div class="alert alert-error"><?= e($erro) ?></div><?php endif; ?>
        <?php if (!$erro): ?>
        <form method="post" data-loading>
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-primary" style="width:100%;">Ir para os simulados</button>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
