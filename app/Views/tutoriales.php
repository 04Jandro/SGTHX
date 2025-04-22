<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriales de Registro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        .tutorial-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .tutorial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #3498db, #2c3e50);
        }
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
        }
        .section-title::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 2px;
            background-color: #3498db;
            bottom: 0;
            left: 25%;
        }
        .video-nav .nav-link {
            color: #495057;
            border-radius: 0;
            border-bottom: 3px solid transparent;
            padding: 0.75rem 1rem;
        }
        .video-nav .nav-link.active {
            color: #3498db;
            border-bottom-color: #3498db;
            background-color: transparent;
        }
        .video-nav .nav-link:hover {
            border-bottom-color: #ccc;
        }
        .progress-bar {
            height: 8px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php include 'user_header.php'; ?>
    
    <!-- Banner Section -->
    <div class="bg-gradient-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold">Tutoriales de Registro</h1>
                    <p class="lead">Aprende paso a paso cómo registrarte y completar tu perfil en nuestro sistema</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-graduation-cap fa-5x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Tutorial Section -->
    <div class="container mb-5">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-4 bg-light p-4">
                                <h4 class="mb-4">Progreso del Tutorial</h4>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Progreso</span>
                                        <span>0%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                                
                                <ul class="nav flex-column video-nav" id="tutorial-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="video1-tab" data-bs-toggle="pill" href="#video1" role="tab">1. Tutorial Registro</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video2-tab" data-bs-toggle="pill" href="#video2" role="tab">2. Información Personal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video3-tab" data-bs-toggle="pill" href="#video3" role="tab">3. Información Académica</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video4-tab" data-bs-toggle="pill" href="#video4" role="tab">4. Académica e Idiomas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video5-tab" data-bs-toggle="pill" href="#video5" role="tab">5. Experiencia Laboral</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video6-tab" data-bs-toggle="pill" href="#video6" role="tab">6. Tiempo Trabajado</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video7-tab" data-bs-toggle="pill" href="#video7" role="tab">7. Otros Estudios</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video8-tab" data-bs-toggle="pill" href="#video8" role="tab">8. Portal de Documentación</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video9-tab" data-bs-toggle="pill" href="#video9" role="tab">9. Mi Información</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="video10-tab" data-bs-toggle="pill" href="#video10" role="tab">10. Formato Hoja de Vida</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <div class="tab-content p-4" id="tutorial-content">
                                    <div class="tab-pane fade show active" id="video1" role="tabpanel">
                                        <h3 class="mb-3">Tutorial de Registro</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/9W8O2ID_K7w?si=oWDl1uchfFJ8Rpcu" 
                                                title="Tutorial Registro"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">En este video inicial, aprenderás los conceptos básicos para comenzar tu registro en nuestro sistema.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary disabled">Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video2-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="video2" role="tabpanel">
                                        <h3 class="mb-3">Información Personal</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/TUQsm3sod4s" 
                                                title="2. Información Personal"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Aprende a completar correctamente toda tu información personal.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video1-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video3-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <!-- Resto de pestañas de videos -->
                                    <div class="tab-pane fade" id="video3" role="tabpanel">
                                        <h3 class="mb-3">Información Académica</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/ds0PRu9vb9Q" 
                                                title="3. Información Académica"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Este tutorial te muestra cómo ingresar tus datos académicos de manera correcta y eficiente.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video2-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video4-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="video4" role="tabpanel">
                                        <h3 class="mb-3">Información Académica e Idiomas</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/v8xWMaEMUmQ" 
                                                title="4. Información académica e idiomas"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Continúa con el registro de tu información académica y tus conocimientos de idiomas.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video3-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video5-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="video5" role="tabpanel">
                                        <h3 class="mb-3">Experiencia Laboral y Docente</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/3JGThjW5w0w" 
                                                title="5. Experiencia Laboral y Docente"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Aprende a registrar correctamente tu experiencia laboral y docente en nuestro sistema.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video4-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video6-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="video6" role="tabpanel">
                                        <h3 class="mb-3">Tiempo Trabajado</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/2-zYNEHFFaQ" 
                                                title="6. Tiempo Trabajado"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Guía detallada para registrar correctamente tus periodos de tiempo trabajado.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video5-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video7-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="video7" role="tabpanel">
                                        <h3 class="mb-3">Otros Estudios</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/PjfVB4gibjQ" 
                                                title="7. Otros Estudios"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Aprende a incluir información sobre cursos, certificaciones y otros estudios complementarios.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video6-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video8-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="video8" role="tabpanel">
                                        <h3 class="mb-3">Portal de Documentación</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/CrTPg4dxSJI" 
                                                title="8. Portal de Documentación"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Guía completa para navegar y utilizar el portal de documentación del sistema.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video7-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video9-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="video9" role="tabpanel">
                                        <h3 class="mb-3">Mi Información</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/CRGCMGME7Sw" 
                                                title="9. Mi Información"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Aprende a revisar y gestionar toda tu información en el sistema.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video8-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-primary" onclick="document.getElementById('video10-tab').click()">Siguiente <i class="fas fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="video10" role="tabpanel">
                                        <h3 class="mb-3">Formato Hoja de Vida</h3>
                                        <div class="ratio ratio-16x9 mb-4 shadow-sm rounded">
                                            <iframe src="https://www.youtube.com/embed/5mqv1-rcUII" 
                                                title="10. Formato Hoja de Vida"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                        <p class="text-muted">Tutorial sobre cómo exportar tu hoja de vida desde el sistema.</p>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary" onclick="document.getElementById('video9-tab').click()"><i class="fas fa-arrow-left me-2"></i> Anterior</button>
                                            <button class="btn btn-success">¡Completado! <i class="fas fa-check ms-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <!-- Bootstrap JS y Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para actualizar la barra de progreso cuando se cambia de video
        document.addEventListener('DOMContentLoaded', function() {
            const videoTabs = document.querySelectorAll('[data-bs-toggle="pill"]');
            const progressBar = document.querySelector('.progress-bar');
            const progressText = document.querySelector('.d-flex.justify-content-between.mb-1 span:last-child');
            
            videoTabs.forEach((tab, index) => {
                tab.addEventListener('shown.bs.tab', function() {
                    const progress = Math.round((index / (videoTabs.length - 1)) * 100);
                    progressBar.style.width = progress + '%';
                    progressText.textContent = progress + '%';
                });
            });
        });
    </script>
</body>
</html>