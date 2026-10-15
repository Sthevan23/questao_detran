<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_login();

$stmt = db()->prepare('SELECT t.*, s.nome AS simulado_nome FROM tentativas t INNER JOIN simulados s ON s.id = t.simulado_id WHERE t.usuario_id = ? AND t.status IN ("finalizado","expirado") ORDER BY t.finalizado_em DESC LIMIT 50');
$stmt->execute([auth_id()]);
$rows = $stmt->fetchAll();

$painelCss = true;
$pageTitle = 'Histórico — ' . site_nome();
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php aluno_sidebar('historico'); ?>
    <div class="painel-content">
        <h1>Histórico de simulados</h1>
        <?php if (!$rows): ?>
            <p class="text-muted">Nenhum simulado finalizado ainda.</p>
        <?php else: ?>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Data</th><th>Simulado</th><th>Nota</th><th>Status</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e(date('d/m/Y H:i', strtotime($r['finalizado_em']))) ?></td>
                    <td><?= e($r['simulado_nome']) ?></td>
                    <td><?= e(number_format((float) $r['percentual'], 1)) ?>%</td>
                    <td><?= $r['aprovado'] ? 'Aprovado' : 'Estudar mais' ?></td>
                    <td><a href="<?= e(url('resultado.php?id=' . (int) $r['id'])) ?>">Ver</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
