<?php
declare(strict_types=1);

function simulado_por_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT s.*, c.nome AS categoria_nome FROM simulados s LEFT JOIN categorias c ON c.id = s.categoria_id WHERE s.id = ? AND s.ativo = 1');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function simulados_listar(): array
{
    return db()->query('SELECT s.*, c.nome AS categoria_nome, c.slug AS categoria_slug FROM simulados s LEFT JOIN categorias c ON c.id = s.categoria_id WHERE s.ativo = 1 ORDER BY s.tipo, s.nome')->fetchAll();
}

function simulado_garantir_por_categoria(int $categoriaId): ?array
{
    $stmt = db()->prepare('SELECT * FROM simulados WHERE tipo = "categoria" AND categoria_id = ? AND ativo = 1 LIMIT 1');
    $stmt->execute([$categoriaId]);
    $row = $stmt->fetch();
    if ($row) {
        return $row;
    }
    $cat = db()->prepare('SELECT nome FROM categorias WHERE id = ? AND ativo = 1');
    $cat->execute([$categoriaId]);
    $c = $cat->fetch();
    if (!$c) {
        return null;
    }
    $ins = db()->prepare('INSERT INTO simulados (nome, tipo, categoria_id, qtd_questoes, duracao_minutos, pontuacao_minima, ativo) VALUES (?, "categoria", ?, 20, 30, 70, 1)');
    $ins->execute(['Simulado: ' . $c['nome'], $categoriaId]);
    return simulado_por_id((int) db()->lastInsertId());
}

function prova_mg_acertos_minimos(): int
{
    return max(1, (int) (config_get('mg_acertos_minimos', '20') ?? 20));
}

function prova_mg_qtd_questoes(): int
{
    return max(1, (int) (config_get('mg_qtd_questoes', '30') ?? 30));
}

function prova_mg_duracao_minutos(): int
{
    return max(1, (int) (config_get('mg_duracao_minutos', '40') ?? 40));
}

/** Evita repetir as mesmas questões do simulado anterior neste navegador. */
function prova_questoes_excluir_sorteio(): array
{
    $excluir = [];
    $historico = $_SESSION['ultimas_provas_questoes'] ?? [];
    if (!is_array($historico)) {
        return [];
    }
    foreach (array_slice($historico, 0, 2) as $lote) {
        if (is_array($lote)) {
            foreach ($lote as $id) {
                $excluir[(int) $id] = (int) $id;
            }
        }
    }

    return array_values($excluir);
}

function prova_registrar_questoes_sorteadas(array $questaoIds): void
{
    $ids = array_values(array_map('intval', $questaoIds));
    if (!$ids) {
        return;
    }
    $hist = $_SESSION['ultimas_provas_questoes'] ?? [];
    if (!is_array($hist)) {
        $hist = [];
    }
    array_unshift($hist, $ids);
    $_SESSION['ultimas_provas_questoes'] = array_slice($hist, 0, 3);
}

/** Aprovação conforme Portal MG: 20 acertos em 30 questões (prova teórica). */
function prova_mg_aprovado(int $acertos, int $total, array $simulado): bool
{
    if ($simulado['tipo'] === 'geral') {
        return $acertos >= prova_mg_acertos_minimos();
    }
    $min = (float) ($simulado['pontuacao_minima'] ?? 70);
    return $total > 0 && round(($acertos / $total) * 100, 2) >= $min;
}

function simulado_prova_geral(): ?array
{
    $stmt = db()->query('SELECT * FROM simulados WHERE tipo = "geral" AND ativo = 1 ORDER BY id ASC LIMIT 1');
    $row = $stmt->fetch();
    if (!$row) {
        return null;
    }
    $qtd = prova_mg_qtd_questoes();
    $dur = prova_mg_duracao_minutos();
    if ((int) $row['qtd_questoes'] !== $qtd || (int) $row['duracao_minutos'] !== $dur) {
        db()->prepare('UPDATE simulados SET qtd_questoes = ?, duracao_minutos = ? WHERE id = ?')
            ->execute([$qtd, $dur, (int) $row['id']]);
        $row['qtd_questoes'] = $qtd;
        $row['duracao_minutos'] = $dur;
    }

    return $row;
}

/**
 * Sorteio equilibrado entre categorias (como conteúdo programático misto na prova real).
 */
