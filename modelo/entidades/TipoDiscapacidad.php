<?php


if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class TipoDiscapacidad {
    private $id, $discapacidad, $descripcion;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getDiscapacidad() { return $this->discapacidad; }
    public function setDiscapacidad($discapacidad) { $this->discapacidad = $discapacidad; }

    public function getDescripcion() { return $this->descripcion; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
}
