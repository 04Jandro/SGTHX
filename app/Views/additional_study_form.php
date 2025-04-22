<?php include('user_header.php'); ?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Estudio Adicional</title>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
            .btn-success {
                padding: 0.75rem 1.5rem;
            }
                        input, select {
                text-transform: uppercase;
            }
        </style>

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 form-container">
                    <h2 class="text-center mb-4 text-dark">
                        <i class="bi bi-journal-bookmark me-2"></i>Formulario de Estudio Adicional
                    </h2>


                    <form id="additionalSave" action="additional-study/save" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <!-- Cédula -->
                            <div class="col-md-6">
                                <label for="cedula" class="form-label">Cédula</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" id="cedula" name="cedula" class="form-control" value="<?= esc($user_cedula) ?>" readonly>
                                </div>
                            </div>

                            <!-- Tipo de Estudio -->
                            <div class="col-md-6">
                                <label for="study_type" class="form-label">Tipo de Estudio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-book"></i></span>
                                    <select id="study_type" name="study_type" class="form-select form-control" >
                                        <option value="" disabled selected>Selecciona un tipo de estudio</option>
                                        <option value="Diplomado">Diplomado</option>
                                        <option value="Certificación">Certificación</option>
                                        <option value="Curso">Curso</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Nombre de la Institución -->
                            <div class="col-md-6">
                                <label for="institution_name" class="form-label">Nombre de la Institución</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" id="institution_name" name="institution_name" 
                                           class="form-control"  placeholder="Nombre de la institución">
                                </div>
                            </div>

                            <!-- Nombre del Estudio -->
                            <div class="col-md-6">
                                <label for="study_name" class="form-label">Nombre del Estudio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-award"></i></span>
                                    <input type="text" id="study_name" name="study_name" 
                                           class="form-control"  placeholder="Nombre del estudio">
                                </div>
                            </div>

                            <!-- Fecha de Inicio -->
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Fecha de Inicio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" id="start_date" name="start_date" 
                                           class="form-control" >
                                </div>
                            </div>

                            <!-- Fecha de Finalización -->
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Fecha de Finalización</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-x"></i></span>
                                    <input type="date" id="end_date" name="end_date" 
                                           class="form-control" >
                                </div>
                            </div>

                            <!-- Horas de Duración -->
                            <div class="col-md-6">
                                <label for="duration_hours" class="form-label">Tiempo de Duración</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                    <input type="number" id="duration_hours" name="duration_hours" 
                                           class="form-control" placeholder="Horas totales">
                                </div>
                            </div>

                            <!-- Modalidad -->
                            <div class="col-md-6">
                                <label for="modality" class="form-label">Modalidad</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-display"></i></span>
                                    <select id="modality" name="modality" class="form-select form-control" >
                                        <option value="" disabled selected>Selecciona una modalidad</option>
                                        <option value="Presencial">Presencial</option>
                                        <option value="Virtual">Virtual</option>
                                        <option value="Híbrido">Híbrido</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Archivo del Certificado -->
                            <div class="col-12">
                                <label for="certificate_file" class="form-label">Subir Certificado</label>
                                <div class="input-group">
                                    <input type="file" id="study_file" name="study_file" 
                                           class="form-control" accept=".pdf,.doc,.docx,.png,.jpg">
                                    <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                </div>
                                <small class="form-text text-muted">
                                    Formatos permitidos: PDF, DOC, DOCX, PNG, JPG (máximo 5MB)
                                </small>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">Estado</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                    <select id="status" name="status" class="form-select form-control" >
                                        <option value="" disabled selected>Selecciona el estado</option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-2"></i>Guardar Estudio
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
                        <p>Tu información de estudios adicionales se ha guardado correctamente.</p>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="window.location.reload();">Aceptar</button>
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
document.getElementById('additionalSave').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevenir el envío normal del formulario

    let errors = [];

    // Validar cedula
    const cedula = document.getElementById('cedula');
    if (!/^\d+$/.test(cedula.value)) {
        errors.push("La cédula debe ser un número válido");
    }

    // Validar study_type
    const studyType = document.getElementById('study_type');
    if (studyType.value.trim().length < 1) {
        errors.push("El tipo de estudio no puede estar vacío");
    }

    // Validar institution_name
    const institutionName = document.getElementById('institution_name');
    if (institutionName.value.trim().length < 1) {
        errors.push("El nombre de la institución no puede estar vacío");
    } else if (!/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.]+$/.test(institutionName.value)) {
        errors.push("El nombre de la institución contiene caracteres inválidos");
    }

    // Validar study_name
    const studyName = document.getElementById('study_name');
    if (studyName.value.trim().length < 1) {
        errors.push("El nombre del estudio no puede estar vacío");
    } else if (!/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.]+$/.test(studyName.value)) {
        errors.push("El nombre del estudio contiene caracteres inválidos");
    }

    // Validar start_date
    const startDate = document.getElementById('start_date');
    if (startDate.value && !/^\d{4}-\d{2}-\d{2}$/.test(startDate.value)) {
        errors.push("La fecha de inicio debe estar en formato AAAA-MM-DD");
    }

    // Validar end_date
    const endDate = document.getElementById('end_date');
    if (endDate.value && !/^\d{4}-\d{2}-\d{2}$/.test(endDate.value)) {
        errors.push("La fecha de finalización debe estar en formato AAAA-MM-DD");
    }

    // Validar duration_hours
    const durationHours = document.getElementById('duration_hours');
    if (durationHours.value && (!/^\d+$/.test(durationHours.value) || durationHours.value <= 0)) {
        errors.push("La duración en horas debe ser un número positivo");
    }

    // Validar modality
    const modality = document.getElementById('modality');
    if (modality.value.trim().length < 1) {
        errors.push("La modalidad no puede estar vacía");
    }

    // Mostrar errores o proceder con el envío
    if (errors.length > 0) {
        const errorList = document.getElementById('errorList');
        errorList.innerHTML = errors.map(error => `<p class="mb-2">• ${error}</p>`).join('');
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    } else {
        fetch('<?= base_url('index.php/user/additional-study/save') ?>', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => {
            if (response.ok) {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                successModal._element.addEventListener('hidden.bs.modal', function () {
                    window.location.href = '/';
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
    }
});

        </script>
        <!-- Scripts de Bootstrap y jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>