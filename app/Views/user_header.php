<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema de Talento Humano</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap 5 JS (no necesita jQuery ni Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery (opcional) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Popper.js (necesario solo si usas Bootstrap sin el bundle) -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <!-- Font Awesome (CDN) -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <!-- Bootstrap Icons (CDN) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">







        <style>
            /* Estilo General */
            body {
                background-color: #f4f7f9;
                font-family: 'Arial', sans-serif;
            }

            /* Sidebar */
            #sidebar {
                background: linear-gradient(135deg, #2c3e50, #34495e);
                color: white;
                height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                width: 270px;
                box-shadow: 10px 0 20px rgba(0,0,0,0.1);
                transition: all 0.3s ease-in-out;
                z-index: 1000;
            }

            #sidebar.hidden {
                transform: translateX(-100%);
            }

            .sidebar-logo {
                background-color: rgba(255,255,255,0.1);
                padding: 15px;
                text-align: center;
            }

            .sidebar-logo h4 {
                display: inline-block;
                position: relative;
            }

            .sidebar-logo h4::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: linear-gradient(to right, #F27405, transparent);
            }

            /* Sidebar Menu */
            .sidebar-menu .nav-link {
                color: #ecf0f1;
                display: flex;
                align-items: center;
                padding: 12px 20px;
                transition: all 0.3s ease;
                text-decoration: none;
            }

            .sidebar-menu .nav-link:hover {
                background-color: rgba(255,255,255,0.1);
                color: #3498db;
            }

            .sidebar-menu .nav-link i {
                margin-right: 10px;
                font-size: 1.2em;
            }

            /* Botón Cerrar Sesión */
            .btn-logout {
                background-color: transparent;
                border: 1px solid transparent;
                color: #ffffff;
                font-size: 1.1rem;
                padding: 15px 0;
                width: 100%;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .btn-logout:hover {
                background-color: #dc3545;
                color: #ffffff;
            }

            /* Contenido Principal */
            #main-content {
                margin-left: 270px;
                padding: 20px;
                transition: all 0.3s ease-in-out;
            }

            #main-content.full-width {
                margin-left: 0;
            }

            /* Navbar */
            .navbar {
                background-color: #ffffff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            /* Separadores y Listas */
            li {
                list-style-type: none;
            }

            .separator {
                border-top: 1px solid #ccc;
                opacity: 0.3;
            }

            /* Animación Chevron */
            .nav-link .bi-chevron-down {
                transition: transform 0.3s ease;
            }

            .nav-link.collapsed .bi-chevron-down {
                transform: rotate(0deg);
            }

            .nav-link:not(.collapsed) .bi-chevron-down {
                transform: rotate(180deg);
            }

            /* Popup de Inactividad */
            #inactivityPopup {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                justify-content: center;
                align-items: center;
                z-index: 9999;
            }

            .popupContent {
                background-color: white;
                padding: 30px;
                border-radius: 8px;
                text-align: center;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                width: 300px;
            }

            .popupContent h3 {
                margin: 0;
                font-size: 20px;
            }

            .popupContent p {
                font-size: 16px;
            }

            .button {
                padding: 10px 20px;
                margin-top: 20px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }

            .button:hover {
                background-color: #218838;
            }

            .logoutButton {
                background-color: #dc3545;
            }

            .logoutButton:hover {
                background-color: #c82333;
            }

            /* Responsive */
            @media (max-width: 768px) {
                #sidebar {
                    width: 250px;
                    position: fixed;
                    left: -250px;  /* Oculto por defecto */
                    transform: translateX(-100%);
                    transition: all 0.3s ease-in-out;
                    z-index: 1000;
                }

                #sidebar.active {
                    left: 0;
                    transform: translateX(0);  /* Muestra el menú */
                }

                #main-content {
                    margin-left: 0;  /* El contenido se ajusta automáticamente */
                }

                /* Botón de menú */
                .menu-button {
                    display: none;
                    position: fixed;
                    top: 30px;
                    left: 20px;
                    background: none;
                    border: none;
                    cursor: pointer;
                    z-index: 1100;
                    transition: transform 0.3s ease-in-out;
                }

                .menu-icon {
                    width: 30px;
                    height: 3px;
                    background: #3498db;
                    display: block;
                    position: relative;
                    transition: all 0.3s ease-in-out;
                }

                .menu-icon::before,
                .menu-icon::after {
                    content: "";
                    width: 30px;
                    height: 3px;
                    background: #3498db;
                    position: absolute;
                    left: 0;
                    transition: all 0.3s ease-in-out;
                }

                .menu-icon::before {
                    top: -8px;
                }

                .menu-icon::after {
                    top: 8px;
                }

                /* Estado activo */
                .menu-button.active {
                    transform: rotate(90deg);
                }

                .menu-button.active .menu-icon {
                    background: transparent;
                }

                .menu-button.active .menu-icon::before {
                    transform: rotate(45deg);
                    top: 0;
                }

                .menu-button.active .menu-icon::after {
                    transform: rotate(-45deg);
                    top: 0;
                }

                /* Mostrar el botón en pantallas pequeñas */
                @media (max-width: 768px) {
                    .menu-button {
                        display: block;
                    }

                    #sidebar {
                        width: 250px;
                        position: fixed;
                        left: -250px;
                        transition: all 0.3s ease-in-out;
                        z-index: 1000;
                    }

                    #sidebar.active {
                        left: 0;
                    }

                    #main-content {
                        margin-left: 0;
                    }
                }

            </style>
        </head>
        <body>


            <!-- Botón Hamburguesa (Móvil) -->
            <button id="menuToggle" class="menu-button">
                <span class="menu-icon"></span>
            </button>

            <!-- Sidebar -->
            <div id="sidebar" class="d-flex flex-column">
                <div class="sidebar-logo text-center py-3">
                    <img src="<?= base_url('img/Utede.png') ?>" class="img-fluid" style="width: 80%;" />
                </div>

                <nav class="sidebar-menu">
                    <ul class="nav flex-column">
                        <li><a class="nav-link" href="<?= base_url('index.php/user/menu') ?>"><i class="bi bi-house-door"></i> Inicio</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/personal-info') ?>"><i class="bi bi-person-fill"></i> Información Personal</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/academic-info') ?>"><i class="bi bi-book-fill"></i> Información Académica</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/basic-info') ?>"><i class="bi bi-question-circle"></i> Académica e Idiomas</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/experience-info') ?>"><i class="bi bi-briefcase-fill"></i> Experiencia Laboral</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/extra-job-info') ?>"><i class="bi bi-briefcase-fill"></i> Tiempo Trabajado</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/additional-study-info') ?>"><i class="bi bi-file-earmark-text"></i> Otros Estudios</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/documents') ?>"><i class="bi bi-file-earmark-pdf"></i>Portal de documentación</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/my-information') ?>"><i class="bi bi-person-badge"></i> Mi Información</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/tutoriales') ?>"><i class="bi bi-play-btn"></i> Tutoriales</a></li>
                        <li><a class="nav-link" href="<?= base_url('index.php/user/help') ?>"><i class="bi bi-question-circle"></i> Ayuda</a></li>
                    </ul>
                </nav>

                <div class="mt-auto text-center p-3">
                    <button class="btn-logout" onclick="location.href = '<?= base_url('index.php/user/menu/logout') ?>'">
                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                    </button>

                </div>
            </div>


            <!-- Contenido Principal -->
            <div id="main-content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0 text-secondary me-3">
                                <?php
                                // Obtener la ruta actual completa
                                $currentRoute = service('uri')->getSegment(2);  // Obtener el segundo segmento de la URL (como 'personal-info')
                                // Cambiar el texto según la ruta
                                switch ($currentRoute) {
                                    case 'personal-info':
                                        echo 'Formulario de información personal';
                                        break;
                                    case 'academic-info':
                                        echo 'Formulario de información académica';
                                        break;
                                    case 'experience-info':
                                        echo 'Formulario de experiencia laboral';
                                        break;
                                    case 'additional-study-info':
                                        echo 'Formulario de otros estudios';
                                        break;
                                    case 'basic-info':
                                        echo 'Formulario de información acádemica e idiomas';
                                        break;
                                    case 'extra-job-info':
                                        echo 'Formulario de información experiencia laboral';
                                        break;
                                    case 'my-information':
                                        echo 'Mi información y hoja de vida';
                                        break;
                                    case 'documents':
                                        echo 'Portal de documentación';
                                        break;
                                    case 'help':
                                        echo 'Ayuda';
                                        break;
                                    case 'profile':
                                        echo 'Perfil';
                                        break;
                                    default:
                                        echo 'Inicio';
                                }
                                ?>
                            </h2>
                        </div>
                        <div class="ms-auto d-flex align-items-center">
                            <div class="dropdown me-3">

                                <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
                                    <li><a class="dropdown-item" href="#">Nuevos contratos</a></li>
                                    <li><a class="dropdown-item" href="#">Revisión de nómina</a></li>
                                </ul>
                            </div>
                            <div class="dropdown" style="margin-right: 30px">
                                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php if ($profilePhoto): ?>
                                        <div style="margin-right: 10px;">
                                            <img src="<?= base_url($profilePhoto) ?: 'uploads/profile_photos/placeholder.jpg' ?>" alt="Foto de perfil" class="rounded-circle me-3" width="50">

                                        </div>
                                    <?php else: ?>
                                        <div style="margin-right: 10px;">Añade tu foto en perfil</div>
                                    <?php endif; ?>
                                    <span class="text-secondary"><?= esc($user_name) ?></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="<?= base_url('index.php/user/profile') ?>">Perfil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('index.php/user/menu/logout') ?>">Cerrar Sesión</a></li>

                                    <?php
