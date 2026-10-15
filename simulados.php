<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/simulado_service.php';
require_instalado();

$prova = simulado_prova_geral();
$totalAtivas = (int) db()->query('SELECT COUNT(*) FROM questoes WHERE ativo = 1')->fetchColumn();
$qtdProva = $prova ? (int) $prova['qtd_questoes'] : prova_mg_qtd_questoes();
$minAcertos = prova_mg_acertos_minimos();
$duracao = $prova ? (int) $prova['duracao_minutos'] : 40;

if (is_post()) {
    csrf_verify();
    $simId = (int) ($_POST['simulado_id'] ?? 0);
    if (!$simId && $prova) {
        $simId = (int) $prova['id'];
    }
    $res = iniciar_tentativa($simId, auth_id());
    if ($res['ok']) {
        $_SESSION['tentativa_id'] = $res['tentativa_id'];
        $_SESSION['tentativa_token'] = $res['token'];
        redirect(url('simulado.php?id=' . $res['tentativa_id']));
    }
    flash('error', $res['msg']);
}

$pageTitle = 'Prova teórica — ' . site_nome();
require __DIR__ . '/includes/header.php';
?>
<div class="container" style="max-width:480px;padding-top:1.5rem;">
    <h1>Simulado da prova</h1>
    <p class="text-muted"><?= $qtdProva ?> questões · <?= $duracao ?> min · aprovado com <?= $minAcertos ?> acertos</p>
    <?php if ($msg = flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>

    <?php if (!$prova): ?>
        <div class="alert alert-error">Importe database.sql no phpMyAdmin.</div>
    <?php elseif ($totalAtivas < $qtdProva): ?>
        <div class="alert alert-error">Faltam questões no banco (<?= $totalAtivas ?>/<?= $qtdProva ?>).</div>
    <?php else: ?>
        <form method="post" data-loading>
            <?= csrf_field() ?>
            <input type="hidden" name="simulado_id" value="<?= (int) $prova['id'] ?>">
            <button type="submit" class="btn btn-primary" style="width:100%;padding:.9rem;font-size:1.05rem;">Começar simulado</button>
        </form>
    <?php endif; ?>
    <p style="text-align:center;margin-top:1.25rem;"><a href="<?= e(url('estudo.php')) ?>">← Voltar a treinar</a></p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
