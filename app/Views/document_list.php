<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Documentos</title>
        <!-- Bootstrap 5 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome para mejores iconos -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <style>
            .table-hover tbody tr:hover {
                background-color: rgba(0,0,0,.075);
                transition: background-color 0.2s ease-in-out;
            }
            .document-actions {
                min-width: 100px;
            }
        </style>
    </head>
    <body class="bg-light">
        <?php include 'user_header.php'; ?>

        <div class="container py-5">
            <div class="row mb-4">
                <div class="col">
                    <h1 class="h2 mb-0">
                        <i class="fas fa-folder-open text-primary me-2"></i>
                        Documentos de <?= $user_name ?> <?= $user_last_name ?>
                    </h1>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4">Cédula</th>
                                    <th>Tipo de Documento</th>
                                    <th>Archivo</th>
                                    <th>Fecha de Subida</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($documents as $doc): ?>
                                    <tr>
                                        <td class="px-4"><?= $doc['cedula'] ?></td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <?= $doc['document_type'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($doc['file_path'])): ?>
                                                <a href="<?= base_url($doc['file_path']) ?>" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   target="_blank">
                                                    <i class="fas fa-file-alt me-1"></i>
                                                    Ver Archivo
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                    No disponible
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <i class="far fa-calendar-alt me-1 text-muted"></i>
                                            <?= date('d/m/Y H:i', strtotime($doc['created_at'])) ?>
                                        </td>
                                        <td class="document-actions text-center">
                                            <!-- Eliminar siempre por ID -->
                                            <a href="<?= base_url('index.php/user/document/delete/' . $doc['id']) ?>" 
                                               class="btn btn-outline-danger btn-sm"
                                               onclick="return confirm('¿Está seguro que desea eliminar este documento?')">
                                                <i class="fas fa-trash-alt me-1"></i>
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts de Bootstrap 5 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
