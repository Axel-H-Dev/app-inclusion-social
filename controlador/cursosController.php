<?php

define('ACCESO_DESDE_CONTROLADOR', true);
session_start();  
require_once __DIR__ . '/../config/config.php';

$action = $_GET['action'] ?? 'listar';
$service = new CursoService();

function redirect($path, $params = []) {
   
    $query = http_build_query(array_merge(['action' => $path], $params));
    header("Location: " . BASE_URL . "controlador/CursosController.php?$query");
    exit;
}

try {
    switch ($action) {

        
        case 'listar': {
     if (!estaLogueado() || esEmpresa()) {
    header("Location: ../index.php");
    exit;
}
            $cursos = $service->obtenerCursosActivos();
            include __DIR__ . '/../vista/cursos/header.php';
            include __DIR__ . '/../vista/cursos/listar.php';
            break;
        }

        
        case 'mis': {
            if (!estaLogueado()) redirect('listar', ['error' => 'Debes iniciar sesión']);
            $mis = $service->obtenerMisCursos($_SESSION['usuario_id'] );
            include __DIR__ . '/../vista/cursos/header.php';
            include __DIR__ . '/../vista/cursos/mis.php';
            break;
        }

        case 'inscribir': {
            if (!estaLogueado()) redirect('listar', ['error' => 'Debes iniciar sesión']);
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('listar');
            $id_curso = (int)($_POST['id_curso'] ?? 0);
            if ($id_curso <= 0) redirect('listar', ['error' => 'Curso inválido']);
            $service->inscribirUsuario($_SESSION['usuario_id'] , $id_curso);
            redirect('mis', ['mensaje' => 'Inscripción exitosa']);
        }

        case 'progreso': {
            if (!estaLogueado()) redirect('listar', ['error' => 'Debes iniciar sesión']);
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('mis');
            $id_ins = (int)($_POST['id_inscripcion'] ?? 0);
            $prog   = (int)($_POST['progreso'] ?? -1);
            $service->actualizarProgreso($id_ins, $prog);
            if ($prog === 100) redirect('certificados', ['mensaje' => '¡Curso completado!']);
            redirect('mis', ['mensaje' => 'Progreso actualizado']);
        }

        case 'certificados': {
            if (!estaLogueado()) redirect('listar', ['error' => 'Debes iniciar sesión']);
            $certificados = $service->misCertificados($_SESSION['usuario_id'] );
            include __DIR__ . '/../vista/cursos/header.php';
            include __DIR__ . '/../vista/cursos/certificados.php';
            break;
        }

   case 'ver_cert': {
    if (!estaLogueado()) redirect('listar', ['error' => 'Debes iniciar sesión']);

   

    $id = (int)($_GET['id'] ?? 0);
    $cert = $service->obtenerCertificado($id);
    if (!$cert) throw new Exception("Certificado no encontrado");

    $curso = $service->obtenerCurso($cert->getCursoId());
    if (!$curso) throw new Exception("Curso no encontrado");

 
    $nombreUsuario = trim(($_SESSION['usuario_nombre'] ?? '') . ' ' . ($_SESSION['usuario_apellido'] ?? ''));

    
    if ($nombreUsuario === '') {
        $uDAO = new UsuarioDAO();
        
        $u = $uDAO->obtenerPorId($cert->getUsuarioId());
        if ($u) {
            
            if (method_exists($u, 'getNombre') && method_exists($u, 'getApellido')) {
                $nombreUsuario = trim(($u->getNombre() ?? '') . ' ' . ($u->getApellido() ?? ''));
            } else {
               
                $nombreUsuario = trim(($u['nombre'] ?? '') . ' ' . ($u['apellido'] ?? ''));
            }
        }
    }
    if ($nombreUsuario === '') $nombreUsuario = 'Usuario';

    
    $empresaNombre = '';
    if ($curso->getEmpresaId()) {
        $eDAO = new EmpresaDAO();
        $emp = $eDAO->obtenerPorId($curso->getEmpresaId()); 
        if ($emp) {
            $empresaNombre = method_exists($emp, 'getNombreEmpresa')
                ? ($emp->getNombreEmpresa() ?? '')
                : ($emp['nombre_empresa'] ?? '');
        }
    }

    include __DIR__ . '/../vista/cursos/ver_certificado.php';
    break;
}



        case 'verificar': {
            $codigo = $_GET['codigo'] ?? '';
            $datos = $codigo ? $service->verificarCertificado($codigo) : null;
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => (bool)$datos, 'data' => $datos], JSON_UNESCAPED_UNICODE);
            break;
        }

      
        case 'crear': {
            if (!estaLogueado() || !esEmpresa()) redirect('listar', ['error'=>'Solo empresas']);
            include __DIR__ . '/../vista/cursos/header.php';
            include __DIR__ . '/../vista/cursos/crear.php';
            break;
        }

        case 'guardar': {
            if (!estaLogueado() || !esEmpresa()) redirect('listar', ['error'=>'Solo empresas']);
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('crear');

            $titulo   = trim($_POST['titulo'] ?? '');
            $desc     = trim($_POST['descripcion'] ?? '');
            $duracion = (int)($_POST['duracion_horas'] ?? 0);

            if ($titulo==='' || $desc==='' || $duracion<=0) redirect('crear', ['error'=>'Datos inválidos']);

            $service->crearCurso($titulo, $desc, $duracion, $_SESSION['usuario_id']);
            redirect('gestionar', ['mensaje'=>'Curso creado']);
        }

        case 'gestionar': {
            if (!estaLogueado() || !esEmpresa()) redirect('listar', ['error'=>'Solo empresas']);
            $cursos = $service->obtenerCursosEmpresa($_SESSION['usuario_id'] );

            include __DIR__ . '/../vista/cursos/header.php';
            include __DIR__ . '/../vista/cursos/gestionar.php';
            break;
        }

        case 'toggle': {
            if (!estaLogueado() || !esEmpresa()) redirect('listar', ['error'=>'Solo empresas']);
            $id = (int)($_GET['id'] ?? 0);
            $curso = $service->obtenerCurso($id);
            if (!$curso) redirect('gestionar', ['error'=>'No existe']);
            $service->actualizarCurso($id, $curso->getTitulo(), $curso->getDescripcion(), $curso->getDuracionHoras(), $curso->isPublicado()?0:1);
            redirect('gestionar', ['mensaje'=>'Estado actualizado']);
        }

