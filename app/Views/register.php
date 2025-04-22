<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de Usuario</title>
        <link rel="stylesheet" href="<?= base_url('css/register2.css') ?>">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="left-side">
                <i class="fas fa-user-plus"></i>
                <h1>Registro de Usuario</h1>
            </div>
            <div class="right-side">
                <img src="<?= base_url('img/Utede.png') ?>" class="img-fluid" style="width: 40%;" />
                <form action="<?= site_url('/register/save') ?>" method="post" id="registerForm">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="document_type">Tipo de Documento:</label>
                        <select id="document_type" name="document_type" required>
                            <option value="" disabled selected>Seleccione su tipo de documento</option>
                            <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                            <option value="Cédula de Extranjería">Cédula de Extranjería</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="Mínimo 2 caracteres" minlength="2" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Apellido:</label>
                        <input type="text" id="last_name" name="last_name" value="<?= old('last_name') ?>" placeholder="Mínimo 2 caracteres" minlength="2" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" value="<?= old('email') ?>" placeholder="Correo válido" required>
                    </div>
                    <div class="form-group">
                        <label for="cedula">Número de Documento:</label>
                        <input type="text" id="cedula" name="cedula" value="<?= old('cedula') ?>" placeholder="Mínimo 5 caracteres" minlength="5" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Número de Teléfono:</label>
                        <input type="text" id="phone" name="phone" value="<?= old('phone') ?>" placeholder="Mínimo 10 dígitos" minlength="10" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" value="<?= old('password') ?>" placeholder="Mínimo 6 caracteres" minlength="6" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña:</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Coincidir con la contraseña" minlength="6" required>
                    </div>
                    <button type="submit">Registrar</button>
                    <div class="login-link">
                        <b>¿Ya tienes cuenta?</b><a href="<?= site_url('/') ?>"> Inicia sesión</a>
                    </div>

                </form>
            </div>
        </div>



        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">
                            <i class="bi bi-check-circle-fill me-2"></i><?php
                            // Verifica si 'name' está presente en el array $_POST
                            if (isset($_POST['name'])) {
                                echo 'Gracias ' . htmlspecialchars($_POST['name'] . '!', ENT_QUOTES, 'UTF-8');
                            } else {
                                // Si 'name' no está presente en el formulario, puedes mostrar un mensaje por defecto o un valor alternativo
                                echo 'Gracias!';
                            }
                            ?>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="fs-4">
                            <i class="bi bi-clipboard-check text-success me-2" style="font-size: 3rem;"></i>
                        </p>
                        <h4>Información Guardada</h4>
                        <p>Te has registrado exitosamente.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>
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

    </script>

    <!-- SCRIPT PARA VER LA CONTRASEÑA -->
    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        // Icono para la contraseña
        const passwordIcon = document.createElement('i');
        passwordIcon.className = "fas fa-eye";
        passwordInput.parentNode.appendChild(passwordIcon);

        passwordIcon.addEventListener('click', function () {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.className = "fas fa-eye-slash"; // Cambiar icono
            } else {
                passwordInput.type = "password";
                passwordIcon.className = "fas fa-eye"; // Cambiar icono
            }
        });

        // Icono para confirmar contraseña
        const confirmPasswordIcon = document.createElement('i');
        confirmPasswordIcon.className = "fas fa-eye";
        confirmPasswordInput.parentNode.appendChild(confirmPasswordIcon);

        confirmPasswordIcon.addEventListener('click', function () {
            if (confirmPasswordInput.type === "password") {
                confirmPasswordInput.type = "text";
                confirmPasswordIcon.className = "fas fa-eye-slash"; // Cambiar icono
            } else {
                confirmPasswordInput.type = "password";
                confirmPasswordIcon.className = "fas fa-eye"; // Cambiar icono
            }
        });
    </script>
    <script>

        document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Array para almacenar los errores
            const errors = [];

            // Validar tipo de documento
            const documentType = document.getElementById('document_type');
            if (!documentType.value) {
                errors.push("Debes seleccionar un tipo de documento");
            }

            // Validar nombre
            const name = document.getElementById('name');
            if (name.value.length < 2) {
                errors.push("El nombre debe tener al menos 2 caracteres");
            } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(name.value)) {
                errors.push("El nombre solo puede contener letras");
            }

            // Validar apellido
            const lastName = document.getElementById('last_name');
            if (lastName.value.length < 2) {
                errors.push("El apellido debe tener al menos 2 caracteres");
            } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(lastName.value)) {
                errors.push("El apellido solo puede contener letras");
            }


            // Validar email
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                errors.push("El correo electrónico no es válido");
            }

// Validar número de documento
            const cedula = document.getElementById('cedula');
            if (cedula.value.length < 5) {
                errors.push("El número de documento debe tener al menos 5 caracteres");
            } else if (!/^\d+$/.test(cedula.value)) {
                errors.push("El número de documento solo puede contener números");
            }

// Validar teléfono
            const phone = document.getElementById('phone');
            if (phone.value.length < 10) {
                errors.push("El número de teléfono debe tener al menos 10 dígitos");
            } else if (!/^\d+$/.test(phone.value)) {
                errors.push("El número de teléfono solo puede contener números");
            }


            // Validar contraseña
            const password = document.getElementById('password');
            if (password.value.length < 6) {
                errors.push("La contraseña debe tener al menos 6 caracteres");
            }

            // Validar confirmación de contraseña
            const confirmPassword = document.getElementById('confirm_password');
            if (password.value !== confirmPassword.value) {
                errors.push("Las contraseñas no coinciden");
            }

            // Si hay errores, mostrar el modal con la lista de errores
            if (errors.length > 0) {
                const errorList = document.getElementById('errorList');
                errorList.innerHTML = errors.map(error => `<p class="mb-2">• ${error}</p>`).join('');
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
                return;
            }

            // Si no hay errores, proceder con el envío
            fetch('<?= base_url('index.php/register/save') ?>', {
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
                            const errorList = document.getElementById('errorList');
                            errorList.innerHTML = '<p class="mb-2">• Hubo un error al procesar tu solicitud. Por favor, intenta nuevamente.</p>';
                            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                            errorModal.show();

                            response.text().then(text => console.log(text));
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
</body>
</html>
