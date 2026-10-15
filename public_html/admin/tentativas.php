<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_admin();

$page = max(1, (int) ($_GET['p'] ?? 1));
$porPagina = 30;
$offset = ($page - 1) * $porPagina;
$pdo = db();
$rows = $pdo->query('SELECT t.id, t.percentual, t.finalizado_em, t.aprovado, u.nome AS aluno, s.nome AS simulado
    FROM tentativas t
    LEFT JOIN usuarios u ON u.id = t.usuario_id
    INNER JOIN simulados s ON s.id = t.simulado_id
    WHERE t.status IN ("finalizado","expirado")
    ORDER BY t.finalizado_em DESC
    LIMIT ' . $porPagina . ' OFFSET ' . $offset)->fetchAll();

$painelCss = true;
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php admin_sidebar('tentativas'); ?>
    <div class="painel-content">
        <h1>Histórico de simulados</h1>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Data</th><th>Aluno</th><th>Simulado</th><th>Nota</th></tr></thead>
                <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e($r['finalizado_em'] ? date('d/m/Y H:i', strtotime($r['finalizado_em'])) : '—') ?></td>
                    <td><?= e($r['aluno'] ?? 'Visitante') ?></td>
                    <td><?= e($r['simulado']) ?></td>
                    <td><?= e(number_format((float) $r['percentual'], 1)) ?>%</td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
