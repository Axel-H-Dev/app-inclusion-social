<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once 'Usuario.php';

class Empresa extends Usuario {
    private $nombreEmpresa;
    private $razonSocial;
    private $condicionSocial;
    private $documento;
    private $calle;
    private $numero;
    private $codigoPostal;
    private $pais;
    private $industria;
    private $cantidadEmpleados;
    private $politicaInclusion;
    private $datosContacto;

    public function getNombreEmpresa() { return $this->nombreEmpresa; }
    public function setNombreEmpresa($nombreEmpresa) { $this->nombreEmpresa = $nombreEmpresa; }

    public function getRazonSocial() { return $this->razonSocial; }
    public function setRazonSocial($razonSocial) { $this->razonSocial = $razonSocial; }

    public function getCondicionSocial() { return $this->condicionSocial; }
    public function setCondicionSocial($condicionSocial) { $this->condicionSocial = $condicionSocial; }

    public function getDocumento() { return $this->documento; }
    public function setDocumento($documento) { $this->documento = $documento; }

    public function getCalle() { return $this->calle; }
    public function setCalle($calle) { $this->calle = $calle; }

    public function getNumero() { return $this->numero; }
    public function setNumero($numero) { $this->numero = $numero; }

    public function getCodigoPostal() { return $this->codigoPostal; }
    public function setCodigoPostal($codigoPostal) { $this->codigoPostal = $codigoPostal; }

    public function getPais() { return $this->pais; }
    public function setPais($pais) { $this->pais = $pais; }

    public function getIndustria() { return $this->industria; }
    public function setIndustria($industria) { $this->industria = $industria; }

    public function getCantidadEmpleados() { return $this->cantidadEmpleados; }
    public function setCantidadEmpleados($cantidadEmpleados) { $this->cantidadEmpleados = $cantidadEmpleados; }

    public function getPoliticaInclusion() { return $this->politicaInclusion; }
    public function setPoliticaInclusion($politicaInclusion) { $this->politicaInclusion = $politicaInclusion; }

    public function getDatosContacto() { return $this->datosContacto; }
    public function setDatosContacto($datosContacto) { $this->datosContacto = $datosContacto; }
}
