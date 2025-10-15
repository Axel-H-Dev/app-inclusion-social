<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class Usuario {
    private $idUsuario;
    private $nombre;
    private $apellido;
    private $email;
    private $clave;
    private $tipoDni;
    private $dni;
    private $telefono;
    private $tipo; // Persona, Empresa, Administrador

   
    public function getIdUsuario() { return $this->idUsuario; }
    public function setIdUsuario($id) { $this->idUsuario = $id; }

    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getApellido() { return $this->apellido; }
    public function setApellido($apellido) { $this->apellido = $apellido; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getClave() { return $this->clave; }
    public function setClave($clave) { $this->clave = $clave; }

    public function getTipoDni() { return $this->tipoDni; }
    public function setTipoDni($tipoDni) { $this->tipoDni = $tipoDni; }

    public function getDni() { return $this->dni; }
    public function setDni($dni) { $this->dni = $dni; }

    public function getTelefono() { return $this->telefono; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }

    public function getTipo() { return $this->tipo; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
}
