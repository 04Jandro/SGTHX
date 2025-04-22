<?php include 'user_header.php'; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Actualización de Información Personal</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
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
            .form-control[readonly] {
                background-color: #e9ecef;
                opacity: 1;
            }
            .card-header {
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
            }
            .language-group {
                background-color: #f8f9fa;
            }
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }
            input, select {
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 form-container">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h2 class="mb-0">
                                <i class="bi bi-person-badge me-2"></i>Actualización de información acádemica e idiomas 
                            </h2>
                        </div>

                        <form id="basicUpdate" action="<?= site_url('user/basic-info/update') ?>" method="post" class="card-body">
                            <div class="row g-3">
                                <!-- Cédula -->
                                <div class="col-md-6">
                                    <label for="cedula" class="form-label">Cédula</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" name="cedula" id="cedula" class="form-control" 
                                               value="<?= isset($user_cedula) ? $user_cedula : '' ?>" readonly>

                                    </div>
                                </div>

                                <!-- Nuevo Título Obtenido -->
                                <div class="col-md-6">
                                    <label for="obtained_title" class="form-label">Título Obtenido</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-award"></i></span>
                                        <input type="text" name="obtained_title" id="obtained_title" class="form-control"
                                               value="<?= isset($personalInfo['obtained_title']) ? $personalInfo['obtained_title'] : '' ?>" 
                                               placeholder="Título obtenido en educación básica y/o media">
                                    </div>
                                </div>

                                <!-- Nivel Académico Máximo -->
                                <div class="col-md-6">
                                    <label for="max_level_academic" class="form-label">Nivel Académico Máximo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-book"></i></span>
                                        <select name="max_level_academic" id="max_level_academic" class="form-control">
                                            <option value="" disabled selected>Seleccionar nivel académico</option>
                                            <?php
                                            // Rango de niveles académicos del 1 al 11
                                            for ($i = 1; $i <= 11; $i++) {
                                                // Verificar si el valor ya está seleccionado
                                                $selected = (isset($personalInfo['max_level_academic']) && $personalInfo['max_level_academic'] == $i) ? 'selected' : '';
                                                echo "<option value=\"$i\" $selected>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <!-- Fecha de Graduación -->
                                <div class="col-md-6">
                                    <label for="graduation_date" class="form-label">Fecha de Graduación</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                        <input type="date" name="graduation_date" id="graduation_date" class="form-control" 
                                               value="<?= isset($personalInfo['graduation_date']) ? $personalInfo['graduation_date'] : '' ?>" >
                                    </div>
                                </div>

                                <!-- Fecha de Título -->
                                <div class="col-md-6">
                                    <label for="title_date" class="form-label">Fecha de Título</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                        <input type="date" name="title_date" id="title_date" class="form-control" 
                                               value="<?= isset($personalInfo['title_date']) ? $personalInfo['title_date'] : '' ?>" >
                                    </div>
                                </div>

                                <!-- Idiomas -->
                                <div class="col-md-6">
                                    <label for="languages" class="form-label">Idiomas</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-translate"></i></span>
                                        <input type="text" name="languages" id="languages" class="form-control" 
                                               value="<?= isset($personalInfo['languages']) ? implode(', ', $userLanguages) : '' ?>" 
                                               placeholder="Escriba los idiomas uno por uno" >
                                    </div>
                                </div>
                            </div>

                            <!-- Language Proficiency Section -->
                            <?php if (!empty($userLanguages)): ?>
                                <div class="card mt-4 mb-3">
                                    <div class="card-header bg-secondary text-white">
                                        <h4 class="mb-0"><i class="bi bi-translate me-2"></i>Nivel de Idiomas</h4>
                                    </div>
                                    <div class="card-body">
                                        <?php foreach ($userLanguages as $language): ?>
                                            <div class="language-group border rounded p-3 mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0"><?= strtoupper(htmlspecialchars($language['language_name'])) ?></h5>
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-language" 
                                                            data-language-id="<?= $language['id'] ?>" 
                                                            data-language-name="<?= htmlspecialchars($language['language_name']) ?>">
                                                        <i class="bi bi-trash me-1"></i>Eliminar
                                                    </button>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label for="speaks_<?= $language['id'] ?>" class="form-label">Habla</label>
                                                        <select name="speaks[<?= $language['id'] ?>]" id="speaks_<?= $language['id'] ?>" class="form-select">
                                                            <option value="regular" <?= isset($language['speaks']) && $language['speaks'] == 'regular' ? 'selected' : '' ?>>Regular</option>
                                                            <option value="bien" <?= isset($language['speaks']) && $language['speaks'] == 'bien' ? 'selected' : '' ?>>Bien</option>
                                                            <option value="muy bien" <?= isset($language['speaks']) && $language['speaks'] == 'muy bien' ? 'selected' : '' ?>>Muy Bien</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="reads_<?= $language['id'] ?>" class="form-label">Lee</label>
                                                        <select name="reads[<?= $language['id'] ?>]" id="reads_<?= $language['id'] ?>" class="form-select">
                                                            <option value="regular" <?= isset($language['reads']) && $language['reads'] == 'regular' ? 'selected' : '' ?>>Regular</option>
                                                            <option value="bien" <?= isset($language['reads']) && $language['reads'] == 'bien' ? 'selected' : '' ?>>Bien</option>
                                                            <option value="muy bien" <?= isset($language['reads']) && $language['reads'] == 'muy bien' ? 'selected' : '' ?>>Muy Bien</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label for="writes_<?= $language['id'] ?>" class="form-label">Escribe</label>
                                                        <select name="writes[<?= $language['id'] ?>]" id="writes_<?= $language['id'] ?>" class="form-select">
                                                            <option value="regular" <?= isset($language['writes']) && $language['writes'] == 'regular' ? 'selected' : '' ?>>Regular</option>
                                                            <option value="bien" <?= isset($language['writes']) && $language['writes'] == 'bien' ? 'selected' : '' ?>>Bien</option>
                                                            <option value="muy bien" <?= isset($language['writes']) && $language['writes'] == 'muy bien' ? 'selected' : '' ?>>Muy Bien</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-save me-2"></i>Actualizar Datos
                                </button>
                            </div>
                        </form>
                    </div>
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
                        <p>Tu información de idiomas y personal académica se ha guardado correctamente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="acceptBtn" data-bs-dismiss="modal">Aceptar</button>
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
            document.getElementById('basicUpdate').addEventListener('submit', function (e) {
                e.preventDefault();

                // Array para almacenar los errores
                const errors = [];

               

                // Validar fecha de título obtenido
                const titleDate = document.getElementById('title_date');
                if (!titleDate.value) {
                    errors.push("Debes seleccionar una fecha de título obtenido");
                }

                // Validar fecha de graduación
                const graduationDate = document.getElementById('graduation_date');
                if (!graduationDate.value) {
                    errors.push("Debes seleccionar una fecha de graduación");
                }

                // Validar el máximo nivel académico
                const maxLevelAcademic = document.getElementById('max_level_academic');
                if (!maxLevelAcademic.value) {
                    errors.push("Debes seleccionar el máximo nivel académico alcanzado");
                }

                // Validar título obtenido
                const obtainedTitle = document.getElementById('obtained_title');
                if (!obtainedTitle.value) {
                    errors.push("Debes ingresar el título obtenido");
                }

                // Mostrar errores si existen
                if (errors.length > 0) {
                    const errorList = document.getElementById('errorList');
                    errorList.innerHTML = errors.map(error => `<p class="mb-2">• ${error}</p>`).join('');
                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                    return;
                }

                // Si no hay errores, proceder con el envío
                fetch('<?= base_url('index.php/user/basic-info/update') ?>', {
                    method: 'POST',
                    body: new FormData(this)
                })
                        .then(response => {
                            if (response.ok) {
                                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                successModal.show();

                                });
                            } else {
                                response.text().then(text => console.log(text));
                                const errorList = document.getElementById('errorList');
                                errorList.innerHTML = '<p class="mb-2">• Hubo un error al procesar tu solicitud. Por favor, intenta nuevamente.</p>';
                                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                                errorModal.show();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            const errorList = document.getElementById('errorList');
                            errorList.innerHTML = '<p class="mb-2">• Error de conexión. Por favor, verifica tu conexión a internet e intenta nuevamente.</p>';
                            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                            errorModal.show();
                        });
            });
        </script>



        <script>
            document.querySelectorAll('.delete-language').forEach(function (button) {
                button.addEventListener('click', function () {
                    const languageId = button.getAttribute('data-language-id');
                    const languageName = button.getAttribute('data-language-name');

                    if (confirm(`¿Estás seguro de que deseas eliminar el idioma ${languageName}?`)) {
                        window.location.href = '<?= site_url("user/basic-info/delete-language/") ?>' + languageId;
                    }
                });
            });
        </script>
    </body>
</html>