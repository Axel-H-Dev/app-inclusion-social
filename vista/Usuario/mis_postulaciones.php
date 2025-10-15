<?php if (!defined('ACCESO_DESDE_CONTROLADOR')) { header("Location: ../../index.php"); exit(); } ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis postulaciones</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body class="has-background-light">
    <nav class="navbar is-light" role="navigation">
    <div class="navbar-brand">
        <a class="navbar-item has-text-weight-bold" href="#">Calnm</a>
    </div>
    <div class="navbar-menu is-active">
        <div class="navbar-end pr-4">
            <a class="navbar-item" href="../vista/usuario/usuario.php">Perfil</a>
            <a class="navbar-item" href="OfertasPublicasController.php">Ver Ofertas Laborales</a>
           <a href="CursosController.php?action=lista" 
   class="navbar-item">
    📚 Mis Cursos
</a>
            <a class="navbar-item has-text-danger" href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</nav>
<section class="section">
  <div class="container">
    <h1 class="title">Mis postulaciones</h1>

    <?php if (!empty($_SESSION['flash_ok'])): ?>
      <div class="notification is-success"><?= $_SESSION['flash_ok']; unset($_SESSION['flash_ok']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_err'])): ?>
      <div class="notification is-danger"><?= $_SESSION['flash_err']; unset($_SESSION['flash_err']); ?></div>
    <?php endif; ?>

    <?php if (empty($postulaciones)): ?>
      <div class="notification is-info">Todavía no te postulaste a ninguna oferta.</div>
    <?php else: ?>
      <div class="table-container">
        <table class="table is-striped is-fullwidth is-hoverable">
          <thead>
            <tr>
              <th>Oferta</th>
              <th>Empresa</th>
              <th>Estado</th>
              <th>Postulado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($postulaciones as $p): 
              $cls = 'is-light';
              if ($p['estado']==='en revisión')  $cls='is-info';
              elseif ($p['estado']==='aceptado') $cls='is-success';
              elseif ($p['estado']==='rechazado')$cls='is-danger';
              elseif ($p['estado']==='retirada') $cls='is-warning';
          ?>
            <tr>
              <td>
                <strong><?= htmlspecialchars($p['titulo']) ?></strong><br>
                
              </td>
              <td><?= htmlspecialchars($p['nombre_empresa']) ?></td>
              <td><span class="tag <?= $cls ?>"><?= htmlspecialchars($p['estado']) ?></span></td>
              <td><?= htmlspecialchars($p['fecha_postulacion']) ?></td>
              <td>
                <?php if (in_array($p['estado'], ['pendiente','en revisión'], true)): ?>
                  <form method="post" action="PersonaPostulacionesController.php"
                        onsubmit="return confirm('¿Seguro que querés retirar tu postulación?');">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
                    <input type="hidden" name="accion" value="retirar">
                    <input type="hidden" name="id_postulacion" value="<?= (int)$p['id_postulacion'] ?>">
                    <button class="button is-small is-warning" type="submit">Retirar</button>
                  </form>
                <?php else: ?>
                  <button class="button is-small" disabled>No disponible</button>
                <?php endif; ?>
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