case 'material': {
  if (!estaLogueado() || !esEmpresa()) redirect('listar', ['error'=>'Solo empresas']);

  $id_curso = (int)($_GET['id_curso'] ?? 0);
  if ($id_curso <= 0) redirect('gestionar', ['error'=>'Curso inválido']);

  $curso = $service->obtenerCurso($id_curso);
  if (!$curso) redirect('gestionar', ['error'=>'Curso no encontrado']);

  if ((int)$curso->getEmpresaId() !== (int)$_SESSION['usuario_id']) {
    redirect('gestionar', ['error'=>'No autorizado']);
  }

  $lecciones = $service->listarLecciones($id_curso);
  include __DIR__ . '/../vista/cursos/header.php';
  include __DIR__ . '/../vista/cursos/material.php';
  break;
}

case 'agregar_leccion': {
  if (!estaLogueado() || !esEmpresa()) redirect('listar', ['error'=>'Solo empresas']);
  if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('gestionar');

  $id_curso = (int)($_POST['id_curso'] ?? 0);
  if ($id_curso <= 0) redirect('gestionar', ['error'=>'Curso inválido']);

  
  $curso = $service->obtenerCurso($id_curso);
  if (!$curso || (int)$curso->getEmpresaId() !== (int)$_SESSION['usuario_id']) {
    redirect('gestionar', ['error'=>'No autorizado']);
  }

  $tipo   = $_POST['tipo'] ?? 'pdf';
  $titulo = trim($_POST['titulo'] ?? '');
  $orden  = (int)($_POST['orden'] ?? 1);
  if ($titulo==='') redirect('material', ['id_curso'=>$id_curso,'error'=>'Título requerido']);

  try {
    if ($tipo === 'texto') {
      $contenido = trim($_POST['contenido_texto'] ?? '');
      $service->agregarLeccionTexto($id_curso, $titulo, $contenido, $orden);
    } else {
      $service->agregarLeccionPdf($id_curso, $titulo, $_FILES['pdf'], $orden);
    }
    redirect('material', ['id_curso'=>$id_curso,'mensaje'=>'Lección agregada']);
  } catch (Exception $e) {
    redirect('material', ['id_curso'=>$id_curso,'error'=>$e->getMessage()]);
  }
}



case 'ver': {
  if (!estaLogueado()) redirect('listar',['error'=>'Debes iniciar sesión']);

  $id_curso = (int)($_GET['id_curso'] ?? 0);
  if ($id_curso <= 0) redirect('listar',['error'=>'Curso inválido']);

  $curso = $service->obtenerCurso($id_curso);
  if (!$curso) redirect('listar',['error'=>'Curso no encontrado']);


  if (esEmpresa()) {
    if ((int)$curso->getEmpresaId() !== (int)$_SESSION['usuario_id']) {
      redirect('gestionar', ['error'=>'No autorizado']);
    }
  } else {

    if (!$curso->isPublicado()) redirect('listar',['error'=>'Curso no disponible']);
  
  }

  $lecciones = $service->listarLecciones($id_curso);
  include __DIR__ . '/../vista/cursos/header.php';
  include __DIR__ . '/../vista/cursos/ver.php';
  break;
}


case 'leer': {
  if (!estaLogueado()) redirect('listar',['error'=>'Debes iniciar sesión']);
  if ($_SERVER['REQUEST_METHOD']!=='POST') redirect('mis');

  $id_curso   = (int)($_POST['id_curso'] ?? 0);
  $id_leccion = (int)($_POST['id_leccion'] ?? 0);
  if ($id_curso<=0 || $id_leccion<=0) redirect('mis', ['error'=>'Datos inválidos']);

 
  $curso = $service->obtenerCurso($id_curso);
  if (!$curso) redirect('mis',['error'=>'Curso no encontrado']);

  if (esEmpresa()) {
    if ((int)$curso->getEmpresaId() !== (int)$_SESSION['usuario_id']) {
      redirect('gestionar', ['error'=>'No autorizado']);
    }
  } else {
   
  }

  try {
    $res = $service->marcarLeccionLeida($_SESSION['usuario_id'], $id_curso, $id_leccion);
    redirect('ver', ['id_curso'=>$id_curso,'mensaje'=>"Progreso: {$res['pct']}%"]);
  } catch (Exception $e) {
    redirect('ver', ['id_curso'=>$id_curso,'error'=>$e->getMessage(),'id_curso'=>$id_curso]);
  }
}


        default:
            redirect('listar');
    }

} catch (Exception $e) {
    
    $msg = $e->getMessage();
    if ($action === 'guardar' || $action === 'crear') {
        redirect('crear', ['error' => $msg]);
    } elseif ($action === 'inscribir' || $action === 'progreso') {
        redirect('mis', ['error' => $msg]);
    } elseif ($action === 'gestionar' || $action === 'toggle') {
        redirect('gestionar', ['error' => $msg]);
    } else {
        redirect('listar', ['error' => $msg]);
    }
}
