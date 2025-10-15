<?php
define('ACCESO_PERMITIDO', true); 
require_once '../../controlador/PerfilController.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="has-background-light">

<nav class="navbar is-light" role="navigation">
    <div class="navbar-brand">
        <a class="navbar-item has-text-weight-bold" href="#">Calnm</a>
    </div>
    <div class="navbar-menu is-active">
        <div class="navbar-end pr-4">
            <a class="navbar-item" href="../../controlador/OfertasPublicasController.php">Ver Ofertas Laborales</a>
            <a class="navbar-item" href="../../controlador/PersonaPostulacionesController.php">Mis postulaciones</a>
             <a href="../../controlador/CursosController.php?action=lista" 
   class="navbar-item">
    📚 Mis Cursos
</a>
            <a class="navbar-item has-text-danger" href="../../controlador/logout.php">Cerrar sesión</a>
           

        </div>
    </div>
</nav>

<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-8-tablet is-6-desktop">
                <div class="box has-text-centered">
                    <h1 class="title is-4">Perfil del Usuario</h1>

                    <div class="content has-text-left">
                        <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario->getNombre()) ?></p>
                        <p><strong>Apellido:</strong> <?= htmlspecialchars($usuario->getApellido()) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($usuario->getEmail()) ?></p>
                        <p><strong>Tipo de DNI:</strong> <?= htmlspecialchars($usuario->getTipoDni()) ?></p>
                        <p><strong>DNI:</strong> <?= htmlspecialchars($usuario->getDni()) ?></p>
                        <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario->getTelefono()) ?></p>
                        <p><strong>Tipo de usuario:</strong> <?= htmlspecialchars($usuario->getTipo()) ?></p>
                    </div>

                    <div class="buttons is-centered mt-4">
                        <a href="editar.php" class="button is-info is-light">
                            ✏️ Editar Perfil
                        </a>
                    </div>

        
<?php $_SESSION['cv_permitido'] = true; ?>
<div class="field mt-5">
    <label class="label">Currículum Vitae (CV)</label>
    <div class="control">
        <?php if ($cv): ?>
            <a href="../../controlador/DescargarCVController.php" class="button is-success">
                📥 Descargar CV
            </a>
        <?php else: ?>
            <p class="has-text-danger">⚠️ No hay CV cargado</p>
        <?php endif; ?>
    </div>
</div>

                 
                   <form action="../../controlador/CargarCVController.php" method="POST" enctype="multipart/form-data" class="mt-4">
    <div class="field">
        <label class="label">Subir CV (PDF, máximo 1MB)</label>
        
        
   <div class="container">
  <div id="drop-area" class="file is-boxed is-centered has-name is-fullwidth">
    <label class="file-label">
      <input id="file-input" class="file-input" type="file" name="cv" accept=".pdf" required>
      <span class="file-cta">
        <span class="file-icon">
          📎
        </span>
        <span class="file-label">
          Arrastrá tu CV aquí o hacé click
        </span>
      </span>
      <span id="file-name" class="file-name">
        Ningún archivo seleccionado
      </span>
    </label>
  </div>
</div>


    <div class="field mt-3">
        <div class="control has-text-centered">
            <input class="button is-primary" type="submit" value="Subir CV">
        </div>
    </div>
</form>


                </div>
            </div>
        </div>
    </div>
</section>
<script>

const dropArea = document.getElementById("drop-area");
const fileInput = document.getElementById("file-input");
const fileName = document.getElementById("file-name");


["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
  dropArea.addEventListener(eventName, e => e.preventDefault(), false);
  dropArea.addEventListener(eventName, e => e.stopPropagation(), false);
});


["dragenter", "dragover"].forEach(eventName => {
  dropArea.addEventListener(eventName, () => dropArea.classList.add("is-primary"), false);
});

["dragleave", "drop"].forEach(eventName => {
  dropArea.addEventListener(eventName, () => dropArea.classList.remove("is-primary"), false);
});


dropArea.addEventListener("drop", e => {
  const files = e.dataTransfer.files;
  if (files.length > 0) {
    fileInput.files = files; 
    fileName.textContent = files[0].name;
  }
});


fileInput.addEventListener("change", () => {
  if (fileInput.files.length > 0) {
    fileName.textContent = fileInput.files[0].name;
  }
});
</script>
</body>
</html>
