<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_admin();

$pdo = db();
$stats = [
    'questoes' => (int) $pdo->query('SELECT COUNT(*) FROM questoes WHERE ativo = 1')->fetchColumn(),
    'alunos' => (int) $pdo->query('SELECT COUNT(*) FROM usuarios WHERE papel = "aluno"')->fetchColumn(),
    'tentativas' => (int) $pdo->query('SELECT COUNT(*) FROM tentativas WHERE status IN ("finalizado","expirado")')->fetchColumn(),
    'categorias' => (int) $pdo->query('SELECT COUNT(*) FROM categorias WHERE ativo = 1')->fetchColumn(),
];

$painelCss = true;
$pageTitle = 'Admin — ' . site_nome();
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php admin_sidebar('index'); ?>
    <div class="painel-content">
        <h1>Dashboard</h1>
        <div class="dash-cards">
            <?php foreach ($stats as $label => $val): ?>
            <div class="dash-card"><span class="text-muted"><?= e(ucfirst($label)) ?></span><strong><?= $val ?></strong></div>
            <?php endforeach; ?>
        </div>
        <p><a class="btn btn-primary" href="<?= e(url('admin/questoes.php?acao=nova')) ?>">Nova questão</a>
        <a class="btn btn-outline-dark" href="<?= e(url('admin/importar.php')) ?>">Importar CSV</a></p>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
