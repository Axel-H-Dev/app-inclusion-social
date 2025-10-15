<?php
session_start();


if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../../index.php");
    exit();
}

if (!isset($_SESSION['controller_token'])) {
    $_SESSION['controller_token'] = bin2hex(random_bytes(32));
}



require_once __DIR__ . '/../modelo/dao/UsuarioDAO.php';
require_once __DIR__ . '/../modelo/dao/EmpresaDAO.php';

$usuarioDAO = new UsuarioDAO();
$empresaDAO = new EmpresaDAO();

$usuario = $usuarioDAO->obtenerPorId($_SESSION['usuario_id']);
$empresa = $empresaDAO->obtenerPorId($_SESSION['usuario_id']);

if (!$usuario || !$empresa) {
    die("No se encontraron datos de la empresa.");
}


define('ACCESO_PERFIL_EMPRESA', true);


require_once __DIR__ . '/../vista/empresa/perfil.php';
