<?php 
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit;
}

if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['rol'])) {
  
    header("Location: ../../index.php");
    exit();
}
$esEmpresa = (($_SESSION['rol'] ?? '') === 'Empresa');
?>

<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div>
                    <h1 class="title is-2 has-text-primary"><?= htmlspecialchars($curso->getTitulo()) ?></h1>
                    <p class="subtitle is-5 has-text-grey">Explora el contenido del curso</p>
                </div>
            </div>
            <div class="level-right">
                <?php if (!$esEmpresa): ?>
                <a class="button is-light" href="<?= BASE_URL ?>controlador/CursosController.php?action=mis">
                    <span class="icon"><i class="fas fa-arrow-left"></i></span>
                    <span>Volver a mis cursos</span>
                </a>
                <?php else: ?>
                <a class="button is-light" href="<?= BASE_URL ?>controlador/CursosController.php?action=gestionar">
                    <span class="icon"><i class="fas fa-arrow-left"></i></span>
                    <span>Volver a gestionar cursos</span>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="box has-background-white-bis">
            <h2 class="title is-4 has-text-grey-dark">
                <span class="icon"><i class="fas fa-info-circle"></i></span>
                Descripción del curso
            </h2>
            <div class="content is-size-5">
                <?= nl2br(htmlspecialchars($curso->getDescripcion())) ?>
            </div>
            <div class="tags">
                <span class="tag is-info is-medium">
                    <span class="icon"><i class="fas fa-clock"></i></span>
                    <span>Duración: <?= (int)$curso->getDuracionHoras() ?> horas</span>
                </span>
            </div>
        </div>

        <?php if (empty($lecciones)): ?>
        <div class="box has-text-centered">
            <div class="content py-5">
                <span class="icon is-large has-text-warning">
                    <i class="fas fa-book-open fa-3x"></i>
                </span>
                <h3 class="title is-4 has-text-grey">Curso en desarrollo</h3>
                <p class="subtitle is-6 has-text-grey">Este curso aún no tiene material disponible.</p>
                <?php if ($esEmpresa): ?>
                <a class="button is-primary mt-3" href="<?= BASE_URL ?>controlador/CursosController.php?action=material&id_curso=<?= (int)$curso->getId() ?>">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Agregar material</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="mb-6">
            <h2 class="title is-3 has-text-grey-dark mb-4">
                <span class="icon"><i class="fas fa-list-ol"></i></span>
                Lecciones del curso
            </h2>
            
            <div class="lecciones-container">
                <?php foreach($lecciones as $l): ?>
                <div class="box leccion-item">
                    <div class="media">
                        <div class="media-left">
                            <figure class="image is-48x48 has-background-primary-light has-text-primary">
                                <span class="icon is-medium">
                                    <i class="fas <?= $l->getTipo()==='pdf' ? 'fa-file-pdf' : 'fa-file-alt' ?> fa-lg"></i>
                                </span>
                            </figure>
                        </div>
                        <div class="media-content">
                            <div class="content">
                                <p class="title is-4 has-text-primary">
                                    <span class="tag is-info is-light mr-3"><?= (int)$l->getOrden() ?></span>
                                    <?= htmlspecialchars($l->getTitulo()) ?>
                                </p>
                                
                                <?php if ($l->getTipo()==='pdf'): ?>
                                <div class="mt-4">
                                    <div class="notification is-info is-light">
                                        <span class="icon"><i class="fas fa-file-pdf"></i></span>
                                        <span>Documento PDF - </span>
                                        <a href="<?= htmlspecialchars($l->getUrlPdf()) ?>" target="_blank" class="has-text-weight-semibold">
                                            Ver en nueva pestaña
                                        </a>
                                    </div>
                                    <iframe class="pdf-viewer" src="<?= htmlspecialchars($l->getUrlPdf()) ?>"></iframe>
                                </div>
                                <?php else: ?>
                                <div class="content-texto mt-4">
                                    <h4 class="title is-5 has-text-grey">Contenido:</h4>
                                    <div class="box has-background-light">
                                        <?= nl2br(htmlspecialchars($l->getContenidoTexto())) ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (!$esEmpresa): ?>
                                <form method="post" action="<?= BASE_URL ?>controlador/CursosController.php?action=leer" class="mt-4">
                                    <input type="hidden" name="id_curso" value="<?= (int)$curso->getId() ?>">
                                    <input type="hidden" name="id_leccion" value="<?= (int)$l->getId() ?>">
                                    <button class="button is-success" type="submit">
                                        <span class="icon"><i class="fas fa-check-circle"></i></span>
                                        <span>Marcar como leído</span>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="buttons is-centered">
            <?php if (!$esEmpresa): ?>
            <a class="button is-light" href="<?= BASE_URL ?>controlador/CursosController.php?action=mis">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Volver a mis cursos</span>
            </a>
            <?php else: ?>
            <a class="button is-light" href="<?= BASE_URL ?>controlador/CursosController.php?action=gestionar">
                <span class="icon"><i class="fas fa-arrow-left"></i></span>
                <span>Volver a gestionar cursos</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.leccion-item {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 4px solid #485fc7;
}

.leccion-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.pdf-viewer {
    width: 100%;
    height: 70vh;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.content-texto .box {
    border-radius: 6px;
    padding: 1.5rem;
    white-space: pre-wrap;
}

.media-left .image {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
}

.lecciones-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
</style>

</body>
</html>