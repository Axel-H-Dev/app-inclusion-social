<?php

use PHPUnit\Framework\TestCase;

class VistaRegistroTest extends TestCase
{
    public function testArchivoVistaExiste(): void
    {
        $vistaPath = __DIR__ . '/../vista/usuario/registro_usuario.php';
        $this->assertFileExists($vistaPath);
    }

    public function testVistaContieneFormulario(): void
    {
        $vistaPath = __DIR__ . '/../vista/usuario/registro_usuario.php';
        $content = file_get_contents($vistaPath);
        
        $this->assertStringContainsString('<form', $content);
        $this->assertStringContainsString('method="POST"', $content);
    }

    public function testVistaContieneCamposRequeridos(): void
    {
        $vistaPath = __DIR__ . '/../vista/usuario/registro_usuario.php';
        $content = file_get_contents($vistaPath);
        
        $this->assertStringContainsString('name="nombre"', $content);
        $this->assertStringContainsString('name="apellido"', $content);
        $this->assertStringContainsString('name="email"', $content);
        $this->assertStringContainsString('name="clave"', $content);
    }

    public function testVistaContieneSelectDiscapacidad(): void
    {
        $vistaPath = __DIR__ . '/../vista/usuario/registro_usuario.php';
        $content = file_get_contents($vistaPath);
        
        $this->assertStringContainsString('name="discapacidad"', $content);
        $this->assertStringContainsString('<select', $content);
    }

    public function testVistaContieneBotonSubmit(): void
    {
        $vistaPath = __DIR__ . '/../vista/usuario/registro_usuario.php';
        $content = file_get_contents($vistaPath);
        
        $this->assertStringContainsString('type="submit"', $content);
        $this->assertStringContainsString('Registrarse', $content);
    }
}
