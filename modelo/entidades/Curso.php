<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Curso {
    private $id_curso;
    private $titulo;
    private $descripcion;
    private $duracion_horas;
    private $id_empresa;
    private $publicado; 
    private $fecha_creacion;
    private $fecha_actualizacion;

    public function __construct() {
        $this->publicado = 1;
        $this->fecha_creacion = date('Y-m-d H:i:s');
    }

   
    public function getId()              { return $this->id_curso; }
    public function getIdCurso()         { return $this->id_curso; }
    public function getTitulo()          { return $this->titulo; }
    public function getDescripcion()     { return $this->descripcion; }
    public function getDuracionHoras()   { return $this->duracion_horas; }
    public function getEmpresaId()       { return $this->id_empresa; }
    public function getPublicado()       { return $this->publicado; }
    public function isPublicado()        { return (int)$this->publicado === 1; }
    public function getFechaCreacion()   { return $this->fecha_creacion; }
    public function getFechaActualizacion(){ return $this->fecha_actualizacion; }

    
    public function setId($v)                 { $this->id_curso = (int)$v; }
    public function setIdCurso($v)            { $this->id_curso = (int)$v; }
    public function setTitulo($v)             { $this->titulo = $v; }
    public function setDescripcion($v)        { $this->descripcion = $v; }
    public function setDuracionHoras($v)      { $this->duracion_horas = (int)$v; }
    public function setEmpresaId($v)          { $this->id_empresa = (int)$v; }
    public function setPublicado($v)          { $this->publicado = (int)$v; }
    public function setFechaCreacion($v)      { $this->fecha_creacion = $v; }
    public function setFechaActualizacion($v) { $this->fecha_actualizacion = $v; }
}
