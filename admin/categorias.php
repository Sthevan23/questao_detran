<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_admin();

$pdo = db();
if (is_post()) {
    csrf_verify();
    $acao = $_POST['acao'] ?? '';
    if ($acao === 'salvar') {
        $id = (int) ($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $desc = trim($_POST['descricao'] ?? '');
        $ordem = (int) ($_POST['ordem'] ?? 0);
        $ativo = isset($_POST['ativo']) ? 1 : 0;
        $slug = slugify($nome);
        if ($nome === '') {
            flash('error', 'Nome obrigatório.');
        } elseif ($id) {
            $pdo->prepare('UPDATE categorias SET nome=?, slug=?, descricao=?, ordem=?, ativo=? WHERE id=?')->execute([$nome, $slug, $desc, $ordem, $ativo, $id]);
            flash('success', 'Categoria atualizada.');
        } else {
            $pdo->prepare('INSERT INTO categorias (nome, slug, descricao, ordem, ativo) VALUES (?,?,?,?,?)')->execute([$nome, $slug, $desc, $ordem, $ativo]);
            flash('success', 'Categoria criada.');
        }
    }
    redirect(url('admin/categorias.php'));
}

$editId = (int) ($_GET['editar'] ?? 0);
$edit = null;
if ($editId) {
    $st = $pdo->prepare('SELECT * FROM categorias WHERE id = ?');
    $st->execute([$editId]);
    $edit = $st->fetch();
}
$rows = $pdo->query('SELECT * FROM categorias ORDER BY ordem, nome')->fetchAll();

$painelCss = true;
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php admin_sidebar('categorias'); ?>
    <div class="painel-content">
        <h1>Categorias</h1>
        <form method="post" class="card" style="margin-bottom:1.5rem;">
            <?= csrf_field() ?>
            <input type="hidden" name="acao" value="salvar">
            <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
            <div class="form-group"><label>Nome</label><input name="nome" required value="<?= e($edit['nome'] ?? '') ?>"></div>
            <div class="form-group"><label>Descrição</label><textarea name="descricao" rows="2"><?= e($edit['descricao'] ?? '') ?></textarea></div>
            <div class="form-group"><label>Ordem</label><input type="number" name="ordem" value="<?= (int) ($edit['ordem'] ?? 0) ?>"></div>
            <label><input type="checkbox" name="ativo" value="1" <?= ($edit['ativo'] ?? 1) ? 'checked' : '' ?>> Ativa</label>
            <p><button class="btn btn-primary" type="submit">Salvar</button></p>
        </form>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Ordem</th><th>Nome</th><th>Slug</th><th>Status</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= (int) $r['ordem'] ?></td>
                    <td><?= e($r['nome']) ?></td>
                    <td><?= e($r['slug']) ?></td>
                    <td><?= $r['ativo'] ? 'Ativa' : 'Inativa' ?></td>
                    <td><a href="?editar=<?= (int) $r['id'] ?>">Editar</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
