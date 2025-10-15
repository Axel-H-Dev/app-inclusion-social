<?php

class TestableAuthController {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function validarDatos($post) {
        $errores = [];

        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}$/", $post['nombre'])) {
            $errores[] = "El nombre debe tener entre 3 y 30 letras.";
        }
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}$/", $post['apellido'])) {
            $errores[] = "El apellido debe tener entre 3 y 30 letras.";
        }
        if (!preg_match("/^\d{7,11}$/", $post['documento'])) {
            $errores[] = "El número de documento debe tener entre 7 y 11 dígitos.";
        }
        if (!preg_match("/^\d{8,12}$/", $post['celular'])) {
            $errores[] = "El teléfono debe tener entre 8 y 12 dígitos.";
        }
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
        }
        if (strlen($post['clave']) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres.";
        }
        if (empty($post['discapacidad'])) {
            $errores[] = "Debe seleccionar una discapacidad.";
        }

        return empty($errores) ? true : $errores;
    }
}
