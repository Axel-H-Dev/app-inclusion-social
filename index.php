<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Login</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="icon" type="image/png" href="imagenes/favicon-32x32.png">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

  <nav class="navbar is-light" role="navigation">
    <div class="navbar-brand">
      <a class="navbar-item" href="#">Calnm</a>
    </div>
    <div class="navbar-menu">
      <div class="navbar-end">
        <a class="navbar-item" href="vista/Usuario/registro_usuario.php">Registrarse Usuario</a>
        <a class="navbar-item" href="vista/Empresa/registro_empresa.php">Registrar Empresa</a>
        <a class="navbar-item" href="vista/nosotros.html">Nosotros</a>
      </div>
    </div>
  </nav>
  <section class="hero is-primary is-bold">
    <div class="hero-body">
      <div class="container has-text-centered">
        <h1 class="title">Bienvenido</h1>
        <h2 class="subtitle">Un portal accesible e intuitivo</h2>
      </div>
    </div>
  </section>
  <section class="section login-background">
    <div class="container">
      <div class="box">
        <h2 class="title is-4 has-text-centered">Iniciar Sesión</h2>
        <form method="POST" action="controlador/login.php">
          <div class="field">
            <label class="label">Email</label>
            <div class="control">
              <input class="input" type="email" placeholder="Email" name="email" required>
            </div>
          </div>

          <div class="field">
            <label class="label">Contraseña</label>
            <div class="control">
              <input class="input" type="password" placeholder="Contraseña" name="clave" required>
            </div>
          </div>

          <div class="control has-text-centered">
            <button class="button is-dark" type="submit">Entrar</button>
          </div>
        </form>
      </div>
    </div>
  </section>



  <footer class="footer has-background-light">
    <div class="content has-text-centered">
      <p>
        <strong>Plataforma de Inclusión Laboral</strong> — Conectando oportunidades con personas con discapacidad.
      </p>
      <p>
        © 2025 - Proyecto desarrollado por estudiantes de la Tecnicatura en Desarrollo de Software.
      </p>
      <p>
        <a href="mailto:contacto@inclusionlab.org"><i class="fas fa-envelope"></i> contacto@inclusionlab.org</a> |
        <a href="vista/privacidad.html"><i class="fas fa-shield-alt"></i> Política de Privacidad</a> |
        <a href="vista/terminos.html"><i class="fas fa-file-contract"></i> Términos y Condiciones</a>
      </p>
      <p>
        <a href="#"><span class="icon"><i class="fab fa-facebook"></i></span></a>
        <a href="#"><span class="icon"><i class="fab fa-twitter"></i></span></a>
        <a href="#"><span class="icon"><i class="fab fa-github"></i></span></a>
      </p>
    </div>
  </footer>

</body>

</html>