<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    die("Acceso denegado");
}

require_once '../modelo/DAO/UsuarioDAO.php';
$dao = new UsuarioDAO();

if (!empty($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($dao->eliminar($id)) {
        header("Location: AdminUsuariosController.php?msg=Usuario eliminado correctamente");
        exit;
    } else {
        echo "❌ Error al eliminar el usuario (puede que tenga registros relacionados).";
    }
} else {
    echo "❌ ID inválido";
}
