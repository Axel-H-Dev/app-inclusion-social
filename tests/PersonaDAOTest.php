<?php

use PHPUnit\Framework\TestCase;

class PersonaDAOTest extends TestCase
{
    private $personaDAO;
    private $mockPDO;
    private $mockStmt;

    protected function setUp(): void
    {
        $this->mockPDO = $this->createMock(PDO::class);
        $this->mockStmt = $this->createMock(PDOStatement::class);
        
        $this->personaDAO = new PersonaDAO();
        
        $reflection = new ReflectionClass($this->personaDAO);
        $pdoProperty = $reflection->getProperty('pdo');
        $pdoProperty->setAccessible(true);
        $pdoProperty->setValue($this->personaDAO, $this->mockPDO);
    }

    public function testRegistrarPersona(): void
    {
        $persona = new Persona();
        $persona->setIdUsuario(1);
        $persona->setIdTipodiscapacidad(2);
        $persona->setCv('Mi CV completo');
        
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->willReturn($this->mockStmt);
            
        $this->mockStmt->expects($this->once())
            ->method('execute')
            ->willReturn(true);
        
        $this->personaDAO->registrar($persona);
        $this->assertTrue(true);
    }

    public function testActualizarCv(): void
    {
        $idPersona = 1;
        $cvNuevo = 'Nuevo CV';
        
        $this->mockPDO->expects($this->once())
            ->method('prepare')
            ->willReturn($this->mockStmt);
            
        $this->mockStmt->expects($this->exactly(2))
            ->method('bindValue');
            
        $this->mockStmt->expects($this->once())
            ->method('execute')
            ->willReturn(true);
        
        $result = $this->personaDAO->actualizarCv($idPersona, $cvNuevo);
        $this->assertTrue($result);
    }
    public function testObtenerCvConString(): void
{
    $idPersona = 1;
    $cv = "Contenido CV";

    $this->mockPDO->expects($this->once())
        ->method('prepare')
        ->willReturn($this->mockStmt);

    $this->mockStmt->expects($this->once())
        ->method('execute')
        ->with(['id' => $idPersona]);

    $this->mockStmt->expects($this->once())
        ->method('fetch')
        ->willReturn(['cv' => $cv]);

    $result = $this->personaDAO->obtenerCv($idPersona);
    $this->assertEquals($cv, $result);
}

public function testObtenerCvCuandoNoExiste(): void
{
    $idPersona = 999;

    $this->mockPDO->expects($this->once())
        ->method('prepare')
        ->willReturn($this->mockStmt);

    $this->mockStmt->expects($this->once())
        ->method('execute')
        ->with(['id' => $idPersona]);

    $this->mockStmt->expects($this->once())
        ->method('fetch')
        ->willReturn(false);

    $result = $this->personaDAO->obtenerCv($idPersona);
    $this->assertNull($result);
}

}
