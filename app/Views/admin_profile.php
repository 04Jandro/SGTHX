<?php include('admin_header.php'); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil</title>

        <!-- Bootstrap 5 CSS -->
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
            .form-control[readonly] {
                background-color: #e9ecef;
                opacity: 1;
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
                        <i class="bi bi-person-circle me-2"></i>Perfil
                    </h2>

                    <form id="profileUpdate" action="<?= base_url('index.php/admin/security/profile/update/' . $user_cedula) ?>" method="post" enctype="multipart/form-data">

                        <div class="row g-3">
                            <!-- Tipo de Documento -->
                            <div class="col-md-6">
                                <label for="document_type" class="form-label">Tipo de Documento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <select id="document_type" name="document_type" class="form-select form-control" required>
                                        <option value="" disabled selected>Selecciona tipo de documento</option>
                                        <option value="Cédula de Ciudadanía" <?= isset($user['document_type']) && $user['document_type'] == 'Cédula de Ciudadanía' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                                        <option value="Pasaporte" <?= isset($user['document_type']) && $user['document_type'] == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                        <option value="Cédula de Extranjería" <?= isset($user['document_type']) && $user['document_type'] == 'Cédula de Extranjería' ? 'selected' : '' ?>>Cédula de Extranjería</option>
                                        <option value="Tarjeta de Identidad" <?= isset($user['document_type']) && $user['document_type'] == 'Tarjeta de Identidad' ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                                        <option value="Cédula de Ciudadanía" <?= isset($user['document_type']) && $user['document_type'] == 'Cédula de Ciudadanía' ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                                        <option value="Pasaporte" <?= isset($user['document_type']) && $user['document_type'] == 'Pasaporte' ? 'selected' : '' ?>>Pasaporte</option>
                                        <option value="Permiso Especial de Permanencia" <?= isset($user['document_type']) && $user['document_type'] == 'Permiso Especial de Permanencia' ? 'selected' : '' ?>>Permiso Especial de Permanencia</option>
                                        <option value="Registro Civil" <?= isset($user['document_type']) && $user['document_type'] == 'Registro Civil' ? 'selected' : '' ?>>Registro Civil</option>
                                        <option value="Documento Nacional de Identidad" <?= isset($user['document_type']) && $user['document_type'] == 'Documento Nacional de Identidad' ? 'selected' : '' ?>>DNI</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Número de Documento (Cédula) -->
                            <div class="col-md-6">
                                <label for="cedula" class="form-label">Número de Documento</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" id="cedula" name="cedula" class="form-control" value="<?= esc($user['cedula']) ?>" required placeholder="Número de documento" readonly>
                                </div>
                            </div>

                            <!-- Nombres -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nombres</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" id="name" name="name" class="form-control" value="<?= esc($user['name']) ?>" required placeholder="Nombres completos">
                                </div>
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Apellidos</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" id="last_name" name="last_name" class="form-control" value="<?= esc($user['last_name']) ?>" required placeholder="Apellidos completos">
                                </div>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" id="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required placeholder="correo@ejemplo.com">
                                </div>
                            </div>

                            <!-- Número de Teléfono -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Número de Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="<?= esc($user['phone']) ?>" required placeholder="Número de teléfono">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">Estado</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-check-circle"></i></span> <!-- Icono para estado -->
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="Pendiente" <?= esc($user['status']) == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                        <option value="Aceptado" <?= esc($user['status']) == 'Aceptado' ? 'selected' : '' ?>>Aceptado</option>
                                        <option value="Denegado" <?= esc($user['status']) == 'Denegado' ? 'selected' : '' ?>>Denegado</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="col-md-6">
                                <label for="role" class="form-label">Rol</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span> <!-- Icono para rol -->
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="Usuario" <?= esc($user['role']) == 'Usuario' ? 'selected' : '' ?>>Usuario</option>
                                        <option value="Administrador" <?= esc($user['role']) == 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                                    </select>
                                </div>
                            </div>



                            <!-- Contraseña -->
                            <div class="col-md-6">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña">
                                </div>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirmar contraseña">
                                </div>
                            </div>

                            <!-- Foto de Perfil -->
                            <div class="col-md-12">
                                <label for="profile_photo" class="form-label">Foto de Perfil</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-camera"></i></span>
                                    <input type="file" id="profile_photo" name="profile_photo" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-2"></i>Guardar
                            </button>
                        </div>
                    </form>

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
                                    <p>Tu perfil se ha guardado correctamente.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        // Manejar el envío del formulario para mostrar el modal de éxito
                        document.getElementById('profileUpdate').addEventListener('submit', function (e) {
                            e.preventDefault(); // Prevenir el envío normal del formulario

                            // Realizar la solicitud al servidor
                            fetch('<?= base_url('index.php/admin/security/profile/update/' . $user_cedula) ?>', {
                                method: 'POST',
                                body: new FormData(this)
                            })
                                    .then(response => {
                                        if (response.ok) {
                                            // Mostrar el modal de éxito
                                            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                            successModal.show();

                                            // Configurar la recarga de la página al cerrar el modal
                                            const modalElement = document.getElementById('successModal');
                                            modalElement.addEventListener('hidden.bs.modal', function () {
                                                location.reload(true); // Recargar la página y limpiar caché
                                            });
                                        } else {
                                            // Manejar el error (mostrar la respuesta completa en la consola)
                                            response.text().then(text => console.log(text)); // Ver el cuerpo de la respuesta
                                            alert('Hubo un error al guardar la información');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Hubo un error al guardar la información');
                                    });
                        });
                    </script>


                    <!-- Scripts de Bootstrap y jQuery -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>



                    <script>
                        // Password match validation
                        document.addEventListener('DOMContentLoaded', function () {
                            const password = document.getElementById('password');
                            const confirmPassword = document.getElementById('confirm_password');

                            function validatePassword() {
                                if (password.value != confirmPassword.value) {
                                    confirmPassword.setCustomValidity("Las contraseñas no coinciden");
                                } else {
                                    confirmPassword.setCustomValidity('');
                                }
                            }

                            password.addEventListener('change', validatePassword);
                            confirmPassword.addEventListener('keyup', validatePassword);
                        });
                    </script>
                </div>
            </div>
        </div>
    </body>
</html>
