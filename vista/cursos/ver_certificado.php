<?php // requiere: $cert, $curso, $nombreUsuario, $empresaNombre ?>
<?php

// Bloquear acceso directo al archivo
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit;
}


  function fecha_es($ts){
    $mes = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    return date('d', $ts).' de '.$mes[(int)date('n',$ts)-1].' de '.date('Y',$ts);
  }
  $ts = strtotime($cert->getFechaEmision());
  $fecha_es = fecha_es($ts);
  $codigo = $cert->getCodigoUnico();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Certificado — <?= htmlspecialchars($curso->getTitulo()) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <style>
    :root { --bg1:#667eea; --bg2:#764ba2; --borde:#f4e19c; --texto:#2c3e50; --gris:#7f8c8d; }
    body { background: linear-gradient(135deg,var(--bg1) 0%,var(--bg2) 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
    .cert { width: 1000px; max-width: 100%; background:#fff; padding:48px; border-radius:12px; box-shadow:0 20px 50px rgba(0,0,0,.25); position:relative; }
    .cert:before { content:""; position:absolute; inset:16px; border:3px solid var(--borde); border-radius:8px; pointer-events:none; }
    h1{ font-size:48px; font-weight:800; color:var(--texto); text-align:center; margin:0; letter-spacing:.5px; }
    h2{ font-size:22px; color:#8f9aa1; text-align:center; margin:6px 0 28px; }
    .nombre{ font-size:36px; text-align:center; font-weight:700; color:var(--texto); border-bottom:2px solid #3498db; display:inline-block; padding:6px 12px; margin: 10px auto 12px; }
    .curso{ font-size:24px; text-align:center; color:#34495e; font-style:italic; margin: 8px 0 6px; }
    .meta{ text-align:center; color:var(--gris); margin-top:10px; }
    .firma-linea{ width:320px; margin:28px auto 0; text-align:center; border-top:2px solid var(--texto); padding-top:8px; font-weight:600; }
    .aval{ text-align:center; margin-top:8px; color:#6b7280; }
    .codigo{ margin-top:14px; text-align:center; font-size:13px; color:#95a5a6; }
    .toolbar{ position:fixed; top:16px; right:16px; display:flex; gap:8px; z-index:9; }
    .button.is-primary.is-light{ box-shadow:0 6px 16px rgba(0,0,0,.15); }
  </style>
</head>
<body>

  
  <div class="toolbar">
    <button class="button is-primary is-light" id="btnPdf">Descargar PDF</button>
  </div>

  <div class="cert" id="cert">
    <h1>CERTIFICADO</h1>
    <h2>de Finalización</h2>

    <p class="has-text-centered">Se certifica que</p>
    <div class="has-text-centered">
      <span class="nombre"><?= htmlspecialchars($nombreUsuario) ?></span>
    </div>

    <p class="has-text-centered">ha completado satisfactoriamente el curso</p>
    <div class="curso">“<?= htmlspecialchars($curso->getTitulo()) ?>”</div>
    <p class="has-text-centered">con una duración de <?= (int)$curso->getDuracionHoras() ?> horas.</p>

    <div class="meta">
      Emitido el <?= htmlspecialchars($fecha_es) ?>
    </div>

    <div style="max-width:640px;margin:24px auto 0;border-top:3px solid #2c3e50"></div>
    <div class="firma-linea">Dirección de Capacitación</div>
    <?php if (!empty($empresaNombre)): ?>
      <div class="aval">Avalado por <strong><?= htmlspecialchars($empresaNombre) ?></strong></div>
    <?php endif; ?>

    <div class="codigo">
      Código de verificación: <?= htmlspecialchars($codigo) ?>
    </div>
  </div>

  
  <script src="https://cdn.jsdelivr.net/npm/html2pdf.js@0.10.1/dist/html2pdf.bundle.min.js"></script>
  <script>
    (function(){
      const btn = document.getElementById('btnPdf');
      const el  = document.getElementById('cert');
      const codigo = <?= json_encode($codigo) ?>;
      btn.addEventListener('click', ()=>{
        const opt = {
          margin:       [8,8,8,8],                 // mm
          filename:     `certificado-${codigo}.pdf`,
          image:        { type: 'jpeg', quality: 0.98 },
          html2canvas:  { scale: 2, useCORS: true, letterRendering: true },
          jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };
        html2pdf().set(opt).from(el).save();
      });
    })();
  </script>
</body>
</html>
