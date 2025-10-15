<?php
session_start();
define('ACCESO_DESDE_CONTROLADOR', true);

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Persona') {
    header("Location: ../index.php");
    exit();
}

require_once '../modelo/DAO/PostulacionDAO.php';

$idPersona = (int)$_SESSION['usuario_id'];


if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
function csrf_ok($t) { return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $t ?? ''); }

$dao = new PostulacionDAO();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'retirar') {
    if (!csrf_ok($_POST['csrf'] ?? '')) {
        die('CSRF token inválido');
    }
    $idPostulacion = (int)($_POST['id_postulacion'] ?? 0);

 
$ok = $dao->retirarPostulacionDelete($idPostulacion, $idPersona);

  ;

    $_SESSION['flash_'.($ok?'ok':'err')] = $ok ? 'Postulación retirada.' : 'No se pudo retirar (verificá estado).';
    header('Location: PersonaPostulacionesController.php');
    exit;
}


$postulaciones = $dao->obtenerPorPersona($idPersona);
include '../vista/Usuario/mis_postulaciones.php';
