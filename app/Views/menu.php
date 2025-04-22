<?php include 'user_header.php'; ?>
<?php include 'status_bar.php'; ?>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Contenido del Dashboard -->
<style>
    .professional-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .professional-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 15px 45px rgba(0,0,0,0.12);
    }

    .professional-card .card-body {
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .professional-card-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .professional-card:hover .professional-card-icon {
        transform: scale(1.1);
        opacity: 1;
    }

    .professional-card .card-title {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 1.3rem;
    }

    .professional-card .card-text {
        color: #6c757d;
        margin-bottom: 20px;
    }

    .professional-btn {
        border-radius: 50px;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .professional-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .professional-btn i {
        margin-left: 10px;
        transition: transform 0.2s ease;
    }

    .professional-btn:hover i {
        transform: translateX(5px);
    }

</style>
<div class="container-dashboard">
    <aside class="alert alert-info border-0 shadow-sm rounded-3 p-3" role="alert">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle-fill text-info" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.163l.207-.09.207.09c.2.092.492.162.686.162.275 0 .375-.193.304-.533l-1-4.705c-.047-.229-.305-.396-.584-.396-.279 0-.537.167-.584.396z"/>
                </svg>
            </div>
            <div>
                <h5 class="alert-heading mb-2 fw-bold">Nota Importante:</h5>
                <p class="mb-0">En esta sección, completa la información requerida en los cuatro apartados. Una vez finalizado, accede al apartado <strong>Mi Información</strong> y haz clic en él botón para generar y cargar automáticamente el formato de hoja de vida con los datos ingresados.</p>
            </div>
        </div>
    </aside>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card professional-card">
                <div class="card-body">
                    <div>
                        <i class="bi bi-person-fill professional-card-icon text-primary"></i>
                        <h5 class="card-title">Información Personal</h5>
                        <p class="card-text">Gestiona y actualiza tus datos personales con total seguridad y confidencialidad.</p>
                    </div>
                    <a href="../user/personal-info" class="btn btn-primary professional-btn mt-3">
                        Completar Perfil <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card professional-card">
                <div class="card-body">
                    <div>
                        <i class="bi bi-book-fill professional-card-icon text-success"></i>
                        <h5 class="card-title">Información Académica</h5>
                        <p class="card-text">Registra y mantén actualizada tu trayectoria educativa, títulos y certificaciones.</p>
                    </div>
                    <a href="../user/academic-info" class="btn btn-success professional-btn mt-3">
                        Actualizar Estudios <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card professional-card">
                <div class="card-body">
                    <div>
                        <i class="bi bi-briefcase-fill professional-card-icon text-warning"></i>
                        <h5 class="card-title">Experiencia Profesional</h5>
                        <p class="card-text">Documenta tu historial laboral, roles desempeñados y logros profesionales más relevantes.</p>
                    </div>
                    <a href="../user/experience-info" class="btn btn-warning text-white professional-btn mt-3">
                        Registrar Experiencia <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card professional-card">
                <div class="card-body">
                    <div>
                        <i class="bi bi-file-earmark-text professional-card-icon text-info"></i>
                        <h5 class="card-title">Otros Estudios</h5>
                        <p class="card-text">Añade cursos complementarios, diplomados, especializaciones y formación adicional.</p>
                    </div>
                    <a href="../user/additional-study-info" class="btn btn-info text-white professional-btn mt-3">
                        Gestionar Estudios <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php if (session()->getFlashdata('error')): ?>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">¡Oops! Algo salió mal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?= session()->getFlashdata('error') ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar el modal si hay un mensaje de error
        window.onload = function () {
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        };
    </script>
<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>