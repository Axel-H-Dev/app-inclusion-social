<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit();
}


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Persona') {
    header("Location: ../../index.php");
    exit();
}


if (!isset($_SESSION['ajax_token'])) {
    $_SESSION['ajax_token'] = bin2hex(random_bytes(16));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ofertas Laborales</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <script>
    
    const AJAX_TOKEN = "<?= $_SESSION['ajax_token'] ?>";
  </script>
</head>
<body class="has-background-light">
<nav class="navbar is-light">
  <div class="navbar-brand">
    <a class="navbar-item has-text-weight-bold" href="#">Calnm</a>
  </div>
  <div class="navbar-menu is-active">
    <div class="navbar-end pr-4">
      <a class="navbar-item" href="../vista/usuario/usuario.php">Perfil</a>
      <a class="navbar-item" href="PersonaPostulacionesController.php">Mis postulaciones</a>
        <a href="CursosController.php?action=lista" 
   class="navbar-item">
    📚 Mis Cursos
</a>
      <a class="navbar-item has-text-danger" href="../controlador/logout.php">Cerrar sesión</a>
    </div>
  </div>
</nav>

<div class="section">
  <div class="container">
    
   
    <div class="box mb-5">
      <form method="GET" action="">
        <div class="columns is-multiline">
          <div class="column is-4">
            <label for="buscar" class="label is-sr-only">Buscar título</label>
            <input class="input" type="text" name="buscar" id="buscar" placeholder="Buscar título" value="<?= htmlspecialchars($buscar ?? '') ?>">
          </div>

          <div class="column is-2">
            <label for="modalidad" class="label is-sr-only">Modalidad</label>
            <div class="select is-fullwidth">
              <select name="modalidad" id="modalidad">
                <option value="">Modalidad</option>
                <option value="Presencial" <?= ($modalidad ?? '') == 'Presencial' ? 'selected' : '' ?>>Presencial</option>
                <option value="Remoto" <?= ($modalidad ?? '') == 'Remoto' ? 'selected' : '' ?>>Remoto</option>
                <option value="Híbrido" <?= ($modalidad ?? '') == 'Híbrido' ? 'selected' : '' ?>>Híbrido</option>
              </select>
            </div>
          </div>

          <div class="column is-2">
            <label for="tipo_trabajo" class="label is-sr-only">Tipo de jornada</label>
            <div class="select is-fullwidth">
              <select name="tipo_trabajo" id="tipo_trabajo">
                <option value="">Tipo de jornada</option>
                <option value="Full-time" <?= ($tipo_trabajo ?? '') == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                <option value="Part-time" <?= ($tipo_trabajo ?? '') == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
                <option value="Freelance" <?= ($tipo_trabajo ?? '') == 'Freelance' ? 'selected' : '' ?>>Freelance</option>
              </select>
            </div>
          </div>

         
          <div class="column is-2">
            <label for="provincia" class="label is-sr-only">Provincia</label>
            <div class="select is-fullwidth">
              <select name="provincia" id="provincia">
                <option value="">Provincia</option>
                <?php foreach ($provincias as $prov): ?>
                  <option value="<?= $prov->getIdProvincia() ?>"
                    <?= ($id_provincia ?? '') == $prov->getIdProvincia() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($prov->getNombre()) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          
          <div class="column is-2">
            <label for="localidad" class="label is-sr-only">Localidad</label>
            <div class="select is-fullwidth">
              <select name="localidad" id="localidad">
                <option value="">Seleccionar provincia primero</option>
              </select>
            </div>
          </div>

          
          <div class="column is-2">
            <label for="discapacidad" class="label is-sr-only">Discapacidad</label>
            <div class="select is-fullwidth">
              <select name="discapacidad" id="discapacidad">
                <option value="">Discapacidad</option>
                <?php foreach ($discapacidades as $disc): ?>
                  <option value="<?= $disc->getId() ?>"
                    <?= ($id_discapacidad ?? '') == $disc->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($disc->getDiscapacidad()) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          
          <div class="column is-2">
            <label for="orden" class="label is-sr-only">Ordenar</label>
            <div class="select is-fullwidth">
              <select name="orden" id="orden">
                <option value="">Ordenar por</option>
                <option value="1" <?= ($orden ?? '') == '1' ? 'selected' : '' ?>>Fecha ↑</option>
                <option value="2" <?= ($orden ?? '') == '2' ? 'selected' : '' ?>>Fecha ↓</option>
                <option value="3" <?= ($orden ?? '') == '3' ? 'selected' : '' ?>>Título A-Z</option>
              </select>
            </div>
          </div>

          <div class="column is-2">
            <button class="button is-info is-fullwidth" type="submit">Buscar</button>
          </div>
          <div class="column is-2">
            <a href="?" class="button is-light is-fullwidth">Limpiar filtros</a>
          </div>
        </div>
      </form>
    </div>

    
    <div class="columns is-multiline">
      <?php if (empty($ofertas)): ?>
        <div class="column is-12">
          <div class="notification is-warning has-text-centered">
            No se encontraron ofertas laborales con esos filtros.
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($ofertas as $oferta): ?>
          <div class="column is-12">
            <a href="OfertaDetalleController.php?id=<?= $oferta['id'] ?>" style="text-decoration: none; color: inherit;">
              <div class="box has-shadow" style="cursor: pointer;">
                <article class="media">
                  <div class="media-content">
                    <div class="content">
                      <p>
                        <strong class="is-size-5"><?= htmlspecialchars($oferta['titulo']) ?></strong><br>
                        <span class="tag is-info is-light"><?= htmlspecialchars($oferta['tipo_trabajo']) ?></span>
                        <span class="tag is-link is-light"><?= htmlspecialchars($oferta['tipo_modalidad']) ?></span><br>
                        <span class="has-text-grey"><?= htmlspecialchars($oferta['provincia']) ?>, <?= htmlspecialchars($oferta['localidad']) ?></span><br>
                        <span class="has-text-primary">Discapacidad: <?= htmlspecialchars($oferta['tipo_discapacidad']) ?></span><br>
                        <small class="has-text-grey">Publicado: <?= date("d/m/Y H:i", strtotime($oferta['fecha_publicacion'])) ?></small>
                      </p>
                    </div>
                  </div>
                </article>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    
    <?php if (($totalPaginas ?? 1) > 1): ?>
      <nav class="pagination is-centered" role="navigation">
        <ul class="pagination-list">
          <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <li>
              <a class="pagination-link <?= ($i == $pagina) ? 'is-current' : '' ?>"
                 href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>">
                <?= $i ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const provinciaSelect = document.getElementById("provincia");
  const localidadSelect = document.getElementById("localidad");
  const selectedLocalidad = "<?= $id_localidad ?? '' ?>";

  function cargarLocalidades(idProvincia) {
    localidadSelect.innerHTML = '<option>Cargando...</option>';
    fetch("../controlador/cargar_localidades.php?provincia_id=" + idProvincia + "&token=" + AJAX_TOKEN)
      .then(res => res.json())
      .then(data => {
        localidadSelect.innerHTML = '<option value="">Todas</option>';
        data.forEach(loc => {
          const option = document.createElement("option");
          option.value = loc.id_localidad;
          option.textContent = loc.nombre;
          if (loc.id_localidad === selectedLocalidad) {
            option.selected = true;
          }
          localidadSelect.appendChild(option);
        });
      })
      .catch(() => {
        localidadSelect.innerHTML = '<option>Error al cargar</option>';
      });
  }

  if (provinciaSelect.value) {
    cargarLocalidades(provinciaSelect.value);
  }

  provinciaSelect.addEventListener("change", function () {
    cargarLocalidades(this.value);
  });
});
</script>
</body>
</html>
