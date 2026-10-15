<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/simulado_service.php';
require_once __DIR__ . '/includes/historico_service.php';
require_instalado();

$id = (int) ($_GET['id'] ?? 0);

$data = resultado_detalhado($id);
if (!$data) {
    flash('error', 'Resultado não disponível.');
    redirect(url('simulados.php'));
}

$t = $data['tentativa'];
$questoes = $data['questoes'];
$totalProva = count($questoes);
$minAcertos = prova_mg_acertos_minimos();
$refazerUrl = url('simulados.php');
historico_registrar_tentativa($id);
$dicas = historico_resumo_ultima_tentativa($id);

$pageTitle = 'Resultado — ' . site_nome();
require __DIR__ . '/includes/header.php';
?>
<div class="container simulado-layout">
    <div class="result-hero">
        <p class="text-muted">Resultado — prova teórica (simulado DETRAN-MG)</p>
        <div class="result-mg-score"><?= (int) $t['qtd_acertos'] ?> de <?= $totalProva ?></div>
        <p class="text-muted" style="margin:.25rem 0;">acertos na prova</p>
        <p class="result-mg-status <?= $t['aprovado'] ? 'aprovado' : 'reprovado' ?>">
            <?= $t['aprovado'] ? 'APROVADO' : 'REPROVADO' ?>
        </p>
        <p>
            Mínimo em MG: <strong><?= $minAcertos ?> acertos</strong> ·
            Erros: <strong><?= (int) $t['qtd_erros'] ?></strong> ·
            Tempo: <?= e(formatar_tempo((int) ($t['tempo_utilizado_seg'] ?? 0))) ?>
        </p>
        <p class="form-hint"><?= $t['aprovado']
            ? 'Parabéns! Você atingiu a nota mínima divulgada pelo Portal MG para a prova teórica.'
            : 'Estude as questões erradas abaixo e tente novamente. No dia da prova, são necessários pelo menos ' . $minAcertos . ' acertos.' ?></p>
        <div class="result-actions">
            <a class="btn btn-primary" href="<?= e($refazerUrl) ?>">Nova prova (outras <?= $totalProva ?> questões)</a>
            <?php
            $erradas = array_filter($questoes, fn($q) => !$q['acertou']);
            if ($erradas):
            ?>
            <a class="btn btn-outline-dark" href="#revisao-erros">Ver questões erradas</a>
            <?php endif; ?>
            <a class="btn btn-outline-dark" href="<?= e(url('historico.php')) ?>">Ver todo o progresso</a>
        </div>
    </div>

    <?php if ($dicas): ?>
    <article class="card hist-dica" style="margin-bottom:1.5rem;">
        <h2 style="margin-top:0;font-size:1.1rem;">O que estudar e revisar</h2>
        <p><?= e($dicas['mensagem']) ?></p>
        <?php if (!empty($dicas['estudar_mais'])): ?>
            <p><strong>Prioridade para treinar:</strong></p>
            <ul class="hist-tema-list">
                <?php foreach ($dicas['estudar_mais'] as $cat): ?>
                <li>
                    <?= e($cat['nome']) ?>
                    <a class="btn btn-sm btn-primary" href="<?= e(url('estudo.php?categoria=' . (int) $cat['id'])) ?>">Treinar</a>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if (!empty($dicas['revisar'])): ?>
            <p class="form-hint" style="margin-top:.75rem;">
                Revisar: <?= e(implode(', ', array_map(fn($c) => (string) $c['nome'], $dicas['revisar']))) ?>.
            </p>
        <?php endif; ?>
    </article>
    <?php endif; ?>

    <h2>Revisão das questões</h2>
    <?php foreach ($questoes as $q): ?>
    <article class="card review-item <?= $q['acertou'] ? 'correct' : 'wrong' ?>" <?= !$q['acertou'] ? 'id="revisao-erros"' : '' ?>>
        <span class="badge <?= $q['acertou'] ? 'badge-success' : 'badge-danger' ?>"><?= $q['acertou'] ? 'Acertou' : 'Errou' ?></span>
        <span class="text-muted"> · <?= e($q['categoria']) ?></span>
        <p style="margin:.75rem 0;"><?= nl2br(e($q['enunciado'])) ?></p>
        <ul class="alt-list" style="pointer-events:none;">
            <?php foreach ($q['alternativas'] as $alt):
                $classes = [];
                if ((int) $alt['correta'] === 1) $classes[] = 'border-success';
                if ((int) $q['escolhida_id'] === (int) $alt['id'] && !(int) $alt['correta']) $classes[] = 'border-danger';
            ?>
            <li>
                <label style="<?= (int) $alt['correta'] === 1 ? 'border-color:var(--success);background:#ecfdf5;' : '' ?><?= ((int) $q['escolhida_id'] === (int) $alt['id'] && !(int) $alt['correta']) ? 'border-color:var(--danger);background:#fef2f2;' : '' ?>">
                    <span><strong><?= e($alt['letra']) ?>)</strong> <?= e($alt['texto']) ?>
                    <?php if ((int) $q['escolhida_id'] === (int) $alt['id']): ?> <em>(sua resposta)</em><?php endif; ?>
                    </span>
                </label>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php if (!empty($q['explicacao'])): ?>
        <p><strong>Explicação:</strong> <?= nl2br(e($q['explicacao'])) ?></p>
        <?php endif; ?>
        <?php if (!empty($q['referencia'])): ?>
        <p class="form-hint">Referência: <?= e($q['referencia']) ?></p>
        <?php endif; ?>
    </article>
    <?php endforeach; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
