<?php
// tests/UsuarioTest.php


use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    private $usuario;

    protected function setUp(): void
    {
        $this->usuario = new Usuario();
    }

    protected function tearDown(): void
    {
        $this->usuario = null;
    }

    public function testSetAndGetIdUsuario()
    {
        $id = 123;
        $this->usuario->setIdUsuario($id);
        $this->assertEquals($id, $this->usuario->getIdUsuario());
    }

    public function testSetAndGetNombre()
    {
        $nombre = "Juan";
        $this->usuario->setNombre($nombre);
        $this->assertEquals($nombre, $this->usuario->getNombre());
    }

    public function testSetAndGetApellido()
    {
        $apellido = "Pérez";
        $this->usuario->setApellido($apellido);
        $this->assertEquals($apellido, $this->usuario->getApellido());
    }

    public function testSetAndGetEmail()
    {
        $email = "juan.perez@example.com";
        $this->usuario->setEmail($email);
        $this->assertEquals($email, $this->usuario->getEmail());
    }

    public function testSetAndGetClave()
    {
        $clave = "password123";
        $this->usuario->setClave($clave);
        $this->assertEquals($clave, $this->usuario->getClave());
    }

    public function testSetAndGetTipoDni()
    {
        $tipoDni = "DNI";
        $this->usuario->setTipoDni($tipoDni);
        $this->assertEquals($tipoDni, $this->usuario->getTipoDni());
    }

    public function testSetAndGetDni()
    {
        $dni = "12345678";
        $this->usuario->setDni($dni);
        $this->assertEquals($dni, $this->usuario->getDni());
    }

    public function testSetAndGetTelefono()
    {
        $telefono = "+5491123456789";
        $this->usuario->setTelefono($telefono);
        $this->assertEquals($telefono, $this->usuario->getTelefono());
    }

    public function testSetAndGetTipo()
    {
        $tipo = "Persona";
        $this->usuario->setTipo($tipo);
        $this->assertEquals($tipo, $this->usuario->getTipo());
    }

    public function testUsuarioCompleto()
    {
        $datos = [
            'id' => 1,
            'nombre' => 'María',
            'apellido' => 'García',
            'email' => 'maria.garcia@test.com',
            'clave' => 'secreto123',
            'tipoDni' => 'DNI',
            'dni' => '87654321',
            'telefono' => '+5491199887766',
            'tipo' => 'Empresa'
        ];

        $this->usuario->setIdUsuario($datos['id']);
        $this->usuario->setNombre($datos['nombre']);
        $this->usuario->setApellido($datos['apellido']);
        $this->usuario->setEmail($datos['email']);
        $this->usuario->setClave($datos['clave']);
        $this->usuario->setTipoDni($datos['tipoDni']);
        $this->usuario->setDni($datos['dni']);
        $this->usuario->setTelefono($datos['telefono']);
        $this->usuario->setTipo($datos['tipo']);

        $this->assertEquals($datos['id'], $this->usuario->getIdUsuario());
        $this->assertEquals($datos['nombre'], $this->usuario->getNombre());
        $this->assertEquals($datos['apellido'], $this->usuario->getApellido());
        $this->assertEquals($datos['email'], $this->usuario->getEmail());
        $this->assertEquals($datos['clave'], $this->usuario->getClave());
        $this->assertEquals($datos['tipoDni'], $this->usuario->getTipoDni());
        $this->assertEquals($datos['dni'], $this->usuario->getDni());
        $this->assertEquals($datos['telefono'], $this->usuario->getTelefono());
        $this->assertEquals($datos['tipo'], $this->usuario->getTipo());
    }

    public function testValoresNulos()
    {
        $this->assertNull($this->usuario->getIdUsuario());
        $this->assertNull($this->usuario->getNombre());
        $this->assertNull($this->usuario->getApellido());
        $this->assertNull($this->usuario->getEmail());
        $this->assertNull($this->usuario->getClave());
        $this->assertNull($this->usuario->getTipoDni());
        $this->assertNull($this->usuario->getDni());
        $this->assertNull($this->usuario->getTelefono());
        $this->assertNull($this->usuario->getTipo());
    }
}