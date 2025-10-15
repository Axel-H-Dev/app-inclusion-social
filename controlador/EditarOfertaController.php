<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'Empresa') {
    header("Location: ../index.php"); exit();
}

require_once '../modelo/DAO/OfertaLaboralDAO.php';
$dao = new OfertaLaboralDAO();
$idEmpresa = (int)$_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = (int)($_POST['id'] ?? 0);
    $titulo         = trim($_POST['titulo'] ?? '');
    $descripcion    = trim($_POST['descripcion'] ?? '');
    $tipo_modalidad = trim($_POST['tipo_modalidad'] ?? '');
    $tipo_trabajo   = trim($_POST['tipo_trabajo'] ?? '');
    $carga_horaria  = isset($_POST['carga_horaria']) ? (int)$_POST['carga_horaria'] : null;
    $salario        = isset($_POST['salario_estimado']) && $_POST['salario_estimado'] !== '' 
                        ? (float)$_POST['salario_estimado'] : null;

    if ($id <= 0) { http_response_code(400); exit('ID inválido'); }
    if ($titulo === '') {
        $_SESSION['flash_err'] = 'El título es obligatorio.';
        header('Location: FormularioVerOfertasController.php'); exit();
    }

    
    if (!$dao->perteneceAEmpresa($id, $idEmpresa)) {
        http_response_code(404); exit('No encontrado');
    }

    
    $ok = $dao->actualizar([
        'id'               => $id,
        'id_empresa'       => $idEmpresa,      
        'titulo'           => $titulo,
        'descripcion'      => $descripcion,
        'tipo_modalidad'   => $tipo_modalidad,
        'tipo_trabajo'     => $tipo_trabajo,
        'carga_horaria'    => $carga_horaria,
        'salario_estimado' => $salario
    ]);

    header("Location: FormularioVerOfertasController.php");
exit();

} else {
   
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id <= 0) { http_response_code(400); exit('ID de oferta no proporcionado.'); }

    $oferta = $dao->obtenerPorId($id, $idEmpresa); 
    if (!$oferta) { http_response_code(404); exit('No encontrado'); }

    define('ACCESO_DESDE_CONTROLADOR', true);
    require '../vista/empresa/editar_oferta_empresa.php';
}
