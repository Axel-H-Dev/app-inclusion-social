<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';


class LeccionDAO {
  /** @var PDO */
  private $pdo;
  private $table = 'curso_leccion';

  public function __construct(){
    $this->pdo = (new Conexion())->getConexion();
  }


  private function map(array $r): Leccion {
    $l = new Leccion();
    $l->setId($r['id_leccion']);
    $l->setCursoId($r['id_curso']);
    $l->setTitulo($r['titulo']);
    $l->setTipo($r['tipo']);
    if (isset($r['url_pdf']))         $l->setUrlPdf($r['url_pdf']);
    if (isset($r['contenido_texto'])) $l->setContenidoTexto($r['contenido_texto']);
    $l->setOrden($r['orden']);
    return $l;
  }

  private function nextOrden(int $id_curso): int {
    $st = $this->pdo->prepare("SELECT COALESCE(MAX(orden),0)+1 FROM {$this->table} WHERE id_curso=?");
    $st->execute([$id_curso]);
    return (int)$st->fetchColumn();
  }


  public function crearTexto(int $id_curso, string $titulo, string $contenido, int $orden = 0): Leccion {
    if ($orden <= 0) { $orden = $this->nextOrden($id_curso); }
    $sql = "INSERT INTO {$this->table}(id_curso,titulo,tipo,contenido_texto,orden)
            VALUES (?,?,?,?,?)";
    $this->pdo->prepare($sql)->execute([$id_curso, $titulo, 'texto', $contenido, $orden]);
    $id = (int)$this->pdo->lastInsertId();
    return $this->obtener($id);
  }

  public function crearPdf(int $id_curso, string $titulo, array $file, int $orden = 0, string $uploadsBase): Leccion {
    if ($orden <= 0) { $orden = $this->nextOrden($id_curso); }

    if ($file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException("Error al subir archivo");
    if (!isset($file['size']) || $file['size'] > 10 * 1024 * 1024) {
      throw new RuntimeException("Máximo 10 MB");
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    if ($mime !== 'application/pdf') throw new RuntimeException("El archivo debe ser PDF");

 
    $dir = rtrim($uploadsBase,'/') . "/cursos/$id_curso/pdfs";
    if (!is_dir($dir)) mkdir($dir, 0775, true);

    $safe = bin2hex(random_bytes(8)) . ".pdf";
    $dest = $dir . "/" . $safe;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
      throw new RuntimeException("No se pudo guardar el PDF");
    }


    $url_rel = rtrim(BASE_URL, '/') . "/uploads/cursos/$id_curso/pdfs/$safe";

    $sql = "INSERT INTO {$this->table}(id_curso,titulo,tipo,url_pdf,orden)
            VALUES (?,?,?,?,?)";
    $this->pdo->prepare($sql)->execute([$id_curso, $titulo, 'pdf', $url_rel, $orden]);
    $id = (int)$this->pdo->lastInsertId();
    return $this->obtener($id);
  }

  
  public function obtener(int $id_leccion): ?Leccion {
    $st = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id_leccion=?");
    $st->execute([$id_leccion]);
    $r = $st->fetch(PDO::FETCH_ASSOC);
    return $r ? $this->map($r) : null;
  }

  public function listarPorCurso(int $id_curso): array {
    $st = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id_curso=? ORDER BY orden ASC, id_leccion ASC");
    $st->execute([$id_curso]);
    $out = [];
    while ($r = $st->fetch(PDO::FETCH_ASSOC)) $out[] = $this->map($r);
    return $out;
  }


  public function eliminar(int $id_leccion): bool {
    return $this->pdo->prepare("DELETE FROM {$this->table} WHERE id_leccion=?")->execute([$id_leccion]);
  }

  public function actualizarOrden(int $id_leccion, int $orden): bool {
    return $this->pdo->prepare("UPDATE {$this->table} SET orden=? WHERE id_leccion=?")->execute([$orden, $id_leccion]);
  }


  public function marcarLeida(int $id_leccion, int $id_usuario): bool {
    $sql = "INSERT IGNORE INTO curso_leccion_vista(id_leccion,id_usuario) VALUES (?,?)";
    return $this->pdo->prepare($sql)->execute([$id_leccion, $id_usuario]);
  }

  public function yaVista(int $id_leccion, int $id_usuario): bool {
    $st = $this->pdo->prepare("SELECT 1 FROM curso_leccion_vista WHERE id_leccion=? AND id_usuario=?");
    $st->execute([$id_leccion, $id_usuario]);
    return (bool)$st->fetchColumn();
  }

  public function leccionesVistasPorUsuario(int $id_curso, int $id_usuario): int {
    $sql = "SELECT COUNT(*) FROM curso_leccion_vista v
            JOIN curso_leccion l ON l.id_leccion = v.id_leccion
            WHERE l.id_curso = ? AND v.id_usuario = ?";
    $st = $this->pdo->prepare($sql);
    $st->execute([$id_curso, $id_usuario]);
    return (int)$st->fetchColumn();
  }

  public function totalLecciones(int $id_curso): int {
    $st = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} WHERE id_curso=?");
    $st->execute([$id_curso]);
    return (int)$st->fetchColumn();
  }
}
