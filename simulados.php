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
<div class="container page-header">
    <h1>Prova teórica (simulado DETRAN-MG)</h1>
    <p class="text-muted">No mesmo formato divulgado pelo Estado de Minas Gerais para a 1ª habilitação.</p>
    <?php if ($msg = flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>
</div>

<div class="container" style="max-width:640px;">
    <article class="card prova-mg-card">
        <h2 style="margin-top:0;color:var(--blue-900);">Como será no dia da prova</h2>
        <ul class="prova-mg-list">
            <li><strong><?= $qtdProva ?> questões</strong> de múltipla escolha (A, B, C ou D)</li>
            <li><strong><?= $duracao ?> minutos</strong> de tempo (cronômetro na tela)</li>
            <li>Conteúdo <strong>misto</strong> (legislação, placas, direção defensiva, primeiros socorros, meio ambiente, mecânica, infrações e circulação)</li>
            <li>Para ser aprovado em MG: <strong>no mínimo <?= $minAcertos ?> acertos</strong> (pode errar até <?= $qtdProva - $minAcertos ?>)</li>
            <li>Sem gabarito durante a prova — resultado só ao final</li>
        </ul>
        <p class="form-hint">Referência: <a href="https://www.mg.gov.br/servico/obter-1a-habilitacao-cnh-ou-acc" target="_blank" rel="noopener noreferrer">Portal MG</a> · Questões aqui são de <strong>treinamento</strong>, não são da prova oficial.</p>

        <?php if (!$prova): ?>
            <div class="alert alert-error">Prova não configurada no banco. Importe database.sql.</div>
        <?php elseif ($totalAtivas < $qtdProva): ?>
            <div class="alert alert-error">Há <?= $totalAtivas ?> questões ativas. Importe <code>seed_100_questoes_mg.sql</code> para completar <?= $qtdProva ?>.</div>
        <?php else: ?>
            <form method="post" data-loading style="margin-top:1.25rem;">
                <?= csrf_field() ?>
                <input type="hidden" name="simulado_id" value="<?= (int) $prova['id'] ?>">
                <button type="submit" class="btn btn-primary" style="width:100%;font-size:1.05rem;padding:.85rem;">Iniciar prova agora</button>
            </form>
        <?php endif; ?>
    </article>

    <p style="text-align:center;margin-top:1.25rem;">
        <a href="<?= e(url('estudo.php')) ?>">Modo estudo</a> — ver resposta e explicação após cada questão (para aprender antes da prova).
    </p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
