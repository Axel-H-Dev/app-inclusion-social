<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';


class InscripcionDAO implements IInscripcionDAO {
    /** @var PDO */
    private $pdo;
    private $table = 'inscripcion';

    public function __construct() {
        $this->pdo = (new Conexion())->getConexion();
    }

    public function crear(Inscripcion $i) {
        $sql = "INSERT INTO {$this->table}
                (id_curso, id_usuario, fecha_inscripcion, progreso, estado)
                VALUES (:c, :u, :fi, :pr, :es)";
        $st = $this->pdo->prepare($sql);
        $st->execute([
            ':c'  => $i->getCursoId(),
            ':u'  => $i->getUsuarioId(),
            ':fi' => $i->getFechaInscripcion(),
            ':pr' => $i->getProgreso(),
            ':es' => $i->getEstado(),
        ]);
        $i->setId($this->pdo->lastInsertId());
        return $i;
    }

    public function obtenerPorId($id) {
        $st = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id_inscripcion = :id");
        $st->execute([':id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->map($row) : null;
    }

    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT i.*
                FROM {$this->table} i
                WHERE i.id_usuario = :u
                ORDER BY i.fecha_inscripcion DESC";
        $st = $this->pdo->prepare($sql);
        $st->execute([':u' => $id_usuario]);
        $out = [];
        while ($r = $st->fetch(PDO::FETCH_ASSOC)) $out[] = $this->map($r);
        return $out;
    }

    public function obtenerPorCurso($id_curso) {
        $st = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id_curso = :c");
        $st->execute([':c' => $id_curso]);
        $out = [];
        while ($r = $st->fetch(PDO::FETCH_ASSOC)) $out[] = $this->map($r);
        return $out;
    }

    public function actualizar(Inscripcion $i) {
        $sql = "UPDATE {$this->table}
                SET progreso = :p,
                    estado = :e,
                    fecha_inicio = :fi,
                    fecha_completado = :fc
                WHERE id_inscripcion = :id";
        $st = $this->pdo->prepare($sql);
        return $st->execute([
            ':p'  => $i->getProgreso(),
            ':e'  => $i->getEstado(),
            ':fi' => $i->getFechaInicio(),
            ':fc' => $i->getFechaCompletado(),
            ':id' => $i->getId(),
        ]);
    }

    public function verificarInscripcion($id_usuario, $id_curso) {
        $st = $this->pdo->prepare("SELECT 1 FROM {$this->table} WHERE id_usuario = :u AND id_curso = :c LIMIT 1");
        $st->execute([':u' => $id_usuario, ':c' => $id_curso]);
        return (bool)$st->fetchColumn();
    }

    public function actualizarProgreso($id_inscripcion, $progreso) {
        $sql = "UPDATE {$this->table}
                SET progreso = :p,
                    estado = CASE WHEN :p = 0 THEN 'inscrito' ELSE 'en_progreso' END
                WHERE id_inscripcion = :id";
        $st = $this->pdo->prepare($sql);
        return $st->execute([':p' => $progreso, ':id' => $id_inscripcion]);
    }

    public function completarCurso($id_inscripcion) {
        $sql = "UPDATE {$this->table}
                SET progreso = 100,
                    estado = 'completado',
                    fecha_completado = NOW()
                WHERE id_inscripcion = :id";
        $st = $this->pdo->prepare($sql);
        return $st->execute([':id' => $id_inscripcion]);
    }



    public function obtenerPorUsuarioCurso(int $id_usuario, int $id_curso): ?Inscripcion {
        $st = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id_usuario=:u AND id_curso=:c LIMIT 1");
        $st->execute([':u'=>$id_usuario, ':c'=>$id_curso]);
        $r = $st->fetch(PDO::FETCH_ASSOC);
        return $r ? $this->map($r) : null;
    }

    public function fijarInicioSiNulo(int $id_inscripcion): void {
        $this->pdo
            ->prepare("UPDATE {$this->table} SET fecha_inicio = IFNULL(fecha_inicio, NOW()) WHERE id_inscripcion=?")
            ->execute([$id_inscripcion]);
    }

   public function setProgresoYEstado(int $id_inscripcion, int $progreso): void {
    $estado = $progreso >= 100 ? 'completado' : ($progreso > 0 ? 'en_progreso' : 'inscrito');
    $sql = "UPDATE {$this->table}
            SET progreso = :p,
                estado   = :e,
                fecha_completado = CASE WHEN :p2 >= 100 THEN NOW() ELSE fecha_completado END
            WHERE id_inscripcion = :id";
    $st = $this->pdo->prepare($sql);
    $st->execute([
        ':p'  => $progreso,
        ':p2' => $progreso,   
        ':e'  => $estado,
        ':id' => $id_inscripcion
    ]);
}


 
    private function map(array $row): Inscripcion {
        $i = new Inscripcion();
        $i->setId($row['id_inscripcion']);
        $i->setCursoId($row['id_curso']);
        $i->setUsuarioId($row['id_usuario']);
        $i->setFechaInscripcion($row['fecha_inscripcion']);
        if (isset($row['fecha_inicio']))     $i->setFechaInicio($row['fecha_inicio']);
        if (isset($row['fecha_completado'])) $i->setFechaCompletado($row['fecha_completado']);
        $i->setProgreso($row['progreso']);
        $i->setEstado($row['estado']);
        return $i;
    }
}
