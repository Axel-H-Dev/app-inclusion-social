<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}
require_once __DIR__ . '/../modelo/dao/OfertaLaboralDAO.php';
require_once __DIR__ . '/../modelo/entidades/OfertaLaboral.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $oferta = new OfertaLaboral();
        $oferta->setIdEmpresa($_SESSION["usuario_id"]);
        $oferta->setTitulo($_POST["titulo"]);
        $oferta->setDescripcion($_POST["descripcion"]);
        $oferta->setTipoModalidad($_POST["tipo_modalidad"]);
        $oferta->setTipoTrabajo($_POST["tipo_trabajo"]);
        $oferta->setCargaHoraria($_POST["carga_horaria"]);
        $oferta->setSalarioEstimado($_POST["salario_estimado"]);
        $oferta->setIdTipoCapacidad($_POST["id_tipocapacidad"]);
        $oferta->setIdProvincia($_POST["provincia"]);
        $oferta->setIdLocalidad($_POST["localidad"]);

        $dao = new OfertaLaboralDAO();
        $id = $dao->registrar($oferta);

        if ($id) {
            header("Location:Formulario_laboralController.php");
            exit();
        } else {
            throw new Exception('No se pudo registrar la oferta.');
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); history.back();</script>";
        exit();
    }
}
?>
