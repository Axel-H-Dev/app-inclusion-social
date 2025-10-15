<?php define('ACCESO_PERMITIDO', true);
require_once '../../controlador/EditarController.php'; 
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
        <h1 class="title is-4">Editar Perfil</h1>
        <form method="POST">
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

            <div class="field is-grouped mt-4">
                <div class="control">
                    <button class="button is-link">Guardar</button>
                </div>
                <div class="control">
                    <a class="button is-light" href="usuario.php">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</section>
</body>
</html>
