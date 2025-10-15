<?php
session_start();


if (!isset($_COOKIE[session_name()])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Persona') {
    header("Location: ../index.php");
    exit();
}


if (!isset($_SESSION['ajax_token'])) {
    $_SESSION['ajax_token'] = bin2hex(random_bytes(16));
}
require_once '../modelo/DAO/OfertaLaboralDAO.php';
require_once '../modelo/DAO/TipoDiscapacidadDAO.php';
require_once '../modelo/DAO/ProvinciaDAO.php';
require_once '../modelo/DAO/LocalidadDAO.php';

$dao = new OfertaLaboralDAO();
$discapacidadDAO = new TipoDiscapacidadDAO();
$provinciaDAO = new ProvinciaDAO();
$localidadDAO = new LocalidadDAO();

$filtros = [
    'buscar' => $_GET['buscar'] ?? '',
    'modalidad' => $_GET['modalidad'] ?? '',
    'tipo_trabajo' => $_GET['tipo_trabajo'] ?? '',
    'orden' => $_GET['orden'] ?? '',
    'provincia' => $_GET['provincia'] ?? '',
    'localidad' => $_GET['localidad'] ?? '',
    'discapacidad' => $_GET['discapacidad'] ?? '',
];

$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$limite = 10;
$offset = ($pagina - 1) * $limite;

$result = $dao->buscarOfertas($filtros, $offset, $limite);
$ofertas = $result['resultados'];
$totalOfertas = $result['total'];
$totalPaginas = ceil($totalOfertas / $limite);

$buscar = $filtros['buscar'];
$modalidad = $filtros['modalidad'];
$tipo_trabajo = $filtros['tipo_trabajo'];
$id_provincia = $filtros['provincia'];
$id_localidad = $filtros['localidad'];
$id_discapacidad = $filtros['discapacidad'];
$orden = $filtros['orden'];

$provincias = $provinciaDAO->obtenerTodas();
$localidades = !empty($id_provincia) ? $localidadDAO->obtenerPorProvincia($id_provincia) : [];
$discapacidades = $discapacidadDAO->obtenerTodos();


define('ACCESO_DESDE_CONTROLADOR', true);
require_once '../vista/usuario/ofertas_laborales.php';
