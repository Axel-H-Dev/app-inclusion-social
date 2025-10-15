<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Localidad {
    private $idLocalidad;
    private $nombre;
    private $provincia; // Objeto Provincia

    public function getIdLocalidad() { return $this->idLocalidad; }
    public function setIdLocalidad($idLocalidad) { $this->idLocalidad = $idLocalidad; }

    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getProvincia() { return $this->provincia; }
    public function setProvincia(Provincia $provincia) { $this->provincia = $provincia; }
}
