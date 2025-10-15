<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Inscripcion {
    private $id_inscripcion;
    private $id_curso;
    private $id_usuario;
    private $fecha_inscripcion;
    private $fecha_inicio;
    private $fecha_completado;
    private $progreso; 
    private $estado;  

    public function __construct() {
        $this->fecha_inscripcion = date('Y-m-d H:i:s');
        $this->progreso = 0;
        $this->estado = 'inscrito';
    }

    
    public function getId()               { return $this->id_inscripcion; }
    public function getIdInscripcion()    { return $this->id_inscripcion; }
    public function getCursoId()          { return $this->id_curso; }
    public function getUsuarioId()        { return $this->id_usuario; }
    public function getFechaInscripcion() { return $this->fecha_inscripcion; }
    public function getFechaInicio()      { return $this->fecha_inicio; }
    public function getFechaCompletado()  { return $this->fecha_completado; }
    public function getProgreso()         { return $this->progreso; }
    public function getEstado()           { return $this->estado; }

   
    public function setId($v)                 { $this->id_inscripcion = (int)$v; }
    public function setIdInscripcion($v)      { $this->id_inscripcion = (int)$v; }
    public function setCursoId($v)            { $this->id_curso = (int)$v; }
    public function setUsuarioId($v)          { $this->id_usuario = (int)$v; }
    public function setFechaInscripcion($v)   { $this->fecha_inscripcion = $v; }
    public function setFechaInicio($v)        { $this->fecha_inicio = $v; }
    public function setFechaCompletado($v)    { $this->fecha_completado = $v; }
    public function setProgreso($v)           { $this->progreso = (int)$v; }
    public function setEstado($v)             { $this->estado = $v; }
}
