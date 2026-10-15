<?php
/**
 * Carga idempotente de 100 questões de treinamento (DETRAN-MG).
 * Uso: php scripts/carga_100_questoes.php
 */
declare(strict_types=1);

define('APP_ROOT', dirname(__DIR__) . '/public_html');
require APP_ROOT . '/includes/database.php';

$jsonPath = __DIR__ . '/questoes_100.json';
if (!is_readable($jsonPath)) {
    fwrite(STDERR, "Arquivo não encontrado: {$jsonPath}\n");
    exit(1);
}

$questoes = json_decode(file_get_contents($jsonPath), true, 512, JSON_THROW_ON_ERROR);
if (!is_array($questoes) || count($questoes) !== 100) {
    fwrite(STDERR, 'JSON deve conter exatamente 100 questões. Encontradas: ' . (is_array($questoes) ? count($questoes) : 0) . "\n");
    exit(1);
}

try {
    $pdo = db();
} catch (Throwable $e) {
    fwrite(STDERR, 'Falha ao conectar MySQL: ' . $e->getMessage() . "\n");
    fwrite(STDERR, "Importe seed_100_questoes_mg.sql pelo phpMyAdmin.\n");
    exit(1);
}

$slugMap = [];
foreach ($pdo->query('SELECT slug, id FROM categorias') as $row) {
    $slugMap[$row['slug']] = (int) $row['id'];
}

$checkDup = $pdo->prepare('SELECT id FROM questoes WHERE enunciado = ? LIMIT 1');
$insQ = $pdo->prepare(
    'INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo)
     VALUES (?, ?, ?, ?, ?, 1, 1)'
);
$insA = $pdo->prepare(
    'INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES (?, ?, ?, ?)'
);

$inseridas = 0;
$ignoradas = 0;
$erros = [];

$pdo->beginTransaction();
try {
    foreach ($questoes as $i => $q) {
        $slug = $q['categoria_slug'] ?? '';
        if (!isset($slugMap[$slug])) {
            $erros[] = 'Linha ' . ($i + 1) . ": categoria inválida {$slug}";
            continue;
        }
        $enunciado = trim($q['enunciado'] ?? '');
        if ($enunciado === '') {
            $erros[] = 'Linha ' . ($i + 1) . ': enunciado vazio';
            continue;
        }
        $checkDup->execute([$enunciado]);
        if ($checkDup->fetch()) {
            $ignoradas++;
            continue;
        }
        $dif = $q['dificuldade'] ?? 'medio';
        if (!in_array($dif, ['facil', 'medio', 'dificil'], true)) {
            $dif = 'medio';
        }
        $alts = $q['alternativas'] ?? [];
        $correta = strtoupper($q['correta'] ?? 'A');
        if (!in_array($correta, ['A', 'B', 'C', 'D'], true)) {
            $erros[] = 'Linha ' . ($i + 1) . ': gabarito inválido';
            continue;
        }
        foreach (['A', 'B', 'C', 'D'] as $L) {
            if (trim($alts[$L] ?? '') === '') {
                $erros[] = 'Linha ' . ($i + 1) . ": alternativa {$L} vazia";
                continue 2;
            }
        }
        $insQ->execute([
            $slugMap[$slug],
            $enunciado,
            $dif,
            trim($q['explicacao'] ?? ''),
            trim($q['referencia'] ?? 'Questão de treinamento autoral. Base: CTB (Lei 9.503/1997).'),
        ]);
        $qid = (int) $pdo->lastInsertId();
        foreach (['A', 'B', 'C', 'D'] as $L) {
            $insA->execute([$qid, $L, trim($alts[$L]), $L === $correta ? 1 : 0]);
        }
        $inseridas++;
    }
    $pdo->commit();
} catch (Throwable $e) {
    $pdo->rollBack();
    fwrite(STDERR, 'Erro na transação: ' . $e->getMessage() . "\n");
    exit(1);
}

echo "=== Carga concluída ===\n";
echo "Inseridas: {$inseridas}\n";
echo "Ignoradas (duplicadas): {$ignoradas}\n";
if ($erros) {
    echo "Avisos:\n" . implode("\n", $erros) . "\n";
}

echo "\n=== Por categoria ===\n";
$rows = $pdo->query(
    'SELECT c.nome, COUNT(q.id) AS total FROM categorias c
     LEFT JOIN questoes q ON q.categoria_id = c.id AND q.ativo = 1
     GROUP BY c.id ORDER BY c.ordem'
)->fetchAll();
foreach ($rows as $r) {
    echo $r['nome'] . ': ' . $r['total'] . "\n";
}

echo "\n=== Validação ===\n";
$total = (int) $pdo->query('SELECT COUNT(*) FROM questoes WHERE ativo = 1')->fetchColumn();
echo "Total questões ativas: {$total}\n";

$badAlt = (int) $pdo->query(
    'SELECT COUNT(*) FROM (
        SELECT questao_id FROM alternativas GROUP BY questao_id HAVING COUNT(*) <> 4
     ) t'
)->fetchColumn();
echo "Questões sem 4 alternativas: {$badAlt}\n";

$badCor = (int) $pdo->query(
    'SELECT COUNT(*) FROM (
        SELECT questao_id FROM alternativas GROUP BY questao_id HAVING SUM(correta) <> 1
     ) t'
)->fetchColumn();
echo "Questões sem exatamente 1 correta: {$badCor}\n";

$semExp = (int) $pdo->query(
    'SELECT COUNT(*) FROM questoes WHERE ativo = 1 AND (explicacao IS NULL OR TRIM(explicacao) = "")'
)->fetchColumn();
echo "Questões sem explicação: {$semExp}\n";

$sorteio = (int) $pdo->query('SELECT COUNT(*) FROM questoes WHERE ativo = 1 ORDER BY RAND() LIMIT 30')->fetchColumn();
echo "Sorteio simulado (30): {$sorteio} questões disponíveis\n";

exit($badAlt || $badCor ? 1 : 0);
