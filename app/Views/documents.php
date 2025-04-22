<?php include 'user_header.php'; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Portal de Documentación</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="bg-light">
        <div class="container-fluid py-5">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-primary text-white text-center py-4">
                            <h2 class="mb-0">
                                <i class="fas fa-file-upload me-2"></i>
                                Portal de Documentación
                            </h2>
                        </div>
                        <div class="card-body p-4">
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <div class="mb-4">
                                <a href="<?= base_url('index.php/user/document/list') ?>" class="card text-decoration-none hover-card">
                                    <div class="card-body d-flex align-items-center p-3 bg-light-hover">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-folder-open fa-2x text-primary"></i>
                                        </div>
                                        <div class="ms-3">
                                            <h5 class="mb-1 text-primary">Mis Documentos</h5>
                                            <p class="mb-0 text-muted">Ver lista completa de documentos subidos</p>
                                        </div>
                                        <div class="ms-auto">
                                            <i class="fas fa-chevron-right text-primary"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Formulario para subir documentos -->
                            <form id="documents" action="<?= base_url('index.php/user/documents/upload') ?>" method="post" enctype="multipart/form-data">
                                <!-- Campo oculto con la cédula del usuario -->
                                <input type="hidden" class="form-control-plaintext" value="<?= esc($user_cedula) ?>" readonly>

                                <div class="row g-4">
                                    <!-- CÉDULA DE CIUDADANÍA -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-id-card fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="cedula" class="form-label fw-bold">Cédula de Ciudadanía</label>
                                                    <input type="file" class="form-control" id="cedula" name="cedula">
                                                    <!-- Select oculto para el tipo de documento (Cédula de Ciudadanía) -->
                                                    <select name="document_type_cedula" style="display:none;">
                                                        <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hoja de Vida -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-file-alt fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="cv" class="form-label fw-bold">Hoja de Vida Firmada</label>
                                                    <input type="file" class="form-control" id="cv" name="cv">
                                                    <select name="document_type_cv" style="display:none;">
                                                        <option value="Hoja de Vida">Hoja de Vida</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- RUT -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-receipt fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="rut" class="form-label fw-bold">RUT (DIAN)</label>
                                                    <input type="file" class="form-control" id="rut" name="rut">
                                                    <select name="document_type_rut" style="display: none;">
                                                        <option value="RUT (DIAN)">RUT (DIAN)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Certificación Bancaria -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-university fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="bank_cert" class="form-label fw-bold">Certificación Bancaria</label>
                                                    <input type="file" class="form-control" id="bank_cert" name="bank_cert">
                                                    <select name="document_type_bank_cert" style="display: none;">
                                                        <option value="Certificación Bancaria">Certificación Bancaria</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Antecedentes Fiscales -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-balance-scale fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="fiscal" class="form-label fw-bold">Antecedentes Fiscales</label>
                                                    <input type="file" class="form-control" id="fiscal" name="fiscal">
                                                    <select name="document_type_fiscal" style="display: none;">
                                                        <option value="Antecedentes Fiscales">Antecedentes Fiscales</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Antecedentes Disciplinarios -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-gavel fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="disciplinary" class="form-label fw-bold">Antecedentes Disciplinarios</label>
                                                    <input type="file" class="form-control" id="disciplinary" name="disciplinary">
                                                    <select name="document_type_disciplinary" style="display: none;">
                                                        <option value="Antecedentes Disciplinarios">Antecedentes Disciplinarios</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Antecedentes Penales -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-shield-alt fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="criminal" class="form-label fw-bold">Antecedentes Penales</label>
                                                    <input type="file" class="form-control" id="criminal" name="criminal">
                                                    <select name="document_type_criminal" style="display: none;">
                                                        <option value="Antecedentes Penales">Antecedentes Penales</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Validación Profesional -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-user-graduate fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="profession_validation" class="form-label fw-bold">Validación Profesional</label>
                                                    <input type="file" class="form-control" id="profession_validation" name="profession_validation">
                                                    <select name="document_type_profession_validation" style="display: none;">
                                                        <option value="Validación Profesional">Validación Profesional</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- REDAM -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="upload-card">
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-exclamation-circle fa-2x text-primary"></i>
                                                    </div>
                                                    <label for="redam" class="form-label fw-bold">
                                                        Registro de Deudores Alimentarios Morosos (REDAM)
                                                    </label>
                                                    <input type="file" class="form-control" id="redam" name="redam">
                                                    <select name="document_type_redam" style="display: none;">
                                                        <option value="REDAM">REDAM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón de subir documentos -->
                                    <div class="text-center mt-5">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="fas fa-cloud-upload-alt me-2"></i>
                                            Subir Documentos
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                        <p>Tus archivos han sido subidos exitosamente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('documents');

        // Escuchar el evento de envío del formulario
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el envío normal del formulario

            // Enviar el formulario utilizando Fetch
            fetch('<?= base_url('index.php/user/documents/upload') ?>', {
                method: 'POST',
                body: new FormData(form) // Enviar los datos del formulario
            })
            .then(response => {
                if (response.ok) {
                    // Mostrar el modal de éxito
                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();

                    // Escuchar cuando el modal se cierre
                    successModal._element.addEventListener('hidden.bs.modal', function () {
                        // Redirigir a la página principal
                        window.location.href = '/index.php/user/documents';
                    });
                } else {
                    // Si la respuesta no es OK, mostrar algún mensaje de error o manejar el fallo
                    alert('Hubo un error al guardar los datos. Intenta nuevamente.');
                }
            })
            .catch(error => {
                // En caso de error en la petición (por ejemplo, problemas de red)
                console.error('Error al enviar los datos:', error);
                alert('Hubo un problema al enviar los datos. Intenta nuevamente.');
            });
        });
    });
</script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
