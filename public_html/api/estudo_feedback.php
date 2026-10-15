<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/bootstrap.php';
require_once dirname(__DIR__) . '/includes/estudo_service.php';
require_instalado();

header('Content-Type: application/json; charset=utf-8');

if (!is_post()) {
    http_response_code(405);
    echo json_encode(['ok' => false]);
    exit;
}

csrf_verify();

$questaoId = (int) ($_POST['questao_id'] ?? 0);
$alternativaId = (int) ($_POST['alternativa_id'] ?? 0);

$res = estudo_avaliar($questaoId, $alternativaId);
echo json_encode($res, JSON_UNESCAPED_UNICODE);
