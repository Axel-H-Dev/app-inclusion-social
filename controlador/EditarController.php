<?php
session_start();
if (!defined('ACCESO_PERMITIDO')) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso directo no permitido.");
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../modelo/DAO/UsuarioDAO.php';

$usuarioDAO = new UsuarioDAO();
$usuario = $usuarioDAO->obtenerPorId($_SESSION['usuario_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario->setNombre(trim($_POST['nombre']));
    $usuario->setApellido(trim($_POST['apellido']));
    $usuario->setEmail(trim($_POST['email']));
    $usuario->setTelefono(trim($_POST['telefono']));

    
    if ($usuarioDAO->emailExiste($usuario->getEmail(), $usuario->getIdUsuario())) {
    $_SESSION['error'] = "El correo electrónico ya está en uso por otro usuario.";
    header("Location: ../Usuario/usuario.php");
    exit();
}


    if ($usuarioDAO->actualizar($usuario)) {
        $_SESSION['exito'] = "Datos actualizados correctamente.";
        header("Location: ../Usuario/usuario.php");
        exit();
    } else {
        $_SESSION['error'] = "Hubo un problema al actualizar los datos.";
        header("Location: ../Usuario/usuario.php");
        exit();
    }
}

