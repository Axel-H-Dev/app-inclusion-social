<?php
// Bloqueo de acceso directo
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}

require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../entidades/Postulacion.php';

class PostulacionDAO {
    /** @var PDO */
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getConexion();
    }

    public function existe($idPersona, $idOferta) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM postulaciones 
            WHERE id_persona = :id_persona AND id_oferta = :id_oferta
        ");
        $stmt->execute([
            'id_persona' => $idPersona,
            'id_oferta'  => $idOferta
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public function tieneCV($idPersona) {
        $stmt = $this->pdo->prepare("SELECT cv FROM persona WHERE id_persona = :id");
        $stmt->execute(['id' => $idPersona]);
        $cv = $stmt->fetchColumn();
        return !empty($cv);
    }

    public function guardar(Postulacion $postulacion) {
        $stmt = $this->pdo->prepare("
            INSERT INTO postulaciones (id_persona, id_oferta, fecha_postulacion, estado)
            VALUES (:id_persona, :id_oferta, :fecha_postulacion, :estado)
        ");
        return $stmt->execute([
            'id_persona'         => $postulacion->getPersona()->getId(),
            'id_oferta'          => $postulacion->getOferta()->getId(),
            'fecha_postulacion'  => $postulacion->getFechaPostulacion(),
            'estado'             => $postulacion->getEstado()
        ]);
    }

    public function obtenerPostulacion($idPersona, $idOferta) {
        $stmt = $this->pdo->prepare("
            SELECT fecha_postulacion 
            FROM postulaciones 
            WHERE id_persona = :id_persona AND id_oferta = :id_oferta
            LIMIT 1
        ");
        $stmt->execute([
            'id_persona' => $idPersona,
            'id_oferta'  => $idOferta
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lista de postulaciones para una oferta de una empresa, incluyendo discapacidad del postulante.
     */
    public function obtenerPorOfertaYEmpresa(int $idOferta, int $idEmpresa): array {
        $sql = "
        SELECT 
            ps.id                 AS id_postulacion,
            ps.estado,
            ps.fecha_postulacion,
            per.id_persona,
            u.nombre,
            u.apellido,
            u.email,
            u.telefono,
            o.titulo,
            per.id_tipodiscapacidad,
            td.discapacidad       AS discapacidad
        FROM postulaciones ps
        JOIN persona per           ON per.id_persona   = ps.id_persona
        JOIN usuario u             ON u.id_usuario     = per.id_persona
        JOIN ofertas_laborales o   ON o.id             = ps.id_oferta
        LEFT JOIN tipo_discapacidad td ON td.id        = per.id_tipodiscapacidad
        WHERE ps.id_oferta = :id_oferta
          AND o.id_empresa = :id_empresa
        ORDER BY ps.fecha_postulacion DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_oferta'  => $idOferta,
            ':id_empresa' => $idEmpresa
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cambiarEstado($idPostulacion, $nuevoEstado, $idEmpresa) {
        // Validar que la postulación pertenezca a una oferta de esta empresa
        $check = $this->pdo->prepare("
            SELECT o.id_empresa
            FROM postulaciones ps
            JOIN ofertas_laborales o ON o.id = ps.id_oferta
            WHERE ps.id = :id_postulacion
            LIMIT 1
        ");
        $check->execute([':id_postulacion' => $idPostulacion]);
        $row = $check->fetch(PDO::FETCH_ASSOC);
        if (!$row || (int)$row['id_empresa'] !== (int)$idEmpresa) {
            return false;
        }

        // Actualizar estado
        $stmt = $this->pdo->prepare("
            UPDATE postulaciones 
            SET estado = :estado
            WHERE id = :id_postulacion
        ");
        return $stmt->execute([
            ':estado'         => $nuevoEstado,
            ':id_postulacion' => $idPostulacion
        ]);
    }

    public function perteneceAOfertaDeEmpresa(int $idPersona, int $idOferta, int $idEmpresa): bool {
        $sql = "
            SELECT 1
            FROM postulaciones ps
            JOIN ofertas_laborales o ON o.id = ps.id_oferta
            WHERE ps.id_persona = :id_persona
              AND ps.id_oferta  = :id_oferta
              AND o.id_empresa  = :id_empresa
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_persona' => $idPersona,
            ':id_oferta'  => $idOferta,
            ':id_empresa' => $idEmpresa
        ]);
        return (bool)$stmt->fetchColumn();
    }

    public function obtenerPorPersona(int $idPersona): array {
        $sql = "
        SELECT 
            ps.id           AS id_postulacion,
            ps.estado,
            ps.fecha_postulacion,
            o.id            AS id_oferta,
            o.titulo,
            e.nombre_empresa
        FROM postulaciones ps
        JOIN ofertas_laborales o ON o.id = ps.id_oferta
        JOIN empresa e           ON e.id_empresa = o.id_empresa
        WHERE ps.id_persona = :id_persona
        ORDER BY ps.fecha_postulacion DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_persona' => $idPersona]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function retirarPostulacionDelete(int $idPostulacion, int $idPersona): bool {
        $stmt = $this->pdo->prepare("
            DELETE FROM postulaciones
            WHERE id = :id_postulacion
              AND id_persona = :id_persona
              AND estado IN ('pendiente','en revisión')
        ");
        return $stmt->execute([
            ':id_postulacion' => $idPostulacion,
            ':id_persona'     => $idPersona
        ]);
    }
}
