<?php
declare(strict_types=1);

$path = __DIR__ . '/questoes_100.json';
$data = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
$slugs = ['legislacao', 'placas', 'direcao-defensiva', 'primeiros-socorros', 'meio-ambiente', 'mecanica', 'infracoes', 'circulacao'];
$porCat = array_fill_keys($slugs, 0);
$enunciados = [];
$ok = true;

foreach ($data as $i => $q) {
    $n = $i + 1;
    $slug = $q['categoria_slug'] ?? '';
    if (!in_array($slug, $slugs, true)) {
        echo "Erro #{$n}: slug inválido\n";
        $ok = false;
    } else {
        $porCat[$slug]++;
    }
    $e = trim($q['enunciado'] ?? '');
    if ($e === '') {
        echo "Erro #{$n}: enunciado vazio\n";
        $ok = false;
    }
    if (isset($enunciados[$e])) {
        echo "Erro #{$n}: enunciado duplicado no JSON\n";
        $ok = false;
    }
    $enunciados[$e] = true;
    if (trim($q['explicacao'] ?? '') === '') {
        echo "Erro #{$n}: sem explicação\n";
        $ok = false;
    }
    $c = strtoupper($q['correta'] ?? '');
    if (!in_array($c, ['A', 'B', 'C', 'D'], true)) {
        echo "Erro #{$n}: gabarito inválido\n";
        $ok = false;
    }
    foreach (['A', 'B', 'C', 'D'] as $L) {
        if (trim($q['alternativas'][$L] ?? '') === '') {
            echo "Erro #{$n}: alternativa {$L} vazia\n";
            $ok = false;
        }
    }
    if (stripos($q['referencia'] ?? '', 'treinamento') === false) {
        echo "Aviso #{$n}: referência sem menção a treinamento autoral\n";
    }
}

echo 'Total JSON: ' . count($data) . "\n";
echo "Por categoria (slug):\n";
foreach ($porCat as $s => $c) {
    echo "  {$s}: {$c}\n";
}
echo $ok ? "Validação JSON: OK\n" : "Validação JSON: FALHOU\n";
exit($ok ? 0 : 1);
