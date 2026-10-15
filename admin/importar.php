<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_instalado();
require_admin();

$pdo = db();
$categorias = $pdo->query('SELECT id, slug FROM categorias')->fetchAll();
$slugMap = [];
foreach ($categorias as $c) {
    $slugMap[$c['slug']] = (int) $c['id'];
}

$log = [];
if (is_post()) {
    csrf_verify();
    if (empty($_FILES['csv']['tmp_name'])) {
        flash('error', 'Selecione um arquivo CSV.');
        redirect(url('admin/importar.php'));
    }
    $fh = fopen($_FILES['csv']['tmp_name'], 'r');
    if (!$fh) {
        flash('error', 'Não foi possível ler o arquivo.');
        redirect(url('admin/importar.php'));
    }
    $header = fgetcsv($fh, 0, ';');
    if (!$header) {
        $header = fgetcsv($fh, 0, ',');
        rewind($fh);
        $header = fgetcsv($fh, 0, ',');
    }
    $linha = 1;
    while (($row = fgetcsv($fh, 0, ';')) !== false) {
        if (count($row) < 8) {
            $row = str_getcsv(implode(',', $row), ',');
        }
        $linha++;
        if (count($row) < 8) {
            $log[] = "Linha $linha: colunas insuficientes.";
            continue;
        }
        [$catSlug, $enunciado, $a, $b, $c, $d, $correta, $explicacao] = array_map('trim', $row);
        $catId = $slugMap[$catSlug] ?? 0;
        if (!$catId || $enunciado === '') {
            $log[] = "Linha $linha: categoria ou enunciado inválido.";
            continue;
        }
        $correta = strtoupper($correta);
        if (!in_array($correta, ['A','B','C','D'], true)) {
            $log[] = "Linha $linha: correta inválida.";
            continue;
        }
        try {
            $pdo->beginTransaction();
            $pdo->prepare('INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, autoral, ativo) VALUES (?,?, "medio", ?, 1, 1)')->execute([$catId, $enunciado, $explicacao]);
            $qid = (int) $pdo->lastInsertId();
            $ins = $pdo->prepare('INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (?,?,?,?)');
            foreach (['A' => $a, 'B' => $b, 'C' => $c, 'D' => $d] as $L => $txt) {
                $ins->execute([$qid, $L, $txt, $L === $correta ? 1 : 0]);
            }
            $pdo->commit();
            $log[] = "Linha $linha: importada (#$qid).";
        } catch (Throwable $e) {
            $pdo->rollBack();
            $log[] = "Linha $linha: erro ao importar.";
        }
    }
    fclose($fh);
}

$painelCss = true;
require dirname(__DIR__) . '/includes/header.php';
require dirname(__DIR__) . '/includes/admin_layout.php';
?>
<div class="container painel-layout">
    <?php admin_sidebar('importar'); ?>
    <div class="painel-content">
        <h1>Importar questões (CSV)</h1>
        <p class="text-muted">Colunas: <code>categoria_slug;enunciado;alt_a;alt_b;alt_c;alt_d;correta;explicacao</code> (separador <strong>;</strong> ou <strong>,</strong>)</p>
        <p>Slugs: <?= e(implode(', ', array_keys($slugMap))) ?></p>
        <form method="post" enctype="multipart/form-data" class="card">
            <?= csrf_field() ?>
            <input type="file" name="csv" accept=".csv,text/csv" required>
            <p><button type="submit" class="btn btn-primary">Importar</button></p>
        </form>
        <?php if ($log): ?>
        <pre class="card" style="white-space:pre-wrap;margin-top:1rem;"><?= e(implode("\n", $log)) ?></pre>
        <?php endif; ?>
    </div>
</div>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
