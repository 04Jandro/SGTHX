<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página con Footer</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1; /* Permite que el contenido principal ocupe el espacio disponible */
            padding: 20px;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center; /* Centra los elementos horizontalmente */
            gap: 20px; /* Espaciado entre elementos */
        }

        footer li {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>



<footer>
    <ul>
        <li>Colombia</li>
        <li>Buga</li>
    </ul>
</footer>

</body>
</html>

