<?php include('admin_header.php'); ?>
<div class="container mt-4">
    <h1 class="mb-4">Panel de Seguridad</h1>
    <p>Desde este panel podrás gestionar usuarios, roles, permisos y otras configuraciones relacionadas con la seguridad.</p>

    <div class="row">
        <!-- Card para la administración de usuarios -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="bi bi-person"></i> Administración de Usuarios</h5>
                </div>
                <div class="card-body">
                    <p>Gestiona todos los usuarios del sistema, asigna roles y edita sus permisos.</p>
                    <a href="<?= site_url('/admin/security/users') ?>" class="btn btn-primary">Ver Usuarios</a>
                </div>
            </div>
        </div>

        <!-- Card para la administración de roles y permisos -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="bi bi-shield-lock"></i> Roles y Permisos</h5>
                </div>
                <div class="card-body">
                    <p>Configura los roles y los permisos asociados a cada usuario dentro del sistema.</p>
                    <a href="<?= site_url('/admin/security/roles') ?>" class="btn btn-primary">Gestionar Roles</a>
                </div>
            </div>
        </div>

        <!-- Card para la auditoría del sistema -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="bi bi-search"></i> Auditoría</h5>
                </div>
                <div class="card-body">
                    <p>Consulta los registros de auditoría para monitorear las actividades realizadas en el sistema.</p>
                    <a href="<?= site_url('/admin/security/audits') ?>" class="btn btn-primary">Ver Auditoría</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Card para la configuración de seguridad -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="bi bi-gear"></i> Configuración de Seguridad</h5>
                </div>
                <div class="card-body">
                    <p>Configura ajustes importantes relacionados con la seguridad y el acceso al sistema.</p>
                    <a href="<?= site_url('/admin/security/settings') ?>" class="btn btn-primary">Ajustes de Seguridad</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
