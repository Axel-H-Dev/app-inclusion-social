<?php if (!defined('ACCESO_DESDE_CONTROLADOR')) { header("Location: ../../index.php"); exit(); } ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Postulaciones recibidas</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="has-background-light">
<section class="section">
  <div class="container">
    <h1 class="title">Postulaciones – <?= htmlspecialchars($tituloOferta ?: 'Oferta #'.$idOferta) ?></h1>

    <?php if (!empty($_SESSION['flash_ok'])): ?>
      <div class="notification is-success"><?= $_SESSION['flash_ok']; unset($_SESSION['flash_ok']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_err'])): ?>
      <div class="notification is-danger"><?= $_SESSION['flash_err']; unset($_SESSION['flash_err']); ?></div>
    <?php endif; ?>

    <p class="mb-4">
      <a class="button is-link is-light" href="FormularioVerOfertasController.php">← Volver a mis ofertas</a>
    </p>

    <?php if (empty($postulaciones)): ?>
      <div class="notification is-warning">No hay postulaciones para esta oferta.</div>
    <?php else: ?>
    <div class="table-container">
      <table class="table is-striped is-fullwidth is-hoverable">
        <thead>
          <tr>
            <th>Postulante</th>
            <th>Discapacidad</th>
            <th>Contacto</th>
            <th>CV</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($postulaciones as $p): ?>
          <tr>
            <td>
              <strong><?= htmlspecialchars($p['apellido'].', '.$p['nombre']) ?></strong>
            </td>
            <td>
              <?= htmlspecialchars($p['discapacidad'] ?: '—') ?>
            </td>
            <td>
              <div>Email: <a href="mailto:<?= htmlspecialchars($p['email']) ?>"><?= htmlspecialchars($p['email']) ?></a></div>
              <?php if (!empty($p['telefono'])): ?>
                <div>Tel: <?= htmlspecialchars($p['telefono']) ?></div>
              <?php endif; ?>
            </td>
            <td>
              <a class="button is-small is-success"
                 href="DescargarCVEmpresaController.php?id_persona=<?= (int)$p['id_persona'] ?>&id_oferta=<?= (int)$idOferta ?>">
                 📥 Descargar CV
              </a>
            </td>
            <td><?= htmlspecialchars($p['fecha_postulacion']) ?></td>
            <td>
              <?php
                $cls = 'is-light';
                if ($p['estado'] === 'en revisión')      $cls = 'is-info';
                elseif ($p['estado'] === 'aceptado')     $cls = 'is-success';
                elseif ($p['estado'] === 'rechazado')    $cls = 'is-danger';
              ?>
              <span class="tag <?= $cls ?>"><?= htmlspecialchars($p['estado']) ?></span>
            </td>
            <td>
              <form method="post" action="empresaPostulacionesController.php?id_oferta=<?= (int)$idOferta ?>" class="is-inline">
                <input type="hidden" name="accion" value="cambiar_estado">
                <input type="hidden" name="id_postulacion" value="<?= (int)$p['id_postulacion'] ?>">
                <input type="hidden" name="id_oferta" value="<?= (int)$idOferta ?>">
                <div class="field has-addons">
                  <p class="control">
                    <span class="select is-small">
                      <select name="estado" required>
                        <?php
                          $opts = [
                            'pendiente'   => 'Pendiente',
                            'en revisión' => 'En revisión',
                            'aceptado'    => 'Aceptado',
                            'rechazado'   => 'Rechazado'
                          ];
                          foreach ($opts as $val => $txt):
                        ?>
                          <option value="<?= $val ?>" <?= $p['estado'] === $val ? 'selected' : '' ?>><?= $txt ?></option>
                        <?php endforeach; ?>
                      </select>
                    </span>
                  </p>
                  <p class="control">
                    <button class="button is-small is-link" type="submit">Actualizar</button>
                  </p>
                </div>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</section>
</body>
</html>
