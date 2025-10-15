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
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="has-background-light">
<section class="section">
<div class="container">
    <h1 class="title">Editar Usuario</h1>

    <form method="post">
        <input type="hidden" name="id_usuario" value="<?= $usuario->getIdUsuario() ?>">

        <div class="field">
            <label class="label">Nombre</label>
            <div class="control">
                <input class="input" type="text" name="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Apellido</label>
            <div class="control">
                <input class="input" type="text" name="apellido" value="<?= htmlspecialchars($usuario->getApellido()) ?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Teléfono</label>
            <div class="control">
                <input class="input" type="text" name="telefono" value="<?= htmlspecialchars($usuario->getTelefono()) ?>">
            </div>
        </div>

        <div class="field">
            <button class="button is-primary" type="submit">Guardar cambios</button>
            <a href="Adminusuarioscontroller.php" class="button is-light">Cancelar</a>
        </div>
    </form>
</div>
</section>
</body>
</html>
