<?php
declare(strict_types=1);

/** Referência padrão exibida nas questões de treinamento importadas para MG. */
function estudo_ref_padrao_mg(): string
{
    return 'Questão de treinamento autoral. Base legal: CTB (Lei nº 9.503/1997) e normas do CONTRAN. '
        . 'Conteúdo alinhado ao exame teórico de habilitação em Minas Gerais (DETRAN-MG). '
        . 'Não é questão oficial de prova anterior.';
}

function estudo_categorias_disponiveis(): array
{
    $sql = 'SELECT c.id, c.nome, c.slug, c.descricao,
            (SELECT COUNT(*) FROM questoes q WHERE q.categoria_id = c.id AND q.ativo = 1) AS total
            FROM categorias c WHERE c.ativo = 1 ORDER BY c.ordem';
    return db()->query($sql)->fetchAll();
}

function estudo_iniciar_fila(?int $categoriaId): array
{
    $params = [];
    $where = 'WHERE q.ativo = 1';
    if ($categoriaId) {
        $where .= ' AND q.categoria_id = ?';
        $params[] = $categoriaId;
    }
    $sql = "SELECT q.id FROM questoes q $where ORDER BY RAND()";
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $ids = array_map('intval', array_column($stmt->fetchAll(), 'id'));

    $_SESSION['estudo_fila'] = $ids;
    $_SESSION['estudo_indice'] = 0;
    $_SESSION['estudo_categoria_id'] = $categoriaId;

    return $ids;
}

function estudo_fila_atual(): array
{
    return [
        'fila' => $_SESSION['estudo_fila'] ?? [],
        'indice' => (int) ($_SESSION['estudo_indice'] ?? 0),
        'categoria_id' => $_SESSION['estudo_categoria_id'] ?? null,
    ];
}

function estudo_proximo_id(): ?int
{
    $fila = $_SESSION['estudo_fila'] ?? [];
    $i = (int) ($_SESSION['estudo_indice'] ?? 0);
    return $fila[$i] ?? null;
}

function estudo_avancar(): ?int
{
    $_SESSION['estudo_indice'] = (int) ($_SESSION['estudo_indice'] ?? 0) + 1;
    return estudo_proximo_id();
}

function estudo_questao_para_tela(int $questaoId): ?array
{
    $stmt = db()->prepare('SELECT q.id, q.enunciado, q.imagem, q.referencia, c.nome AS categoria
        FROM questoes q INNER JOIN categorias c ON c.id = q.categoria_id
        WHERE q.id = ? AND q.ativo = 1 LIMIT 1');
    $stmt->execute([$questaoId]);
    $q = $stmt->fetch();
    if (!$q) {
        return null;
    }

    $alt = db()->prepare('SELECT id, letra, texto FROM alternativas WHERE questao_id = ? ORDER BY letra');
    $alt->execute([$questaoId]);
    $q['alternativas'] = $alt->fetchAll();
    return $q;
}

function estudo_avaliar(int $questaoId, int $alternativaId): array
{
    $stmt = db()->prepare('SELECT q.id, q.explicacao, q.referencia FROM questoes q WHERE q.id = ? AND q.ativo = 1');
    $stmt->execute([$questaoId]);
    $q = $stmt->fetch();
    if (!$q) {
        return ['ok' => false, 'msg' => 'Questão não encontrada.'];
    }

    $altStmt = db()->prepare('SELECT id, letra, texto, correta FROM alternativas WHERE questao_id = ? ORDER BY letra');
    $altStmt->execute([$questaoId]);
    $alternativas = $altStmt->fetchAll();

    $escolhida = null;
    $correta = null;
    foreach ($alternativas as $a) {
        if ((int) $a['id'] === $alternativaId) {
            $escolhida = $a;
        }
        if ((int) $a['correta'] === 1) {
            $correta = $a;
        }
    }

    if (!$escolhida || !$correta) {
        return ['ok' => false, 'msg' => 'Alternativa inválida.'];
    }

    $acertou = (int) $escolhida['id'] === (int) $correta['id'];

    return [
        'ok' => true,
        'acertou' => $acertou,
        'letra_correta' => $correta['letra'],
        'texto_correto' => $correta['texto'],
        'letra_escolhida' => $escolhida['letra'],
        'explicacao' => $q['explicacao'] ?: 'Revise o tema no CTB e no material do curso teórico.',
        'referencia' => $q['referencia'] ?: estudo_ref_padrao_mg(),
    ];
}
