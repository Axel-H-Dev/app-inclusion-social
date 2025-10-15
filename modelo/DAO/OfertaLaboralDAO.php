<?php

// Evitar acceso directo por URL
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../entidades/OfertaLaboral.php';

class OfertaLaboralDAO
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = (new Conexion())->getConexion();
    }
public function obtenerDetalle($id) {
    $stmt = $this->pdo->prepare("
        SELECT o.*, p.nombre AS provincia, l.nombre AS localidad, td.discapacidad AS tipo_discapacidad, e.nombre_empresa
        FROM ofertas_laborales o
        JOIN provincia p ON o.id_provincia = p.id_provincia
        JOIN localidad l ON o.id_localidad = l.id_localidad
        JOIN tipo_discapacidad td ON o.id_tipocapacidad = td.id
        JOIN empresa e ON o.id_empresa = e.id_empresa
        WHERE o.id = :id
    ");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function registrar(OfertaLaboral $oferta)
    {
        $sql = "INSERT INTO ofertas_laborales (
            id_empresa, titulo, descripcion, tipo_modalidad, tipo_trabajo, 
            carga_horaria, salario_estimado, id_tipocapacidad, id_provincia, id_localidad
        ) VALUES (
            :id_empresa, :titulo, :descripcion, :tipo_modalidad, :tipo_trabajo,
            :carga_horaria, :salario_estimado, :id_tipocapacidad, :id_provincia, :id_localidad
        )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_empresa' => $oferta->getIdEmpresa(),
            ':titulo' => $oferta->getTitulo(),
            ':descripcion' => $oferta->getDescripcion(),
            ':tipo_modalidad' => $oferta->getTipoModalidad(),
            ':tipo_trabajo' => $oferta->getTipoTrabajo(),
            ':carga_horaria' => $oferta->getCargaHoraria(),
            ':salario_estimado' => $oferta->getSalarioEstimado(),
            ':id_tipocapacidad' => $oferta->getIdTipoCapacidad(),
            ':id_provincia' => $oferta->getIdProvincia(),
            ':id_localidad' => $oferta->getIdLocalidad()
        ]);
        return $this->pdo->lastInsertId();
    }
    public function obtenerPorEmpresa($idEmpresa)
    {
        $stmt = $this->pdo->prepare("
            SELECT o.*, p.nombre AS provincia, l.nombre AS localidad, t.discapacidad
            FROM ofertas_laborales o
            JOIN provincia p ON o.id_provincia = p.id_provincia
            JOIN localidad l ON o.id_localidad = l.id_localidad
            JOIN tipo_discapacidad t ON o.id_tipocapacidad = t.id
            WHERE o.id_empresa = :id_empresa
            ORDER BY o.fecha_publicacion DESC
        ");
        $stmt->execute([':id_empresa' => $idEmpresa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id, $idEmpresa)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ofertas_laborales WHERE id = :id AND id_empresa = :id_empresa");
        $stmt->execute([
            ':id' => $id,
            ':id_empresa' => $idEmpresa
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE ofertas_laborales SET 
                titulo = :titulo,
                descripcion = :descripcion,
                tipo_modalidad = :tipo_modalidad,
                tipo_trabajo = :tipo_trabajo,
                carga_horaria = :carga_horaria,
                salario_estimado = :salario_estimado
            WHERE id = :id AND id_empresa = :id_empresa
        ");
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':descripcion' => $data['descripcion'],
            ':tipo_modalidad' => $data['tipo_modalidad'],
            ':tipo_trabajo' => $data['tipo_trabajo'],
            ':carga_horaria' => $data['carga_horaria'],
            ':salario_estimado' => $data['salario_estimado'],
            ':id' => $data['id'],
            ':id_empresa' => $data['id_empresa']
        ]);
        return $stmt->rowCount();
    }

    public function eliminar($idOferta, $idEmpresa)
    {
        $stmt = $this->pdo->prepare("DELETE FROM ofertas_laborales WHERE id = :id AND id_empresa = :id_empresa");
        $stmt->execute([
            ':id' => $idOferta,
            ':id_empresa' => $idEmpresa
        ]);
        return $stmt->rowCount();
    }
public function buscarOfertas($filtros, $offset = 0, $limite = 10)
{
    $conditions = [];
    $params = [];

    
    if (!empty($filtros['buscar'])) {
        $conditions[] = "LOWER(o.titulo) LIKE :buscar";
        $params['buscar'] = '%' . strtolower(trim($filtros['buscar'])) . '%';
    }

  
    if (!empty($filtros['modalidad'])) {
        $conditions[] = "o.tipo_modalidad = :modalidad";
        $params['modalidad'] = $filtros['modalidad'];
    }

    if (!empty($filtros['tipo_trabajo'])) {
        $conditions[] = "o.tipo_trabajo = :tipo_trabajo";
        $params['tipo_trabajo'] = $filtros['tipo_trabajo'];
    }

    if (!empty($filtros['provincia'])) {
        $conditions[] = "o.id_provincia = :id_provincia";
        $params['id_provincia'] = $filtros['provincia'];
    }

    if (!empty($filtros['localidad'])) {
        $conditions[] = "o.id_localidad = :id_localidad";
        $params['id_localidad'] = $filtros['localidad'];
    }

    if (!empty($filtros['discapacidad'])) {
        $conditions[] = "o.id_tipocapacidad = :id_discapacidad";
        $params['id_discapacidad'] = $filtros['discapacidad'];
    }

    
    $sqlBase = "
        FROM ofertas_laborales o
        JOIN provincia p ON o.id_provincia = p.id_provincia
        JOIN localidad l ON o.id_localidad = l.id_localidad
        JOIN tipo_discapacidad td ON o.id_tipocapacidad = td.id
    ";

    if (!empty($conditions)) {
        $sqlBase .= " WHERE " . implode(" AND ", $conditions);
    }

   
    $sqlCount = "SELECT COUNT(*) " . $sqlBase;
    $stmtCount = $this->pdo->prepare($sqlCount);
    $stmtCount->execute($params);
    $total = $stmtCount->fetchColumn();

   
    $sql = "
        SELECT o.id, o.titulo, o.tipo_modalidad, o.tipo_trabajo, o.fecha_publicacion,
               p.nombre AS provincia, l.nombre AS localidad, td.discapacidad AS tipo_discapacidad
        $sqlBase
    ";

    switch ($filtros['orden'] ?? '') {
        case '1':
            $sql .= " ORDER BY o.fecha_publicacion ASC";
            break;
        case '2':
            $sql .= " ORDER BY o.fecha_publicacion DESC";
            break;
        case '3':
            $sql .= " ORDER BY o.titulo ASC";
            break;
        default:
            $sql .= " ORDER BY o.fecha_publicacion DESC";
            break;
    }

   
    $sql .= " LIMIT " . (int)$offset . ", " . (int)$limite;

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['resultados' => $resultados, 'total' => $total];
}
public function perteneceAEmpresa(int $idOferta, int $idEmpresa): bool {
    $stmt = $this->pdo->prepare("
        SELECT 1
        FROM ofertas_laborales
        WHERE id = :id AND id_empresa = :emp
        LIMIT 1
    ");
    $stmt->execute([':id' => $idOferta, ':emp' => $idEmpresa]);
    return (bool)$stmt->fetchColumn();
}

}
