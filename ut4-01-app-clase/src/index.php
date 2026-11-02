<?php
// Página de inicio y navegación de la aplicación.
require_once __DIR__ . '/includes/auth.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi aplicación plantilla - JAMM</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Mi aplicación de clase</h1>

        <p>
            Bienvenido,
            <?= htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8') ?>.
        </p>

        <p>
            Proyecto 'plantilla' para intentar reunir, por pasos,
            los contenidos de Desarrollo Web en Entorno Servidor.
        </p>

        <h2>Tarea 4: preferencias con sesión</h2>
        <p><a href="01-preferencias/preferencias.php">Establecer preferencias</a></p>
        <p><a href="01-preferencias/mostrar.php">Mostrar preferencias</a></p>
        <p><a href="logout.php">Cerrar sesión</a></p>

        <h3>Ampliación: productos desde la base de datos</h3>
        <p><a href="02-productos/productos.php">Ver productos</a></p>
        <p><a href="02-productos/cesta.php">Ver la cesta</a></p>

        <h3>Ampliación: registro usuarios</h3>
        <p><a href="03-registro-usuarios/register.php">Registrar usuario</a></p>
        <p><a href="03-registro-usuarios/usuarios.php">Ver y borrar usuarios</a></p>

        <h3>Ampliación: cookies del navegador</h3>
        <p><a href="04-cookies/contador.php">Comparar sesión y cookie</a></p>

    </main>
</body>

</html>