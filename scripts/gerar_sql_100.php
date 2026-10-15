<?php
/**
 * Gera seed_100_questoes_mg.sql a partir de questoes_100.json (importação phpMyAdmin).
 * Uso: php scripts/gerar_sql_100.php
 */
declare(strict_types=1);

$jsonPath = __DIR__ . '/questoes_100.json';
$outPath = dirname(__DIR__) . '/seed_100_questoes_mg.sql';
$questoes = json_decode(file_get_contents($jsonPath), true, 512, JSON_THROW_ON_ERROR);

$slugToId = [
    'legislacao' => 1,
    'placas' => 2,
    'direcao-defensiva' => 3,
    'primeiros-socorros' => 4,
    'meio-ambiente' => 5,
    'mecanica' => 6,
    'infracoes' => 7,
    'circulacao' => 8,
];

$ref = 'Questão de treinamento autoral. Base: CTB (Lei 9.503/1997) e normas CONTRAN. Estudo DETRAN-MG. Não é questão oficial de prova.';

$sql = "-- 100 questões de treinamento DETRAN-MG (gerado de scripts/questoes_100.json)\n";
$sql .= "-- Importe pelo phpMyAdmin. Duplicatas: use scripts/carga_100_questoes.php para carga idempotente.\n\n";
$sql .= "USE `aprova_cnh`;\n\n";
$sql .= "SET @ref = " . sqlQuote($ref) . ";\n\n";

foreach ($questoes as $q) {
    $cat = $slugToId[$q['categoria_slug']] ?? 0;
    if (!$cat) {
        continue;
    }
    $dif = in_array($q['dificuldade'], ['facil', 'medio', 'dificil'], true) ? $q['dificuldade'] : 'medio';
    $sql .= "INSERT INTO questoes (categoria_id, enunciado, dificuldade, explicacao, referencia, autoral, ativo) VALUES\n";
    $sql .= '(' . $cat . ', ' . sqlQuote($q['enunciado']) . ', ' . sqlQuote($dif) . ', '
        . sqlQuote($q['explicacao']) . ', '
        . sqlQuote($q['referencia'] ?? $ref) . ", 1, 1);\n";
    $sql .= "SET @q = LAST_INSERT_ID();\n";
    $parts = [];
    foreach (['A', 'B', 'C', 'D'] as $L) {
        $parts[] = "(@q,'{$L}'," . sqlQuote($q['alternativas'][$L]) . ',' . ($L === $q['correta'] ? '1' : '0') . ')';
    }
    $sql .= 'INSERT INTO alternativas (questao_id, letra, texto, correta) VALUES ' . implode(',', $parts) . ";\n\n";
}

file_put_contents($outPath, $sql);
echo "Gerado: {$outPath} (" . count($questoes) . " questões)\n";

function sqlQuote(string $s): string
{
    return "'" . str_replace(["\\", "'"], ["\\\\", "\\'"], $s) . "'";
}
