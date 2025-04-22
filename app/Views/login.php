<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
        <!-- Fuentes y estilos -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
        <link rel="icon" href="SGTH.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <!-- Lado izquierdo -->
            <div class="lado-izquierdo">
                <h1>Bienvenido</h1>
                <p>Sistema de Gestión del Talento Humano</p>
            </div>

            <!-- Lado derecho -->
            <div class="lado-derecho">

                <img src="<?= base_url('img/Utede.png') ?>" class="img-fluid" style="width: 30%;" />

                <!-- Mostrar mensajes de error -->
                <?php if (session()->getFlashdata('error')): ?>
                    <p class="error-message"><?= session()->getFlashdata('error') ?></p>
                <?php endif; ?>

                <form action="<?= site_url('/login/access') ?>" method="post">
        <!-- Campo de cédula o correo electrónico -->
        <div class="mb-3">
          <label for="credential" class="form-label">Cédula o Correo Electrónico</label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-person-fill"></i>
            </span>
            <input type="text" class="form-control" id="credential" name="credential" placeholder="Ingrese su cédula o correo electrónico" required>
          </div>
        </div>

        <!-- Campo de contraseña -->
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <div class="input-group">
              <span class="input-group-text">
                  <i class="fa-solid fa-lock"></i>   
              </span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
            <span class="input-group-text" id="toggle-password">
              <i class="bi bi-eye-slash"></i>
            </span>
          </div>
        </div>

        <!-- Botón para enviar -->
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
          </button>
        </div>
      </form>
                </form>

                <!-- Enlaces adicionales -->
                <!--<p><a href="<?= site_url('/') ?>">¿Olvidaste tu contraseña?</a></p>-->
                <p>¿No tienes cuenta? <a href="<?= site_url('/register') ?>">Regístrate</a></p>
            </div>

           <!-- Footer -->
            <!-- Footer -->
           <!-- Footer -->
            <!-- Footer -->
            <footer class="footer d-flex justify-content-between align-items-center">
                <p class="mb-0"><strong>© Desarrollado por la compañía eduX Futuro - SIE</strong></p>
                <!--<img src="<?= base_url('img/edux-s.png') ?>" class="img-fluid" style="width: 6%;" />-->
                <div class="social-icons"></div>
            </footer>




        </div>

<div id="roleModal" class="modal" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-content">
        <span class="close" aria-label="Cerrar">&times;</span> <!-- Botón para cerrar -->
        <h3 id="modalTitle"><i class="fas fa-user-shield"></i> Selecciona tu rol</h3>
        <div class="modal-buttons">
            <button id="adminBtn" aria-label="Ingresar como Administrador">
                <i class="fas fa-user-cog"></i> Administrador
            </button>
            <button id="userBtn" aria-label="Ingresar como Usuario">
                <i class="fas fa-user"></i> Usuario
            </button>
        </div>
    </div>
</div>


        <!-- Incluir el script -->

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Mostrar el modal si el rol es "Administrador"
                const userRole = '<?= session()->get('role') ?>'; // Asumimos que el rol está en la sesión

                if (userRole === 'Administrador') {
                    const modal = document.getElementById('roleModal');
                    const modalContent = modal.querySelector('.modal-content');

                    modal.classList.add('active'); // Mostrar el modal
                    modalContent.classList.add('show'); // Añadir la animación al modal

                    // Redirigir como Administrador
                    document.getElementById('adminBtn').addEventListener('click', function () {
                        window.location.href = "<?= site_url('admin/menu') ?>"; // Redirigir a Administrador
                    });

                    // Redirigir como Usuario
                    document.getElementById('userBtn').addEventListener('click', function () {
                        window.location.href = "<?= site_url('user/menu') ?>"; // Redirigir a Usuario
                    });

                    // Cerrar el modal si se hace clic fuera del contenido
                    window.addEventListener('click', function (event) {
                        if (event.target === modal) {
                            modal.classList.remove('active'); // Ocultar el modal
                            modalContent.classList.remove('show');
                        }
                    });

                    // Cerrar el modal con la X
                    document.querySelector('.close').addEventListener('click', function () {
                        modal.classList.remove('active');
                        modalContent.classList.remove('show');
                    });
                }
            });

        </script>



        <script>
            // Selecciona el campo de contraseña y el ícono de toggle
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('toggle-password');

            // Agrega un evento de clic al ícono de toggle
            togglePassword.addEventListener('click', function () {
                // Cambia entre 'password' y 'text'
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
            });
        </script>

    </body>
</html>
