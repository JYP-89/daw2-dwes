<?php
require_once __DIR__ . '/../includes/auth.php';

// Contador de la sesión, se va al cerrarla
if (isset($_SESSION['visitas_sesion'])) {
    $_SESSION['visitas_sesion']++;
} else {
    $_SESSION['visitas_sesion'] = 1;
}

// Contador de la cookie
if (isset($_COOKIE['visitas_cookie'])) {
    $visitasCookie = (int) $_COOKIE['visitas_cookie'] + 1;
} else {
    $visitasCookie = 1;
}

// La cookie permanece un año
setcookie(
    'visitas_cookie',
    $visitasCookie,
    time() + (365 * 24 * 60 * 60),
    '/'
);

// esa es la diferencia

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sesión Vs cookie - JAMM</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <main class="contenedor">
        <h1>Sesión y cookies</h1>

        <p>Visitas durante esta sesión: <?= $_SESSION['visitas_sesion'] ?></p>

        <p>Visitas guardadas en la cookie: <?= $visitasCookie ?></p>

        <p><a href="contador.php">Actualizar los contadores</a></p>
        <!-- Al volver a cargar esta página, ambos contadores aumentan. -->
        <p><a href="../index.php">Volver al inicio</a></p>
    </main>
</body>
</html>