<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';


class CursoDAO implements ICursoDAO {
    /** @var PDO */
    private $pdo;
    private $table = 'curso';

    public function __construct() {
        $this->pdo = (new Conexion())->getConexion(); 
    }

    public function crear(Curso $c) {
        $sql = "INSERT INTO {$this->table}
                (titulo, descripcion, duracion_horas, id_empresa, publicado, fecha_creacion)
                VALUES (:t, :d, :h, :emp, :pub, :fc)";
        $st = $this->pdo->prepare($sql);
        $st->execute([
            ':t'   => $c->getTitulo(),
            ':d'   => $c->getDescripcion(),
            ':h'   => $c->getDuracionHoras(),
            ':emp' => $c->getEmpresaId(),
            ':pub' => $c->isPublicado() ? 1 : 0,
            ':fc'  => $c->getFechaCreacion(),
        ]);
        $c->setId($this->pdo->lastInsertId());
        return $c;
    }

    public function obtenerPorId($id) {
        $st = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id_curso = :id");
        $st->execute([':id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->map($row) : null;
    }

    public function obtenerTodos() {
        $rs = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY fecha_creacion DESC");
        $out = [];
        while ($r = $rs->fetch(PDO::FETCH_ASSOC)) $out[] = $this->map($r);
        return $out;
    }

    public function obtenerPorEmpresa($id_empresa) {
        $st = $this->pdo->prepare("SELECT * FROM {$this->table}
                                   WHERE id_empresa = :e
                                   ORDER BY fecha_creacion DESC");
        $st->execute([':e' => $id_empresa]);
        $out = [];
        while ($r = $st->fetch(PDO::FETCH_ASSOC)) $out[] = $this->map($r);
        return $out;
    }

    public function actualizar(Curso $c) {
        $sql = "UPDATE {$this->table}
                SET titulo = :t,
                    descripcion = :d,
                    duracion_horas = :h,
                    publicado = :p,
                    fecha_actualizacion = NOW()
                WHERE id_curso = :id";
        $st = $this->pdo->prepare($sql);
        return $st->execute([
            ':t'  => $c->getTitulo(),
            ':d'  => $c->getDescripcion(),
            ':h'  => $c->getDuracionHoras(),
            ':p'  => $c->isPublicado() ? 1 : 0,
            ':id' => $c->getId(),
        ]);
    }

    public function desactivar($id_curso) {
        $st = $this->pdo->prepare("UPDATE {$this->table} SET publicado = 0 WHERE id_curso = :id");
        return $st->execute([':id' => $id_curso]);
    }

    public function obtenerActivos() {
        $rs = $this->pdo->query("SELECT * FROM {$this->table} WHERE publicado = 1 ORDER BY fecha_creacion DESC");
        $out = [];
        while ($r = $rs->fetch(PDO::FETCH_ASSOC)) $out[] = $this->map($r);
        return $out;
    }

    
    private function map(array $row): Curso {
        $c = new Curso();
        $c->setId($row['id_curso']);
        $c->setTitulo($row['titulo']);
        $c->setDescripcion($row['descripcion']);
        $c->setDuracionHoras($row['duracion_horas']);
        $c->setEmpresaId($row['id_empresa']);
        $c->setPublicado($row['publicado']);
        $c->setFechaCreacion($row['fecha_creacion']);
        if (isset($row['fecha_actualizacion'])) $c->setFechaActualizacion($row['fecha_actualizacion']);
        return $c;
    }
}
