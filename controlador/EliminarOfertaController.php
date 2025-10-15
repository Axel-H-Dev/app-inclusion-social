<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: FormularioVerOfertasController.php");
    exit();
}


if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    die("Acceso no autorizado (CSRF detectado).");
}


if (empty($_POST['id'])) {
    die("ID de oferta no proporcionado.");
}

require_once '../modelo/DAO/OfertaLaboralDAO.php';
$dao = new OfertaLaboralDAO();


$dao->eliminar($_POST['id'], $_SESSION['usuario_id']);


header("Location: FormularioVerOfertasController.php?msg=oferta_eliminada");
exit();
