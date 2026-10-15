<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_admin();

$pdo = db();
$page = max(1, (int) ($_GET['p'] ?? 1));
$porPagina = 25;
$offset = ($page - 1) * $porPagina;
$total = (int) $pdo->query('SELECT COUNT(*) FROM usuarios WHERE papel = "aluno"')->fetchColumn();
$stmt = $pdo->query('SELECT id, nome, email, ativo, criado_em FROM usuarios WHERE papel = "aluno" ORDER BY criado_em DESC LIMIT ' . $porPagina . ' OFFSET ' . $offset);
$rows = $stmt->fetchAll();

if (is_post()) {
    csrf_verify();
    $id = (int) ($_POST['id'] ?? 0);
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $pdo->prepare('UPDATE usuarios SET ativo = ? WHERE id = ? AND papel = "aluno"')->execute([$ativo, $id]);
    flash('success', 'Aluno atualizado.');
    redirect(url('admin/usuarios.php'));
}

$painelCss = true;
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php admin_sidebar('usuarios'); ?>
    <div class="painel-content">
        <h1>Alunos cadastrados</h1>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Nome</th><th>E-mail</th><th>Cadastro</th><th>Status</th><th>Ação</th></tr></thead>
                <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e($r['nome']) ?></td>
                    <td><?= e($r['email']) ?></td>
                    <td><?= e(date('d/m/Y', strtotime($r['criado_em']))) ?></td>
                    <td><?= $r['ativo'] ? 'Ativo' : 'Inativo' ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                            <?php if ($r['ativo']): ?>
                                <button type="submit">Desativar</button>
                            <?php else: ?>
                                <input type="hidden" name="ativo" value="1">
                                <button type="submit">Ativar</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
