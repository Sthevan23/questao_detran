<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/upload.php';
require_instalado();
require_admin();

$pdo = db();
$acao = $_GET['acao'] ?? 'listar';
$id = (int) ($_GET['id'] ?? 0);
$erro = flash('error');
$ok = flash('success');
$categorias = $pdo->query('SELECT id, nome FROM categorias ORDER BY ordem')->fetchAll();

function salvar_questao(PDO $pdo, ?int $id, array $post, array $files): array
{
    $categoriaId = (int) ($post['categoria_id'] ?? 0);
    $enunciado = trim($post['enunciado'] ?? '');
    $explicacao = trim($post['explicacao'] ?? '');
    $referencia = trim($post['referencia'] ?? '');
    $dificuldade = $post['dificuldade'] ?? 'medio';
    $ativo = isset($post['ativo']) ? 1 : 0;
    $autoral = isset($post['autoral']) ? 1 : 0;
    $letras = ['A', 'B', 'C', 'D'];
    $textos = [];
    $correta = strtoupper(trim($post['correta'] ?? 'A'));
    foreach ($letras as $L) {
        $textos[$L] = trim($post['alt_' . $L] ?? '');
    }

    if ($categoriaId < 1 || $enunciado === '') {
        return ['ok' => false, 'msg' => 'Preencha categoria e enunciado.'];
    }
    if (!in_array($dificuldade, ['facil', 'medio', 'dificil'], true)) {
        $dificuldade = 'medio';
    }
    if (!in_array($correta, $letras, true)) {
        return ['ok' => false, 'msg' => 'Alternativa correta inválida.'];
    }
    foreach ($letras as $L) {
        if ($textos[$L] === '') {
            return ['ok' => false, 'msg' => 'Preencha as quatro alternativas.'];
        }
    }

    $imagem = null;
    if ($id) {
        $cur = $pdo->prepare('SELECT imagem FROM questoes WHERE id = ?');
        $cur->execute([$id]);
        $imagem = $cur->fetchColumn() ?: null;
    }
    $up = upload_imagem_questao($files['imagem'] ?? []);
    if (!$up['ok']) {
        return $up;
    }
    if ($up['filename']) {
        $imagem = $up['filename'];
    }

    $pdo->beginTransaction();
    try {
        if ($id) {
            $pdo->prepare('UPDATE questoes SET categoria_id=?, enunciado=?, imagem=?, dificuldade=?, explicacao=?, referencia=?, autoral=?, ativo=? WHERE id=?')
                ->execute([$categoriaId, $enunciado, $imagem, $dificuldade, $explicacao, $referencia, $autoral, $ativo, $id]);
            $pdo->prepare('DELETE FROM alternativas WHERE questao_id = ?')->execute([$id]);
            $qid = $id;
        } else {
            $pdo->prepare('INSERT INTO questoes (categoria_id, enunciado, imagem, dificuldade, explicacao, referencia, autoral, ativo) VALUES (?,?,?,?,?,?,?,?)')
                ->execute([$categoriaId, $enunciado, $imagem, $dificuldade, $explicacao, $referencia, $autoral, $ativo]);
            $qid = (int) $pdo->lastInsertId();
        }
        $ins = $pdo->prepare('INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (?,?,?,?)');
        foreach ($letras as $L) {
            $ins->execute([$qid, $L, $textos[$L], $L === $correta ? 1 : 0]);
        }
        $pdo->commit();
        return ['ok' => true, 'id' => $qid];
    } catch (Throwable $e) {
        $pdo->rollBack();
        return ['ok' => false, 'msg' => 'Erro ao salvar questão.'];
    }
}

if (is_post()) {
    csrf_verify();
    $postAcao = $_POST['acao'] ?? '';
    if ($postAcao === 'salvar') {
        $res = salvar_questao($pdo, $id ?: null, $_POST, $_FILES);
        if ($res['ok']) {
            flash('success', 'Questão salva.');
            redirect(url('admin/questoes.php'));
        }
        flash('error', $res['msg']);
        redirect(url('admin/questoes.php?acao=' . ($id ? 'editar&id=' . $id : 'nova')));
    }
    if ($postAcao === 'excluir' && $id) {
        $pdo->prepare('DELETE FROM questoes WHERE id = ?')->execute([$id]);
        flash('success', 'Questão excluída.');
        redirect(url('admin/questoes.php'));
    }
}

$busca = trim($_GET['q'] ?? '');
$catF = (int) ($_GET['cat'] ?? 0);
$page = max(1, (int) ($_GET['p'] ?? 1));
$porPagina = 20;

$questaoEdit = null;
$alts = [];
if ($acao === 'editar' && $id) {
    $st = $pdo->prepare('SELECT * FROM questoes WHERE id = ?');
    $st->execute([$id]);
    $questaoEdit = $st->fetch();
    if ($questaoEdit) {
        $alts = $pdo->prepare('SELECT * FROM alternativas WHERE questao_id = ? ORDER BY letra');
        $alts->execute([$id]);
        $alts = $alts->fetchAll();
    }
}

