<?php
session_start();


if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: /inclusion_laboral2/index.php");
    exit();
}

require_once __DIR__ . '/../modelo/dao/UsuarioDAO.php';
require_once __DIR__ . '/../modelo/dao/EmpresaDAO.php';

$usuarioDAO = new UsuarioDAO();
$empresaDAO = new EmpresaDAO();

$id = $_SESSION['usuario_id'];
$usuario = $usuarioDAO->obtenerPorId($id);
$empresa = $empresaDAO->obtenerPorId($id);

if (!$usuario || !$empresa) {
    die("No se encontraron datos de la empresa.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $usuario->setNombre(trim($_POST['nombre_usuario']));
    $usuario->setApellido(trim($_POST['apellido_usuario']));
    $usuario->setEmail(trim($_POST['email_usuario']));
    $usuario->setTelefono(trim($_POST['telefono_usuario']));

   
    $empresa->setNombreEmpresa(trim($_POST['nombre_empresa']));
    $empresa->setRazonSocial(trim($_POST['razon_social']));
    $empresa->setCondicionSocial(trim($_POST['condicion_social']));
    $empresa->setDocumento(trim($_POST['documento']));
    $empresa->setCalle(trim($_POST['calle']));
    $empresa->setNumero(trim($_POST['numero']));
    $empresa->setCodigoPostal(trim($_POST['codigo_postal']));
    $empresa->setTelefono(trim($_POST['telefono_empresa']));
    $empresa->setPais(trim($_POST['pais']));
    $empresa->setIndustria(trim($_POST['industria']));
    $empresa->setCantidadEmpleados((int)$_POST['empleados']);
    $empresa->setPoliticaInclusion(trim($_POST['politica_inclusion']));
    $empresa->setDatosContacto(trim($_POST['datos_contacto']));

    
    $usuarioDAO->actualizar($usuario);
    $empresaDAO->actualizar($empresa);

    
    header("Location: PerfilEmpresaController.php");
    exit();
}


define('ACCESO_EDITAR_EMPRESA', true);
require_once __DIR__ . '/../vista/empresa/editar.php';
