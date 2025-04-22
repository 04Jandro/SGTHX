<?php include 'user_header.php'; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Información Personal</title>
        <!-- Bootstrap 5 CSS -->

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
            .form-control, .form-select {
                border-radius: 8px;
                padding: 0.75rem 1rem;
                border-color: #ced4da;
                transition: all 0.3s ease;
            }
            .form-control:focus, .form-select:focus {
                border-color: #6c757d;
                box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
            }
            .btn-primary, .btn-secondary, .btn-success {
                border-radius: 8px;
                padding: 0.75rem 1.5rem;
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #004085;
            }
            .form-step {
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .form-step.active {
                display: block;
                opacity: 1;
            }
            .step-indicator {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }
            .step-indicator .step {
                flex: 1;
                text-align: center;
                padding: 10px;
                background-color: #e9ecef;
                color: #6c757d;
                position: relative;
            }
            .step-indicator .step.active {
                background-color: #007bff;
                color: white;
            }
            .step-indicator .step:not(:first-child)::before {
                content: '';
                position: absolute;
                top: 50%;
                left: -50%;
                width: 100%;
                height: 2px;
                background-color: #e9ecef;
                z-index: -1;
            }
            .step-indicator .step.active:not(:first-child)::before {
                background-color: #007bff;
            }
            .col-12{
                margin-top:20px;
            }
            .form-control[readonly] {
                background-color: #e9ecef; /* Aplica un gris claro */
                opacity: 1;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 form-container">
                    <h2 class="text-center mb-4 text-dark">
                        <i class="fas fa-user-edit me-2"></i>Formulario de Información Personal
                    </h2>

                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div class="step active">Información Personal</div>
                        <div class="step">Detalles Adicionales</div>
                        <div class="step">Más Información</div>
                    </div>

                   <form action="<?= base_url('index.php/user/personal-info/update/' . $personalInfo['cedula']) ?>" method="POST" id="multiStepForm" enctype="multipart/form-data">

                        <!-- Step 1: Personal Information -->
                        <div class="form-step active" id="step-1">
                            <div class="row g-3">
                                <!-- Tipo de Documento y Cédula -->
                                <div class="col-md-6">
                                    <label for="document_type" class="form-label">Tipo de Documento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <select class="form-select" id="document_type" name="document_type" required>
                                            <option value="CC" <?= $user['document_type'] == 'CC' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                                            <option value="TI" <?= $user['document_type'] == 'TI' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                                            <option value="NIT" <?= $user['document_type'] == 'NIT' ? 'selected' : '' ?>>NIT</option>
                                            <option value="Pasaporte" <?= $user['document_type'] == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="cedula" class="form-label">Número de Documento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" id="cedula" name="cedula" class="form-control" 
                                               value="<?= esc($user['cedula']) ?>" readonly>
                                    </div>
                                </div>

                                <!-- Fecha y Lugar de Expedición -->
                                <div class="col-md-6">
                                    <label for="date_of_issue" class="form-label">Fecha de Expedición</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" id="date_of_issue" name="date_of_issue"
                                               value="<?= esc($personalInfo['date_of_issue']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="place_of_issue" class="form-label">Lugar de Expedición</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control" id="place_of_issue" name="place_of_issue"
                                               value="<?= esc($personalInfo['place_of_issue']) ?>" required>
                                    </div>
                                </div>

                                <!-- Género y Nacionalidad -->
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">Género</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="M" <?= $personalInfo['gender'] == 'M' ? 'selected' : '' ?>>Masculino</option>
                                            <option value="F" <?= $personalInfo['gender'] == 'F' ? 'selected' : '' ?>>Femenino</option>
                                            <option value="Otro" <?= $personalInfo['gender'] == 'Otro' ? 'selected' : '' ?>>Otro</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nationality" class="form-label">Nacionalidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        <input type="text" class="form-control" id="nationality" name="nationality"
                                               value="<?= esc($personalInfo['nationality']) ?>" required>
                                    </div>
                                </div>

                                <!-- Nombres -->
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">Primer nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                               value="<?= esc($personalInfo['first_name']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="middle_name" class="form-label">Segundo nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name"
                                               value="<?= esc($personalInfo['middle_name']) ?>">
                                    </div>
                                </div>

                                <!-- Apellidos -->
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Primer apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                               value="<?= esc($personalInfo['last_name']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="second_last_name" class="form-label">Segundo apellido</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <input type="text" class="form-control" id="second_last_name" name="second_last_name"
                                               value="<?= esc($personalInfo['second_last_name']) ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Archivo Académico -->

                            <div class="col-12">
                                <label for="file_path" class="form-label">Subir Archivo de Cédula</label>
                                <div class="input-group">
                                    <input type="file" id="cedula_file" name="cedula_file" 
                                           class="form-control" accept=".pdf,.doc,.docx,.png,.jpg">
                                    <span class="input-group-text"><i class="bi bi-upload"></i></span>
                                </div>
                                <small class="form-text text-muted">
                                    Formatos permitidos: PDF, DOC, DOCX, PNG, JPG (máximo 5MB)
                                </small>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary next-step">
                                    Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Additional Personal Details -->
                        <div class="form-step" id="step-2">
                            <div class="row g-3">
                                <!-- País y Departamento de nacimiento -->
                                <div class="col-md-6">
                                    <label for="birth_country" class="form-label">País de nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                        <input type="text" class="form-control" id="birth_country" name="birth_country" required value="<?= esc($personalInfo['birth_country']) ?>">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="birth_department" class="form-label">Departamento de nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                                        <input type="text" class="form-control" id="birth_department" name="birth_department" required value="<?= esc($personalInfo['birth_department']) ?>">
                                    </div>
                                </div>

                                <!-- Ciudad y Fecha de nacimiento -->
                                <div class="col-md-6">
                                    <label for="birth_city" class="form-label">Ciudad de nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                                        <input type="text" class="form-control" id="birth_city" name="birth_city" required value="<?= esc($personalInfo['birth_city']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="birth_date" class="form-label">Fecha de nacimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date" required value="<?= esc($personalInfo['birth_date']) ?>">
                                    </div>
                                </div>

                                <!-- Edad y Dirección -->
                                <div class="col-md-6">
                                    <label for="age" class="form-label">Edad</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                                        <input type="number" class="form-control" id="age" name="age" required value="<?= esc($personalInfo['age']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                        <input type="text" class="form-control" id="address" name="address" required value="<?= esc($personalInfo['address']) ?>">
                                    </div>
                                </div>

                                <!-- Contacto -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= esc($personalInfo['phone']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label">Móvil</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        <input type="tel" class="form-control" id="mobile" name="mobile" value="<?= esc($personalInfo['mobile']) ?>">
                                    </div>
                                </div>

                                <!-- Correo Electrónico -->
                                <div class="col-12">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" required value="<?= esc($personalInfo['email']) ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Anterior
                                </button>
                                <button type="button" class="btn btn-primary next-step">
                                    Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Military and Marital Information -->
                        <div class="form-step" id="step-3">
                            <div class="row g-3">
                                <!-- Información Militar -->
                                <div class="col-md-6">
                                    <label for="military_card_type" class="form-label">Tipo de tarjeta militar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                        <input type="text" class="form-control" id="military_card_type" name="military_card_type" value="<?= esc($personalInfo['military_card_type']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="military_card_number" class="form-label">Número de tarjeta militar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                        <input type="text" class="form-control" id="military_card_number" name="military_card_number" value="<?= esc($personalInfo['military_card_number']) ?>"> 
                                    </div>
                                </div>

                                <!-- Distrito militar y Estado civil -->
                                <div class="col-md-6">
                                    <label for="military_district" class="form-label">Distrito militar</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                        <input type="text" class="form-control" id="military_district" name="military_district" value="<?= esc($personalInfo['military_district']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="marital_status" class="form-label">Estado civil</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                        <select class="form-select" id="marital_status" name="marital_status" required>
                                            <option value="Soltero" <?= (esc($personalInfo['marital_status']) == 'Soltero') ? 'selected' : ''; ?>>Soltero</option>
                                            <option value="Casado" <?= (esc($personalInfo['marital_status']) == 'Casado') ? 'selected' : ''; ?>>Casado</option>
                                            <option value="Divorciado" <?= (esc($personalInfo['marital_status']) == 'Divorciado') ? 'selected' : ''; ?>>Divorciado</option>
                                            <option value="Viudo" <?= (esc($personalInfo['marital_status']) == 'Viudo') ? 'selected' : ''; ?>>Viudo</option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Tipo de documento del cónyuge -->
                                <div class="col-md-6">
                                    <label for="spouse_document_type" class="form-label">Tipo de documento Conyuge</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="spouse_document_type" name="spouse_document_type" value="<?= esc($personalInfo['spouse_document_type']) ?>">
                                    </div>
                                </div>

                                <!-- Documento del cónyuge -->
                                <div class="col-md-6">
                                    <label for="spouse_id_number" class="form-label">Documento del conyuge</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="spouse_id_number" name="spouse_id_number" value="<?= esc($personalInfo['spouse_id_number']) ?>">
                                    </div>
                                </div>

                                <!-- Primer nombre del cónyuge -->
                                <div class="col-md-6">
                                    <label for="spouse_first_name" class="form-label">Primer nombre del cónyuge</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="spouse_first_name" name="spouse_first_name" value="<?= esc($personalInfo['spouse_first_name']) ?>">
                                    </div>
                                </div>

                                <!-- Apellido del cónyuge -->
                                <div class="col-md-6">
                                    <label for="spouse_last_name" class="form-label">Apellido del cónyuge</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <input type="text" class="form-control" id="spouse_last_name" name="spouse_last_name" value="<?= esc($personalInfo['spouse_last_name']) ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary prev-step">
                                    <i class="fas fa-arrow-left me-2"></i>Anterior
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Guardar Información
                                </button>
                            </div>
                        </div>
                        <!-- Modal de éxito -->
                        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="successModalLabel">¡Gracias, <?= $user_name ?>!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Información personal guardada exitosamente.
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Botón de cierre que redirige al menú -->
                                        <a href="<?= base_url('index.php/user/menu') ?>" class="btn btn-success">Cerrar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal de Error -->
                        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="errorModalLabel">¡Error al guardar los datos!</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $errorMessage = session()->getFlashdata('error');
                                        if (is_array($errorMessage)) {
                                            echo "<ul>";
                                            foreach ($errorMessage as $error) {
                                                echo "<li>" . esc($error) . "</li>";
                                            }
                                            echo "</ul>";
                                        } else {
                                            echo esc($errorMessage);
                                        }
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            // Mostrar el modal de error si hay un mensaje
<?php if (session()->getFlashdata('error')) : ?>
                                var myModal = new bootstrap.Modal(document.getElementById('errorModal'), {
                                    keyboard: false
                                });
                                myModal.show();
<?php endif; ?>
                        </script>




                        <!-- Scripts de Bootstrap y jQuery -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

                        <script>

                            // Mostrar modal de éxito si hay un mensaje flash de éxito
                            $(document).ready(function () {
<?php if (session()->getFlashdata('success')): ?>
                                    // Mostrar el modal de éxito cuando se carga la página
                                    $('#successModal').modal('show');
<?php endif; ?>
                            });

                        </script>


                        <script>
                            // Variables para los pasos y botones
                            const steps = document.querySelectorAll('.form-step');
                            const stepIndicators = document.querySelectorAll('.step');
                            const nextBtns = document.querySelectorAll('.next-step');
                            const prevBtns = document.querySelectorAll('.prev-step');

                            let currentStep = 0;

                            // Mostrar el paso actual
                            function showStep(stepIndex) {
                                steps.forEach((step, index) => {
                                    step.classList.toggle('active', index === stepIndex);
                                });
                                stepIndicators.forEach((indicator, index) => {
                                    indicator.classList.toggle('active', index === stepIndex);
                                });
                            }

                            // Manejo del botón "Siguiente"
                            nextBtns.forEach(button => {
                                button.addEventListener('click', () => {
                                    if (currentStep < steps.length - 1) {
                                        currentStep++;
                                        showStep(currentStep);
                                    }
                                });
                            });

                            // Manejo del botón "Anterior"
                            prevBtns.forEach(button => {
                                button.addEventListener('click', () => {
                                    if (currentStep > 0) {
                                        currentStep--;
                                        showStep(currentStep);
                                    }
                                });
                            });

                            // Inicializar el formulario mostrando el primer paso
                            showStep(currentStep);
                        </script>

                        <script>

                            // Calcular la edad basada en la fecha de nacimiento
                            $birthDateInput.on('change', function() {
                            const birthDateValue = $(this).val();
                                    if (!birthDateValue) return; // Si no hay valor, salir

                                    const birthDate = new Date(birthDateValue);
                                    if (isNaN(birthDate)) {
                            alert('Por favor, ingrese una fecha válida.');
                                    return;
                            }

                            const today = new Date();
                                    let age = today.getFullYear() - birthDate.getFullYear();
                                    const monthDiff = today.getMonth() - birthDate.getMonth();
                                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                            }

                            $ageInput.val(age);
                            });
                            }
                            );
                        </script>

                        </body>
                        </html>