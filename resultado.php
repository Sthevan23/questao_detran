<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/simulado_service.php';
require_instalado();

$id = (int) ($_GET['id'] ?? 0);

if (is_post() && ($_POST['acao'] ?? '') === 'favorito' && auth_check()) {
    csrf_verify();
    $qid = (int) ($_POST['questao_id'] ?? 0);
    if ($qid) {
        $chk = db()->prepare('SELECT 1 FROM favoritos WHERE usuario_id = ? AND questao_id = ?');
        $chk->execute([auth_id(), $qid]);
        if ($chk->fetch()) {
            db()->prepare('DELETE FROM favoritos WHERE usuario_id = ? AND questao_id = ?')->execute([auth_id(), $qid]);
        } else {
            db()->prepare('INSERT INTO favoritos (usuario_id, questao_id) VALUES (?, ?)')->execute([auth_id(), $qid]);
        }
    }
    redirect(url('resultado.php?id=' . $id));
}

$favIds = [];
if (auth_check()) {
    $fs = db()->prepare('SELECT questao_id FROM favoritos WHERE usuario_id = ?');
    $fs->execute([auth_id()]);
    foreach ($fs->fetchAll() as $f) {
        $favIds[(int) $f['questao_id']] = true;
    }
}
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
        <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-top:1rem;">
            <a class="btn btn-primary" href="<?= e($refazerUrl) ?>">Nova prova (outras <?= $totalProva ?> questões)</a>
            <?php
            $erradas = array_filter($questoes, fn($q) => !$q['acertou']);
            if ($erradas):
            ?>
            <a class="btn btn-outline-dark" href="#revisao-erros">Ver questões erradas</a>
            <?php endif; ?>
        </div>
    </div>

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
        <?php if (auth_check()): ?>
        <form method="post" style="margin-top:.5rem;">
            <?= csrf_field() ?>
            <input type="hidden" name="acao" value="favorito">
            <input type="hidden" name="questao_id" value="<?= (int) $q['id'] ?>">
            <button type="submit" class="btn btn-sm btn-outline-dark"><?= isset($favIds[(int) $q['id']]) ? 'Remover dos favoritos' : 'Favoritar questão' ?></button>
        </form>
        <?php endif; ?>
    </article>
    <?php endforeach; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
