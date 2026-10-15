<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_instalado();

$stmt = db()->query('SELECT c.*, (SELECT COUNT(*) FROM questoes q WHERE q.categoria_id = c.id AND q.ativo = 1) AS total_questoes FROM categorias c WHERE c.ativo = 1 ORDER BY c.ordem');
$cats = $stmt->fetchAll();

$pageTitle = 'Categorias — ' . site_nome();
require __DIR__ . '/includes/header.php';
?>
<div class="container page-header">
    <h1>Categorias de estudo</h1>
    <p class="text-muted">Use o modo estudo para ver a explicação após cada resposta ou faça um simulado cronometrado.</p>
</div>
<div class="container card-grid">
    <?php foreach ($cats as $c): ?>
    <article class="card">
        <div class="card-icon">📖</div>
        <h3><?= e($c['nome']) ?></h3>
        <p><?= e($c['descricao'] ?? '') ?></p>
        <p class="text-muted"><?= (int) $c['total_questoes'] ?> questões ativas</p>
        <a class="btn btn-primary btn-sm" href="<?= e(url('estudo.php?categoria=' . (int) $c['id'])) ?>">Modo estudo</a>
        <a class="btn btn-outline-dark btn-sm" href="<?= e(url('simulados.php?categoria=' . (int) $c['id'])) ?>">Simulado</a>
    </article>
    <?php endforeach; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
