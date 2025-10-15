<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit();
}


if (!isset($_GET['token']) || $_GET['token'] !== ($_SESSION['ajax_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['error' => 'Token inválido']);
    exit();
}

header('Content-Type: application/json');
require_once '../modelo/dao/LocalidadDAO.php';

if (!empty($_GET['provincia_id'])) {
    $dao = new LocalidadDAO();
    $localidades = $dao->obtenerPorProvincia($_GET['provincia_id']);
    $out = [];

    foreach ($localidades as $loc) {
        $out[] = [
            'id_localidad' => $loc->getIdLocalidad(),
            'nombre' => $loc->getNombre()
        ];
    }
    echo json_encode($out);
    exit();
}


echo json_encode([]);
exit();