$painelCss = true;
$pageTitle = 'Questões — Admin';
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php admin_sidebar('questoes'); ?>
    <div class="painel-content">
        <?php if ($acao === 'nova' || ($acao === 'editar' && $questaoEdit)): ?>
            <h1><?= $questaoEdit ? 'Editar questão' : 'Nova questão' ?></h1>
            <?php if ($erro): ?><div class="alert alert-error"><?= e($erro) ?></div><?php endif; ?>
            <form method="post" enctype="multipart/form-data" class="card">
                <?= csrf_field() ?>
                <input type="hidden" name="acao" value="salvar">
                <div class="form-group">
                    <label>Categoria</label>
                    <select name="categoria_id" required>
                        <?php foreach ($categorias as $c): ?>
                        <option value="<?= (int) $c['id'] ?>" <?= (int) ($questaoEdit['categoria_id'] ?? 0) === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Enunciado</label>
                    <textarea name="enunciado" rows="4" required><?= e($questaoEdit['enunciado'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Imagem (opcional)</label>
                    <input type="file" name="imagem" accept="image/jpeg,image/png,image/webp">
                </div>
                <?php foreach (['A','B','C','D'] as $L):
                    $altRow = null;
                    foreach ($alts as $a) { if ($a['letra'] === $L) { $altRow = $a; break; } }
                    $corretaL = $altRow && $altRow['correta'] ? $L : null;
                ?>
                <div class="form-group">
                    <label>Alternativa <?= $L ?></label>
                    <input type="text" name="alt_<?= $L ?>" required value="<?= e($altRow['texto'] ?? '') ?>">
                </div>
                <?php endforeach; ?>
                <div class="form-group">
                    <label>Letra correta</label>
                    <select name="correta">
                        <?php
                        $corSel = 'A';
                        foreach ($alts as $a) { if ($a['correta']) { $corSel = $a['letra']; break; } }
                        foreach (['A','B','C','D'] as $L): ?>
                        <option value="<?= $L ?>" <?= $corSel === $L ? 'selected' : '' ?>><?= $L ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Dificuldade</label>
                    <select name="dificuldade">
                        <?php foreach (['facil','medio','dificil'] as $d): ?>
                        <option value="<?= $d ?>" <?= ($questaoEdit['dificuldade'] ?? 'medio') === $d ? 'selected' : '' ?>><?= ucfirst($d) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Explicação</label>
                    <textarea name="explicacao" rows="3"><?= e($questaoEdit['explicacao'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Referência / fonte</label>
                    <input type="text" name="referencia" value="<?= e($questaoEdit['referencia'] ?? '') ?>">
                </div>
                <label><input type="checkbox" name="autoral" value="1" <?= ($questaoEdit['autoral'] ?? 1) ? 'checked' : '' ?>> Questão autoral ou com uso autorizado</label><br>
                <label><input type="checkbox" name="ativo" value="1" <?= ($questaoEdit['ativo'] ?? 1) ? 'checked' : '' ?>> Ativa</label>
                <p style="margin-top:1rem;">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="<?= e(url('admin/questoes.php')) ?>" class="btn btn-outline-dark">Cancelar</a>
                </p>
            </form>
        <?php else: ?>
            <h1>Questões</h1>
            <?php if ($ok): ?><div class="alert alert-success"><?= e($ok) ?></div><?php endif; ?>
            <?php if ($erro): ?><div class="alert alert-error"><?= e($erro) ?></div><?php endif; ?>
            <div class="toolbar">
                <a class="btn btn-primary" href="<?= e(url('admin/questoes.php?acao=nova')) ?>">Nova</a>
                <form method="get">
                    <input type="search" name="q" placeholder="Buscar..." value="<?= e($busca) ?>">
                    <select name="cat">
                        <option value="0">Todas categorias</option>
                        <?php foreach ($categorias as $c): ?>
                        <option value="<?= (int) $c['id'] ?>" <?= $catF === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-outline-dark">Filtrar</button>
                </form>
            </div>
            <?php
            $where = 'WHERE 1=1';
            $params = [];
            if ($busca !== '') {
                $where .= ' AND q.enunciado LIKE ?';
                $params[] = '%' . $busca . '%';
            }
            if ($catF > 0) {
                $where .= ' AND q.categoria_id = ?';
                $params[] = $catF;
            }
            $countStmt = $pdo->prepare("SELECT COUNT(*) FROM questoes q $where");
            $countStmt->execute($params);
            $total = (int) $countStmt->fetchColumn();
            $offset = ($page - 1) * $porPagina;
            $sql = "SELECT q.id, q.enunciado, q.ativo, q.dificuldade, c.nome AS categoria FROM questoes q INNER JOIN categorias c ON c.id = q.categoria_id $where ORDER BY q.id DESC LIMIT $porPagina OFFSET $offset";
            $list = $pdo->prepare($sql);
            $list->execute($params);
            $rows = $list->fetchAll();
            ?>
            <div class="table-wrap">
                <table class="data-table">
                    <thead><tr><th>ID</th><th>Enunciado</th><th>Categoria</th><th>Status</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($rows as $r): ?>
                    <tr>
                        <td><?= (int) $r['id'] ?></td>
                        <td><?= e(mb_strimwidth($r['enunciado'], 0, 80, '…')) ?></td>
                        <td><?= e($r['categoria']) ?></td>
                        <td><?= $r['ativo'] ? 'Ativa' : 'Inativa' ?></td>
                        <td>
                            <a href="<?= e(url('admin/questoes.php?acao=editar&id=' . (int) $r['id'])) ?>">Editar</a>
                            <form method="post" style="display:inline;" onsubmit="return confirm('Excluir?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="acao" value="excluir">
                                <button type="submit" formaction="<?= e(url('admin/questoes.php?id=' . (int) $r['id'])) ?>">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php $pages = (int) ceil($total / $porPagina); if ($pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <?php if ($i === $page): ?><span class="current"><?= $i ?></span>
                    <?php else: ?><a href="?p=<?= $i ?>&q=<?= e(urlencode($busca)) ?>&cat=<?= $catF ?>"><?= $i ?></a><?php endif; ?>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
