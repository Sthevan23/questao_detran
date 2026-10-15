<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_admin();

$pdo = db();
if (is_post()) {
    csrf_verify();
    $nome = trim($_POST['site_nome'] ?? 'Aprova CNH');
    $max = max(3, (int) ($_POST['max_login_tentativas'] ?? 5));
    $bloq = max(5, (int) ($_POST['bloqueio_minutos'] ?? 15));
    $upsert = $pdo->prepare('INSERT INTO configuracoes (chave, valor) VALUES (?, ?) ON DUPLICATE KEY UPDATE valor = VALUES(valor)');
    $upsert->execute(['site_nome', $nome]);
    $upsert->execute(['max_login_tentativas', (string) $max]);
    $upsert->execute(['bloqueio_minutos', (string) $bloq]);
    flash('success', 'Configurações salvas.');
    redirect(url('admin/configuracoes.php'));
}

$painelCss = true;
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php admin_sidebar('configuracoes'); ?>
    <div class="painel-content">
        <h1>Configurações</h1>
        <?php if ($m = flash('success')): ?><div class="alert alert-success"><?= e($m) ?></div><?php endif; ?>
        <form method="post" class="card">
            <?= csrf_field() ?>
            <div class="form-group"><label>Nome do site</label><input name="site_nome" value="<?= e(config_get('site_nome', 'Aprova CNH')) ?>"></div>
            <div class="form-group"><label>Máx. tentativas de login</label><input type="number" name="max_login_tentativas" value="<?= e(config_get('max_login_tentativas', '5')) ?>"></div>
            <div class="form-group"><label>Bloqueio (minutos)</label><input type="number" name="bloqueio_minutos" value="<?= e(config_get('bloqueio_minutos', '15')) ?>"></div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
        <p class="form-hint" style="margin-top:1rem;">Após a instalação, remova ou renomeie <code>install.php</code> por segurança.</p>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
