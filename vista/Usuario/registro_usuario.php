
<?php
require '../../modelo/DAO/TipoDiscapacidadDAO.php';
$tipoDAO = new TipoDiscapacidadDAO();
$discapacidades = $tipoDAO->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registro Usuario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
  <nav class="navbar is-light">
    <div class="navbar-menu">
      <div class="navbar-start">
        <a class="navbar-item" href="../../index.php">Inicio</a>
        <a class="navbar-item" href="../Empresa/registro_empresa.php">Registrar Empresa</a>
      </div>
    </div>
  </nav>

  <section class="section">
    <div class="container">
      <div class="box">
        <h2 class="title is-4 has-text-centered">Registro de Nuevo Usuario</h2>

    <form method="POST" action="/inclusion_laboral2/controlador/AuthController.php">


          <div class="columns">
            <div class="column">
              <div class="field">
                <label class="label">Nombre</label>
                <div class="control">
                  <input class="input" type="text" name="nombre" placeholder="Nombre"
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}" required>
                </div>
              </div>
            </div>
            <div class="column">
              <div class="field">
                <label class="label">Apellido</label>
                <div class="control">
                  <input class="input" type="text" name="apellido" placeholder="Apellido"
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}" required>
                </div>
              </div>
            </div>
          </div>

          <div class="columns">
            <div class="column">
              <div class="field">
                <label class="label">Tipo de Documento</label>
                <div class="control">
                  <div class="select is-fullwidth">
                    <select name="tipo_doc" required>
                      <option value="dni">DNI</option>
                      <option value="pasaporte">Pasaporte</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="column">
              <div class="field">
                <label class="label">Número de Documento</label>
                <div class="control">
                  <input class="input" type="text" name="documento" placeholder="Número de Documento"
                    pattern="\d{7,11}" maxlength="10" required>
                </div>
              </div>
            </div>
          </div>

          <div class="field">
            <label class="label">Teléfono Celular</label>
            <div class="control">
              <input class="input" type="tel" name="celular" placeholder="Teléfono Celular"
                pattern="\d{8,12}" maxlength="12" required>
            </div>
          </div>

          <div class="field">
            <label class="label">Email</label>
            <div class="control">
              <input class="input" type="email" name="email" placeholder="Email" required>
            </div>
          </div>

          <div class="field">
            <label class="label">Contraseña</label>
            <div class="control">
              <input class="input" type="password" name="clave" placeholder="Contraseña"
                required autocomplete="off">
            </div>
          </div>

          <div class="field">
            <label class="label">¿Tiene alguna discapacidad?</label>
            <div class="control">
              <div class="select is-fullwidth">
                <select name="discapacidad" required>
                  <option value="" disabled selected>Seleccione una opción</option>
                  <?php foreach ($discapacidades as $row): ?>
                    <option value="<?= $row->getId(); ?>"><?= htmlspecialchars($row->getDiscapacidad()); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="field has-text-centered mt-4">
            <div class="control">
              <button type="submit" class="button is-dark is-medium">
                Registrarse
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>

</html>