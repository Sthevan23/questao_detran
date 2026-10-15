<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/aluno_stats.php';
require_instalado();
require_login();

$rows = aluno_questoes_erradas(auth_id());
$painelCss = true;
$pageTitle = 'Questões erradas — ' . site_nome();
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php aluno_sidebar('erradas'); ?>
    <div class="painel-content">
        <h1>Questões respondidas incorretamente</h1>
        <p class="text-muted">Revise os temas abaixo e faça um simulado por categoria.</p>
        <?php if (!$rows): ?><p>Nenhum erro registrado — ótimo trabalho!</p><?php endif; ?>
        <?php foreach ($rows as $r): ?>
        <article class="card" style="margin-bottom:1rem;">
            <span class="badge badge-danger"><?= e($r['categoria']) ?></span>
            <p><?= nl2br(e($r['enunciado'])) ?></p>
        </article>
        <?php endforeach; ?>
        <a class="btn btn-primary" href="<?= e(url('simulados.php')) ?>">Novo simulado</a>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
