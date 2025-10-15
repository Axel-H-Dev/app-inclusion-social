<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../entidades/Provincia.php';

class ProvinciaDAO {
    private $pdo;
    public function __construct() {
        $this->pdo = (new Conexion())->getConexion();
    }

    public function obtenerTodas() {
        $stmt = $this->pdo->query("SELECT id_provincia, nombre FROM provincia");
        $provincias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prov = new Provincia();
            $prov->setIdProvincia($row['id_provincia']);
            $prov->setNombre($row['nombre']);
            $provincias[] = $prov;
        }
        return $provincias;
    }
}
