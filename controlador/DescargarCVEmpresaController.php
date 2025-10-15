<?php

session_start();


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../index.php");
    exit();
}


$idEmpresa = isset($_SESSION['usuario_id']) ? (int)$_SESSION['usuario_id'] : 0;
if ($idEmpresa <= 0) {
    http_response_code(403);
    exit('Empresa no autenticada.');
}

require_once '../modelo/DAO/PostulacionDAO.php';
require_once '../modelo/DAO/PersonaDAO.php';


$idPersona = isset($_GET['id_persona']) ? (int)$_GET['id_persona'] : 0;
$idOferta  = isset($_GET['id_oferta'])  ? (int)$_GET['id_oferta']  : 0;

if ($idPersona <= 0 || $idOferta <= 0) {
    http_response_code(400);
    exit('Parámetros inválidos.');
}

try {
    $postulacionDAO = new PostulacionDAO();
    $personaDAO     = new PersonaDAO();

    
    if (!$postulacionDAO->perteneceAOfertaDeEmpresa($idPersona, $idOferta, $idEmpresa)) {
        http_response_code(403);
        exit('No autorizado: la postulación no pertenece a una oferta de esta empresa.');
    }

   
    $cv = $personaDAO->obtenerCv($idPersona);
    if (!$cv) {
        http_response_code(404);
        exit('CV no encontrado.');
    }

   
    while (ob_get_level()) { ob_end_clean(); }
    ini_set('zlib.output_compression', 'Off');

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="cv_' . $idPersona . '.pdf"');
    header('Content-Length: ' . strlen($cv));
    echo $cv;
    exit;

} catch (Throwable $e) {
    
    http_response_code(500);
    exit('Error interno al procesar la descarga.');
}
