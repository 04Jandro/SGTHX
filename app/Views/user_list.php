<?php include 'admin_header.php'; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Usuarios</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <style>
            body {
                background-color: #f4f6f9;
            }
            .table-container {
                flex-grow: 1;
                overflow: auto;
            }
            .table {
                margin-bottom: 0;
                width: 100%;
            }
            .table td, .table th {
                vertical-align: middle;
            }
            .table-header {
                background-color: #f2f2f2;
            }
            .search-bar {
                max-width: 300px;
            }
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #004a9f;
            }
            .action-buttons {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 10px;
            }
            .action-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 8px;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .action-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.2);
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            .action-btn:hover::before {
                opacity: 1;
            }
            .action-btn i {
                font-size: 18px;
                position: relative;
                z-index: 1;
            }
            .action-btn-view {
                background-color: #007bff;
                color: white;
            }
            .action-btn-edit {
                background-color: #ffc107;
                color: white;
            }
            .action-btn-delete {
                background-color: #dc3545;
                color: white;
            }
            .estado-column {
                width: 150px;
            }

            .estado-column + td {
                width: 150px;
            }
            
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <!-- Barra de título y búsqueda -->
            <div class="d-flex justify-content-between align-items-center py-3">
                <div></div>
                <div class="d-flex align-items-center">
                    <div class="input-group search-bar">
                        <input id="search-input" type="text" class="form-control w-50" placeholder="Buscar por nombre, correo o cédula..." aria-label="Buscar">
                        <button class="btn btn-primary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla de usuarios -->
            <div class="table-container">
                <table class="table table-striped table-bordered" id="user-table">
                    <thead class="table-header">
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th class="estado-column">Estado</th>
                            <th style="width: 200px;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= base_url($user['profile_photo'] ?: 'uploads/profile_photos/placeholder.jpg') ?>" alt="Foto de perfil" class="rounded-circle me-3" width="50">
                                        <div>
                                            <div class="fw-bold"><?= strtoupper($user['name'] . ' ' . $user['last_name']) ?></div>
                                            <small class="text-muted"><?= $user['document_type'] . ' - ' . $user['cedula'] ?></small>
                                            <div class="text-muted"><?= $user['email'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center estado-column">
                                    <?php if ($user['status'] == 'Aceptado'): ?>
                                        <span class="badge bg-success">Aceptado</span>
                                    <?php elseif ($user['status'] == 'Denegado'): ?>
                                        <span class="badge bg-danger">Denegado</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Pendiente</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a  target="_blank" href="<?= site_url('pdf/consultar/' . $user['cedula'] ?? '') ?>" 
                                            class="action-btn btn btn-success text-light" 
                                            title="Hoja de vida">
                                            <i class="bi bi-file-text-fill"></i>
                                        </a>

                                        <a href="<?= base_url('index.php/admin/security/edit/' . $user['cedula']) ?>" class="action-btn action-btn-edit" title="Ver Usuario" style="background-color: #007bff; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none;">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </a>
                                        <a href="profile/<?= $user['cedula'] ?>" 
                                           class="action-btn btn btn-warning text-dark" 
                                           title="Ajuste">
                                            <i class="bi bi-gear-fill"></i>
                                        </a>

                                        <!-- En la sección de los botones de acción, cambia el delete button a: -->
                                        <a href="#" 
                                           class="action-btn action-btn-delete delete-user" 
                                           title="Eliminar" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#confirmDeleteModal"
                                           data-user-cedula="<?= $user['cedula'] ?>"
                                           data-user-name="<?= strtoupper($user['name'] . ' ' . $user['last_name']) ?>">
                                            <i class="bi bi-archive-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de Confirmación -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">
                            <strong>¿Está seguro que desea eliminar al usuario <span id="userNameToDelete"></span>?</strong>
                        </p>
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Esta acción no se puede deshacer. Se eliminará permanentemente la información del usuario.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Eliminar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.getElementById('search-input').addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#user-table tbody tr');

                rows.forEach(row => {
                    const name = row.querySelector('.fw-bold')?.textContent.toLowerCase() || '';
                    const email = row.querySelector('.text-muted:nth-child(3)')?.textContent.toLowerCase() || '';
                    const id = row.querySelector('small')?.textContent.toLowerCase() || '';

                    if (name.includes(searchTerm) || email.includes(searchTerm) || id.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Modal delete confirmation script
            document.addEventListener('DOMContentLoaded', function () {
                const deleteButtons = document.querySelectorAll('.delete-user');
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
                const userNameToDelete = document.getElementById('userNameToDelete');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const userId = this.getAttribute('data-user-id');
                        const userName = this.getAttribute('data-user-name');

                        userNameToDelete.textContent = userName;
                        confirmDeleteBtn.href = 'delete/' + userId;
                    });
                });
            });
        </script>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        const deleteButtons = document.querySelectorAll('.delete-user');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const userNameToDelete = document.getElementById('userNameToDelete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevenir el comportamiento por defecto del enlace
                const userCedula = this.getAttribute('data-user-cedula');
                const userName = this.getAttribute('data-user-name');
                
                userNameToDelete.textContent = userName;
                confirmDeleteBtn.href = 'delete/' + userCedula;
                
                confirmDeleteModal.show(); // Mostrar el modal correctamente
            });
        });
    });
</script>
    </body>
</html>