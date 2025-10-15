<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}
require_once __DIR__ . '/../modelo/DAO/UsuarioDAO.php';
require_once __DIR__ . '/../modelo/DAO/EmpresaDAO.php';
require_once __DIR__ . '/../modelo/entidades/Usuario.php';
require_once __DIR__ . '/../modelo/entidades/Empresa.php';

$controller = new AuthControllerEmpresa();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->registrarEmpresa();
}

class AuthControllerEmpresa {
    private $usuarioDAO;
    private $empresaDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
        $this->empresaDAO = new EmpresaDAO();
    }

    public function registrarEmpresa() {
        $data = $_POST;

        try {
            
            $resultadoValidacion = $this->validarDatos($data);
            if ($resultadoValidacion !== true) {
                throw new Exception(implode("\n", $resultadoValidacion));
            }

            
            if ($this->usuarioDAO->emailExiste($data['email_usuario'])) {
                throw new Exception('El correo electrónico ya está registrado.');
            }

            
            $usuario = new Usuario();
            $usuario->setNombre($data['nombre_usuario']);
            $usuario->setApellido($data['apellido_usuario']);
            $usuario->setEmail($data['email_usuario']);
            $usuario->setClave($data['clave_usuario']);
            $usuario->setTipoDni($data['tipo_documento']);
            $usuario->setDni($data['numero_documento']);
            $usuario->setTelefono($data['telefono_usuario']);
            $usuario->setTipo('Empresa');

            $idUsuario = $this->usuarioDAO->registrar($usuario);

           
            $empresa = new Empresa();
            $empresa->setIdUsuario($idUsuario);
            $empresa->setNombreEmpresa($data['nombre_empresa']);
            $empresa->setRazonSocial($data['razon_social']);
            $empresa->setCondicionSocial($data['condicion_social']);
            $empresa->setDocumento($data['documento']);
            $empresa->setCalle($data['calle']);
            $empresa->setNumero($data['numero']);
            $empresa->setCodigoPostal($data['codigo_postal']);
            $empresa->setPais($data['pais']);
            $empresa->setIndustria($data['industria']);
            $empresa->setCantidadEmpleados($data['empleados']);
            $empresa->setPoliticaInclusion(null);
            $empresa->setDatosContacto(null);

            $this->empresaDAO->registrar($empresa);

            $this->alert('success', '¡Registro exitoso!', 'La empresa fue registrada correctamente.', '/inclusion_laboral2/index.php');

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                
                $this->alert('error', 'Correo duplicado', 'El correo ya está registrado en el sistema.', '/inclusion_laboral2/vista/empresa/registro_empresa.php');
            } else {
                $this->alert('error', 'Error en la base de datos', $e->getMessage(), '/inclusion_laboral2/vista/empresa/registro_empresa.php');
            }
        } catch (Exception $e) {
            $this->alert('error', 'Error', $e->getMessage(), '/inclusion_laboral2/vista/empresa/registro_empresa.php');
        }
    }

    private function validarDatos($post) {
        $errores = [];

      
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}$/", $post['nombre_usuario'])) {
            $errores[] = "El nombre del usuario debe tener entre 3 y 30 letras.";
        }
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}$/", $post['apellido_usuario'])) {
            $errores[] = "El apellido del usuario debe tener entre 3 y 30 letras.";
        }
        if (!preg_match("/^\d{7,11}$/", $post['numero_documento'])) {
            $errores[] = "El número de documento debe tener entre 7 y 11 dígitos.";
        }
        if (!preg_match("/^\d{8,12}$/", $post['telefono_usuario'])) {
            $errores[] = "El teléfono del usuario debe tener entre 8 y 12 dígitos.";
        }
        if (!filter_var($post['email_usuario'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico del usuario no es válido.";
        }
        if (strlen($post['clave_usuario']) < 6) {
            $errores[] = "La contraseña debe tener al menos 6 caracteres.";
        }

        
        if (!preg_match("/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ ]{3,50}$/", $post['nombre_empresa'])) {
            $errores[] = "El nombre de la empresa debe tener entre 3 y 50 caracteres.";
        }
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}$/", $post['razon_social'])) {
            $errores[] = "La razón social debe tener entre 3 y 50 letras.";
        }
        if (!preg_match("/^\d{11}$/", $post['documento'])) {
            $errores[] = "El CUIT debe tener exactamente 11 dígitos.";
        }
        if (!preg_match("/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ .,-]{3,50}$/", $post['calle'])) {
            $errores[] = "La calle debe tener entre 3 y 50 caracteres.";
        }
        if (!preg_match("/^\d{1,5}$/", $post['numero'])) {
            $errores[] = "El número de calle debe tener entre 1 y 5 dígitos.";
        }
        if (!preg_match("/^\d{4,5}$/", $post['codigo_postal'])) {
            $errores[] = "El código postal debe tener entre 4 y 5 dígitos.";
        }
        if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}$/", $post['industria'])) {
            $errores[] = "La industria debe tener entre 3 y 50 letras.";
        }
        if (!preg_match("/^\d{1,5}$/", $post['empleados'])) {
            $errores[] = "La cantidad de empleados debe ser un número válido.";
        }

        return empty($errores) ? true : $errores;
    }

    private function alert($icon, $title, $text, $redirect) {
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
