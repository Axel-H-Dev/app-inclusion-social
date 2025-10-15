<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

require_once '../modelo/DAO/PersonaDAO.php';

if (isset($_FILES['cv'])) {
    $archivo = $_FILES['cv'];

   
    if ($archivo['size'] > 1000000) {
        alertar('El archivo no debe superar 1MB');
        exit();
    }
    if ($archivo['type'] !== 'application/pdf') {
        alertar('Solo se permiten archivos PDF');
        exit();
    }

   
    $cvData = file_get_contents($archivo['tmp_name']);
    $personaDAO = new PersonaDAO();
    $ok = $personaDAO->actualizarCv($_SESSION['usuario_id'], $cvData);

    if ($ok) {
        alertar('CV actualizado correctamente', '../vista/usuario/usuario.php');
    } else {
        alertar('Error al guardar el CV', '../vista/usuario/usuario.php');
    }
}

function alertar($msg, $redir = '../../vista/usuario/perfil.php') {
    while (ob_get_level()) ob_end_clean();
    ini_set('zlib.output_compression', 'Off');
    echo "<script>alert('$msg'); window.location.href = '$redir';</script>";
    exit();
}
?>
