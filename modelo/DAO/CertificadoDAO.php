<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';


class CertificadoDAO implements ICertificadoDAO {
    /** @var PDO */
    private $pdo;
    private $table = 'certificado';

    public function __construct() {
        $this->pdo = (new Conexion())->getConexion();
    }

    public function crear(Certificado $c) {
        $sql = "INSERT INTO {$this->table}
                (codigo_unico, id_inscripcion, id_usuario, id_curso, fecha_emision, url_validacion)
                VALUES (:cod, :ins, :usr, :cur, :fe, :url)";
        $st = $this->pdo->prepare($sql);
        $st->execute([
            ':cod' => $c->getCodigoUnico(),
            ':ins' => $c->getInscripcionId(),
            ':usr' => $c->getUsuarioId(),
            ':cur' => $c->getCursoId(),
            ':fe'  => $c->getFechaEmision(),
            ':url' => $c->getUrlValidacion(),
        ]);
        $c->setId($this->pdo->lastInsertId());
        return $c;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT c.* FROM {$this->table} c WHERE c.id_certificado = :id";
        $st = $this->pdo->prepare($sql);
        $st->execute([':id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->map($row) : null;
    }

    public function obtenerPorCodigo($codigo) {
        $st = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE codigo_unico = :c");
        $st->execute([':c' => $codigo]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->map($row) : null;
    }

    public function obtenerPorUsuario($id_usuario) {
        $st = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id_usuario = :u ORDER BY fecha_emision DESC");
        $st->execute([':u' => $id_usuario]);
        $out = [];
        while ($r = $st->fetch(PDO::FETCH_ASSOC)) $out[] = $this->map($r);
        return $out;
    }

    public function verificarCertificado($codigo) {
        
        $sql = "SELECT
                    c.codigo_unico,
                    c.fecha_emision,
                    u.id_usuario,
                    CONCAT(u.nombre, ' ', u.apellido) AS usuario_nombre,
                    cu.id_curso,
                    cu.titulo AS curso_titulo,
                    cu.duracion_horas,
                    e.id_empresa,
                    e.nombre_empresa AS empresa_nombre
                FROM {$this->table} c
                INNER JOIN usuario u ON u.id_usuario = c.id_usuario
                INNER JOIN curso cu    ON cu.id_curso   = c.id_curso
                LEFT  JOIN empresa e   ON e.id_empresa  = cu.id_empresa
                WHERE c.codigo_unico = :codigo";
        $st = $this->pdo->prepare($sql);
        $st->execute([':codigo' => $codigo]);
        return $st->fetch(PDO::FETCH_ASSOC) ?: null;
    }

 
    private function map(array $row): Certificado {
        $c = new Certificado();
        $c->setId($row['id_certificado']);
        $c->setCodigoUnico($row['codigo_unico']);
        $c->setInscripcionId($row['id_inscripcion']);
        $c->setUsuarioId($row['id_usuario']);
        $c->setCursoId($row['id_curso']);
        $c->setFechaEmision($row['fecha_emision']);
        if (isset($row['url_validacion'])) $c->setUrlValidacion($row['url_validacion']);
        return $c;
    }
}
