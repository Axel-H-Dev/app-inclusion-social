<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '/Inclusion_laboral2/'); // Ajustá si cambia la carpeta

// Autoload de clases
spl_autoload_register(function ($class) {
    $paths = ['config', 'modelo/entidades', 'modelo/DAO', 'servicio'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/../' . $path . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Helpers de sesión
function estaLogueado() {
    return isset($_SESSION['usuario_id']);
}

function esEmpresa() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'Empresa';
}

function esAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador';
}

// Constante de seguridad para bloquear acceso directo
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    define('ACCESO_DESDE_CONTROLADOR', true);
}
