<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!defined('ACCESO_EDITAR_EMPRESA')) {
    header("Location: /inclusion_laboral2/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empresa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<nav class="navbar is-light" role="navigation">
    <div class="navbar-brand">
        <a class="navbar-item has-text-weight-bold" href="#">Calnm</a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-end pr-4">
            <a class="navbar-item" href="Formulario_laboralController.php">Publicar Oferta Laboral</a>
            <a class="navbar-item" href="FormularioVerOfertasController.php">Ver Ofertas Laborales</a>
            <a class="navbar-item has-text-danger" href="controlador/logout.php">Cerrar sesión</a>
        </div>
    </div>
</nav>

<section class="section">
    <div class="container">
        <div class="box">
            <h1 class="title has-text-centered">Editar Usuario y Empresa</h1>

            
            <form method="POST" action="EditarEmpresaController.php">

                
                <div class="box">
                    <h2 class="subtitle">Datos del Usuario</h2>

                    <div class="field">
                        <label class="label">Nombre</label>
                        <input class="input" type="text" name="nombre_usuario" required value="<?= htmlspecialchars($usuario->getNombre()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Apellido</label>
                        <input class="input" type="text" name="apellido_usuario" required value="<?= htmlspecialchars($usuario->getApellido()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Email</label>
                        <input class="input" type="email" name="email_usuario" required value="<?= htmlspecialchars($usuario->getEmail()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Teléfono</label>
                        <input class="input" type="tel" name="telefono_usuario" value="<?= htmlspecialchars($usuario->getTelefono()) ?>">
                    </div>
                </div>

              
                <div class="box">
                    <h2 class="subtitle">Datos de la Empresa</h2>

                    <div class="field">
                        <label class="label">Nombre Empresa</label>
                        <input class="input" type="text" name="nombre_empresa" required value="<?= htmlspecialchars($empresa->getNombreEmpresa()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Razón Social</label>
                        <input class="input" type="text" name="razon_social" required value="<?= htmlspecialchars($empresa->getRazonSocial()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Condición Social</label>
                        <input class="input" type="text" name="condicion_social" required value="<?= htmlspecialchars($empresa->getCondicionSocial()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Documento</label>
                        <input class="input" type="text" name="documento" required value="<?= htmlspecialchars($empresa->getDocumento()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Calle</label>
                        <input class="input" type="text" name="calle" required value="<?= htmlspecialchars($empresa->getCalle()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Número</label>
                        <input class="input" type="text" name="numero" required value="<?= htmlspecialchars($empresa->getNumero()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Código Postal</label>
                        <input class="input" type="text" name="codigo_postal" required value="<?= htmlspecialchars($empresa->getCodigoPostal()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Teléfono Empresa</label>
                        <input class="input" type="text" name="telefono_empresa" required value="<?= htmlspecialchars($empresa->getTelefono()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">País</label>
                        <input class="input" type="text" name="pais" required value="<?= htmlspecialchars($empresa->getPais()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Industria</label>
                        <input class="input" type="text" name="industria" required value="<?= htmlspecialchars($empresa->getIndustria()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Cantidad de Empleados</label>
                        <input class="input" type="number" name="empleados" required value="<?= htmlspecialchars($empresa->getCantidadEmpleados()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Política de Inclusión</label>
                        <input class="input" type="text" name="politica_inclusion" value="<?= htmlspecialchars($empresa->getPoliticaInclusion()) ?>">
                    </div>

                    <div class="field">
                        <label class="label">Datos de Contacto</label>
                        <input class="input" type="text" name="datos_contacto" value="<?= htmlspecialchars($empresa->getDatosContacto()) ?>">
                    </div>
                </div>

                
                <div class="field is-grouped is-justify-content-center mt-5">
                    <button class="button is-primary" type="submit" name="btnActualizarEmpresa">
                        ✅ Actualizar Perfil
                    </button>
                </div>

            </form>
        </div>
    </div>
</section>
</body>
</html>
