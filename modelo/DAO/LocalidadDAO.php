<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../entidades/Localidad.php';

class LocalidadDAO {
    private $pdo;
    public function __construct() {
        $this->pdo = (new Conexion())->getConexion();
    }

    public function obtenerPorProvincia($idProvincia) {
        $stmt = $this->pdo->prepare("SELECT id_localidad, nombre FROM localidad WHERE id_provincia = :idProvincia order by nombre ASC");
        $stmt->bindParam(":idProvincia", $idProvincia, PDO::PARAM_INT);
        $stmt->execute();
        $localidades = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $loc = new Localidad();
            $loc->setIdLocalidad($row['id_localidad']);
            $loc->setNombre($row['nombre']);
            $localidades[] = $loc;
        }
        return $localidades;
    }
}