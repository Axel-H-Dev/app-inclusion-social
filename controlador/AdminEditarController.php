<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    die("Acceso denegado");
}

require_once '../modelo/DAO/UsuarioDAO.php';
require_once '../modelo/entidades/Usuario.php';

$dao = new UsuarioDAO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $usuario = new Usuario();
    $usuario->setIdUsuario($_POST['id_usuario']);
    $usuario->setNombre($_POST['nombre']);
    $usuario->setApellido($_POST['apellido']);
    $usuario->setEmail($_POST['email']);
    $usuario->setTelefono($_POST['telefono']);

    if ($dao->actualizar($usuario)) {
        header("Location: AdminUsuariosController.php?msg=Usuario actualizado correctamente");
exit;

    } else {
        echo "❌ Error al actualizar el usuario.";
    }

} else {
    
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("ID inválido");
    }

    $usuario = $dao->obtenerPorId($_GET['id']);
    if (!$usuario) {
        die("Usuario no encontrado");
    }
define('ACCESO_DESDE_CONTROLADOR', true);
    require_once '../vista/admin/editar_usuario.php';
}
