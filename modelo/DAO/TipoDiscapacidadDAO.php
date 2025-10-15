<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../entidades/TipoDiscapacidad.php';

class TipoDiscapacidadDAO {
    private $pdo;
    public function __construct() {
        $this->pdo = (new Conexion())->getConexion();
    }
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM tipo_discapacidad ORDER BY id");
        $lista = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new TipoDiscapacidad();
            $obj->setId($row['id']);
            $obj->setDiscapacidad($row['discapacidad']);
            $obj->setDescripcion($row['descripcion']);
            $lista[] = $obj;
        }
        return $lista;
    }
}

