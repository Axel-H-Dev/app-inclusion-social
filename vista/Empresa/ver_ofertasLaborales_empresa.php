<?php

if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Ofertas Laborales</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>

<body>
    <nav class="navbar is-light" role="navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="#">Calnm</a>
        </div>
        <div class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="formulario_laboralController.php">Publicar Oferta Laboral</a>
                <a class="navbar-item" href="perfilempresacontroller.php">Editar Empresa</a>
                        <a href="CursosController.php?action=crear" 
   class="navbar-item">
    📚 Mis Cursos
</a>
                <a class="navbar-item has-text-danger" href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="title is-4">Ofertas Publicadas</h1>

        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Modalidad</th>
                    <th>Tipo</th>
                    <th>Provincia</th>
                    <th>Localidad</th>
                    <th>Discapacidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ofertas as $oferta): ?>
                    <tr>
                        <td><?= htmlspecialchars($oferta['titulo']) ?></td>
                        <td><?= htmlspecialchars($oferta['descripcion']) ?></td>
                        <td><?= htmlspecialchars($oferta['tipo_modalidad']) ?></td>
                        <td><?= htmlspecialchars($oferta['tipo_trabajo']) ?></td>
                        <td><?= htmlspecialchars($oferta['provincia']) ?></td>
                        <td><?= htmlspecialchars($oferta['localidad']) ?></td>
                        <td><?= htmlspecialchars($oferta['discapacidad']) ?></td>
                        <td>
                            <a href="EditarOfertaController.php?id=<?= $oferta['id'] ?>" class="button is-small is-info">Editar</a>
                            <a href="empresaPostulacionesController.php?id_oferta=<?= (int)$oferta['id'] ?>"
                                class="button is-small is-link">👀 Ver postulaciones</a>

                            <form action="EliminarOfertaController.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $oferta['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                <button type="submit" class="button is-small is-danger" onclick="return confirm('¿Seguro que querés eliminar esta oferta?');">
                                    Eliminar
                                </button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>