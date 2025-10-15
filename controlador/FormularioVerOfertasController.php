<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../index.php");
    exit();
}


if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once '../modelo/DAO/OfertaLaboralDAO.php';
$dao = new OfertaLaboralDAO();
$ofertas = $dao->obtenerPorEmpresa($_SESSION['usuario_id']); 

define('ACCESO_DESDE_CONTROLADOR', true);
require '../vista/empresa/ver_ofertaslaborales_empresa.php';
