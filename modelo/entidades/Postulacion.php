<?php


if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Postulacion {
    private $id;
    private $persona; 
    private $oferta;  
    private $fechaPostulacion;
    private $estado; 

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getPersona() { return $this->persona; }
    public function setPersona(Persona $persona) { $this->persona = $persona; }

    public function getOferta() { return $this->oferta; }
    public function setOferta(OfertaLaboral $oferta) { $this->oferta = $oferta; }

    public function getFechaPostulacion() { return $this->fechaPostulacion; }
    public function setFechaPostulacion($fechaPostulacion) { $this->fechaPostulacion = $fechaPostulacion; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }
}
