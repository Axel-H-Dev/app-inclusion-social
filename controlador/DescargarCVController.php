<?php
session_start();


if (!isset($_SESSION['usuario_id']) || empty($_SESSION['cv_permitido'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso no permitido.");
}


unset($_SESSION['cv_permitido']);

require_once '../modelo/DAO/PersonaDAO.php';

$personaDAO = new PersonaDAO();
$cv = $personaDAO->obtenerCv($_SESSION['usuario_id']);

if ($cv) {
    while (ob_get_level()) ob_end_clean();
    ini_set('zlib.output_compression', 'Off');

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="cv.pdf"');
    header('Content-Length: ' . strlen($cv));
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    flush();

    echo $cv;
    exit();
} else {
    salirConAlerta('No hay CV cargado');
}

function salirConAlerta($mensaje) {
    echo "<script>alert('$mensaje'); window.location.href='../../vista/usuario/perfil.php';</script>";
    exit();
}
?>
