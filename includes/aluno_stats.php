<?php
declare(strict_types=1);

function aluno_resumo(int $usuarioId): array
{
    $pdo = db();
    $stmt = $pdo->prepare('SELECT COUNT(*) AS total, AVG(percentual) AS media, SUM(qtd_acertos) AS acertos, SUM(qtd_erros) AS erros FROM tentativas WHERE usuario_id = ? AND status IN ("finalizado","expirado")');
    $stmt->execute([$usuarioId]);
    $r = $stmt->fetch() ?: [];

    $hist = $pdo->prepare('SELECT id, percentual, qtd_acertos, qtd_erros, finalizado_em, aprovado FROM tentativas WHERE usuario_id = ? AND status IN ("finalizado","expirado") ORDER BY finalizado_em DESC LIMIT 10');
    $hist->execute([$usuarioId]);

    $catSql = 'SELECT c.nome, AVG(CASE WHEN a.correta = 1 THEN 100 ELSE 0 END) AS media
        FROM tentativas t
        INNER JOIN respostas_tentativas rt ON rt.tentativa_id = t.id
        INNER JOIN questoes q ON q.id = rt.questao_id
        INNER JOIN categorias c ON c.id = q.categoria_id
        LEFT JOIN alternativas a ON a.id = rt.alternativa_id
        WHERE t.usuario_id = ? AND t.status IN ("finalizado","expirado")
        GROUP BY c.id ORDER BY media DESC';
    $catStmt = $pdo->prepare($catSql);
    $catStmt->execute([$usuarioId]);
    $cats = $catStmt->fetchAll();

    return [
        'total_simulados' => (int) ($r['total'] ?? 0),
        'media' => $r['media'] !== null ? round((float) $r['media'], 1) : null,
        'historico' => $hist->fetchAll(),
        'categorias' => $cats,
        'melhor_categoria' => $cats[0] ?? null,
        'pior_categoria' => $cats ? $cats[count($cats) - 1] : null,
    ];
}

function aluno_questoes_erradas(int $usuarioId, int $limit = 50): array
{
    $sql = 'SELECT DISTINCT q.id, q.enunciado, c.nome AS categoria
            FROM tentativas t
            INNER JOIN respostas_tentativas rt ON rt.tentativa_id = t.id
            INNER JOIN questoes q ON q.id = rt.questao_id
            INNER JOIN categorias c ON c.id = q.categoria_id
            LEFT JOIN alternativas a ON a.id = rt.alternativa_id
            WHERE t.usuario_id = ? AND t.status IN ("finalizado","expirado")
              AND (a.correta IS NULL OR a.correta = 0)
            ORDER BY t.finalizado_em DESC
            LIMIT ' . (int) $limit;
    $stmt = db()->prepare($sql);
    $stmt->execute([$usuarioId]);
    return $stmt->fetchAll();
}
