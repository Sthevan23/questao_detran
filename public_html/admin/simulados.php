<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_admin();

$pdo = db();
$categorias = $pdo->query('SELECT id, nome FROM categorias WHERE ativo = 1 ORDER BY ordem')->fetchAll();

if (is_post()) {
    csrf_verify();
    $id = (int) ($_POST['id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $tipo = $_POST['tipo'] === 'categoria' ? 'categoria' : 'geral';
    $catId = $tipo === 'categoria' ? (int) ($_POST['categoria_id'] ?? 0) : null;
    $qtd = max(5, min(100, (int) ($_POST['qtd_questoes'] ?? 30)));
    $dur = max(5, min(180, (int) ($_POST['duracao_minutos'] ?? 40)));
    $min = max(0, min(100, (int) ($_POST['pontuacao_minima'] ?? 70)));
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if ($nome === '') {
        flash('error', 'Nome obrigatório.');
    } elseif ($id) {
        $pdo->prepare('UPDATE simulados SET nome=?, tipo=?, categoria_id=?, qtd_questoes=?, duracao_minutos=?, pontuacao_minima=?, ativo=? WHERE id=?')
            ->execute([$nome, $tipo, $catId ?: null, $qtd, $dur, $min, $ativo, $id]);
        flash('success', 'Simulado atualizado.');
    } else {
        $pdo->prepare('INSERT INTO simulados (nome, tipo, categoria_id, qtd_questoes, duracao_minutos, pontuacao_minima, ativo) VALUES (?,?,?,?,?,?,?)')
            ->execute([$nome, $tipo, $catId ?: null, $qtd, $dur, $min, $ativo]);
        flash('success', 'Simulado criado.');
    }
    redirect(url('admin/simulados.php'));
}

$editId = (int) ($_GET['editar'] ?? 0);
$edit = null;
if ($editId) {
    $st = $pdo->prepare('SELECT * FROM simulados WHERE id = ?');
    $st->execute([$editId]);
    $edit = $st->fetch();
}
$rows = $pdo->query('SELECT s.*, c.nome AS categoria_nome FROM simulados s LEFT JOIN categorias c ON c.id = s.categoria_id ORDER BY s.id')->fetchAll();

$painelCss = true;
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php admin_sidebar('simulados'); ?>
    <div class="painel-content">
        <h1>Modalidades de simulado</h1>
        <form method="post" class="card" style="margin-bottom:1.5rem;">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
            <div class="form-group"><label>Nome</label><input name="nome" required value="<?= e($edit['nome'] ?? '') ?>"></div>
            <div class="form-group">
                <label>Tipo</label>
                <select name="tipo" id="tipo-sim">
                    <option value="geral" <?= ($edit['tipo'] ?? '') === 'geral' ? 'selected' : '' ?>>Geral</option>
                    <option value="categoria" <?= ($edit['tipo'] ?? '') === 'categoria' ? 'selected' : '' ?>>Por categoria</option>
                </select>
            </div>
            <div class="form-group">
                <label>Categoria (se por categoria)</label>
                <select name="categoria_id">
                    <option value="0">—</option>
                    <?php foreach ($categorias as $c): ?>
                    <option value="<?= (int) $c['id'] ?>" <?= (int) ($edit['categoria_id'] ?? 0) === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group"><label>Quantidade de questões</label><input type="number" name="qtd_questoes" value="<?= (int) ($edit['qtd_questoes'] ?? 30) ?>"></div>
            <div class="form-group"><label>Duração (minutos)</label><input type="number" name="duracao_minutos" value="<?= (int) ($edit['duracao_minutos'] ?? 40) ?>"></div>
            <div class="form-group"><label>Pontuação mínima (%)</label><input type="number" name="pontuacao_minima" value="<?= (int) ($edit['pontuacao_minima'] ?? 70) ?>"></div>
            <label><input type="checkbox" name="ativo" value="1" <?= ($edit['ativo'] ?? 1) ? 'checked' : '' ?>> Ativo</label>
            <p><button class="btn btn-primary">Salvar</button></p>
        </form>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Nome</th><th>Tipo</th><th>Questões</th><th>Tempo</th><th>Mínimo</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e($r['nome']) ?></td>
                    <td><?= $r['tipo'] === 'geral' ? 'Geral' : e($r['categoria_nome'] ?? 'Categoria') ?></td>
                    <td><?= (int) $r['qtd_questoes'] ?></td>
                    <td><?= (int) $r['duracao_minutos'] ?> min</td>
                    <td><?= (int) $r['pontuacao_minima'] ?>%</td>
                    <td><a href="?editar=<?= (int) $r['id'] ?>">Editar</a></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
