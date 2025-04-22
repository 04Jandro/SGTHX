<?php include 'admin_header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda - Sistema de Información Académica</title>
    <!-- Enlace a la hoja de estilos de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a FontAwesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .main-header {
            color: #004085;
        }

        .sub-header {
            color: #0062cc;
        }

        .card-body {
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 25px;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .contact-info p {
            font-size: 1.2rem;
        }

        .contact-info ul {
            list-style-type: none;
            padding-left: 0;
        }

        .contact-info ul li {
            margin-bottom: 10px;
        }

        .contact-info ul li i {
            margin-right: 10px;
            color: #0062cc;
        }

        .btn-custom {
            background-color: #0062cc;
            color: white;
            border-radius: 25px;
            padding: 8px 20px;
        }

        .btn-custom:hover {
            background-color: #004085;
            color: white;
        }

        .map-container {
            margin-top: 30px;
        }

        /* Mejora para la tabla de contenido */
        .table-of-content {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .table-of-content ul {
            list-style-type: none;
            padding-left: 0;
        }

        .table-of-content ul li {
            margin-bottom: 15px;
        }

        .table-of-content a {
            color: #0062cc;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .table-of-content a:hover {
            color: #004085;
            text-decoration: underline;
        }

        .table-of-content .fa {
            margin-right: 10px;
            color: #0062cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="main-header mb-4">Página de Ayuda - Sistema de Información Académica</h1>

        <!-- Tabla de contenido -->
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="table-of-content">
                    <h2 class="sub-header">Contenido</h2>
                    <ul>
                        <li><a href="#intro"><i class="fas fa-info-circle"></i> Introducción</a></li>
                        <li><a href="#features"><i class="fas fa-cogs"></i> Características del Sistema</a></li>
                        <li><a href="#instructions"><i class="fas fa-users-cog"></i> Instrucciones de Uso</a></li>
                        <li><a href="#contact"><i class="fas fa-phone-alt"></i> Información de Contacto</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <!-- Sección de Introducción -->
                <div id="intro" class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Introducción <i class="fas fa-info-circle"></i></h3>
                        <p>Bienvenido a la página de ayuda de Administrador del Sistema de Gestión del Talento Humano. Este sistema te permite gestionar, visualizar y actualizar tu información académica de forma eficiente. A continuación, te ofrecemos detalles sobre cómo usar el sistema y sus funcionalidades.</p>
                    </div>
                </div>

                <!-- Sección de Características -->
                <div id="features" class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Características del Sistema <i class="fas fa-cogs"></i></h3>
                        <ul>
                            <li>Gestión de información de los usuarios.</li>
                            <li>Visualización, edición, eliminación y aprobación de usuarios.</li>
                            <li>Configuración de seguridad, roles y cambio de características de usuario.</li>
                            <li>Interfaz amigable y fácil de usar.</li>
                        </ul>
                    </div>
                </div>

                <!-- Sección de Instrucciones de Uso -->
                <div id="instructions" class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Instrucciones de Uso <i class="fas fa-users-cog"></i></h3>
                        <p>Te explicamos a continuación cómo usar el sistema:</p>
                        <ul>
                            <li><strong>Inicio:</strong> Vista principal donde se muestra la visualización del total de usuarios registrados y de los usuarios nuevos de cada mes. Además, tendrá acceso al apartado de gestión de usuarios.</li>
                            <li><strong>Gestión de Usuarios:</strong> Puede visualizar el listado de .</li>
                            <li><strong>Actualizar información:</strong> Si necesitas modificar un registro, puedes hacerlo desde la opción de "Editar".</li>
                            <li><strong>Eliminar registros:</strong> Si deseas eliminar un registro, selecciona "Eliminar" y confirma la acción.</li>
                        </ul>
                    </div>
                </div>

                <!-- Sección de Información de Contacto -->
                <div id="contact" class="card mb-4 contact-info">
                    <div class="card-body">
                        <h3 class="card-title">Información de Contacto <i class="fas fa-phone-alt"></i></h3>
                        <p>Si necesitas asistencia adicional o tienes alguna pregunta, no dudes en contactarnos:</p>
                        <ul>
                            <li><i class="fas fa-envelope"></i> Email: <a href="mailto:soporte@sistemacademico.com">soporte@sistemacademico.com</a></li>
                            <li><i class="fas fa-phone"></i> Teléfono: +57 (602) 3896023</li>
                            <li><i class="fas fa-map-marker-alt"></i> Dirección: Carrera 12 # 26 C 74, Buga – Valle del Cauca.</li>
                        </ul>
                        <a href="mailto:soporte@sistemacademico.com" class="btn btn-custom">Enviar un Correo</a>
                    </div>
                </div>

                <!-- Sección de Mapa Estático -->
                <div class="map-container">
                    <h3 class="sub-header">Ubicación de Contacto <i class="fas fa-map-marker-alt"></i></h3>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d512.1426174986885!2d-76.29388401195247!3d3.9159149463289826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sco!4v1732892494409!5m2!1ses!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

    </div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
