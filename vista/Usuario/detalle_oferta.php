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
  <title><?= htmlspecialchars($oferta['titulo']) ?></title>
</head>
<body>
  <h1><?= htmlspecialchars($oferta['titulo']) ?></h1>
  <p><strong>Empresa:</strong> <?= htmlspecialchars($oferta['nombre_empresa']) ?></p>
  <p><strong>Ubicación:</strong> <?= htmlspecialchars($oferta['provincia']) ?>, <?= htmlspecialchars($oferta['localidad']) ?></p>
  <p><strong>Modalidad:</strong> <?= htmlspecialchars($oferta['tipo_modalidad']) ?></p>
  <p><strong>Tipo de trabajo:</strong> <?= htmlspecialchars($oferta['tipo_trabajo']) ?></p>
  <p><strong>Capacidad requerida:</strong> <?= htmlspecialchars($oferta['tipo_discapacidad']) ?></p>
  <p><strong>Carga horaria:</strong> <?= $oferta['carga_horaria'] ?> hs</p>
  <p><strong>Salario estimado:</strong> $<?= number_format($oferta['salario_estimado'], 2) ?></p>
  <p><strong>Publicado:</strong> <?= date("d/m/Y H:i", strtotime($oferta['fecha_publicacion'])) ?></p>
  <p><?= nl2br(htmlspecialchars($oferta['descripcion'])) ?></p>

  <?php if (isset($_SESSION['usuario_id'])): ?>
    <?php if ($postulado): ?>
        <p style="color:green;">
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                ✅ ¡Felicidades, te postulaste el <?= date("d/m/Y", strtotime($fechaPostulacion)) ?>!
            <?php else: ?>
                ✅ Ya te postulaste a esta oferta el <?= date("d/m/Y", strtotime($fechaPostulacion)) ?>.
            <?php endif; ?>
        </p>
    <?php elseif ($requiereCV): ?>
        <p style="color:red;">❌ Tenés que subir tu CV antes de postularte.</p>
        <meta http-equiv="refresh" content="3;url=usuario.php">
    <?php else: ?>
        <form method="post">
            <button type="submit" name="postular">Postularse</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <p><strong>🔒 Iniciá sesión para postularte.</strong></p>
<?php endif; ?>


  <a href="OfertasPublicasController.php">← Volver al listado</a>
</body>
</html>
