<?php include('user_header.php'); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Archivo No Encontrado</title>
    <!-- Enlace a Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .error-container {
            margin-top: 10%;
        }

        .alert {
            border-radius: 10px;
            padding: 30px;
        }

        .btn-regresar {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-regresar:hover {
            background-color: #0056b3;
        }

        .btn-regresar:focus {
            outline: none;
        }

        .btn-close-tab {
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-close-tab:hover {
            background-color: #c82333;
        }

        .btn-close-tab:focus {
            outline: none;
        }
    </style>
</head>

<body>
    <div class="container error-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger text-center">
                    <h4 class="alert-heading">¡Error!</h4>
                    <p><?= session()->getFlashdata('error'); ?></p>
                    <hr>
                    <p>Por favor, verifica la información y vuelve a intentarlo.</p>
                </div>
                <div class="d-flex justify-content-between">
                    <!-- El botón ahora se llama "Regresar" y cierra la pestaña -->
                    <button class="btn-regresar" onclick="window.close();">Regresar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
