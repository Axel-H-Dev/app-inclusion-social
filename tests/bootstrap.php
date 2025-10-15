<?php

spl_autoload_register(function ($className) {
    $paths = [
        __DIR__ . '/../entidades/',
        __DIR__ . '/../modelo/DAO/',
        __DIR__ . '/../modelo/entidades/',    
        __DIR__ . '/../modelo/',
        __DIR__ . '/../',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

define('TESTING', true);

if (!class_exists('Conexion')) {
    class Conexion {
        public function getConexion() {
            return new PDO('sqlite::memory:');
        }
    }
}

// NO cargar AuthController.php original porque tiene headers y exit