function sortear_prova_mg_equilibrada(int $qtd, array $excluirIds = []): array
{
    $pdo = db();
    $cats = $pdo->query('SELECT id FROM categorias WHERE ativo = 1 ORDER BY ordem')->fetchAll(PDO::FETCH_COLUMN);
    $n = count($cats);
    if ($n === 0) {
        return [];
    }

    $ids = [];
    $usados = array_values(array_unique(array_map('intval', $excluirIds)));
    $base = intdiv($qtd, $n);
    $extra = $qtd % $n;
    shuffle($cats);

    foreach ($cats as $i => $catId) {
        $need = $base + ($i < $extra ? 1 : 0);
        if ($need < 1) {
            continue;
        }
        $notIn = $usados ? implode(',', array_map('intval', $usados)) : '0';
        $sql = 'SELECT id FROM questoes WHERE ativo = 1 AND categoria_id = ? AND id NOT IN (' . $notIn . ') ORDER BY RAND() LIMIT ' . (int) $need;
        $stmt = $pdo->prepare($sql);
        $stmt->execute([(int) $catId]);
        foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $qid) {
            $qid = (int) $qid;
            $ids[] = $qid;
            $usados[] = $qid;
        }
    }

    while (count($ids) < $qtd) {
        $notIn = $usados ? implode(',', array_map('intval', $usados)) : '0';
        $row = $pdo->query('SELECT id FROM questoes WHERE ativo = 1 AND id NOT IN (' . $notIn . ') ORDER BY RAND() LIMIT 1')->fetch();
        if (!$row) {
            break;
        }
        $qid = (int) $row['id'];
        $ids[] = $qid;
        $usados[] = $qid;
    }

    shuffle($ids);
    return array_slice($ids, 0, $qtd);
}

function sortear_questoes(array $simulado, array $excluirIds = []): array
{
    $qtd = (int) $simulado['qtd_questoes'];
    if ($simulado['tipo'] === 'geral') {
        $qtd = prova_mg_qtd_questoes();
    }
    $pdo = db();
    $excluir = array_values(array_unique(array_map('intval', $excluirIds)));
    $notInExcluir = $excluir ? ' AND id NOT IN (' . implode(',', $excluir) . ')' : '';

    if ($simulado['tipo'] === 'categoria' && !empty($simulado['categoria_id'])) {
        $sql = 'SELECT id FROM questoes WHERE ativo = 1 AND categoria_id = ?' . $notInExcluir . ' ORDER BY RAND() LIMIT ' . (int) $qtd;
        $stmt = $pdo->prepare($sql);
        $stmt->execute([(int) $simulado['categoria_id']]);
        $ids = array_column($stmt->fetchAll(), 'id');
        if (count($ids) < $qtd && $excluir) {
            return sortear_questoes($simulado, []);
        }

        return array_map('intval', $ids);
    }

    if ($simulado['tipo'] === 'geral') {
        $ids = sortear_prova_mg_equilibrada($qtd, $excluir);
        if (count($ids) < $qtd && $excluir) {
            return sortear_prova_mg_equilibrada($qtd, []);
        }

        return $ids;
    }

    $sql = 'SELECT id FROM questoes WHERE ativo = 1' . $notInExcluir . ' ORDER BY RAND() LIMIT ' . (int) $qtd;
    $ids = array_column($pdo->query($sql)->fetchAll(), 'id');
    if (count($ids) < $qtd && $excluir) {
        return sortear_questoes($simulado, []);
    }

    return array_map('intval', $ids);
}

