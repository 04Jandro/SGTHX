<?php

// Determina la clase de alerta en función del estado del usuario
if ($user_status === "Pendiente") {
    $alert_class = "alert alert-secondary";
} elseif ($user_status === "Aceptado") {
    $alert_class = "alert alert-success";
} elseif ($user_status === "Denegado") {
    $alert_class = "alert alert-danger";
} else {
    $alert_class = "alert alert-light"; // Clase por defecto si no coincide con ninguno
}
?>

<!-- Ejemplo de uso en HTML -->
<div class="<?php echo $alert_class; ?>">
    El estado del usuario es: <?php echo htmlspecialchars($user_status); ?>
</div>
