<?php 
// Bloqueo acceso directo
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="has-background-light">
<section class="section">
    <div class="container">
        <h1 class="title">Listado de Usuarios</h1>

        <?php if (isset($_GET['msg'])): ?>
            <div class="notification is-success"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <table class="table is-striped is-fullwidth">
            <thead>
                <tr>
                    <th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th><th>Tipo</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id_usuario'] ?></td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['apellido']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['tipo']) ?></td>
                    <td>
                        <a class="button is-small is-info" href="../controlador/AdminEditarController.php?id=<?= $u['id_usuario'] ?>">Editar</a>
                        <a class="button is-small is-danger" href="../controlador/AdminEliminarController.php?id=<?= $u['id_usuario'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="logout.php" class="button is-light">Cerrar sesión</a>
    </div>
</section>
</body>
</html>
