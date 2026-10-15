<?php
declare(strict_types=1);

function historico_registrar_tentativa(int $tentativaId): void
{
    if ($tentativaId < 1) {
        return;
    }
    $lista = $_SESSION['historico_tentativas'] ?? [];
    if (!is_array($lista)) {
        $lista = [];
    }
    $lista = array_values(array_filter(array_map('intval', $lista), fn($id) => $id !== $tentativaId));
    array_unshift($lista, $tentativaId);
    $_SESSION['historico_tentativas'] = array_slice($lista, 0, 40);
}

function historico_tentativa_ids(): array
{
    $lista = $_SESSION['historico_tentativas'] ?? [];
    if (!is_array($lista)) {
        return [];
    }

    return array_values(array_filter(array_map('intval', $lista), fn($id) => $id > 0));
}

function historico_painel(): array
{
    $ids = historico_tentativa_ids();
    $vazio = [
        'tem_dados' => false,
        'simulados' => [],
        'totais' => [
            'provas' => 0,
            'acertos' => 0,
            'erros' => 0,
            'aprovacoes' => 0,
        ],
        'categorias' => [],
        'estudar_mais' => [],
        'revisar' => [],
        'mensagem' => 'Faça pelo menos um simulado completo para ver aqui quantas questões você acertou e o que vale revisar.',
    ];
    if (!$ids) {
        return $vazio;
    }

    $in = implode(',', $ids);
    $pdo = db();
    $simulados = $pdo->query(
        'SELECT t.id, t.finalizado_em, t.qtd_acertos, t.qtd_erros, t.aprovado, t.percentual, s.nome AS simulado_nome
         FROM tentativas t
         INNER JOIN simulados s ON s.id = t.simulado_id
         WHERE t.id IN (' . $in . ') AND t.status IN ("finalizado", "expirado")
         ORDER BY t.finalizado_em DESC'
    )->fetchAll();

    if (!$simulados) {
        return $vazio;
    }

    $totais = [
        'provas' => count($simulados),
        'acertos' => 0,
        'erros' => 0,
        'aprovacoes' => 0,
    ];
    foreach ($simulados as $s) {
        $totais['acertos'] += (int) $s['qtd_acertos'];
        $totais['erros'] += (int) $s['qtd_erros'];
        if ((int) $s['aprovado'] === 1) {
            $totais['aprovacoes']++;
        }
    }

    $catSql = 'SELECT c.id, c.nome, c.slug,
            SUM(CASE WHEN a.correta = 1 THEN 1 ELSE 0 END) AS acertos,
            SUM(CASE WHEN rt.alternativa_id IS NULL OR IFNULL(a.correta, 0) = 0 THEN 1 ELSE 0 END) AS erros,
            COUNT(*) AS total
        FROM tentativas t
        INNER JOIN respostas_tentativas rt ON rt.tentativa_id = t.id
        INNER JOIN questoes q ON q.id = rt.questao_id
        INNER JOIN categorias c ON c.id = q.categoria_id
        LEFT JOIN alternativas a ON a.id = rt.alternativa_id
        WHERE t.id IN (' . $in . ') AND t.status IN ("finalizado", "expirado")
        GROUP BY c.id, c.nome, c.slug
        ORDER BY (SUM(CASE WHEN a.correta = 1 THEN 1 ELSE 0 END) / COUNT(*)) ASC, erros DESC';
    $categorias = $pdo->query($catSql)->fetchAll();

    foreach ($categorias as &$c) {
        $total = max(1, (int) $c['total']);
        $c['pct_acerto'] = round(((int) $c['acertos'] / $total) * 100, 1);
    }
    unset($c);

    $minAcertos = prova_mg_acertos_minimos();
    $analise = historico_montar_mensagens($categorias, $totais, $minAcertos);

    return [
        'tem_dados' => true,
        'simulados' => $simulados,
        'totais' => $totais,
        'categorias' => $categorias,
        'estudar_mais' => $analise['estudar_mais'],
        'revisar' => $analise['revisar'],
        'mensagem' => $analise['mensagem'],
        'min_acertos' => $minAcertos,
    ];
}