// Obtenemos la cédula del usuario desde la sesión
                                    $cedula = session()->get('cedula');

// Verificamos si la cédula existe
                                    if ($cedula) {
                                        // Creamos una instancia del modelo UserModel
                                        $userModel = new \App\Models\UserModel();

                                        // Obtenemos el usuario desde la base de datos
                                        $user = $userModel->find($cedula);

                                        // Verificamos si el usuario tiene el rol de Administrador
                                        if ($user && $user['role'] === 'Administrador'):
                                            ?>
                                            <li><a class="dropdown-item" href="<?= base_url('index.php/admin/menu') ?>">Menú administrador</a></li>
                                            <?php
                                        endif;
                                    }
                                    ?>

                                </ul>
                            </div>



                            <!-- Popup de inactividad (oculto por defecto) -->
                            <div id="inactivityPopup" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="inactivityPopupLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="inactivityPopupLabel">¡Tu sesión está a punto de expirar!</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="closeInactivityPopup()">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Haz clic en "Seguir activo" para continuar usando la página, o en "Cerrar sesión" para salir.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeInactivityPopup()">Seguir activo</button>
                                            <button type="button" class="btn btn-danger" onclick="window.location.href = '<?= base_url('index.php/user/menu/logout') ?>'">Cerrar sesión</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Popup de inactividad (oculto por defecto) -->
                            <div id="inactivityPopup" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="inactivityPopupLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="inactivityPopupLabel">¡Tu sesión está a punto de expirar!</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="closeInactivityPopup()">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Haz clic en "Seguir activo" para continuar usando la página, o en "Cerrar sesión" para salir.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeInactivityPopup()">Seguir activo</button>


                                        </div>
                                    </div>
                                </div>
                            </div>



                            <script>
                                // Tiempo de inactividad en milisegundos (20 minutos = 1200000 ms)
                                const INACTIVITY_LIMIT = 1200000; // 20 minutos
                                let inactivityTimer;
                                // Función para recargar la página o redirigir
                                function reloadPage() {
                                    alert('Tu sesión ha expirado debido a la inactividad.');
                                    window.location.reload(); // Recarga la página
                                }

                                // Función para mostrar el popup de inactividad
                                function showInactivityPopup() {
                                    // Mostrar el popup de inactividad
                                    const popup = document.getElementById('inactivityPopup');
                                    popup.style.display = 'block'; // Mostrar el popup
                                }

                                // Función para cerrar el popup
                                function closeInactivityPopup() {
                                    const popup = document.getElementById('inactivityPopup');
                                    popup.style.display = 'none'; // Cerrar el popup
                                    resetInactivityTimer(); // Resetear el temporizador de inactividad
                                }

                                // Función para resetear el temporizador de inactividad
                                function resetInactivityTimer() {
                                    clearTimeout(inactivityTimer); // Limpiar el temporizador anterior
                                    inactivityTimer = setTimeout(showInactivityPopup, INACTIVITY_LIMIT); // Establecer nuevo temporizador
                                }

                                // Detectar actividad del usuario
                                window.onload = resetInactivityTimer;
                                window.onmousemove = resetInactivityTimer;
                                window.onkeydown = resetInactivityTimer;
                                window.onclick = resetInactivityTimer;
                            </script>

                            </nav>

                            <script>
                                document.getElementById("menuToggle").addEventListener("click", function () {
                                    const sidebar = document.getElementById("sidebar");
                                    this.classList.toggle("active");
                                    sidebar.classList.toggle("active");
                                });
                            </script>

