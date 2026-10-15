<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_login();

$uid = auth_id();
if (is_post()) {
    csrf_verify();
    $qid = (int) ($_POST['questao_id'] ?? 0);
    $acao = $_POST['acao'] ?? '';
    if ($acao === 'remover') {
        db()->prepare('DELETE FROM favoritos WHERE usuario_id = ? AND questao_id = ?')->execute([$uid, $qid]);
    }
    redirect(url('aluno/favoritos.php'));
}

$stmt = db()->prepare('SELECT q.id, q.enunciado, c.nome AS categoria FROM favoritos f INNER JOIN questoes q ON q.id = f.questao_id INNER JOIN categorias c ON c.id = q.categoria_id WHERE f.usuario_id = ? ORDER BY f.criado_em DESC');
$stmt->execute([$uid]);
$rows = $stmt->fetchAll();

$painelCss = true;
$pageTitle = 'Favoritos — ' . site_nome();
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php aluno_sidebar('favoritos'); ?>
    <div class="painel-content">
        <h1>Questões favoritas</h1>
        <?php if (!$rows): ?><p class="text-muted">Nenhuma favorita ainda. Favorite questões ao revisar resultados (em breve no resultado).</p><?php endif; ?>
        <?php foreach ($rows as $r): ?>
        <article class="card" style="margin-bottom:1rem;">
            <span class="text-muted"><?= e($r['categoria']) ?></span>
            <p><?= e(mb_strimwidth($r['enunciado'], 0, 200, '…')) ?></p>
            <form method="post" style="display:inline;">
                <?= csrf_field() ?>
                <input type="hidden" name="questao_id" value="<?= (int) $r['id'] ?>">
                <input type="hidden" name="acao" value="remover">
                <button type="submit" class="btn btn-sm btn-outline-dark">Remover</button>
            </form>
        </article>
        <?php endforeach; ?>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