/** @param array<int, array<string, mixed>> $categorias */
function historico_montar_mensagens(array $categorias, array $totais, int $minAcertos): array
{
    $estudar = [];
    $revisar = [];
    foreach ($categorias as $c) {
        $pct = (float) $c['pct_acerto'];
        $erros = (int) $c['erros'];
        if ($pct < 70 || $erros >= 3) {
            $estudar[] = $c;
        }
        if ($erros >= 2) {
            $revisar[] = $c;
        }
    }

    $estudar = array_slice($estudar, 0, 4);
    $revisar = array_slice($revisar, 0, 4);

    $provas = (int) $totais['provas'];
    $aprov = (int) $totais['aprovacoes'];
    $mediaAcertos = $provas > 0 ? round($totais['acertos'] / $provas, 1) : 0;

    if (!$categorias) {
        $msg = 'Continue fazendo simulados para descobrir em quais temas você precisa reforçar.';
    } elseif ($aprov >= $provas && $provas >= 2) {
        $msg = 'Parabéns! Você foi aprovada nos simulados recentes. Mesmo assim, revise os temas abaixo para fixar na prova real.';
    } elseif ($mediaAcertos >= $minAcertos) {
        $msg = 'Sua média de acertos está boa (' . $mediaAcertos . ' por prova). Foque nos temas mais fracos abaixo para passar com folga.';
    } else {
        $msg = 'Para a prova do DETRAN-MG você precisa de pelo menos ' . $minAcertos . ' acertos em 30 questões. '
            . 'Sua média recente é ' . $mediaAcertos . ' — estude mais os assuntos indicados e treine questão por questão antes do próximo simulado.';
    }

    return [
        'estudar_mais' => $estudar,
        'revisar' => $revisar,
        'mensagem' => $msg,
    ];
}

function historico_resumo_ultima_tentativa(int $tentativaId): ?array
{
    if (!in_array($tentativaId, historico_tentativa_ids(), true)) {
        $chk = db()->prepare('SELECT 1 FROM tentativas WHERE id = ? AND status IN ("finalizado","expirado")');
        $chk->execute([$tentativaId]);
        if (!$chk->fetch()) {
            return null;
        }
        historico_registrar_tentativa($tentativaId);
    }

    $ids = [(int) $tentativaId];
    $in = (string) (int) $tentativaId;
    $pdo = db();
    $catSql = 'SELECT c.id, c.nome, c.slug,
            SUM(CASE WHEN a.correta = 1 THEN 1 ELSE 0 END) AS acertos,
            SUM(CASE WHEN rt.alternativa_id IS NULL OR IFNULL(a.correta, 0) = 0 THEN 1 ELSE 0 END) AS erros,
            COUNT(*) AS total
        FROM tentativas t
        INNER JOIN respostas_tentativas rt ON rt.tentativa_id = t.id
        INNER JOIN questoes q ON q.id = rt.questao_id
        INNER JOIN categorias c ON c.id = q.categoria_id
        LEFT JOIN alternativas a ON a.id = rt.alternativa_id
        WHERE t.id IN (' . $in . ') AND t.status IN ("finalizado", "expirado")
        GROUP BY c.id, c.nome, c.slug
        ORDER BY erros DESC, acertos ASC';
    $categorias = $pdo->query($catSql)->fetchAll();
    foreach ($categorias as &$c) {
        $total = max(1, (int) $c['total']);
        $c['pct_acerto'] = round(((int) $c['acertos'] / $total) * 100, 1);
    }
    unset($c);

    $totais = ['provas' => 1, 'acertos' => 0, 'erros' => 0, 'aprovacoes' => 0];
    $t = db()->prepare('SELECT qtd_acertos, qtd_erros, aprovado FROM tentativas WHERE id = ?');
    $t->execute([$tentativaId]);
    $row = $t->fetch();
    if (!$row) {
        return null;
    }
    $totais['acertos'] = (int) $row['qtd_acertos'];
    $totais['erros'] = (int) $row['qtd_erros'];
    if ((int) $row['aprovado'] === 1) {
        $totais['aprovacoes'] = 1;
    }

    return historico_montar_mensagens($categorias, $totais, prova_mg_acertos_minimos());
}
