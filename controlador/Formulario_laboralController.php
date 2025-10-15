<?php
session_start();


if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../index.php");
    exit();
}


if (!isset($_SESSION['ajax_token'])) {
    $_SESSION['ajax_token'] = bin2hex(random_bytes(16));
}

require_once '../modelo/dao/ProvinciaDAO.php';
require_once '../modelo/dao/TipoDiscapacidadDAO.php';

$provincias = (new ProvinciaDAO())->obtenerTodas();
$discapacidades = (new TipoDiscapacidadDAO())->obtenerTodos();

define('ACCESO_DESDE_CONTROLADOR', true);
require '../vista/empresa/formulario_laboral_empresa.php';
