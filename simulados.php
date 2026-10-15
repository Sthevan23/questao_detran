<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/simulado_service.php';
require_instalado();

$prova = simulado_prova_geral();
$totalAtivas = (int) db()->query('SELECT COUNT(*) FROM questoes WHERE ativo = 1')->fetchColumn();
$qtdProva = $prova ? (int) $prova['qtd_questoes'] : prova_mg_qtd_questoes();
$minAcertos = prova_mg_acertos_minimos();
$duracao = prova_mg_duracao_minutos();

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
<div class="container page-narrow">
    <header class="page-header page-header--compact">
        <h1>Simulado da prova real</h1>
        <p class="text-muted">Formato DETRAN-MG — treino completo antes do dia da prova.</p>
    </header>

    <ul class="simulado-info-list">
        <li><strong><?= $qtdProva ?> questões</strong> por prova</li>
        <li><strong><?= $duracao ?> minutos</strong> de tempo</li>
        <li>Aprovado com <strong><?= $minAcertos ?> acertos</strong></li>
        <li>Novo sorteio <strong>a cada simulado</strong></li>
    </ul>

    <?php if ($msg = flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>

    <?php if (!$prova): ?>
        <div class="alert alert-error">Importe database.sql no phpMyAdmin.</div>
    <?php elseif ($totalAtivas < $qtdProva): ?>
        <div class="alert alert-error">Faltam questões no banco (<?= $totalAtivas ?>/<?= $qtdProva ?>).</div>
    <?php else: ?>
        <article class="card card--action">
            <form method="post" data-loading>
                <?= csrf_field() ?>
                <input type="hidden" name="simulado_id" value="<?= (int) $prova['id'] ?>">
                <button type="submit" class="btn btn-primary btn-block">Iniciar nova prova (<?= $qtdProva ?> questões)</button>
            </form>
        </article>
    <?php endif; ?>
    <p class="page-links"><a href="<?= e(url('estudo.php')) ?>">← Voltar a treinar</a></p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
