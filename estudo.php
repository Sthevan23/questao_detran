<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/estudo_service.php';
require_instalado();

$categoriaGet = $_GET['categoria'] ?? null;
$categoriaId = null;
if ($categoriaGet !== null && $categoriaGet !== '') {
    $categoriaId = (int) $categoriaGet;
    if ($categoriaId === 0) {
        $categoriaId = null;
    }
}
$reiniciar = isset($_GET['reiniciar']);

if (is_post() && ($_POST['acao'] ?? '') === 'proxima') {
    csrf_verify();
    estudo_avancar();
    redirect(url('estudo.php'));
}

if ($reiniciar || array_key_exists('categoria', $_GET)) {
    $ids = estudo_iniciar_fila($categoriaId);
    if (!$ids) {
        flash('error', 'Não há questões ativas nesta categoria. Importe seed_treinamento_mg.sql ou cadastre questões no admin.');
    }
} elseif (empty($_SESSION['estudo_fila'])) {
    $ids = estudo_iniciar_fila(null);
    if (!$ids) {
        flash('error', 'Não há questões de treinamento. Importe seed_treinamento_mg.sql pelo phpMyAdmin.');
    }
}

$fila = estudo_fila_atual();
$total = count($fila['fila']);
$indice = $fila['indice'];
$questaoId = estudo_proximo_id();

$pageTitle = 'Treinar — ' . site_nome();
$extraJs = 'assets/js/estudo.js';
require __DIR__ . '/includes/header.php';

$categorias = estudo_categorias_disponiveis();
?>
<div class="container simulado-layout">
    <div class="page-header">
        <h1>Treinar para a prova</h1>
        <p class="text-muted">Toque em uma alternativa — na hora você vê se acertou e a explicação.</p>
    </div>

    <?php if ($msg = flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>

    <form method="get" class="card card--soft estudo-filtro">
        <label for="categoria">Tema (opcional)</label>
        <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-top:.35rem;">
            <select name="categoria" id="categoria">
                <option value="">Todas as categorias</option>
                <?php foreach ($categorias as $c): ?>
                <option value="<?= (int) $c['id'] ?>" <?= (int) ($fila['categoria_id'] ?? 0) === (int) $c['id'] ? 'selected' : '' ?>>
                    <?= e($c['nome']) ?> (<?= (int) $c['total'] ?>)
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary">Carregar questões</button>
            <a class="btn btn-outline-dark" href="<?= e(url('estudo.php?reiniciar=1&categoria=' . (int) ($fila['categoria_id'] ?? 0))) ?>">Embaralhar de novo</a>
        </div>
    </form>

    <?php if (!$questaoId): ?>
        <div class="card">
            <p>Você concluiu todas as questões desta seleção.</p>
            <a class="btn btn-primary" href="<?= e(url('estudo.php?reiniciar=1&categoria=' . (int) ($fila['categoria_id'] ?? 0))) ?>">Recomeçar</a>
            <a class="btn btn-outline-dark" href="<?= e(url('simulados.php')) ?>">Ir para simulado</a>
        </div>
    <?php else:
        $q = estudo_questao_para_tela($questaoId);
        if (!$q):
    ?>
        <div class="alert alert-error">Questão indisponível.</div>
    <?php else: ?>
    <div id="estudo-app"
         data-questao-id="<?= (int) $q['id'] ?>"
         data-csrf="<?= e(csrf_token()) ?>"
         data-feedback-url="<?= e(url('api/estudo_feedback.php')) ?>">
        <div class="simulado-top">
            <span class="text-muted">Treinamento · <?= e($q['categoria']) ?></span>
            <span id="estudo-progress-label">Questão <?= $indice + 1 ?> de <?= $total ?></span>
        </div>

        <article class="questao-card">
            <span class="badge badge-info">Treinamento</span>
            <h2 class="questao-num">Questão <?= $indice + 1 ?> de <?= $total ?></h2>
            <p class="questao-enunciado"><?= nl2br(e($q['enunciado'])) ?></p>
            <?php if (!empty($q['imagem'])): ?>
                <img class="questao-img" src="<?= e(url('uploads/' . $q['imagem'])) ?>" alt="" loading="lazy">
            <?php endif; ?>
            <ul class="alt-list" id="estudo-alternativas">
                <?php foreach ($q['alternativas'] as $alt): ?>
                <li>
                    <label data-alt-id="<?= (int) $alt['id'] ?>">
                        <input type="radio" name="estudo_alt" value="<?= (int) $alt['id'] ?>">
                        <span class="alt-text"><strong><?= e($alt['letra']) ?>)</strong> <?= e($alt['texto']) ?></span>
                    </label>
                </li>
                <?php endforeach; ?>
            </ul>

            <div id="estudo-feedback" class="estudo-feedback" hidden></div>

            <form method="post" id="estudo-proxima-form" style="margin-top:1rem;" hidden>
                <?= csrf_field() ?>
                <input type="hidden" name="acao" value="proxima">
                <button type="submit" class="btn btn-primary">Próxima questão</button>
            </form>
        </article>
    </div>
    <?php endif; endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
