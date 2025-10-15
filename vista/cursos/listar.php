<?php 
// vista/cursos/listar.php — requiere: $cursos
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit;
}


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Persona') {
    header("Location: ../../index.php");
    exit();
} 
?>

<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    <h1 class="title is-2 has-text-primary">Cursos Disponibles</h1>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <span class="tag is-primary is-light is-medium">
                        <span class="icon"><i class="fas fa-book"></i></span>
                        <span><?= count($cursos) ?> curso(s)</span>
                    </span>
                </div>
            </div>
        </div>

        <?php if (empty($cursos)): ?>
        <div class="box has-text-centered">
            <div class="content py-6">
                <span class="icon is-large has-text-grey-light">
                    <i class="fas fa-book-open fa-3x"></i>
                </span>
                <h3 class="title is-4 has-text-grey">No hay cursos disponibles</h3>
                <p class="subtitle is-6 has-text-grey">Pronto agregaremos nuevos cursos para ti.</p>
            </div>
        </div>
        <?php else: ?>
        <div class="columns is-multiline is-variable is-4">
            <?php foreach ($cursos as $curso): ?>
            <div class="column is-4">
                <div class="card card-hover">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-left">
                                <figure class="image is-48x48 has-background-primary-light has-text-primary">
                                    <span class="icon is-medium">
                                        <i class="fas fa-graduation-cap fa-lg"></i>
                                    </span>
                                </figure>
                            </div>
                            <div class="media-content">
                                <p class="title is-4 has-text-primary"><?= htmlspecialchars($curso->getTitulo()) ?></p>
                            </div>
                        </div>
                        
                        <div class="content">
                            <p class="has-text-grey description-truncate"><?= nl2br(htmlspecialchars($curso->getDescripcion())) ?></p>
                            
                            <div class="tags are-medium mt-4">
                                <span class="tag is-info is-light">
                                    <span class="icon"><i class="fas fa-clock"></i></span>
                                    <span><?= (int)$curso->getDuracionHoras() ?> horas</span>
                                </span>
                                <span class="tag is-success is-light">
                                    <span class="icon"><i class="fas fa-users"></i></span>
                                    <span>Disponible</span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <footer class="card-footer">
                        <?php if (estaLogueado()): ?>
                        <form class="card-footer-item" method="post"
                            action="<?= BASE_URL ?>controlador/CursosController.php?action=inscribir">
                            <input type="hidden" name="id_curso" value="<?= (int)$curso->getId() ?>">
                            <button class="button is-primary is-fullwidth" type="submit">
                                <span class="icon"><i class="fas fa-user-plus"></i></span>
                                <span>Inscribirme</span>
                            </button>
                        </form>
                        <?php else: ?>
                        <a class="card-footer-item has-text-info has-text-centered" 
                        href="<?= BASE_URL ?>login.php">
                            <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                            <span>Inicia sesión para inscribirte</span>
                        </a>
                        <?php endif; ?>
                    </footer>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<style>
.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.card-content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.card-footer {
    margin-top: auto;
}

.card-footer-item {
    border-top: 1px solid #f5f5f5;
    padding: 1rem;
}

.media-left .image {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
}

.description-truncate {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<script>
// JavaScript para el menú hamburguesa
document.addEventListener('DOMContentLoaded', () => {
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
    
    $navbarBurgers.forEach(el => {
        el.addEventListener('click', () => {
            const target = el.dataset.target;
            const $target = document.getElementById(target);
            
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');
        });
    });
    
    // Animación suave para los botones de inscripción
    document.querySelectorAll('form button[type="submit"]').forEach(button => {
        button.addEventListener('click', function(e) {
            this.classList.add('is-loading');
        });
    });
});
</script>
</body>
</html>