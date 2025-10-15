<?php
if (!defined('ACCESO_DESDE_CONTROLADOR')) {
    header("Location: ../../index.php");
    exit;
}


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Empresa') {
    header("Location: ../../index.php");
    exit();
} 
  $siguienteOrden = 1;
  if (!empty($lecciones)) {
    $last = end($lecciones);
    $siguienteOrden = (int)$last->getOrden() + 1;
    reset($lecciones);
  }
?>

<?php // requiere $curso, $lecciones ?>
<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <div>
                    <h1 class="title is-2 has-text-primary">Material del Curso</h1>
                    <p class="subtitle is-4 has-text-info"><?= htmlspecialchars($curso->getTitulo()) ?></p>
                </div>
            </div>
            <div class="level-right">
                <a class="button is-light" href="<?= BASE_URL ?>controlador/CursosController.php?action=gestionar">
                    <span class="icon"><i class="fas fa-arrow-left"></i></span>
                    <span>Volver a mis cursos</span>
                </a>
            </div>
        </div>

        <div class="columns">
            <div class="column is-7">
                <div class="box has-background-white-bis">
                    <h2 class="title is-4 has-text-grey-dark">
                        <span class="icon"><i class="fas fa-list-ol"></i></span>
                        Lecciones del curso
                    </h2>
                    
                    <?php if (empty($lecciones)): ?>
                    <div class="content has-text-centered py-5">
                        <span class="icon is-large has-text-grey-light">
                            <i class="fas fa-book-reader fa-3x"></i>
                        </span>
                        <p class="title is-5 has-text-grey">No hay lecciones aún</p>
                        <p class="subtitle is-6 has-text-grey">Comienza agregando la primera lección a tu curso.</p>
                    </div>
                    <?php else: ?>
                    <div class="table-container">
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr>
                                    <th class="has-text-weight-semibold">#</th>
                                    <th class="has-text-weight-semibold">Título</th>
                                    <th class="has-text-weight-semibold">Tipo</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($lecciones as $l): ?>
                                <tr>
                                    <td><span class="tag is-info is-light"><?= (int)$l->getOrden() ?></span></td>
                                    <td class="has-text-weight-medium"><?= htmlspecialchars($l->getTitulo()) ?></td>
                                    <td>
                                        <span class="tag <?= $l->getTipo()==='pdf' ? 'is-danger' : 'is-info' ?>">
                                            <span class="icon is-small">
                                                <i class="fas <?= $l->getTipo()==='pdf' ? 'fa-file-pdf' : 'fa-file-alt' ?>"></i>
                                            </span>
                                            <span><?= $l->getTipo()==='pdf' ? 'PDF' : 'Texto' ?></span>
                                        </span>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="column is-5">
                <div class="box">
                    <h2 class="title is-4 has-text-grey-dark">
                        <span class="icon"><i class="fas fa-plus-circle"></i></span>
                        Agregar nueva lección
                    </h2>
                    
                    <form method="post" enctype="multipart/form-data"
                          action="<?= BASE_URL ?>controlador/CursosController.php?action=agregar_leccion">
                        <input type="hidden" name="id_curso" value="<?= (int)$curso->getId() ?>">
                        
                        <div class="field">
                            <label class="label">Título de la lección</label>
                            <div class="control has-icons-left">
                                <input class="input" name="titulo" required placeholder="Ej: Introducción al curso">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-heading"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="field">
                            <label class="label">Orden de visualización</label>
                            <div class="control has-icons-left">
                                <input class="input" type="number" name="orden" value="<?= $siguienteOrden ?>" min="1">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-sort-numeric-down"></i>
                                </span>
                            </div>
                            <p class="help">Define el orden en que aparecerá esta lección</p>
                        </div>
                        
                        <div class="field">
                            <label class="label">Tipo de contenido</label>
                            <div class="control has-icons-left">
                                <div class="select is-fullwidth">
                                    <select name="tipo" onchange="toggleTipo(this.value)">
                                        <option value="pdf">PDF - Archivo descargable</option>
                                        <option value="texto">Texto - Contenido en línea</option>
                                    </select>
                                </div>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-file-alt"></i>
                                </span>
                            </div>
                        </div>

                        <div id="grp_pdf" class="field">
                            <label class="label">Archivo PDF</label>
                            <div class="file has-name is-fullwidth">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="pdf" accept="application/pdf">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">Seleccionar archivo…</span>
                                    </span>
                                    <span class="file-name">Ningún archivo seleccionado</span>
                                </label>
                            </div>
                            <p class="help">Tamaño máximo: 10 MB. Solo se permiten archivos PDF.</p>
                        </div>

                        <div id="grp_texto" class="field" style="display:none">
                            <label class="label">Contenido de texto</label>
                            <div class="control">
                                <textarea class="textarea" name="contenido_texto" rows="6" placeholder="Escribe el contenido completo de la lección aquí..."></textarea>
                            </div>
                        </div>

                        <div class="field">
    <div class="control has-text-centered">
        <button class="button is-primary" type="submit">
            <span class="icon"><i class="fas fa-plus"></i></span>
            <span>Agregar lección</span>
        </button>
    </div>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleTipo(v){
    document.getElementById('grp_pdf').style.display = v === 'pdf' ? 'block' : 'none';
    document.getElementById('grp_texto').style.display = v === 'texto' ? 'block' : 'none';
}

// Script para mostrar el nombre del archivo seleccionado
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.querySelector('.file-input');
    const fileName = document.querySelector('.file-name');
    
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
        } else {
            fileName.textContent = 'Ningún archivo seleccionado';
        }
    });
    
    // Inicializar el estado de los campos según el tipo seleccionado
    const tipoSelect = document.querySelector('select[name="tipo"]');
    toggleTipo(tipoSelect.value);
});
</script>

<style>
.table th {
    border-top: none;
    border-bottom: 2px solid #dbdbdb;
}

.table td {
    vertical-align: middle;
}

.box {
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.file-name {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.select:not(.is-multiple):not(.is-loading)::after {
    border-color: #485fc7;
}
</style>

</body>
</html>