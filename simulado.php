<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/simulado_service.php';
require_instalado();

$id = (int) ($_GET['id'] ?? $_SESSION['tentativa_id'] ?? 0);
$token = $_SESSION['tentativa_token'] ?? '';

if (is_post() && isset($_POST['finalizar'])) {
    csrf_verify();
    $tempo = max(0, (int) ($_POST['tempo_utilizado'] ?? 0));
    $expirado = ($_POST['expirado'] ?? '') === '1';
    $res = finalizar_tentativa($id, $tempo, $expirado);
    if ($res['ok']) {
        redirect(url('resultado.php?id=' . $id));
    }
    flash('error', $res['msg']);
    redirect(url('simulados.php'));
}

$t = tentativa_carregar($id, $token);
if (!$t || $t['status'] !== 'em_andamento') {
    flash('error', 'Simulado não encontrado ou já finalizado.');
    redirect(url('simulados.php'));
}

$questoes = tentativa_questoes_com_alternativas($id);
$duracao = (int) $t['duracao_minutos'] * 60;

$totalQ = count($questoes);
$pageTitle = 'Prova em andamento — ' . site_nome();
$extraJs = 'assets/js/simulado.js';
require __DIR__ . '/includes/header.php';
?>
<div class="container simulado-layout">
    <div id="simulado-app"
         data-tentativa-id="<?= (int) $id ?>"
         data-token="<?= e($token) ?>"
         data-duracao="<?= $duracao ?>"
         data-csrf="<?= e(csrf_token()) ?>"
         data-save-url="<?= e(url('api/salvar_resposta.php')) ?>"
         data-finalizar-url="<?= e(url('simulado.php?id=' . $id)) ?>">
        <div class="simulado-top">
            <div>
                <div class="text-muted" style="font-size:.85rem;">Prova teórica · <?= $totalQ ?> questões · DETRAN-MG</div>
                <div id="sim-progress-label">Questão 1 de <?= $totalQ ?></div>
            </div>
            <div class="progress-bar" aria-hidden="true"><span id="sim-progress" style="width:0;"></span></div>
            <div class="timer" id="sim-timer" aria-live="polite">--:--</div>
        </div>

        <nav class="sim-map" id="sim-map" aria-label="Ir para questão">
            <?php foreach ($questoes as $i => $q): ?>
            <button type="button"
                    class="sim-map-btn"
                    data-goto="<?= $i ?>"
                    aria-label="Questão <?= $i + 1 ?>"
                    aria-current="<?= $i === 0 ? 'true' : 'false' ?>"><?= $i + 1 ?></button>
            <?php endforeach; ?>
        </nav>

        <?php foreach ($questoes as $i => $q): ?>
        <article class="questao-card" data-questao data-questao-id="<?= (int) $q['id'] ?>" <?= $i > 0 ? 'hidden' : '' ?>>
            <h2 class="questao-num">Questão <?= (int) $q['ordem'] ?> de <?= $totalQ ?></h2>
            <p class="questao-enunciado"><?= nl2br(e($q['enunciado'])) ?></p>
            <?php if (!empty($q['imagem'])): ?>
                <img class="questao-img" src="<?= e(url('uploads/' . $q['imagem'])) ?>" alt="Ilustração da questão" loading="lazy">
            <?php endif; ?>
            <ul class="alt-list">
                <?php foreach ($q['alternativas'] as $alt): ?>
                <li>
                    <label>
                        <input type="radio" name="alt_<?= (int) $q['id'] ?>" value="<?= (int) $alt['id'] ?>"
                            <?= (int) ($q['alternativa_id'] ?? 0) === (int) $alt['id'] ? 'checked' : '' ?>>
                        <span class="alt-text"><strong><?= e($alt['letra']) ?>)</strong> <?= e($alt['texto']) ?></span>
                    </label>
                </li>
                <?php endforeach; ?>
            </ul>
            <label class="revisao-flag">
                <input type="checkbox" data-revisao <?= !empty($q['marcada_revisao']) ? 'checked' : '' ?>>
                Marcar para revisão
            </label>
        </article>
        <?php endforeach; ?>

        <div class="sim-nav">
            <button type="button" class="btn btn-outline-dark" data-prev>Anterior</button>
            <button type="button" class="btn btn-outline-dark" data-next>Próxima</button>
            <button type="button" class="btn btn-primary" data-finalizar>Encerrar prova</button>
        </div>

        <form id="form-finalizar" method="post" class="sr-only">
            <?= csrf_field() ?>
            <input type="hidden" name="finalizar" value="1">
            <input type="hidden" name="tempo_utilizado" value="0">
            <input type="hidden" name="expirado" value="0">
        </form>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
