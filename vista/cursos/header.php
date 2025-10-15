<?php
// vista/cursos/header.php
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Calnm — Cursos</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .is-clickable{cursor:pointer}
    .progress.is-thin{height: 12px;}
    .navbar-item img {max-height: 2.5rem;}
    .navbar-brand-logo {font-size: 1.8rem; letter-spacing: -0.5px;}
    .navbar-item.has-divider {border-right: 1px solid #eee;}
    .navbar-dropdown-icon {margin-right: 0.5rem; width: 1.2rem; text-align: center;}
    
    /* Centrar elementos del navbar */
    .navbar-center {
      display: flex;
      justify-content: center;
      flex-grow: 1;
      margin-left: auto;
      margin-right: auto;
    }
    
    /* Asegurar que el navbar se expanda correctamente */
    .navbar-menu {
      flex-grow: 1;
      justify-content: center;
    }
  </style>
</head>
<body class="has-background-light">
  <nav class="navbar is-light is-spaced" role="navigation" aria-label="main navigation">
    <div class="container">
      <div class="navbar-brand">
        <a class="navbar-item" href="<?= esEmpresa() ? 'perfilempresacontroller.php' : '../vista/usuario/usuario.php' ?>">
          <span class="navbar-brand-logo has-text-weight-bold has-text-primary">Calnm</span>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="mainNav">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div id="mainNav" class="navbar-menu">
        <!-- Contenedor central para los elementos del navbar -->
        <div class="navbar-center">
          <?php if (estaLogueado()): ?>
            <?php if (esEmpresa()): ?>
              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link is-arrowless">
                  <span class="icon"><i class="fas fa-graduation-cap"></i></span>
                  <span>Cursos</span>
                </a>
                <div class="navbar-dropdown">
                  <a class="navbar-item" href="<?= BASE_URL ?>controlador/CursosController.php?action=crear">
                    <span class="navbar-dropdown-icon"><i class="fas fa-plus-circle"></i></span>
                    Crear curso
                  </a>
                  <a class="navbar-item" href="<?= BASE_URL ?>controlador/CursosController.php?action=gestionar">
                    <span class="navbar-dropdown-icon"><i class="fas fa-cog"></i></span>
                    Gestionar cursos
                  </a>
                </div>
              </div>
              
              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link is-arrowless">
                  <span class="icon"><i class="fas fa-briefcase"></i></span>
                  <span>Empleo</span>
                </a>
                <div class="navbar-dropdown">
                  <a class="navbar-item" href="Formulario_laboralController.php">
                    <span class="navbar-dropdown-icon"><i class="fas fa-plus"></i></span>
                    Publicar Oferta
                  </a>
                  <a class="navbar-item" href="FormularioVerOfertasController.php">
                    <span class="navbar-dropdown-icon"><i class="fas fa-list"></i></span>
                    Ver Ofertas
                  </a>
                </div>
              </div>
              
              <a class="navbar-item" href="perfilempresacontroller.php">
                <span class="icon"><i class="fas fa-building"></i></span>
                <span>Perfil Empresa</span>
              </a>
              
            <?php else: ?>
              <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link is-arrowless">
                  <span class="icon"><i class="fas fa-graduation-cap"></i></span>
                  <span>Cursos</span>
                </a>
                <div class="navbar-dropdown">
                  <a class="navbar-item" href="<?= BASE_URL ?>controlador/CursosController.php?action=listar">
                    <span class="navbar-dropdown-icon"><i class="fas fa-search"></i></span>
                    Ver cursos
                  </a>
                  <a class="navbar-item" href="<?= BASE_URL ?>controlador/CursosController.php?action=mis">
                    <span class="navbar-dropdown-icon"><i class="fas fa-bookmark"></i></span>
                    Mis cursos
                  </a>
                  <a class="navbar-item" href="<?= BASE_URL ?>controlador/CursosController.php?action=certificados">
                    <span class="navbar-dropdown-icon"><i class="fas fa-certificate"></i></span>
                    Mis certificados
                  </a>
                </div>
              </div>
              
              <a class="navbar-item" href="OfertasPublicasController.php">
                <span class="icon"><i class="fas fa-briefcase"></i></span>
                <span>Ofertas Laborales</span>
              </a>
              
              <a class="navbar-item" href="PersonaPostulacionesController.php">
                <span class="icon"><i class="fas fa-file-alt"></i></span>
                <span>Mis postulaciones</span>
              </a>
              
              <a class="navbar-item" href="../vista/usuario/usuario.php">
                <span class="icon"><i class="fas fa-user"></i></span>
                <span>Perfil</span>
              </a>
            <?php endif; ?>
          <?php else: ?>
            <a class="navbar-item" href="<?= BASE_URL ?>controlador/CursosController.php?action=listar">
              <span class="icon"><i class="fas fa-graduation-cap"></i></span>
              <span>Ver cursos</span>
            </a>
          <?php endif; ?>
        </div>

        <div class="navbar-end">
          <?php if (estaLogueado()): ?>
            <div class="navbar-item">
              <div class="buttons">
                <a class="button is-outlined is-danger" href="logout.php">
                  <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                  <span>Cerrar sesión</span>
                </a>
              </div>
            </div>
          <?php else: ?>
            <div class="navbar-item">
              <div class="buttons">
                <a class="button is-primary" href="../index.php">
                  <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                  <span>Iniciar sesión</span>
                </a>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <section class="section">
    <div class="container">
      <?php if (!empty($_GET['mensaje'])): ?>
        <div class="notification is-success is-light">
          <button class="delete"></button>
          <?= htmlspecialchars($_GET['mensaje']) ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($_GET['error'])): ?>
        <div class="notification is-danger is-light">
          <button class="delete"></button>
          <?= htmlspecialchars($_GET['error']) ?>
        </div>
      <?php endif; ?>
      
  <!-- JavaScript para el menú hamburguesa -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    // Obtener todos los elementos "navbar-burger"
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    
    // Añadir un evento click a cada uno
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {
        // Obtener el target del elemento "navbar-burger"
        const target = el.dataset.target;
        const $target = document.getElementById(target);
        
        // Alternar la clase "is-active" tanto en "navbar-burger" como en "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');
      });
    });
  });
  </script>