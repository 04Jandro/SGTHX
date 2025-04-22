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



                    <form id="academicSave" action="academic-info/save" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="row g-3">
                            <!-- Cédula -->
                            <div class="col-md-6">
                                <label for="cedula" class="form-label">Número de Identificacíon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" id="cedula" name="cedula" 
                                           class="form-control " value="<?= esc($user_cedula) ?>" readonly>
                                </div>
                                <small class="form-text text-muted">
                                    Número de Identificacíon
                                </small>
                            </div>

                            <!-- Nivel Académico -->
                            <div class="col-md-6">
                                <label for="academic_level" class="form-label">Nivel Académico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-book"></i></span>
                                    <select id="academic_level" name="academic_level" class="form-select form-control" required>
                                        <option value="" disabled selected>Selecciona tu nivel Académico</option>
                                        <option value="BásicaSecundaria">Básica secundaria</option>
                                        <option value="EducacionMedia">Educación media</option>
                                        <option value="Pregrado">Pregrado</option>
                                        <option value="Postgrado">Postgrado</option>
                                    </select>
                                </div>
                                <small class="form-text text-muted">
                                    Nivel Académico (Obligatorio)
                                </small>
                            </div>

                            <!-- Nivel de Formación -->
                            <div class="col-md-6">
                                <label for="level_education" class="form-label">Nivel de Formación</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-book"></i></span>
                                    <select id="level_education" name="level_education" class="form-select form-control" required>
                                        <option value="">Selecciona tu nivel de formación</option>
                                    </select>
                                </div>
                                <small class="form-text text-muted">
                                    Nivel de Formación (Obligatorio)
                                </small>
                            </div>

                            <!-- Nuevo Select que aparecerá solo si se selecciona Pregrado -->
                            <div id="pregradoOptions" style="display:none;">
                                <label for="pregrado_formation">Formación en Pregrado:</label>
                                <select id="pregrado_formation" name="pregrado_formation">
                                    <option value="" disabled selected>Selecciona tu formación en Pregrado</option>
                                    <option value="Tecnico">Técnico</option>
                                    <option value="Tecnologico">Tecnológico</option>
                                    <option value="ProfesionalUniversitario">Profesional Universitario</option>
                                </select>
                            </div>

                            <!-- Área de Conocimiento -->
                            <div class="col-md-6">
                                <label for="area_knowledge" class="form-label">Área de Conocimiento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <select for="area_knowledge" id="area_knowledge" name="area_knowledge" class="form-select form-control" disabled> 
                                        <option value="" disabled selected>Selecciona el área de conocimiento</option>
                                        <option value="Agronomia veterinario afines">Agronomía, Veterinario y Afines</option>
                                        <option value="Bellas artes">Bellas Artes</option>
                                        <option value="Ciencias educacion">Ciencias de la Educación</option>
                                        <option value="Ciencias salud">Ciencias de la Salud</option>
                                        <option value="Ciencias sociales_humanas">Ciencias Sociales y Humanas</option>
                                        <option value="Ciencias sociales_derecho">Ciencias Sociales, Derecho, Ciencias Políticas</option>
                                        <option value="Ciencias humanidades_personales">Ciencias y Humanidades Personales</option>
                                        <option value="Economia administracion contaduria">Economía, Administración, Contaduría y Afines</option>
                                        <option value="Generica">Genérica</option>
                                        <option value="Humanidades ciencias religiosas">Humanidades y Ciencias Religiosas</option>
                                        <option value="Ingenieria arquitectura urbanismo">Ingeniería, Arquitectura, Urbanismo y Afines</option>
                                        <option value="Matematicas ciencias naturales">Matemáticas y Ciencias Naturales</option>
                                        <option value="Tecnologia informatica">Tecnología Informática</option>
                                        <option value="No aplica">No Aplica</option>
                                    </select>
                                </div>
                                <small class="form-text text-muted">
                                    Área del Conocimiento
                                </small>
                            </div>


                            <!-- Institución -->
                            <div class="col-md-6">
                                <label for="institution" class="form-label">Institución</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" id="institution" name="institution" 
                                           class="form-control" required placeholder="Nombre de la universidad">
                                </div>
                                <small class="form-text text-muted">
                                    Institución
                                </small>
                            </div>

                            <!-- Título Obtenido -->
                            <div class="col-md-6">
                                <label for="title_obtained" class="form-label">Título Obtenido</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-award"></i></span>
                                    <input type="text" id="title_obtained" name="title_obtained" 
                                           class="form-control" required placeholder="Título profesional">
                                </div>
                                <small class="form-text text-muted">
                                    Título Obtenido
                                </small>
                            </div>
                            <!-- Semestres Aprobados -->
                            <div class="col-md-6">
                                <label for="semesters_passed" class="form-label">Semestres Aprobados</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                                    <input type="number" id="semesters_passed" name="semesters_passed" 
                                           class="form-control" placeholder="Semestres Aprobados" required>
                                </div>
                                <small class="form-text text-muted">
                                    Número de semestres aprobados.
                                </small>
                            </div>

                            <!-- Graduado -->
                            <div class="col-md-6">
                                <label for="graduated" class="form-label">¿Está Graduado?</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                    <select id="graduated" name="graduated" class="form-control" required>
                                        <option value="" disabled selected>Seleccione...</option>
                                        <option value="si">Sí</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                                <small class="form-text text-muted">
                                    Indique si está graduado.
                                </small>
                            </div>

                            <!-- Número de Tarjeta Profesional -->
                            <div class="col-md-6">
                                <label for="professional_card_number" class="form-label">Número de Tarjeta Profesional</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-checklist"></i></span>
                                    <input type="text" id="professional_card_number" name="professional_card_number" 
                                           class="form-control" placeholder="Número de Tarjeta Profesional">
                                </div>
                                <small class="form-text text-muted">
                                    Número de la tarjeta profesional (opcional)
                                </small>
                            </div>

                            <!-- Fecha de Inicio -->
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Fecha de Iniciación</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" id="start_date" name="start_date" 
                                           class="form-control" required>
                                </div>
                                <small class="form-text text-muted">
                                    Fecha de Iniciación
                                </small>
                            </div>

                            <!-- Fecha de Fin -->
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Fecha de Finalización</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-x"></i></span>
                                    <input type="date" id="end_date" name="end_date" 
                                           class="form-control" required>
                                </div>
                                <small class="form-text text-muted">
                                    Fecha de Finalización
                                </small>
                            </div>


                            <!-- Archivo Académico -->
                            <div class="col-12">
                                <label for="academic_file" class="form-label">Subir Archivo de Soporte</label>
                                <div class="input-group">
                                    <input type="file" id="academic_file" name="academic_file" 
                                           class="form-control" accept=".pdf,.doc,.docx,.png,.jpg">
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
                    <i class="bi bi-check-circle-fill me-2"></i>Gracias <?php echo htmlspecialchars($user_name . '!', ENT_QUOTES, 'UTF-8'); ?>
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
                <!-- Volver al menú -->
                <a href="https://sgth.utede.com.co/index.php/user/menu" class="btn btn-secondary">Volver al Menú</a>

                <!-- Ingresar otra información académica -->
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="window.location.reload();">Ingresar Otra Información Académica</button>
            </div>
        </div>
    </div>
