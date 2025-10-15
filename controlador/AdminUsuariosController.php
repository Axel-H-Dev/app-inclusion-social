<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: ../index.php");
    exit;
}

require_once '../modelo/DAO/UsuarioDAO.php';
$dao = new UsuarioDAO();
$usuarios = $dao->obtenerTodos();

define('ACCESO_DESDE_CONTROLADOR', true);
require_once '../vista/admin/usuarios.php';
