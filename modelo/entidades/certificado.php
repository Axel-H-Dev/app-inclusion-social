<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Certificado {
    private $id_certificado;
    private $codigo_unico;
    private $id_inscripcion;
    private $id_usuario;
    private $id_curso;
    private $fecha_emision;
    private $url_validacion;

    public function __construct() {
        $this->codigo_unico = $this->generarCodigoUnico();
        $this->fecha_emision = date('Y-m-d H:i:s');
    }

    private function generarCodigoUnico() {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 12));
    }

  
    public function getId()             { return $this->id_certificado; }
    public function getIdCertificado()  { return $this->id_certificado; }
    public function getCodigoUnico()    { return $this->codigo_unico; }
    public function getInscripcionId()  { return $this->id_inscripcion; }
    public function getUsuarioId()      { return $this->id_usuario; }
    public function getCursoId()        { return $this->id_curso; }
    public function getFechaEmision()   { return $this->fecha_emision; }
    public function getUrlValidacion()  { return $this->url_validacion; }

    
    public function setId($v)                { $this->id_certificado = (int)$v; }
    public function setIdCertificado($v)     { $this->id_certificado = (int)$v; }
    public function setCodigoUnico($v)       { $this->codigo_unico = $v; }
    public function setInscripcionId($v)     { $this->id_inscripcion = (int)$v; }
    public function setUsuarioId($v)         { $this->id_usuario = (int)$v; }
    public function setCursoId($v)           { $this->id_curso = (int)$v; }
    public function setFechaEmision($v)      { $this->fecha_emision = $v; }
    public function setUrlValidacion($v)     { $this->url_validacion = $v; }
}