function iniciar_tentativa(int $simuladoId, ?int $usuarioId): array
{
    $sim = simulado_por_id($simuladoId);
    if (!$sim) {
        return ['ok' => false, 'msg' => 'Simulado não encontrado.'];
    }

    if ($sim['tipo'] === 'geral') {
        $sim['qtd_questoes'] = prova_mg_qtd_questoes();
        $sim['duracao_minutos'] = prova_mg_duracao_minutos();
    }

    $excluir = $sim['tipo'] === 'geral' ? prova_questoes_excluir_sorteio() : [];
    $questoes = sortear_questoes($sim, $excluir);
    $esperado = (int) $sim['qtd_questoes'];
    if (count($questoes) < 1) {
        return ['ok' => false, 'msg' => 'Não há questões cadastradas. Importe seed_100_questoes_mg.sql no phpMyAdmin.'];
    }
    if ($sim['tipo'] === 'geral' && count($questoes) < $esperado) {
        return ['ok' => false, 'msg' => 'Cadastre pelo menos ' . $esperado . ' questões para simular a prova completa de MG.'];
    }

    $token = bin2hex(random_bytes(16));
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $ins = $pdo->prepare('INSERT INTO tentativas (usuario_id, simulado_id, categoria_id, status, token_sessao) VALUES (?, ?, ?, "em_andamento", ?)');
        $ins->execute([
            $usuarioId,
            $simuladoId,
            $sim['categoria_id'] ?: null,
            $token,
        ]);
        $tentativaId = (int) $pdo->lastInsertId();

        $ordem = 1;
        $iq = $pdo->prepare('INSERT INTO tentativa_questoes (tentativa_id, questao_id, ordem) VALUES (?, ?, ?)');
        $ir = $pdo->prepare('INSERT INTO respostas_tentativas (tentativa_id, questao_id) VALUES (?, ?)');
        foreach ($questoes as $qid) {
            $iq->execute([$tentativaId, $qid, $ordem++]);
            $ir->execute([$tentativaId, $qid]);
        }
        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        return ['ok' => false, 'msg' => 'Erro ao iniciar simulado.'];
    }

    if ($sim['tipo'] === 'geral') {
        prova_registrar_questoes_sorteadas($questoes);
    }

    return [
        'ok' => true,
        'tentativa_id' => $tentativaId,
        'token' => $token,
        'duracao_seg' => (int) $sim['duracao_minutos'] * 60,
        'qtd' => count($questoes),
    ];
}

function tentativa_carregar(int $id, ?string $token = null): ?array
{
    $stmt = db()->prepare('SELECT t.*, s.nome AS simulado_nome, s.duracao_minutos, s.pontuacao_minima, s.qtd_questoes FROM tentativas t INNER JOIN simulados s ON s.id = t.simulado_id WHERE t.id = ? LIMIT 1');
    $stmt->execute([$id]);
    $t = $stmt->fetch();
    if (!$t) {
        return null;
    }
    if ($token !== null && !hash_equals((string) ($t['token_sessao'] ?? ''), $token)) {
        return null;
    }
    $uid = auth_id();
    if ($t['usuario_id'] && $uid && (int) $t['usuario_id'] !== $uid) {
        return null;
    }
    return $t;
}

function tentativa_questoes_com_alternativas(int $tentativaId): array
{
    $sql = 'SELECT tq.ordem, q.id, q.enunciado, q.imagem, q.categoria_id,
            rt.alternativa_id, rt.marcada_revisao
            FROM tentativa_questoes tq
            INNER JOIN questoes q ON q.id = tq.questao_id
            LEFT JOIN respostas_tentativas rt ON rt.tentativa_id = tq.tentativa_id AND rt.questao_id = q.id
            WHERE tq.tentativa_id = ?
            ORDER BY tq.ordem';
    $stmt = db()->prepare($sql);
    $stmt->execute([$tentativaId]);
    $questoes = $stmt->fetchAll();

    $altStmt = db()->prepare('SELECT id, letra, texto FROM alternativas WHERE questao_id = ? ORDER BY letra');
    foreach ($questoes as &$q) {
        $altStmt->execute([(int) $q['id']]);
        $q['alternativas'] = $altStmt->fetchAll();
    }
    unset($q);
    return $questoes;
}

function salvar_resposta_tentativa(int $tentativaId, int $questaoId, ?int $alternativaId, bool $revisao): bool
{
    $t = tentativa_carregar($tentativaId, $_SESSION['tentativa_token'] ?? null);
    if (!$t || $t['status'] !== 'em_andamento') {
        return false;
    }

    $chk = db()->prepare('SELECT 1 FROM tentativa_questoes WHERE tentativa_id = ? AND questao_id = ?');
    $chk->execute([$tentativaId, $questaoId]);
    if (!$chk->fetch()) {
        return false;
    }

    if ($alternativaId) {
        $v = db()->prepare('SELECT 1 FROM alternativas WHERE id = ? AND questao_id = ?');
        $v->execute([$alternativaId, $questaoId]);
        if (!$v->fetch()) {
            return false;
        }
    }

    $sql = 'UPDATE respostas_tentativas SET alternativa_id = ?, marcada_revisao = ?, respondido_em = CASE WHEN ? IS NOT NULL THEN NOW() ELSE respondido_em END WHERE tentativa_id = ? AND questao_id = ?';
    $stmt = db()->prepare($sql);
    $stmt->execute([$alternativaId, $revisao ? 1 : 0, $alternativaId, $tentativaId, $questaoId]);
    return true;
}

