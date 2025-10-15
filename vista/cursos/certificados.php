<?php

// Bloquear acceso directo al archivo
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
                    <h1 class="title is-2 has-text-primary">Mis Certificados</h1>
                    <p class="subtitle is-5 has-text-grey">Tus logros y certificaciones</p>
                </div>
            </div>
            <div class="level-right">
                <a class="button is-light" href="<?= BASE_URL ?>controlador/CursosController.php?action=mis">
                    <span class="icon"><i class="fas fa-arrow-left"></i></span>
                    <span>Volver a mis cursos</span>
                </a>
            </div>
        </div>

        <?php if (empty($certificados)): ?>
        <div class="box has-text-centered">
            <div class="content py-6">
                <span class="icon is-large has-text-grey-light">
                    <i class="fas fa-award fa-3x"></i>
                </span>
                <h3 class="title is-4 has-text-grey">Aún no tienes certificados</h3>
                <p class="subtitle is-6 has-text-grey">Completa un curso para obtener tu primer certificado.</p>
                <div class="buttons is-centered mt-4">
                    <a class="button is-primary" href="<?= BASE_URL ?>controlador/CursosController.php?action=mis">
                        <span class="icon"><i class="fas fa-book-open"></i></span>
                        <span>Ir a mis cursos</span>
                    </a>
                    <a class="button is-light" href="<?= BASE_URL ?>controlador/CursosController.php?action=listar">
                        <span class="icon"><i class="fas fa-search"></i></span>
                        <span>Explorar cursos</span>
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="notification is-info is-light">
            <span class="icon"><i class="fas fa-info-circle"></i></span>
            <span>Has obtenido <?= count($certificados) ?> certificado(s). ¡Felicidades!</span>
        </div>

        <div class="columns is-multiline">
            <?php foreach ($certificados as $cert): $curso = $cursoDAO->obtenerPorId($cert->getCursoId()); ?>
            <div class="column is-4">
                <div class="card certificate-card">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-left">
                                <figure class="image is-48x48 has-background-success-light has-text-success">
                                    <span class="icon is-medium">
                                        <i class="fas fa-certificate fa-lg"></i>
                                    </span>
                                </figure>
                            </div>
                            <div class="media-content">
                                <p class="title is-5 has-text-success">Certificado</p>
                                <p class="subtitle is-6 has-text-grey">Completación exitosa</p>
                            </div>
                        </div>
                        
                        <div class="content">
                            <div class="certificate-info">
                                <p class="has-text-weight-semibold"><?= htmlspecialchars($curso->getTitulo()) ?></p>
                                
                                <div class="tags are-small mt-3">
                                    <span class="tag is-info is-light">
                                        <span class="icon"><i class="fas fa-hashtag"></i></span>
                                        <span><?= htmlspecialchars($cert->getCodigoUnico()) ?></span>
                                    </span>
                                </div>
                                
                                <p class="is-size-7 has-text-grey mt-3">
                                    <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                                    <span>Emitido el <?= date('d/m/Y', strtotime($cert->getFechaEmision())) ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <footer class="card-footer">
                        <a class="card-footer-item has-text-info"
                           href="<?= BASE_URL ?>controlador/CursosController.php?action=ver_cert&id=<?= (int)$cert->getId() ?>"
                           target="_blank">
                            <span class="icon"><i class="fas fa-eye"></i></span>
                            <span>Ver certificado</span>
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
.certificate-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #e8e8e8;
}

.certificate-card:hover {
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

.certificate-info {
    border-left: 3px solid #48c78e;
    padding-left: 1rem;
    margin-left: -1rem;
}

.tags {
    margin-bottom: 0.5rem;
}

.notification {
    margin-bottom: 2rem;
    border-radius: 6px;
}
</style>

</body>
</html>