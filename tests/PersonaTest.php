<?php

use PHPUnit\Framework\TestCase;

class PersonaTest extends TestCase
{
    private $persona;

    protected function setUp(): void
    {
        $this->persona = new Persona();
    }

    protected function tearDown(): void
    {
        $this->persona = null;
    }

    public function testSetAndGetId(): void
    {
        $id = 456;
        $this->persona->setId($id);
        $this->assertEquals($id, $this->persona->getId());
    }

    public function testSetAndGetIdUsuario(): void
    {
        $idUsuario = 789;
        $this->persona->setIdUsuario($idUsuario);
        $this->assertEquals($idUsuario, $this->persona->getIdUsuario());
    }

    public function testSetAndGetIdTipodiscapacidad(): void
    {
        $idTipo = 2;
        $this->persona->setIdTipodiscapacidad($idTipo);
        $this->assertEquals($idTipo, $this->persona->getIdTipodiscapacidad());
    }

    public function testSetAndGetCv(): void
    {
        $cv = "Mi experiencia laboral...";
        $this->persona->setCv($cv);
        $this->assertEquals($cv, $this->persona->getCv());
    }

    public function testSetAndGetCertificaciones(): void
    {
        $certificaciones = "Certificación en PHP, JavaScript";
        $this->persona->setCertificaciones($certificaciones);
        $this->assertEquals($certificaciones, $this->persona->getCertificaciones());
    }

    public function testPersonaCompleta(): void
    {
        $datos = [
            'id' => 100,
            'idUsuario' => 100,
            'idTipodiscapacidad' => 3,
            'cv' => 'Curriculum vitae completo con toda mi experiencia...',
            'certificaciones' => 'PHP Developer, MySQL Expert, Scrum Master'
        ];

        $this->persona->setId($datos['id']);
        $this->persona->setIdUsuario($datos['idUsuario']);
        $this->persona->setIdTipodiscapacidad($datos['idTipodiscapacidad']);
        $this->persona->setCv($datos['cv']);
        $this->persona->setCertificaciones($datos['certificaciones']);

        $this->assertEquals($datos['id'], $this->persona->getId());
        $this->assertEquals($datos['idUsuario'], $this->persona->getIdUsuario());
        $this->assertEquals($datos['idTipodiscapacidad'], $this->persona->getIdTipodiscapacidad());
        $this->assertEquals($datos['cv'], $this->persona->getCv());
        $this->assertEquals($datos['certificaciones'], $this->persona->getCertificaciones());
    }

    public function testIdUsuarioEsIgualAId(): void
    {
        $id = 555;
        $this->persona->setId($id);
        $this->persona->setIdUsuario($id);
        
        $this->assertEquals($this->persona->getId(), $this->persona->getIdUsuario());
    }

    public function testValoresNulos(): void
    {
        $this->assertNull($this->persona->getId());
        $this->assertNull($this->persona->getIdUsuario());
        $this->assertNull($this->persona->getIdTipodiscapacidad());
        $this->assertNull($this->persona->getCv());
        $this->assertNull($this->persona->getCertificaciones());
    }
}
