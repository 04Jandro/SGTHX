<?php include 'admin_header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
    background-color: #f4f7f6;
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
}

.dashboard-container {
    padding: 30px 15px;
}

.dashboard-header {
    background: linear-gradient(135deg, #2c3e50 95%, #D93D04 50%);
    color: white;
    padding: 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.dashboard-header h1 {
    font-weight: 700;
    margin-bottom: 10px;
}

.dashboard-stats {
    display: flex;
    flex-wrap: wrap; /* Permite que las tarjetas se ajusten */
    gap: 20px; /* Espacio uniforme entre tarjetas */
    justify-content: center; /* Alinea al centro */
    margin-bottom: 30px;
}

.stat-card {
    background-color: white;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    flex-basis: calc(33.333% - 20px); /* Cada tarjeta ocupa un tercio con espacio */
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
}

.stat-card h3 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 1.8rem;
}

.stat-card p {
    color: #6c757d;
    font-size: 0.9rem;
}

.professional-card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.professional-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.12);
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

.professional-btn {
    border-radius: 50px;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.professional-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Responsividad */
@media (max-width: 768px) {
    .stat-card {
        flex-basis: calc(50% - 20px); /* Ocupa la mitad en tablets */
    }
}

@media (max-width: 480px) {
    .stat-card {
        flex-basis: 100%; /* Ocupa todo el ancho en móviles */
    }
}

</style>

<div class="container-dashboard">
    <div class="dashboard-header">
        <h1>SGTH - Sistema de Gestión de Talento Humano</h1>
        <p>Panel de Administración Integral</p>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3><?= $user_count ?></h3>
            <p>Total de Usuarios</p>
        </div>
        <div class="stat-card">
            <h3><?= $new_users_this_month ?></h3>
            <p>Usuarios Nuevos este Mes</p>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card professional-card">
                <div class="card-body">
                    <div>
                        <i class="bi bi-people-fill professional-card-icon text-primary"></i>
                        <h5 class="card-title">Gestión de Usuarios</h5>
                        <p class="card-text">Administra y controla el acceso de usuarios al sistema. Visualiza, edita y gestiona perfiles de usuario con total seguridad y eficiencia.</p>
                    </div>
                    <a href="<?= base_url('index.php/admin/security/users') ?>" class="btn btn-primary professional-btn mt-3">
                        Gestión de Usuarios <i class="bi bi-arrow-right"></i>
                    </a>
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
        window.onload = function () {
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        };
    </script>
<?php endif; ?>

</body>
</html>