function finalizar_tentativa(int $tentativaId, int $tempoUtilizadoSeg, bool $expirado = false): array
{
    $t = tentativa_carregar($tentativaId, $_SESSION['tentativa_token'] ?? null);
    if (!$t || $t['status'] !== 'em_andamento') {
        return ['ok' => false, 'msg' => 'Tentativa inválida ou já finalizada.'];
    }

    $pdo = db();
    $sql = 'SELECT rt.questao_id, rt.alternativa_id, a.correta
            FROM respostas_tentativas rt
            LEFT JOIN alternativas a ON a.id = rt.alternativa_id
            WHERE rt.tentativa_id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tentativaId]);
    $rows = $stmt->fetchAll();

    $total = count($rows);
    $acertos = 0;
    foreach ($rows as $r) {
        if ((int) ($r['correta'] ?? 0) === 1) {
            $acertos++;
        }
    }
    $erros = $total - $acertos;
    $pct = $total > 0 ? round(($acertos / $total) * 100, 2) : 0;
    $simRow = simulado_por_id((int) $t['simulado_id']) ?? ['tipo' => 'geral', 'qtd_questoes' => $total, 'pontuacao_minima' => 70];
    $aprovado = prova_mg_aprovado($acertos, $total, $simRow) ? 1 : 0;
    $status = $expirado ? 'expirado' : 'finalizado';

    $upd = $pdo->prepare('UPDATE tentativas SET status = ?, finalizado_em = NOW(), tempo_utilizado_seg = ?, qtd_acertos = ?, qtd_erros = ?, percentual = ?, aprovado = ? WHERE id = ?');
    $upd->execute([$status, $tempoUtilizadoSeg, $acertos, $erros, $pct, $aprovado, $tentativaId]);

    unset($_SESSION['tentativa_id'], $_SESSION['tentativa_token']);

    require_once __DIR__ . '/historico_service.php';
    historico_registrar_tentativa($tentativaId);

    return [
        'ok' => true,
        'acertos' => $acertos,
        'erros' => $erros,
        'percentual' => $pct,
        'aprovado' => (bool) $aprovado,
    ];
}

function resultado_detalhado(int $tentativaId): ?array
{
    $t = tentativa_carregar($tentativaId);
    if (!$t || !in_array($t['status'], ['finalizado', 'expirado'], true)) {
        return null;
    }
    $uid = auth_id();
    if ($t['usuario_id'] && (!$uid || (int) $t['usuario_id'] !== $uid)) {
        if (!auth_is_admin()) {
            return null;
        }
    }

    $sql = 'SELECT q.id, q.enunciado, q.imagem, q.explicacao, q.referencia, c.nome AS categoria,
            rt.alternativa_id AS escolhida_id,
            (SELECT a2.id FROM alternativas a2 WHERE a2.questao_id = q.id AND a2.correta = 1 LIMIT 1) AS correta_id
            FROM tentativa_questoes tq
            INNER JOIN questoes q ON q.id = tq.questao_id
            INNER JOIN categorias c ON c.id = q.categoria_id
            INNER JOIN respostas_tentativas rt ON rt.tentativa_id = tq.tentativa_id AND rt.questao_id = q.id
            WHERE tq.tentativa_id = ?
            ORDER BY tq.ordem';
    $stmt = db()->prepare($sql);
    $stmt->execute([$tentativaId]);
    $questoes = $stmt->fetchAll();

    $altStmt = db()->prepare('SELECT id, letra, texto, correta FROM alternativas WHERE questao_id = ? ORDER BY letra');
    foreach ($questoes as &$q) {
        $altStmt->execute([(int) $q['id']]);
        $q['alternativas'] = $altStmt->fetchAll();
        $q['acertou'] = (int) $q['escolhida_id'] === (int) $q['correta_id'] && $q['escolhida_id'] !== null;
    }
    unset($q);

    return ['tentativa' => $t, 'questoes' => $questoes];
}

function estatisticas_publicas(): array
{
    $pdo = db();
    $questoes = (int) $pdo->query('SELECT COUNT(*) FROM questoes WHERE ativo = 1')->fetchColumn();
    $tentativas = (int) $pdo->query('SELECT COUNT(*) FROM tentativas WHERE status IN ("finalizado","expirado")')->fetchColumn();
    $alunos = (int) $pdo->query('SELECT COUNT(*) FROM usuarios WHERE papel = "aluno" AND ativo = 1')->fetchColumn();
    return [
        'questoes' => $questoes,
        'tentativas' => $tentativas,
        'alunos' => $alunos,
        'mostrar' => $questoes > 0 && ($tentativas > 0 || $alunos > 0),
    ];
}
