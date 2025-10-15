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
    <title>Editar Oferta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="title is-4">Editar Oferta Laboral</h2>
    <form method="POST" action="EditarOfertaController.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($oferta['id']) ?>">
        <div class="field">
            <label class="label">Título</label>
            <div class="control">
                <input class="input" type="text" name="titulo" required value="<?= htmlspecialchars($oferta['titulo']) ?>">
            </div>
        </div>
        <div class="field">
            <label class="label">Descripción</label>
            <div class="control">
                <textarea class="textarea" name="descripcion" required><?= htmlspecialchars($oferta['descripcion']) ?></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label">Modalidad</label>
            <div class="control">
                <select class="input" name="tipo_modalidad" required>
                    <option value="Presencial" <?= $oferta['tipo_modalidad']=='Presencial'?'selected':'' ?>>Presencial</option>
                    <option value="Remoto" <?= $oferta['tipo_modalidad']=='Remoto'?'selected':'' ?>>Remoto</option>
                    <option value="Híbrido" <?= $oferta['tipo_modalidad']=='Híbrido'?'selected':'' ?>>Híbrido</option>
                </select>
            </div>
        </div>
        <div class="field">
            <label class="label">Tipo de jornada</label>
            <div class="control">
                <select class="input" name="tipo_trabajo" required>
                    <option value="Full-time" <?= $oferta['tipo_trabajo']=='Full-time'?'selected':'' ?>>Full-time</option>
                    <option value="Part-time" <?= $oferta['tipo_trabajo']=='Part-time'?'selected':'' ?>>Part-time</option>
                    <option value="Freelance" <?= $oferta['tipo_trabajo']=='Freelance'?'selected':'' ?>>Freelance</option>
                </select>
            </div>
        </div>
        <div class="field">
            <label class="label">Carga horaria (hs)</label>
            <div class="control">
                <input class="input" type="number" name="carga_horaria" required value="<?= htmlspecialchars($oferta['carga_horaria']) ?>">
            </div>
        </div>
        <div class="field">
            <label class="label">Salario estimado</label>
            <div class="control">
                <input class="input" type="number" name="salario_estimado" step="0.01" required value="<?= htmlspecialchars($oferta['salario_estimado']) ?>">
            </div>
        </div>
        <div class="field mt-4">
            <button class="button is-primary" type="submit">Guardar cambios</button>
            <a href="FormularioVerOfertasController.php" class="button is-light">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
