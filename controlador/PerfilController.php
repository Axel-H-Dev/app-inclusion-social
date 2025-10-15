<?php

session_start();
if (!defined('ACCESO_PERMITIDO')) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso directo no permitido.");
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

require_once __DIR__ . '/../modelo/DAO/UsuarioDAO.php';
require_once __DIR__ . '/../modelo/DAO/PersonaDAO.php';

$usuarioDAO = new UsuarioDAO();
$personaDAO = new PersonaDAO();

$usuario = $usuarioDAO->obtenerPorId($_SESSION['usuario_id']);
$cv = $personaDAO->obtenerCv($_SESSION['usuario_id']); 

if (!$usuario) {
    header("Location: ../../index.php");
    exit();
}

