<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!defined('ACCESO_PERFIL_EMPRESA')) {
    header("Location: ../../index.php");
    exit();
}


if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Empresa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="has-background-light">
    <nav class="navbar is-light" role="navigation">
        <div class="navbar-brand">
            <a class="navbar-item has-text-weight-bold" href="#">Calnm</a>
        </div>
        <div class="navbar-menu is-active">
            <div class="navbar-end pr-4">
                <a class="navbar-item" href="Formulario_laboralController.php">Publicar Oferta Laboral</a>
                <a class="navbar-item" href="FormularioVerOfertasController.php">Ver Ofertas Laborales</a>
                      <a href="CursosController.php?action=crear" 
   class="navbar-item">
    📚 Mis Cursos
</a>
                <a class="navbar-item has-text-danger" href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    <section class="section">
        <div class="container">
            <div class="box has-text-centered">
                <h1 class="title is-4">Perfil de la Empresa</h1>
                <div class="content has-text-left">
                    <h2 class="subtitle">Datos del Usuario</h2>
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario->getNombre()) ?></p>
                    <p><strong>Apellido:</strong> <?= htmlspecialchars($usuario->getApellido()) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($usuario->getEmail()) ?></p>
                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario->getTelefono()) ?></p>

                    <h2 class="subtitle mt-4">Datos de la Empresa</h2>
                    <p><strong>Nombre Empresa:</strong> <?= htmlspecialchars($empresa->getNombreEmpresa()) ?></p>
                    <p><strong>Razón Social:</strong> <?= htmlspecialchars($empresa->getRazonSocial()) ?></p>
                    <p><strong>Condición Social:</strong> <?= htmlspecialchars($empresa->getCondicionSocial()) ?></p>
                    <p><strong>Documento:</strong> <?= htmlspecialchars($empresa->getDocumento()) ?></p>
                    <p><strong>Calle:</strong> <?= htmlspecialchars($empresa->getCalle()) ?></p>
                    <p><strong>Número:</strong> <?= htmlspecialchars($empresa->getNumero()) ?></p>
                    <p><strong>Código Postal:</strong> <?= htmlspecialchars($empresa->getCodigoPostal()) ?></p>
                    <p><strong>Teléfono Empresa:</strong> <?= htmlspecialchars($empresa->getTelefono()) ?></p>
                    <p><strong>País:</strong> <?= htmlspecialchars($empresa->getPais()) ?></p>
                    <p><strong>Industria:</strong> <?= htmlspecialchars($empresa->getIndustria()) ?></p>
                    <p><strong>Cantidad de Empleados:</strong> <?= htmlspecialchars($empresa->getCantidadEmpleados()) ?></p>
                    <p><strong>Política de Inclusión:</strong> <?= htmlspecialchars($empresa->getPoliticaInclusion()) ?></p>
                    <p><strong>Datos de Contacto:</strong> <?= htmlspecialchars($empresa->getDatosContacto()) ?></p>
                </div>
                <div class="buttons is-centered mt-4">
                    <a href="editarempresacontroller.php" class="button is-info is-light">✏️ Editar Perfil</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
