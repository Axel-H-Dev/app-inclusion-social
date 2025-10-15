<?php

use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    public function testValidacionNombreValido(): void
    {
        $nombre = "Juan Carlos";
        $patron = "/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}$/";
        $this->assertMatchesRegularExpression($patron, $nombre);
    }

    public function testValidacionNombreInvalido(): void
    {
        $nombre = "A";
        $patron = "/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}$/";
        $this->assertDoesNotMatchRegularExpression($patron, $nombre);
    }

    public function testValidacionEmailValido(): void
    {
        $email = "usuario@ejemplo.com";
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    public function testValidacionEmailInvalido(): void
    {
        $email = "email-invalido";
        $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    public function testValidacionDocumentoValido(): void
    {
        $documento = "12345678";
        $patron = "/^\d{7,11}$/";
        $this->assertMatchesRegularExpression($patron, $documento);
    }

    public function testValidacionDocumentoInvalido(): void
    {
        $documento = "123";
        $patron = "/^\d{7,11}$/";
        $this->assertDoesNotMatchRegularExpression($patron, $documento);
    }
}
