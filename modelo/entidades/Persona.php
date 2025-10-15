<?php


if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Persona {
    private $idUsuario;
    private $idTipodiscapacidad;
    private $cv;
    private $certificaciones;

    
    public function getId() {
        return $this->idUsuario;
    }

    public function setId($id) {
        $this->idUsuario = $id;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getIdTipodiscapacidad() {
        return $this->idTipodiscapacidad;
    }

    public function setIdTipodiscapacidad($idTipodiscapacidad) {
        $this->idTipodiscapacidad = $idTipodiscapacidad;
    }

    public function getCv() {
        return $this->cv;
    }

    public function setCv($cv) {
        $this->cv = $cv;
    }

    public function getCertificaciones() {
        return $this->certificaciones;
    }

    public function setCertificaciones($certificaciones) {
        $this->certificaciones = $certificaciones;
    }
}
