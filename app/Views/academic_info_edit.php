<?php include('user_header.php'); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Información Académica</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            body {
                background-color: #f4f6f9;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            }
            .form-container {
                background-color: white;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                padding: 30px;
                margin-top: 3rem;
                width: 100%;

            }
            .form-label {
                font-weight: 600;
                color: #495057;
            }
            .form-control {
                border-radius: 8px;
                padding: 0.75rem 1rem;
                border-color: #ced4da;
                transition: all 0.3s ease;
            }
            .form-control:focus {
                border-color: #6c757d;
                box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
            }
            .file-input-wrapper {
                position: relative;
                overflow: hidden;
            }
            .file-input-wrapper input[type=file] {
                font-size: 100px;
                position: absolute;
                left: 0;
                top: 0;
                opacity: 0;
            }
            #pregradoOptions {
                display: none; /* Ocultar el select de Pregrado por defecto */
            }
            .form-control[readonly] {
                background-color: #e9ecef; /* Aplica un gris claro */
                opacity: 1;
            }


            .btn-success{
                padding: 0.75rem 1.5rem;
            }
            input, select {
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 form-container">
                    <h2 class="text-center mb-4 text-dark">
                        <i class="fas fa-graduation-cap me-2"></i>Formulario de Información Académica
                    </h2>

                    <form id="academicEdit" action="<?= base_url('index.php/user/academic-info/update/' . $user_cedula) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="row g-3">
                            <!-- Cédula -->
                            <div class="col-md-6">
                                <label for="cedula" class="form-label">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" id="cedula" name="cedula" class="form-control" value="<?= esc($user_cedula) ?>" readonly>
                                </div>
                            </div>

                            <!-- Nivel Académico -->
                            <div class="col-md-6">
                                <label for="academic_level" class="form-label">Nivel Académico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-book"></i></span>
                                    <select id="academic_level" name="academic_level" class="form-select form-control" >
                                        <option value="" disabled selected>Selecciona tu nivel Académico</option>
                                        <option value="BásicaSecundaria" <?= ($academic_level == 'BásicaSecundaria') ? 'selected' : '' ?>>Básica secundaria</option>
                                        <option value="EducacionMedia" <?= ($academic_level == 'EducacionMedia') ? 'selected' : '' ?>>Educación media</option>
                                        <option value="Pregrado" <?= ($academic_level == 'Pregrado') ? 'selected' : '' ?>>Pregrado</option>
                                        <option value="Postgrado" <?= ($academic_level == 'Postgrado') ? 'selected' : '' ?>>Postgrado</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nivel de Formación -->
                            <div class="col-md-6">
                                <label for="level_education" class="form-label">Nivel de Formación</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-book"></i></span>
                                    <select id="level_education" name="level_education" class="form-select form-control" >
                                        <option value="">Selecciona tu nivel de formación</option>
                                        <?php
                                        // Usar un array de niveles posibles, y marcar como 'selected' el que corresponde
                                        $levels = ['Preescolar', 'Básica primaria', 'Básica secundaria', 'Educación media', 'Pregrado', 'Postgrado'];
                                        foreach ($levels as $level) {
                                            echo '<option value="' . $level . '" ' . (($level_education == $level) ? 'selected' : '') . '>' . $level . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Área de Conocimiento -->
                            <div class="col-md-6">
                                <label for="area_knowledge" class="form-label">Área de Conocimiento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <select for="area_knowledge" id="area_knowledge" name="area_knowledge" class="form-select form-control" disabled> 
                                        <option value="" disabled selected>Selecciona el área de conocimiento</option>
                                        <option value="Agronomia_veterinario_afines" <?= ($area_knowledge == 'Agronomia_veterinario_afines') ? 'selected' : '' ?>>Agronomía, Veterinario y Afines</option>
                                        <option value="Bellas_artes" <?= ($area_knowledge == 'Bellas_artes') ? 'selected' : '' ?>>Bellas Artes</option>
                                        <option value="Ciencias_educacion" <?= ($area_knowledge == 'Ciencias_educacion') ? 'selected' : '' ?>>Ciencias de la Educación</option>
                                        <option value="Ciencias_salud" <?= ($area_knowledge == 'Ciencias_salud') ? 'selected' : '' ?>>Ciencias de la Salud</option>
                                        <option value="Ciencias_sociales_humanas" <?= ($area_knowledge == 'Ciencias_sociales_humanas') ? 'selected' : '' ?>>Ciencias Sociales y Humanas</option>
                                        <option value="Ciencias_sociales_derecho" <?= ($area_knowledge == 'Ciencias_sociales_derecho') ? 'selected' : '' ?>>Ciencias Sociales, Derecho, Ciencias Políticas</option>
                                        <option value="Ciencias_humanidades_personales" <?= ($area_knowledge == 'Ciencias_humanidades_personales') ? 'selected' : '' ?>>Ciencias y Humanidades Personales</option>
                                        <option value="Economia_administracion_contaduria" <?= ($area_knowledge == 'Economia_administracion_contaduria') ? 'selected' : '' ?>>Economía, Administración, Contaduría y Afines</option>
                                        <option value="Generica" <?= ($area_knowledge == 'Generica') ? 'selected' : '' ?>>Genérica</option>
                                        <option value="Humanidades_ciencias_religiosas" <?= ($area_knowledge == 'Humanidades_ciencias_religiosas') ? 'selected' : '' ?>>Humanidades y Ciencias Religiosas</option>
                                        <option value="Ingenieria_arquitectura_urbanismo" <?= ($area_knowledge == 'Ingenieria_arquitectura_urbanismo') ? 'selected' : '' ?>>Ingeniería, Arquitectura, Urbanismo y Afines</option>
                                        <option value="Matematicas_ciencias_naturales" <?= ($area_knowledge == 'Matematicas_ciencias_naturales') ? 'selected' : '' ?>>Matemáticas y Ciencias Naturales</option>
                                        <option value="Tecnologia_informatica" <?= ($area_knowledge == 'Tecnologia_informatica') ? 'selected' : '' ?>>Tecnología Informática</option>
                                        <option value="No_aplica" <?= ($area_knowledge == 'No_aplica') ? 'selected' : '' ?>>No Aplica</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Institución -->
                            <div class="col-md-6">
                                <label for="institution" class="form-label">Institución</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" id="institution" name="institution" class="form-control"  placeholder="Nombre de la universidad" value="<?= esc($institution) ?>">
                                </div>
                            </div>

                            <!-- Título Obtenido -->
                            <div class="col-md-6">
                                <label for="title_obtained" class="form-label">Título Obtenido</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-award"></i></span>
                                    <input type="text" id="title_obtained" name="title_obtained" class="form-control"  placeholder="Título profesional" value="<?= esc($title_obtained) ?>">
                                </div>
                            </div>

                            <!-- Fecha de Inicio -->
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Fecha de Inicio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" id="start_date" name="start_date" class="form-control"  value="<?= esc($start_date) ?>">
                                </div>
                            </div>

                            <!-- Fecha de Fin -->
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Fecha de Fin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-x"></i></span>
                                    <input type="date" id="end_date" name="end_date" class="form-control"  value="<?= esc($end_date) ?>">
                                </div>
                            </div>

                            <!-- Archivo Académico -->
                            <div class="col-12">
                                <label for="academic_file" class="form-label">Subir Archivo de Soporte</label>
                                <div class="input-group">
                                    <input type="file" id="academic_file" name="academic_file" class="form-control" accept=".pdf,.doc,.docx,.png,.jpg">
                                    <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                </div>
                                <small class="form-text text-muted">
                                    Formatos permitidos: PDF, DOC, DOCX, PNG, JPG (máximo 5MB)
                                </small>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Guardar Información
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">
                            <i class="bi bi-check-circle-fill me-2"></i>Gracias <?php echo htmlspecialchars($user['name'] . '!', ENT_QUOTES, 'UTF-8'); ?>
                        </h5>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="fs-4">
                            <i class="bi bi-clipboard-check text-success me-2" style="font-size: 3rem;"></i>
                        </p>
                        <h4>Información Guardada</h4>
                        <p>Tu información académica se ha guardado correctamente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
// Manejar el envío del formulario para mostrar el modal de éxito
            document.getElementById('academicEdit').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevenir el envío normal del formulario

                // Aquí generalmente harías un envío AJAX
                // Para este ejemplo, simularemos una respuesta exitosa
                fetch('<?= base_url('index.php/user/academic-info/update/' . $user_cedula) ?>', {
                    method: 'POST',
                    body: new FormData(this)
                })
                        .then(response => {
                            if (response.ok) {
                                // Mostrar el modal de éxito
                                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                successModal.show();
                            } else {
                                // Manejar el error (mostrar la respuesta completa en la consola)
                                response.text().then(text => console.log(text));  // Ver el cuerpo de la respuesta
                                alert('Hubo un error al guardar la información');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Hubo un error al guardar la información');
                        });
            });
        </script>

        <script>
            const academicLevelSelect = document.getElementById("academic_level");
            const educationLevelSelect = document.getElementById("level_education");
            const areaKnowledgeField = document.getElementById("area_knowledge");

            const educationOptions = {
                Preescolar: ["Preescolar"],
                BásicaPrimaria: ["Primero", "Segundo", "Tercero", "Cuarto", "Quinto"],
                BásicaSecundaria: ["Sexto", "Séptimo", "Octavo", "Noveno", "Décimo", "Undécimo"],
                EducacionMedia: ["Décimo", "Undécimo"],
                Pregrado: ["Formación complementaria", "Técnico", "Técnico profesional", "Tecnólogo", "Profesional"],
                Postgrado: ["Especialización", "Maestría", "Doctorado", "Postdoctorado"]
            };

            // Escuchar cambios en el select de Nivel Académico
            academicLevelSelect.addEventListener("change", function () {
                const selectedAcademicLevel = academicLevelSelect.value;

                // Limpiar las opciones actuales del select de Nivel de Formación
                educationLevelSelect.innerHTML = '<option value="">Selecciona tu nivel de formación</option>';

                // Verificar si hay opciones para el nivel académico seleccionado
                if (educationOptions[selectedAcademicLevel]) {
                    educationOptions[selectedAcademicLevel].forEach(optionText => {
                        const optionElement = document.createElement("option");
                        optionElement.value = optionText.toLowerCase().replace(/ /g, "_"); // Crear valores únicos
                        optionElement.textContent = optionText; // Texto que aparecerá en el select
                        educationLevelSelect.appendChild(optionElement);
                    });
                }

                // Habilitar o deshabilitar el campo Área de Conocimiento
                if (selectedAcademicLevel === "Pregrado" || selectedAcademicLevel === "Postgrado") {
                    areaKnowledgeField.disabled = false; // Habilitar el campo
                } else {
                    areaKnowledgeField.disabled = true; // Deshabilitar el campo
                    areaKnowledgeField.value = ""; // Limpiar el valor seleccionado si estaba habilitado previamente
                }
            });
        </script>


        <!-- Scripts de Bootstrap y jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>


        <!-- Optional: Add Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">



    </body>
</html>