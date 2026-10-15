<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/simulado_service.php';
require_instalado();

header('Content-Type: application/json; charset=utf-8');

if (!is_post()) {
    http_response_code(405);
    echo json_encode(['ok' => false]);
    exit;
}

csrf_verify();

$tentativaId = (int) ($_POST['tentativa_id'] ?? 0);
$token = (string) ($_POST['token'] ?? '');
if ($token !== '' && isset($_SESSION['tentativa_token']) && hash_equals($_SESSION['tentativa_token'], $token)) {
    // ok
} elseif ($tentativaId !== (int) ($_SESSION['tentativa_id'] ?? 0)) {
    http_response_code(403);
    echo json_encode(['ok' => false]);
    exit;
}

$questaoId = (int) ($_POST['questao_id'] ?? 0);
$altRaw = $_POST['alternativa_id'] ?? '';
$alternativaId = $altRaw === '' || $altRaw === null ? null : (int) $altRaw;
$revisao = ($_POST['revisao'] ?? '0') === '1';

$ok = salvar_resposta_tentativa($tentativaId, $questaoId, $alternativaId, $revisao);
echo json_encode(['ok' => $ok]);
