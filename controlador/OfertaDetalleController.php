<?php
session_start();
require_once '../modelo/DAO/OfertaLaboralDAO.php';
require_once '../modelo/DAO/PostulacionDAO.php';
require_once '../modelo/entidades/Postulacion.php';
require_once '../modelo/entidades/OfertaLaboral.php';
require_once '../modelo/entidades/Persona.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']);
$dao = new OfertaLaboralDAO();
$oferta = $dao->obtenerDetalle($id);

if (!$oferta) {
    die("Oferta no encontrada.");
}

$postulado = false;
$requiereCV = false;
$fechaPostulacion = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postular'])) {
    if (!isset($_SESSION['usuario_id'])) {
        die("Debe iniciar sesión para postularse.");
    }

    $idPersona = $_SESSION['usuario_id'];
    $postulacionDAO = new PostulacionDAO();

    
    $postulacionExistente = $postulacionDAO->obtenerPostulacion($idPersona, $id);
    if ($postulacionExistente) {
        $postulado = true;
        $fechaPostulacion = $postulacionExistente['fecha_postulacion'];
    } 
    elseif (!$postulacionDAO->tieneCV($idPersona)) {
        $requiereCV = true;
    } 
    else {
        
        $postulacion = new Postulacion();
        $persona = new Persona();
        $persona->setId($idPersona);
        $ofertaObj = new OfertaLaboral();
        $ofertaObj->setId($id);

        $postulacion->setPersona($persona);
        $postulacion->setOferta($ofertaObj);
        $postulacion->setFechaPostulacion(date("Y-m-d H:i:s"));
        $postulacion->setEstado("pendiente");

        if ($postulacionDAO->guardar($postulacion)) {
            $postulado = true;
            $fechaPostulacion = $postulacion->getFechaPostulacion();
        }
    }
} 
else if (isset($_SESSION['usuario_id'])) {
    
    $postulacionDAO = new PostulacionDAO();
    $postulacionExistente = $postulacionDAO->obtenerPostulacion($_SESSION['usuario_id'], $id);
    if ($postulacionExistente) {
        $postulado = true;
        $fechaPostulacion = $postulacionExistente['fecha_postulacion'];
    }
}
define('ACCESO_DESDE_CONTROLADOR', true);
require_once '../vista/usuario/detalle_oferta.php';
