<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
class CursoService {
    private $cursoDAO;
    private $inscripcionDAO;
    private $certificadoDAO;
    private $leccionDAO;
    private $uploadsBase; 

 public function __construct() {
  $this->cursoDAO       = new CursoDAO();
  $this->inscripcionDAO = new InscripcionDAO();
  $this->certificadoDAO = new CertificadoDAO();
  $this->leccionDAO     = new LeccionDAO();

  
  $this->uploadsBase = dirname(__DIR__) . '/uploads';
  if (!is_dir($this->uploadsBase)) { @mkdir($this->uploadsBase, 0775, true); }
}

    
    public function crearCurso($titulo, $descripcion, $duracion_horas, $id_empresa) {
        $c = new Curso();
        $c->setTitulo($titulo);
        $c->setDescripcion($descripcion);
        $c->setDuracionHoras((int)$duracion_horas);
        $c->setEmpresaId((int)$id_empresa);
        $c->setPublicado(1);
        return $this->cursoDAO->crear($c);
    }

    public function actualizarCurso($id_curso, $titulo, $descripcion, $duracion_horas, $publicado) {
        $curso = $this->cursoDAO->obtenerPorId((int)$id_curso);
        if (!$curso) throw new Exception("Curso no encontrado");
        $curso->setTitulo($titulo);
        $curso->setDescripcion($descripcion);
        $curso->setDuracionHoras((int)$duracion_horas);
        $curso->setPublicado((int)$publicado);
        return $this->cursoDAO->actualizar($curso);
    }

    public function desactivarCurso($id_curso) { return $this->cursoDAO->desactivar((int)$id_curso); }
    public function obtenerCursosActivos()     { return $this->cursoDAO->obtenerActivos(); }
    public function obtenerCurso($id_curso)    { return $this->cursoDAO->obtenerPorId((int)$id_curso); }
    public function obtenerCursosEmpresa($id_empresa){ return $this->cursoDAO->obtenerPorEmpresa((int)$id_empresa); }

    
    public function inscribirUsuario($id_usuario, $id_curso) {
        if ($this->inscripcionDAO->verificarInscripcion($id_usuario, $id_curso)) {
            throw new Exception("Ya estás inscripto en este curso");
        }
        $i = new Inscripcion();
        $i->setUsuarioId((int)$id_usuario);
        $i->setCursoId((int)$id_curso);
        return $this->inscripcionDAO->crear($i);
    }

    public function obtenerMisCursos($id_usuario) { return $this->inscripcionDAO->obtenerPorUsuario((int)$id_usuario); }

    
    public function actualizarProgreso($id_inscripcion, $progreso) {
        $progreso = (int)$progreso;
        if ($progreso < 0 || $progreso > 100) throw new Exception("Progreso inválido");
        if ($progreso === 100) {
            $this->inscripcionDAO->completarCurso((int)$id_inscripcion);
            $ins = $this->inscripcionDAO->obtenerPorId((int)$id_inscripcion);
            if (!$ins) throw new Exception("Inscripción no encontrada");
            $cert = new Certificado();
            $cert->setInscripcionId($ins->getId());
            $cert->setUsuarioId($ins->getUsuarioId());
            $cert->setCursoId($ins->getCursoId());
            $cert->setUrlValidacion(BASE_URL . "controlador/CursosController.php?action=verificar&codigo=" . $cert->getCodigoUnico());
            return $this->certificadoDAO->crear($cert);
        } else {
            return $this->inscripcionDAO->actualizarProgreso((int)$id_inscripcion, $progreso);
        }
    }

    
    public function agregarLeccionTexto(int $id_curso, string $titulo, string $contenido, int $orden=1): Leccion {
        return $this->leccionDAO->crearTexto($id_curso,$titulo,$contenido,$orden);
    }

    public function agregarLeccionPdf(int $id_curso, string $titulo, array $file, int $orden=1): Leccion {
        return $this->leccionDAO->crearPdf($id_curso,$titulo,$file,$orden,$this->uploadsBase);
    }

    public function listarLecciones(int $id_curso): array {
        return $this->leccionDAO->listarPorCurso($id_curso);
    }

    public function eliminarLeccion(int $id_leccion): bool {
        return $this->leccionDAO->eliminar($id_leccion);
    }

    
    public function marcarLeccionLeida(int $id_usuario, int $id_curso, int $id_leccion): array {
        
        $ins = $this->inscripcionDAO->obtenerPorUsuarioCurso($id_usuario,$id_curso);
        if (!$ins) { throw new Exception("No estás inscripto en el curso."); }

        
        $this->leccionDAO->marcarLeida($id_leccion,$id_usuario);
        $this->inscripcionDAO->fijarInicioSiNulo($ins->getId());

        
        $vistas = $this->leccionDAO->leccionesVistasPorUsuario($id_curso,$id_usuario);
        $total  = $this->leccionDAO->totalLecciones($id_curso);
        $pct    = $total>0 ? min(100, (int) round(($vistas/$total)*100)) : 0;

       
        $this->inscripcionDAO->setProgresoYEstado($ins->getId(), $pct);

       
        if ($pct >= 100) {
            $cert = new Certificado();
            $cert->setInscripcionId($ins->getId());
            $cert->setUsuarioId($ins->getUsuarioId());
            $cert->setCursoId($ins->getCursoId());
            $cert->setUrlValidacion(BASE_URL . "controlador/CursosController.php?action=verificar&codigo=" . $cert->getCodigoUnico());
            $this->certificadoDAO->crear($cert);
        }

        return ['vistas'=>$vistas,'total'=>$total,'pct'=>$pct];
    }

    
    public function misCertificados($id_usuario) { return $this->certificadoDAO->obtenerPorUsuario((int)$id_usuario); }
    public function obtenerCertificado($id_cert) { return $this->certificadoDAO->obtenerPorId((int)$id_cert); }
    public function verificarCertificado($codigo){ return $this->certificadoDAO->verificarCertificado($codigo); }
}
