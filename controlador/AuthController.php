<?php

// Separar la lógica de ejecución de la definición de la clase
class AuthControllerUsuario {
    private $usuarioDAO;

    // Constantes para validaciones (más mantenible)
    private const NOMBRE_PATTERN = "/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}$/";
    private const DOCUMENTO_PATTERN = "/^\d{7,11}$/";
    private const TELEFONO_PATTERN = "/^\d{8,12}$/";
    private const CLAVE_MIN_LENGTH = 6;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    // Mover lógica de headers a un método separado
    public static function checkRequestMethod() {
        if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../index.php");
            exit();
        }
    }

    public function registrarUsuario() {
        $data = $_POST;

        try {
            $resultadoValidacion = $this->validarDatos($data);
            if ($resultadoValidacion !== true) {
                throw new Exception(implode("\n", $resultadoValidacion));
            }

            if ($this->usuarioDAO->emailExiste($data['email'])) {
                throw new Exception('El correo electrónico ya está registrado.');
            }

            // Crear usuario
            $usuario = $this->crearUsuario($data);
            $idUsuario = $this->usuarioDAO->registrar($usuario); 

            // Crear persona
            $this->crearPersona($idUsuario, $data);

            $this->alert('success', '¡Registro exitoso!', 'El usuario fue registrado correctamente.', '/inclusion_laboral2/index.php');

        } catch (PDOException $e) {
            $this->manejarErrorPDO($e);
        } catch (Exception $e) {
            $this->alert('error', 'Error', $e->getMessage(), '/inclusion_laboral2/vista/usuario/registro_usuario.php');
        }
    }

    // Extraer creación de usuario a método separado con sanitización
    private function crearUsuario($data) {
        $usuario = new Usuario();
        $usuario->setNombre(trim($data['nombre']));
        $usuario->setApellido(trim($data['apellido']));
        $usuario->setEmail(trim(strtolower($data['email'])));
        $usuario->setClave($data['clave']); 
        $usuario->setTipoDni($data['tipo_doc']);
        $usuario->setDni($data['documento']);
        $usuario->setTelefono($data['celular']);
        $usuario->setTipo('Persona');
        return $usuario;
    }

    // Extraer creación de persona a método separado
    private function crearPersona($idUsuario, $data) {
        require_once __DIR__ . '/../modelo/DAO/PersonaDAO.php';
        require_once __DIR__ . '/../modelo/entidades/Persona.php';

        $personaDAO = new PersonaDAO();
        $persona = new Persona();
        $persona->setIdUsuario($idUsuario); 
        $persona->setIdTipodiscapacidad($data['discapacidad']);
        $persona->setCv(null);
        $persona->setCertificaciones(null);
        
        $personaDAO->registrar($persona);
    }

    // Método separado para manejo de errores PDO
    private function manejarErrorPDO($e) {
        if ($e->getCode() == '23000') {
            $this->alert('error', 'Correo duplicado', 'El correo ya está registrado en el sistema.', '/inclusion_laboral2/vista/usuario/registro_usuario.php');
        } else {
            $this->alert('error', 'Error en la base de datos', 'Error inesperado: ' . $e->getMessage(), '/inclusion_laboral2/vista/usuario/registro_usuario.php');
        }
    }

    // Usar constantes en las validaciones con mejor seguridad
    public function validarDatos($post) {
        $errores = [];

        // Validar nombre
        $nombre = trim($post['nombre'] ?? '');
        if (!preg_match(self::NOMBRE_PATTERN, $nombre)) {
            $errores[] = "El nombre debe tener entre 3 y 30 letras.";
        }

        // Validar apellido
        $apellido = trim($post['apellido'] ?? '');
        if (!preg_match(self::NOMBRE_PATTERN, $apellido)) {
            $errores[] = "El apellido debe tener entre 3 y 30 letras.";
        }

        // Validar documento
        $documento = trim($post['documento'] ?? '');
        if (!preg_match(self::DOCUMENTO_PATTERN, $documento)) {
            $errores[] = "El número de documento debe tener entre 7 y 11 dígitos.";
        }

        // Validar teléfono
        $celular = trim($post['celular'] ?? '');
        if (!preg_match(self::TELEFONO_PATTERN, $celular)) {
            $errores[] = "El teléfono debe tener entre 8 y 12 dígitos.";
        }

        // Validar email
        $email = trim($post['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
        }

        // Validar contraseña
        $clave = $post['clave'] ?? '';
        if (strlen($clave) < self::CLAVE_MIN_LENGTH) {
            $errores[] = "La contraseña debe tener al menos " . self::CLAVE_MIN_LENGTH . " caracteres.";
        }

        // Validar discapacidad
        if (empty($post['discapacidad'])) {
            $errores[] = "Debe seleccionar una discapacidad.";
        }

        return empty($errores) ? true : $errores;
    }

    // Método alert con protección XSS
    private function alert($icon, $title, $text, $redirect) {
        // Escapar datos para prevenir XSS
        $icon = htmlspecialchars($icon, ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        $redirect = htmlspecialchars($redirect, ENT_QUOTES, 'UTF-8');

        echo "
        <html><head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head><body>
        <script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                text: '$text',
                confirmButtonText: 'Aceptar',
                timer: 4000,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '$redirect';
            }).catch(() => {
                window.location.href = '$redirect';
            });
            setTimeout(() => {
                window.location.href = '$redirect';
            }, 4000);
        </script>
        </body></html>";
        exit;
    }
}

// Mover la lógica de ejecución al final
require_once __DIR__ . '/../modelo/DAO/UsuarioDAO.php';
require_once __DIR__ . '/../modelo/entidades/Usuario.php';

// Solo ejecutar si no estamos en modo testing
if (!defined('TESTING')) {
    AuthControllerUsuario::checkRequestMethod();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new AuthControllerUsuario();
        $controller->registrarUsuario();
    }
}