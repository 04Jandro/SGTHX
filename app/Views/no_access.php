<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado</title>
</head>
<body>
    <h1>Página de Acceso Restringido</h1>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Crear modal y estilos
            const styles = `
                .modal-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    display: none;
                    justify-content: center;
                    align-items: center;
                    z-index: 1000;
                }
                .modal-content {
                    background: white;
                    padding: 30px;
                    border-radius: 10px;
                    text-align: center;
                    max-width: 400px;
                    width: 90%;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                }
                .modal-title {
                    color: #f44336; /* Rojo para error */
                    margin-bottom: 20px;
                }
                .continue-btn {
                    background-color: #f44336;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                }
                .continue-btn:hover {
                    background-color: #e53935;
                }
            `;

            // Crear elemento de estilo
            const styleSheet = document.createElement('style');
            styleSheet.textContent = styles;
            document.head.appendChild(styleSheet);

            // Crear modal
            const modalOverlay = document.createElement('div');
            modalOverlay.className = 'modal-overlay';
            
            const modalContent = document.createElement('div');
            modalContent.className = 'modal-content';
            modalContent.innerHTML = `
                <h2 class="modal-title">¡No tienes los permisos necesarios!</h2>
                <p>No tienes acceso a esta página.</p>
                <button class="continue-btn">Volver al Menú</button>
            `;
            
            modalOverlay.appendChild(modalContent);
            document.body.appendChild(modalOverlay);

            // Botón de continuar en el modal
            const continueBtn = modalContent.querySelector('.continue-btn');
            continueBtn.addEventListener('click', () => {
                // Redirige al menú después de que el usuario haga clic
                window.location.href = 'menu';  // Cambia esta ruta según sea necesario
            });

            // Mostrar modal al cargar la página si el usuario no tiene permisos
            modalOverlay.style.display = 'flex';
        });
    </script>
</body>
</html>
