<?php
session_start();
define('ACCESO_DESDE_CONTROLADOR', true);


if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'Empresa') {
    header("Location: ../index.php");
    exit();
}

require_once '../modelo/DAO/PostulacionDAO.php';
require_once '../modelo/DAO/OfertaLaboralDAO.php';

$idEmpresa = (int)$_SESSION['usuario_id'];
if ($idEmpresa <= 0) {
    http_response_code(403);
    exit('No autorizado');
}

$daoPost   = new PostulacionDAO();
$daoOferta = new OfertaLaboralDAO();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'cambiar_estado') {

    $idPostulacion = (int)($_POST['id_postulacion'] ?? 0);
    $idOferta      = (int)($_POST['id_oferta'] ?? 0);
    $estado        = $_POST['estado'] ?? 'pendiente';

    $validos = ['pendiente','en revisión','aceptado','rechazado'];
    if (!in_array($estado, $validos, true)) {
        $estado = 'pendiente';
    }

    if ($idPostulacion > 0 && $idOferta > 0) {
        $daoPost->cambiarEstado($idPostulacion, $estado, $idEmpresa);
    }

    header("Location: empresaPostulacionesController.php?id_oferta=" . $idOferta);
    exit;
}


$idOferta = isset($_GET['id_oferta']) ? (int)$_GET['id_oferta'] : 0;
$postulaciones = [];
$tituloOferta  = '';

if ($idOferta > 0) {
  
    if (!$daoOferta->perteneceAEmpresa($idOferta, $idEmpresa)) {
        http_response_code(404);
        exit('No encontrado');
    }

  
    $postulaciones = $daoPost->obtenerPorOfertaYEmpresa($idOferta, $idEmpresa);

    $oferta = $daoOferta->obtenerPorId($idOferta, $idEmpresa); 
    $tituloOferta = $oferta['titulo'] ?? '(Sin postulaciones por el momento)';
}

include '../vista/Empresa/ver_postulaciones_oferta.php';
