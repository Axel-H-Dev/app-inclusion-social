<?php


if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';
require_once __DIR__ . '/../entidades/Empresa.php';

class EmpresaDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getConexion();
    }

    public function registrar(Empresa $empresa) {
        $sql = "INSERT INTO empresa (
                    id_empresa, nombre_empresa, razon_social, condicion_social, documento,
                    calle, numero, codigo_postal, pais, industria, cantidad_empleados, 
                    politica_inclusion, datos_contacto
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $empresa->getIdUsuario(), 
            $empresa->getNombreEmpresa(),
            $empresa->getRazonSocial(),
            $empresa->getCondicionSocial(),
            $empresa->getDocumento(),
            $empresa->getCalle(),
            $empresa->getNumero(),
            $empresa->getCodigoPostal(),
            $empresa->getPais(),
            $empresa->getIndustria(),
            $empresa->getCantidadEmpleados(),
            $empresa->getPoliticaInclusion(),
            $empresa->getDatosContacto()
        ]);
    }
       public function obtenerPorId($idEmpresa) {
        $sql = "SELECT * FROM empresa WHERE id_empresa = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $idEmpresa]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $empresa = new Empresa();
            $empresa->setIdUsuario($row['id_empresa']);
            $empresa->setNombreEmpresa($row['nombre_empresa']);
            $empresa->setRazonSocial($row['razon_social']);
            $empresa->setCondicionSocial($row['condicion_social']);
            $empresa->setDocumento($row['documento']);
            $empresa->setCalle($row['calle']);
            $empresa->setNumero($row['numero']);
            $empresa->setCodigoPostal($row['codigo_postal']);
            $empresa->setTelefono($row['telefono']);
            $empresa->setPais($row['pais']);
            $empresa->setIndustria($row['industria']);
            $empresa->setCantidadEmpleados($row['cantidad_empleados']);
            $empresa->setPoliticaInclusion($row['politica_inclusion']);
            $empresa->setDatosContacto($row['datos_contacto']);
            return $empresa;
        }
        return null;
    }

    public function actualizar(Empresa $empresa) {
        $sql = "UPDATE empresa SET 
                    nombre_empresa = :ne, razon_social = :rs, condicion_social = :cs, documento = :doc,
                    calle = :calle, numero = :num, codigo_postal = :cp, telefono = :tel,
                    pais = :pais, industria = :ind, cantidad_empleados = :emp,
                    politica_inclusion = :pi, datos_contacto = :dc
                WHERE id_empresa = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':ne' => $empresa->getNombreEmpresa(),
            ':rs' => $empresa->getRazonSocial(),
            ':cs' => $empresa->getCondicionSocial(),
            ':doc' => $empresa->getDocumento(),
            ':calle' => $empresa->getCalle(),
            ':num' => $empresa->getNumero(),
            ':cp' => $empresa->getCodigoPostal(),
            ':tel' => $empresa->getTelefono(),
            ':pais' => $empresa->getPais(),
            ':ind' => $empresa->getIndustria(),
            ':emp' => $empresa->getCantidadEmpleados(),
            ':pi'  => $empresa->getPoliticaInclusion(),
            ':dc'  => $empresa->getDatosContacto(),
            ':id' => $empresa->getIdUsuario()
        ]);
    }
}
