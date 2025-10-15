<?php


if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Provincia {
    private $idProvincia;
    private $nombre;

    public function getIdProvincia() {
        return $this->idProvincia;
    }
    public function setIdProvincia($idProvincia) {
        $this->idProvincia = $idProvincia;
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
}
