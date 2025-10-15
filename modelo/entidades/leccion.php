<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Leccion {
  private $id_leccion;
  private $id_curso;
  private $titulo;
  private $tipo; 
  private $url_pdf;
  private $contenido_texto;
  private $orden;

  
  public function getId(){ return $this->id_leccion; }
  public function getCursoId(){ return $this->id_curso; }
  public function getTitulo(){ return $this->titulo; }
  public function getTipo(){ return $this->tipo; }
  public function getUrlPdf(){ return $this->url_pdf; }
  public function getContenidoTexto(){ return $this->contenido_texto; }
  public function getOrden(){ return $this->orden; }

  
  public function setId($v){ $this->id_leccion=(int)$v; }
  public function setCursoId($v){ $this->id_curso=(int)$v; }
  public function setTitulo($v){ $this->titulo=$v; }
  public function setTipo($v){ $this->tipo=$v; }
  public function setUrlPdf($v){ $this->url_pdf=$v; }
  public function setContenidoTexto($v){ $this->contenido_texto=$v; }
  public function setOrden($v){ $this->orden=(int)$v; }
}
