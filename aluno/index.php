<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/aluno_stats.php';
require_instalado();
require_login();

$uid = auth_id();
$resumo = aluno_resumo($uid);
$painelCss = true;
$pageTitle = 'Minha área — ' . site_nome();
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php aluno_sidebar('index'); ?>
    <div class="painel-content">
        <h1>Olá, <?= e(auth_user()['nome'] ?? '') ?></h1>
        <div class="dash-cards">
            <div class="dash-card"><span class="text-muted">Simulados</span><strong><?= (int) $resumo['total_simulados'] ?></strong></div>
            <div class="dash-card"><span class="text-muted">Média</span><strong><?= $resumo['media'] !== null ? e((string) $resumo['media']) . '%' : '—' ?></strong></div>
        </div>
        <?php if ($resumo['melhor_categoria']): ?>
        <p>Melhor categoria: <strong><?= e($resumo['melhor_categoria']['nome']) ?></strong>
        <?php if ($resumo['pior_categoria'] && $resumo['pior_categoria']['nome'] !== $resumo['melhor_categoria']['nome']): ?>
         · Atenção em: <strong><?= e($resumo['pior_categoria']['nome']) ?></strong>
        <?php endif; ?>
        </p>
        <?php endif; ?>

        <?php if ($resumo['categorias']): ?>
        <h2>Desempenho por categoria</h2>
        <?php foreach ($resumo['categorias'] as $c): $pct = min(100, max(0, (float) $c['media'])); ?>
        <div class="chart-bar">
            <span style="min-width:140px;"><?= e($c['nome']) ?></span>
            <div class="chart-bar-track"><div class="chart-bar-fill" style="width:<?= $pct ?>%;"></div></div>
            <span><?= number_format($pct, 0) ?>%</span>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <p style="margin-top:1.5rem;">
            <a class="btn btn-primary" href="<?= e(url('estudo.php')) ?>">Modo estudo</a>
            <a class="btn btn-outline-dark" href="<?= e(url('simulados.php')) ?>">Simulado</a>
            <a class="btn btn-outline-dark" href="<?= e(url('aluno/historico.php')) ?>">Ver histórico</a>
        </p>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