</div>

        <!-- Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="errorModalLabel">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>Error en el Formulario
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="fs-4">
                            <i class="bi bi-x-circle text-danger me-2" style="font-size: 3rem;"></i>
                        </p>
                        <h4>Por favor, corrige los siguientes errores:</h4>
                        <div id="errorList" class="text-start mt-3">
                            <!-- Los errores se insertarán aquí -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
                            <script>
    document.getElementById('academicSave').addEventListener('submit', function (e) {
        e.preventDefault();

        // Array para almacenar los errores
        const errors = [];

        // Validar nivel académico
        const academicLevel = document.getElementById('academic_level');
        if (!academicLevel.value) {
            errors.push("Debes seleccionar un nivel académico");
        }

        // Validar nivel de educación
        const levelEducation = document.getElementById('level_education');
        if (!levelEducation.value) {
            errors.push("Debes seleccionar un nivel de educación");
        }

        // Validar área de conocimiento (opcional)
        const areaKnowledge = document.getElementById('area_knowledge');
        if (areaKnowledge.value && areaKnowledge.value.length < 2) {
            errors.push("El área de conocimiento, si se proporciona, debe tener al menos 2 caracteres");
        }

        // Validar institución
        const institution = document.getElementById('institution');
        if (institution.value.length < 2) {
            errors.push("El nombre de la institución debe tener al menos 2 caracteres");
        }

        // Validar título obtenido
        const titleObtained = document.getElementById('title_obtained');
        if (titleObtained.value.length < 2) {
            errors.push("El título obtenido debe tener al menos 2 caracteres");
        }

        // Validar fecha de inicio
        const startDate = document.getElementById('start_date');
        if (!startDate.value) {
            errors.push("Debes seleccionar una fecha de inicio válida");
        }


        // Validar archivo académico (opcional, debe ser un archivo válido)
        const academicFile = document.getElementById('academic_file');
        if (academicFile.files.length > 0) {
            const file = academicFile.files[0];
            if (file.size > 2 * 1024 * 1024) { // Limite de 2 MB
                errors.push("El archivo académico no debe superar los 2 MB");
            }
        }

        // Validar número de semestres aprobados
        const semestersPassed = document.getElementById('semesters_passed');
        if (!/^\d+$/.test(semestersPassed.value)) {
            errors.push("El número de semestres aprobados debe ser un número válido");
        }

        // Validar si está graduado
        const graduated = document.getElementById('graduated');
        if (!graduated.value) {
            errors.push("Debes seleccionar si estás graduado");
        }



        // Mostrar errores si existen
        if (errors.length > 0) {
            const errorList = document.getElementById('errorList');
            errorList.innerHTML = errors.map(error => `<p class=\"mb-2\">• ${error}</p>`).join('');
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
            return;
        }

        // Si no hay errores, proceder con el envío
        fetch('<?= base_url('index.php/user/academic-info/save') ?>', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => {
            if (response.ok) {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                successModal._element.addEventListener('hidden.bs.modal', function () {
                });
            } else {
                response.text().then(text => console.log(text));
                const errorList = document.getElementById('errorList');
                errorList.innerHTML = '<p class=\"mb-2\">• Hubo un error al procesar tu solicitud. Por favor, intenta nuevamente.</p>';
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorList = document.getElementById('errorList');
            errorList.innerHTML = '<p class=\"mb-2\">• Error de conexión. Por favor, verifica tu conexión a internet e intenta nuevamente.</p>';
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
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


        <script>

            $(document).ready(function () {
                // Optional: Date validation
                $('#start_date, #end_date').on('change', function () {
                    var startDate = new Date($('#start_date').val());


                    if (startDate > endDate) {
                        alert('La fecha de inicio no puede ser posterior a la fecha de fin');
                        $(this).val('');
                    }
                });
            });
        </script>

    </body>
</html>