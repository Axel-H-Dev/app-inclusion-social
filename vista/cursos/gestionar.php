<?php // vista/cursos/gestionar.php — requiere: $cursos 
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit;
}


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../../index.php");
    exit();
} 

?>
<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div>
                    <h1 class="title is-2 has-text-primary">Gestionar Mis Cursos</h1>
                    <p class="subtitle is-5 has-text-grey">Administra y edita todos tus cursos publicados</p>
                </div>
            </div>
            <div class="level-right">
                <a class="button is-primary is-medium" href="<?= BASE_URL ?>controlador/CursosController.php?action=crear">
                    <span class="icon"><i class="fas fa-plus-circle"></i></span>
                    <span>Crear nuevo curso</span>
                </a>
            </div>
        </div>

        <?php if (empty($cursos)): ?>
        <div class="box has-text-centered">
            <div class="content py-6">
                <span class="icon is-large has-text-grey-light">
                    <i class="fas fa-book-open fa-3x"></i>
                </span>
                <h3 class="title is-4 has-text-grey">Aún no tienes cursos</h3>
                <p class="subtitle is-6 has-text-grey">Comienza creando tu primer curso para compartir conocimiento.</p>
                <a class="button is-primary mt-3" href="<?= BASE_URL ?>controlador/CursosController.php?action=crear">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Crear primer curso</span>
                </a>
            </div>
        </div>
        <?php else: ?>
        <div class="columns is-multiline">
            <?php foreach ($cursos as $curso): ?>
            <div class="column is-6">
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
                                <p class="subtitle is-6 has-text-grey description-truncate"><?= htmlspecialchars($curso->getDescripcion()) ?></p>
                            </div>
                        </div>
                        
                        <div class="content">
                            <div class="tags are-medium">
                                <span class="tag is-info is-light">
                                    <span class="icon"><i class="fas fa-clock"></i></span>
                                    <span><?= (int)$curso->getDuracionHoras() ?> horas</span>
                                </span>
                                <span class="tag <?= $curso->isPublicado() ? 'is-success' : 'is-danger' ?> is-light">
                                    <span class="icon">
                                        <i class="fas <?= $curso->isPublicado() ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                                    </span>
                                    <span><?= $curso->isPublicado() ? 'Publicado' : 'Inactivo' ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <footer class="card-footer">
                        <a class="card-footer-item has-text-info"
                           href="<?= BASE_URL ?>controlador/CursosController.php?action=material&id_curso=<?= (int)$curso->getId() ?>">
                            <span class="icon"><i class="fas fa-book"></i></span>
                            <span>Material</span>
                        </a>
                        
                        <a class="card-footer-item has-text-link"
                           href="<?= BASE_URL ?>controlador/CursosController.php?action=ver&id_curso=<?= (int)$curso->getId() ?>"
                           target="_blank" rel="noopener">
                            <span class="icon"><i class="fas fa-external-link-alt"></i></span>
                            <span>Vista previa</span>
                        </a>
                        
                        <a class="card-footer-item has-text-<?= $curso->isPublicado() ? 'warning' : 'success' ?>"
                           href="<?= BASE_URL ?>controlador/CursosController.php?action=toggle&id=<?= (int)$curso->getId() ?>"
                           onclick="return confirm('¿Confirmás cambiar el estado del curso?')">
                            <span class="icon">
                                <i class="fas <?= $curso->isPublicado() ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                            </span>
                            <span><?= $curso->isPublicado() ? 'Ocultar' : 'Publicar' ?></span>
                        </a>
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
    border-top: 1px solid #f5f5f5;
}

.card-footer-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.75rem;
    transition: background-color 0.2s ease;
}

.card-footer-item:hover {
    background-color: #f9f9f9;
}

.media-left .image {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
}

.description-truncate {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.tags {
    margin-top: 0.5rem;
}
</style>

</body>
</html>