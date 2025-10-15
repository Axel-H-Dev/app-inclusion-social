<?php

use PHPUnit\Framework\TestCase;

class UsuarioDAOTest extends TestCase
{
    private $usuarioDAO;
    private $mockPDO;
    private $mockStmt;

    protected function setUp(): void
    {
        $this->mockPDO = $this->createMock(PDO::class);
        $this->mockStmt = $this->createMock(PDOStatement::class);
        
        $this->usuarioDAO = new UsuarioDAO();
        
        $reflection = new ReflectionClass($this->usuarioDAO);
        $pdoProperty = $reflection->getProperty('pdo');
        $pdoProperty->setAccessible(true);
        $pdoProperty->setValue($this->usuarioDAO, $this->mockPDO);
    }

    public function testEmailExisteRetornaTrue(): void
    {
        $email = "test@example.com";
        
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->willReturn($this->mockStmt);
            
        $this->mockStmt->expects($this->once())
            ->method('execute')
            ->with(['email' => $email]);
            
        $this->mockStmt->expects($this->once())
            ->method('fetchColumn')
            ->willReturn(1);
        
        $result = $this->usuarioDAO->emailExiste($email);
        $this->assertTrue($result);
    }

    public function testEmailExisteRetornaFalse(): void
    {
        $email = "noexiste@example.com";
        
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->willReturn($this->mockStmt);
            
        $this->mockStmt->expects($this->once())
            ->method('execute')
            ->with(['email' => $email]);
            
        $this->mockStmt->expects($this->once())
            ->method('fetchColumn')
            ->willReturn(0);
        
        $result = $this->usuarioDAO->emailExiste($email);
        $this->assertFalse($result);
    }

    public function testRegistrarUsuario(): void
    {
        $usuario = new Usuario();
        $usuario->setNombre('Juan');
        $usuario->setApellido('Pérez');
        $usuario->setEmail('juan@test.com');
        $usuario->setClave('password123');

        $expectedId = "123";  
        
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->willReturn($this->mockStmt);
            
        $this->mockStmt->expects($this->once())
            ->method('execute')
            ->willReturn(true);
            
        $this->mockPDO->expects($this->once())
            ->method('lastInsertId')
            ->willReturn($expectedId);  
        
        $result = $this->usuarioDAO->registrar($usuario);
        $this->assertEquals($expectedId, $result);
    }
}
