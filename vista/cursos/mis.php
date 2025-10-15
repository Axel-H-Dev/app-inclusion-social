<?php
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit;
}


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Persona') {
    header("Location: ../../index.php");
    exit();
}

$cursoDAO = new CursoDAO();
?>
<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div>
                    <h1 class="title is-2 has-text-primary">Mis Cursos</h1>
                    <p class="subtitle is-5 has-text-grey">Gestiona tu progreso de aprendizaje</p>
                </div>
            </div>
            <div class="level-right">
                <a class="button is-primary" href="<?= BASE_URL ?>controlador/CursosController.php?action=listar">
                    <span class="icon"><i class="fas fa-search"></i></span>
                    <span>Explorar más cursos</span>
                </a>
            </div>
        </div>

        <?php if (empty($mis)): ?>
        <div class="box has-text-centered">
            <div class="content py-6">
                <span class="icon is-large has-text-grey-light">
                    <i class="fas fa-book-open fa-3x"></i>
                </span>
                <h3 class="title is-4 has-text-grey">No tienes cursos inscritos</h3>
                <p class="subtitle is-6 has-text-grey">Comienza tu journey de aprendizaje explorando nuestros cursos disponibles.</p>
                <a class="button is-primary is-medium mt-4" href="<?= BASE_URL ?>controlador/CursosController.php?action=listar">
                    <span class="icon"><i class="fas fa-graduation-cap"></i></span>
                    <span>Descubrir cursos</span>
                </a>
            </div>
        </div>
        <?php else: ?>
        <div class="columns is-multiline">
            <?php foreach ($mis as $insc): $curso = $cursoDAO->obtenerPorId($insc->getCursoId()); ?>
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
                                <span class="tag <?= $insc->getEstado()==='completado' ? 'is-success' : 'is-warning' ?>">
                                    <span class="icon">
                                        <i class="fas <?= $insc->getEstado()==='completado' ? 'fa-check-circle' : 'fa-spinner' ?>"></i>
                                    </span>
                                    <span><?= htmlspecialchars(ucfirst($insc->getEstado())) ?></span>
                                </span>
                            </div>
                            
                            <div class="progress-container">
                                <label class="progress-label has-text-weight-semibold">Progreso del curso</label>
                                <progress class="progress is-primary is-medium" max="100"
                                          value="<?= (int)$insc->getProgreso() ?>">
                                    <?= (int)$insc->getProgreso() ?>%
                                </progress>
                                <p class="has-text-right is-size-6 has-text-grey">
                                    <span class="has-text-weight-semibold"><?= (int)$insc->getProgreso() ?>%</span> completado
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <footer class="card-footer">
                        <a class="card-footer-item has-text-info"
                           href="<?= BASE_URL ?>controlador/CursosController.php?action=ver&id_curso=<?= (int)$insc->getCursoId() ?>">
                            <span class="icon"><i class="fas fa-play-circle"></i></span>
                            <span>Continuar curso</span>
                        </a>
                        
                        <?php if ($insc->getEstado() === 'completado'): ?>
                        <a class="card-footer-item has-text-success"
                           href="<?= BASE_URL ?>controlador/CursosController.php?action=certificados">
                            <span class="icon"><i class="fas fa-award"></i></span>
                            <span>Ver certificado</span>
                        </a>
                        <?php else: ?>
                        <div class="card-footer-item has-text-grey-light">
                            <span class="icon"><i class="fas fa-lock"></i></span>
                            <span>Certificado</span>
                        </div>
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

.progress-container {
    margin-top: 1.5rem;
}

.progress-label {
    display: block;
    margin-bottom: 0.5rem;
    color: #363636;
}

.progress.is-medium {
    height: 0.75rem;
    border-radius: 4px;
}

.tags {
    margin-bottom: 1rem;
}
</style>

</body>
</html>