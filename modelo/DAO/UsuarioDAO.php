<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../entidades/Usuario.php';

class UsuarioDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Conexion())->getConexion();
    }

    public function registrar(Usuario $usuario)
    {
        $sql = "INSERT INTO usuario (nombre, apellido, email, clave, tipo_dni, dni, telefono, tipo)
                VALUES (:nombre, :apellido, :email, :clave, :tipo_dni, :dni, :telefono, :tipo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nombre' => $usuario->getNombre(),
            'apellido' => $usuario->getApellido(),
            'email' => $usuario->getEmail(),
            'clave' => password_hash($usuario->getClave(), PASSWORD_DEFAULT),
            'tipo_dni' => $usuario->getTipoDni(),
            'dni' => $usuario->getDni(),
            'telefono' => $usuario->getTelefono(),
            'tipo' => $usuario->getTipo()
        ]);

        return $this->pdo->lastInsertId();
    }

    public function emailExiste($email)
    {
        $sql = "SELECT COUNT(*) FROM usuario WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
    public function login($email, $clave)
    {
        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioData && password_verify($clave, $usuarioData['clave'])) {
            $usuario = new Usuario();
            $usuario->setIdUsuario($usuarioData['id_usuario']);
            $usuario->setNombre($usuarioData['nombre']);
            $usuario->setApellido($usuarioData['apellido']);
            $usuario->setEmail($usuarioData['email']);
            $usuario->setTipo($usuarioData['tipo']);
            return $usuario;
        }

        return null;
    }
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuarioData) {
            $usuario = new Usuario();
            $usuario->setIdUsuario($usuarioData['id_usuario']);
            $usuario->setNombre($usuarioData['nombre']);
            $usuario->setApellido($usuarioData['apellido']);
            $usuario->setEmail($usuarioData['email']);
            $usuario->setTipoDni($usuarioData['tipo_dni']);
            $usuario->setDni($usuarioData['dni']);
            $usuario->setTelefono($usuarioData['telefono']);
            $usuario->setTipo($usuarioData['tipo']);
            return $usuario;
        }

        return null;
    }
    public function actualizar(Usuario $usuario)
    {
        $sql = "UPDATE usuario SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono
                WHERE id_usuario = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nombre' => $usuario->getNombre(),
            'apellido' => $usuario->getApellido(),
            'email' => $usuario->getEmail(),
            'telefono' => $usuario->getTelefono(),
            'id' => $usuario->getIdUsuario()
        ]);
    }
    public function obtenerTodos()
    {
        $sql = "SELECT * FROM usuario WHERE tipo != 'Administrador' ORDER BY id_usuario ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function eliminar($id) {
    try {
        $this->pdo->beginTransaction();

       
        $stmtEmp = $this->pdo->prepare("DELETE FROM empresa WHERE id_empresa = :id");
        $stmtEmp->execute(['id' => $id]);

        
        $stmtPer = $this->pdo->prepare("DELETE FROM persona WHERE id_persona = :id");
        $stmtPer->execute(['id' => $id]);

     
        $stmtUsr = $this->pdo->prepare("DELETE FROM usuario WHERE id_usuario = :id AND tipo != 'Administrador'");
        $stmtUsr->execute(['id' => $id]);

        $this->pdo->commit();

      
        return $stmtUsr->rowCount() > 0;

    } catch (Exception $e) {
        $this->pdo->rollBack();
        error_log("Error al eliminar usuario: " . $e->getMessage());
        return false;
    }
}

}
