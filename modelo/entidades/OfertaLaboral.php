<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class OfertaLaboral {
    private $id, $idEmpresa, $titulo, $descripcion, $tipoModalidad, $tipoTrabajo, $cargaHoraria,
        $salarioEstimado, $idTipocapacidad, $idProvincia, $idLocalidad, $fechaPublicacion;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getIdEmpresa() { return $this->idEmpresa; }
    public function setIdEmpresa($idEmpresa) { $this->idEmpresa = $idEmpresa; }

    public function getTitulo() { return $this->titulo; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }

    public function getDescripcion() { return $this->descripcion; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getTipoModalidad() { return $this->tipoModalidad; }
    public function setTipoModalidad($tipoModalidad) { $this->tipoModalidad = $tipoModalidad; }

    public function getTipoTrabajo() { return $this->tipoTrabajo; }
    public function setTipoTrabajo($tipoTrabajo) { $this->tipoTrabajo = $tipoTrabajo; }

    public function getCargaHoraria() { return $this->cargaHoraria; }
    public function setCargaHoraria($cargaHoraria) { $this->cargaHoraria = $cargaHoraria; }

    public function getSalarioEstimado() { return $this->salarioEstimado; }
    public function setSalarioEstimado($salarioEstimado) { $this->salarioEstimado = $salarioEstimado; }

    public function getIdTipocapacidad() { return $this->idTipocapacidad; }
    public function setIdTipocapacidad($idTipocapacidad) { $this->idTipocapacidad = $idTipocapacidad; }

    public function getIdProvincia() { return $this->idProvincia; }
    public function setIdProvincia($idProvincia) { $this->idProvincia = $idProvincia; }

    public function getIdLocalidad() { return $this->idLocalidad; }
    public function setIdLocalidad($idLocalidad) { $this->idLocalidad = $idLocalidad; }

    public function getFechaPublicacion() { return $this->fechaPublicacion; }
    public function setFechaPublicacion($fechaPublicacion) { $this->fechaPublicacion = $fechaPublicacion; }
}

