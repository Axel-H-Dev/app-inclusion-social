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
    <title>Publicar Oferta Laboral</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
   
    <script>
        const AJAX_TOKEN = "<?= $_SESSION['ajax_token'] ?>";
    </script>
</head>
<body>
  
<nav class="navbar is-light">
    <div class="navbar-brand">
        <a class="navbar-item has-text-weight-bold" href="#">Calnm</a>
    </div>
    <div id="navbarEmpresa" class="navbar-menu is-active">
        <div class="navbar-end pr-4">
            <a class="navbar-item" href="perfilempresacontroller.php">Editar Empresa</a>
            <a class="navbar-item" href="FormularioVerOfertasController.php">Ver Ofertas Publicadas</a>
                    <a href="CursosController.php?action=crear" 
   class="navbar-item">
    📚 Mis Cursos
</a>
            <a class="navbar-item has-text-danger" href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</nav>

<form action="PublicarOfertaController.php" method="POST">
    <label>Título:</label>
    <input type="text" name="titulo" required>

    <label>Descripción:</label>
    <textarea name="descripcion" required></textarea>

    <label>Provincia:</label>
    <select name="provincia" id="provincia" required>
        <option value="">Seleccionar</option>
        <?php foreach ($provincias as $prov): ?>
            <option value="<?= is_array($prov) ? $prov['id_provincia'] : $prov->getIdProvincia() ?>">
                <?= is_array($prov) ? htmlspecialchars($prov['nombre']) : htmlspecialchars($prov->getNombre()) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Localidad:</label>
    <select name="localidad" id="localidad" required>
        <option value="">Seleccionar provincia primero</option>
    </select>

    <label>Tipo de modalidad:</label>
    <select name="tipo_modalidad" required>
        <option value="Presencial">Presencial</option>
        <option value="Remoto">Remoto</option>
        <option value="Híbrido">Híbrido</option>
    </select>

    <label>Tipo de jornada:</label>
    <select name="tipo_trabajo" required>
        <option value="Full-time">Full-time</option>
        <option value="Part-time">Part-time</option>
        <option value="Freelance">Freelance</option>
    </select>

    <label>Carga horaria (hs):</label>
    <input type="number" name="carga_horaria" required>

    <label>Salario estimado:</label>
    <input type="number" name="salario_estimado" step="0.01" required>

    <label>Tipo de discapacidad aceptada:</label>
    <select name="id_tipocapacidad" required>
        <option value="">Seleccionar</option>
        <?php foreach ($discapacidades as $d): ?>
            <option value="<?= $d->getId() ?>">
                <?= htmlspecialchars($d->getDiscapacidad()) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Publicar oferta">
</form>

<script>
document.getElementById("provincia").addEventListener("change", function() {
    const provinciaId = this.value;
    const localidadSelect = document.getElementById("localidad");
    localidadSelect.innerHTML = '<option value="">Cargando...</option>';

    
    fetch('cargar_localidades.php?provincia_id=' + provinciaId + '&token=' + AJAX_TOKEN)
        .then(response => {
            if (!response.ok) throw new Error("Error HTTP " + response.status);
            return response.json();
        })
        .then(data => {
            if (data.error) throw new Error(data.error);
            localidadSelect.innerHTML = '<option value="">Seleccionar</option>';
            data.forEach(loc => {
                const option = document.createElement("option");
                option.value = loc.id_localidad;
                option.textContent = loc.nombre;
                localidadSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error al cargar localidades:", error);
            localidadSelect.innerHTML = '<option value="">Error al cargar</option>';
        });
});
</script>

</body>
</html>
