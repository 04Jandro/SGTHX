<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema de Talento Humano</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Incluir Font Awesome (puedes agregarlo en tu archivo <head>) -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

        <style>
            body {
                background-color: #f4f7f9;
                font-family: 'Arial', sans-serif;
            }

            #sidebar {
                background: linear-gradient(135deg, #2c3e50, #34495e);
                color: white;
                height: 100vh;
                position: fixed;
                left: 0;
                top: 0;
                width: 270px;
                box-shadow: 10px 0 20px rgba(0,0,0,0.1);
                transition: all 0.3s;
                z-index: 1000;
            }

            .sidebar-logo {
                background-color: rgba(255,255,255,0.1);
                padding: 15px;
                text-align: center;
            }

            .sidebar-menu .nav-link {
                color: #ecf0f1;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                padding: 12px 20px;
            }

            .sidebar-menu .nav-link:hover {
                background-color: rgba(255,255,255,0.1);
                color: #3498db;
            }

            .sidebar-menu .nav-link i {
                margin-right: 10px;
                font-size: 1.2em;
            }

            #main-content {
                margin-left: 270px;
                padding: 20px;
                transition: margin-left 0.3s;
            }

            .navbar {
                background-color: #ffffff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .container-dashboard {
                max-width: 1200px;
                margin: 20px auto;
            }

            @media (max-width: 768px) {
                #sidebar {
                    width: 0;
                    overflow: hidden;
                }
                #main-content {
                    margin-left: 0;
                }
            }
            .sidebar-logo {
                position: relative; /* Necesario para posicionar el gradiente */
            }

            .sidebar-logo h4 {
                display: inline-block; /* Asegura que el h4 no ocupe toda la línea */
                position: relative;
            }

            .sidebar-logo h4::after {
                content: '';
                position: absolute;
                bottom: 0; /* Ajusta para que quede justo debajo del texto */
                left: 0;
                width: 100%;
                height: 3px; /* Ajusta el grosor de la línea */
                background: linear-gradient(to right, #F27405, transparent);
            }
            li {
                list-style-type: none; /* Elimina el marcador de lista (punto) */
            }

            .separator {
                border-top: 1px solid #ccc; /* Línea separadora */
                opacity: 0.3; /* Transparencia */
            }
            .btn-logout {
                background-color: transparent;
                border: 1px solid transparent;
                color: #ffffff; /* Color inicial del texto */
                font-size: 1.1rem;
                transition: background-color 0.3s ease, color 0.3s ease; /* Transición suave */
                list-style-type: none; /* Elimina el punto */
                padding: 15px 0; /* Ajusta el tamaño vertical del botón */
            }

            .btn-logout:hover {
                background-color: #dc3545; /* Fondo rojo al hacer hover */
                color: #ffffff; /* Texto blanco */
                border: none; /* Elimina el borde al hacer hover */
            }


            /* Estilo para el fondo del popup */
            #inactivityPopup {
                display: none; /* Oculto por defecto */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
                justify-content: center;
                align-items: center;
                z-index: 9999; /* Asegura que el popup esté sobre otros elementos */
            }

            /* Estilo para el contenido del popup */
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
        </style>
    </head>
    <body>
        <!-- Sidebar Fijo -->
        <div id="sidebar" class="d-flex flex-column h-100">
            <div class="sidebar-logo text-center py-3">
                <img src="<?= base_url('img/Utede.png') ?>" class="img-fluid" style="width: 80%;" />
            </div>
            <nav class="sidebar-menu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('index.php/admin/menu') ?>">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('index.php/admin/security/users') ?>">
                            <i class="bi bi-person-fill"></i> Gestión de Usuarios
                        </a>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('index.php/admin/contracts') ?>">
                            <i class="bi bi-file-fill"></i> Contratos
                        </a>
                    </li>
                    -->
                    <!--
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('index.php/admin/security') ?>">
                            <i class="bi bi-shield-lock-fill"></i> Seguridad y Roles
                        </a>
                    </li>
                    -->
                                        <li class="nav-item">
                        <a class="nav-link" href="#">
                                <i class="bi bi-file-earmark-bar-graph"></i> Generador de reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('index.php/admin/help') ?>">
                            <i class="bi bi-question-circle"></i> Ayuda
                        </a>
                    </li>

                </ul>
            </nav>

            <!-- Botón de cerrar sesión (al final) -->
            <div class="mt-auto text-center p-3">
                <button class="btn-logout w-100" onclick="location.href = '<?= base_url('index.php/admin/menu/logout') ?>'">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </div>  

            </>

        </div>
        <!-- Contenido Principal -->
        <div id="main-content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <div class="d-flex align-items-center">
                        <h2 class="mb-0 text-secondary me-3">
                            <?php
// Obtener el tercer segmento de la URL (por defecto)
                            $currentRoute = service('uri')->getSegment(3);

// Verificar si la ruta actual es 'help'
                            if (service('uri')->getSegment(2) === 'help') {
                                $currentRoute = 'help'; // Cambiar manualmente a 'help' para que coincida
                            }

// Cambiar el texto según la ruta
                            switch ($currentRoute) {
                                case 'users':
                                    echo 'Gestión de usuarios';
                                    break;
                                case 'edit':
                                    echo 'Edición de información usuario';
                                    break;
                                case 'profile':
                                    echo 'Edición perfil usuario';
                                    break;
                                case 'help':
                                    echo 'Ayuda';
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
                                        <img src="<?= base_url($profilePhoto); ?>" alt="Foto de Perfil" class="rounded-circle me-2" width="50" height="50">
                                    </div>
                                <?php else: ?>
                                    <div style="margin-right: 10px;">Añade tu foto en perfil</div>
                                <?php endif; ?>
                                <span class="text-secondary"><?= esc($user_name) ?></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?= base_url('index.php/admin/security/profile/' . esc($user_cedula)); ?>">Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('index.php/admin/menu/logout') ?>">Cerrar Sesión</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('index.php/user/menu/') ?>">Cambiar a usuario</a></li>
                            </ul>

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
                        clearTimeout(inactivityTimer);  // Limpiar el temporizador anterior
                        inactivityTimer = setTimeout(showInactivityPopup, INACTIVITY_LIMIT);  // Establecer nuevo temporizador
                    }

                    // Detectar actividad del usuario
                    window.onload = resetInactivityTimer;
                    window.onmousemove = resetInactivityTimer;
                    window.onkeydown = resetInactivityTimer;
                    window.onclick = resetInactivityTimer;
                </script>

            </nav>