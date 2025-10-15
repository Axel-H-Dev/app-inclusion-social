<?php

use PHPUnit\Framework\TestCase;

class IntegracionRegistroTest extends TestCase
{
    public function testControladorExiste(): void
    {
        $controllerPath = __DIR__ . '/../controlador/AuthController.php';
        $this->assertFileExists($controllerPath);
    }

    public function testVistaExiste(): void
    {
        $vistaPath = __DIR__ . '/../vista/usuario/registro_usuario.php';
        $this->assertFileExists($vistaPath);
    }

    public function testValidacionIntegrada(): void
    {
      
        require_once __DIR__ . '/TestableAuthController.php';
        $controller = new TestableAuthController();
        
        $datosCompletos = [
            'nombre' => 'María José',
            'apellido' => 'García Pérez',
            'documento' => '12345678',
            'celular' => '1234567890',
            'email' => 'maria@ejemplo.com',
            'clave' => 'password123',
            'discapacidad' => '1'
        ];
        
        $resultado = $controller->validarDatos($datosCompletos);
        $this->assertTrue($resultado);
    }
}
