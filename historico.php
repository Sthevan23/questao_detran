<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/simulado_service.php';
require_once __DIR__ . '/includes/historico_service.php';
require_instalado();

$painel = historico_painel();
$pageTitle = 'Meu progresso — ' . site_nome();
require __DIR__ . '/includes/header.php';
?>
<div class="container page-medium">
    <header class="page-header page-header--compact">
        <h1>Meu progresso</h1>
        <p class="text-muted">Histórico dos simulados neste aparelho — acertos, erros e o que vale estudar.</p>
    </header>

    <?php if (!$painel['tem_dados']): ?>
        <div class="card card--action">
            <p><?= e($painel['mensagem']) ?></p>
            <a class="btn btn-primary" href="<?= e(url('simulados.php')) ?>">Fazer um simulado</a>
        </div>
    <?php else:
        $t = $painel['totais'];
        $media = $t['provas'] > 0 ? round($t['acertos'] / $t['provas'], 1) : 0;
    ?>
        <div class="hist-stats">
            <div class="hist-stat">
                <span class="hist-stat-num"><?= (int) $t['provas'] ?></span>
                <span class="hist-stat-label">simulados feitos</span>
            </div>
            <div class="hist-stat hist-stat-ok">
                <span class="hist-stat-num"><?= (int) $t['acertos'] ?></span>
                <span class="hist-stat-label">acertos no total</span>
            </div>
            <div class="hist-stat hist-stat-bad">
                <span class="hist-stat-num"><?= (int) $t['erros'] ?></span>
                <span class="hist-stat-label">erros no total</span>
            </div>
            <div class="hist-stat">
                <span class="hist-stat-num"><?= e((string) $media) ?></span>
                <span class="hist-stat-label">média de acertos / prova</span>
            </div>
        </div>

        <article class="card hist-dica">
            <h2 style="margin-top:0;font-size:1.1rem;">O que fazer agora</h2>
            <p><?= e($painel['mensagem']) ?></p>
            <?php if ($painel['estudar_mais']): ?>
                <p><strong>Estudar mais:</strong></p>
                <ul class="hist-tema-list">
                    <?php foreach ($painel['estudar_mais'] as $cat): ?>
                    <li>
                        <?= e($cat['nome']) ?>
                        <span class="text-muted">(<?= (int) $cat['erros'] ?> erro<?= (int) $cat['erros'] === 1 ? '' : 's' ?> · <?= e((string) $cat['pct_acerto']) ?>% de acerto)</span>
                        <a class="btn btn-sm btn-primary" href="<?= e(url('estudo.php?categoria=' . (int) $cat['id'])) ?>">Treinar este tema</a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if ($painel['revisar']): ?>
                <p style="margin-top:1rem;"><strong>Revisar antes da prova:</strong></p>
                <ul class="hist-tema-list hist-tema-revisar">
                    <?php foreach ($painel['revisar'] as $cat): ?>
                    <li><?= e($cat['nome']) ?> — <?= (int) $cat['erros'] ?> questão<?= (int) $cat['erros'] === 1 ? '' : 'ões' ?> errada<?= (int) $cat['erros'] === 1 ? '' : 's' ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </article>

        <h2 class="section-title" style="font-size:1.2rem;margin-top:1.75rem;">Simulados anteriores</h2>
        <div class="hist-list">
            <?php foreach ($painel['simulados'] as $s):
                $total = (int) $s['qtd_acertos'] + (int) $s['qtd_erros'];
            ?>
            <a class="card hist-row" href="<?= e(url('resultado.php?id=' . (int) $s['id'])) ?>">
                <div>
                    <strong><?= e(date('d/m/Y H:i', strtotime((string) $s['finalizado_em']))) ?></strong>
                    <span class="text-muted"> · <?= e($s['simulado_nome']) ?></span>
                </div>
                <div class="hist-row-score">
                    <span><?= (int) $s['qtd_acertos'] ?> acertos · <?= (int) $s['qtd_erros'] ?> erros</span>
                    <span class="badge <?= (int) $s['aprovado'] ? 'badge-success' : 'badge-danger' ?>">
                        <?= (int) $s['aprovado'] ? 'Aprovado' : 'Reprovado' ?>
                    </span>
                </div>
                <span class="hist-row-detail"><?= (int) $s['qtd_acertos'] ?> de <?= $total ?> questões</span>
            </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <p class="page-links">
        <a href="<?= e(url('simulados.php')) ?>">Fazer novo simulado</a>
        ·
        <a href="<?= e(url('estudo.php')) ?>">Treinar questões</a>
    </p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
