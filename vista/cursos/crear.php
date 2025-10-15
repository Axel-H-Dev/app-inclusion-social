<?php // vista/cursos/crear.php 
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
        <div class="columns is-centered">
            <div class="column is-two-thirds">
                <div class="mb-6">
                    <h1 class="title is-2 has-text-primary">Crear Nuevo Curso</h1>
                    <p class="subtitle is-5 has-text-grey">Completa la información para agregar un nuevo curso a tu catálogo</p>
                </div>

                <div class="box has-background-white-bis">
                    <form method="post" action="<?= BASE_URL ?>controlador/CursosController.php?action=guardar">
                        <div class="field">
                            <label class="label" for="titulo">
                                <span class="icon is-small"><i class="fas fa-heading"></i></span>
                                Título del curso
                            </label>
                            <div class="control has-icons-left">
                                <input class="input" id="titulo" name="titulo" type="text" maxlength="200" required 
                                       placeholder="Ingresa un título atractivo para tu curso">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-pen"></i>
                                </span>
                            </div>
                            <p class="help">Máximo 200 caracteres</p>
                        </div>

                        <div class="field">
                            <label class="label" for="descripcion">
                                <span class="icon is-small"><i class="fas fa-align-left"></i></span>
                                Descripción
                            </label>
                            <div class="control">
                                <textarea class="textarea" id="descripcion" name="descripcion" rows="5" required
                                          placeholder="Describe detalladamente el contenido, objetivos y beneficios del curso"></textarea>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label" for="duracion_horas">
                                <span class="icon is-small"><i class="fas fa-clock"></i></span>
                                Duración estimada
                            </label>
                            <div class="control has-icons-left">
                                <input class="input" id="duracion_horas" name="duracion_horas" type="number" min="1" required 
                                       placeholder="Ej: 10 horas">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-hourglass-half"></i>
                                </span>
                            </div>
                            <p class="help">Duración en horas del curso completo</p>
                        </div>

                        <div class="field is-grouped is-grouped-centered">
                            <div class="control">
                                <button class="button is-primary is-medium" type="submit">
                                    <span class="icon"><i class="fas fa-plus-circle"></i></span>
                                    <span>Crear curso</span>
                                </button>
                            </div>
                            <div class="control">
                                <a class="button is-light is-medium" href="<?= BASE_URL ?>controlador/CursosController.php?action=gestionar">
                                    <span class="icon"><i class="fas fa-times"></i></span>
                                    <span>Cancelar</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

            
            </div>
        </div>
    </div>
</section>

<style>
    .box {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        padding: 2.5rem;
    }
    
    .field {
        margin-bottom: 1.8rem;
    }
    
    .input, .textarea {
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .input:focus, .textarea:focus {
        box-shadow: 0 0 0 0.125em rgba(72, 95, 199, 0.25);
        border-color: #485fc7;
    }
    
    .button {
        border-radius: 6px;
        font-weight: 600;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    
    .label {
        font-weight: 600;
        color: #363636;
        margin-bottom: 0.5rem;
    }
    
    .help {
        margin-top: 0.4rem;
    }
</style>

</body>
</html>