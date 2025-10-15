<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}
require_once __DIR__ . '/../modelo/DAO/UsuarioDAO.php';
require_once __DIR__ . '/../modelo/entidades/Usuario.php';

$controller = new login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login($_POST['email'], $_POST['clave']);
}

class login
{
    private $usuarioDAO;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function login($email, $clave)
    {
        try {
            $usuario = $this->usuarioDAO->login($email, $clave);

            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario->getIdUsuario();
                $_SESSION['rol'] = $usuario->getTipo();

                $_SESSION['usuario_nombre']  = method_exists($usuario, 'getNombre')  ? ($usuario->getNombre()  ?? '') : '';
    $_SESSION['usuario_apellido'] = method_exists($usuario, 'getApellido') ? ($usuario->getApellido() ?? '') : '';

                switch ($usuario->getTipo()) {
                    case 'Persona':
                        $this->redirect('../vista/Usuario/usuario.php');
                        break;
                    case 'Empresa':
                        $this->redirect('perfilempresacontroller.php');
                        break;
                    case 'Administrador':
                        $this->redirect('adminusuarioscontroller.php');
                        break;
                    default:
                        throw new Exception('Tipo de usuario desconocido.');
                }
            } else {
                throw new Exception('Correo o contraseña incorrectos.');
            }
        } catch (Exception $e) {
            $this->alert('error', 'Error de inicio de sesión', $e->getMessage(), '/inclusion_laboral2/index.php');
        }
    }

    private function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    private function alert($icon, $title, $text, $redirect)
    {
        echo "
        <html><head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head><body>
        <script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                text: '$text',
                confirmButtonText: 'Intentar de nuevo'
            }).then(() => {
                window.location.href = '$redirect';
            });
        </script>
        </body></html>";
        exit;
    }
}
