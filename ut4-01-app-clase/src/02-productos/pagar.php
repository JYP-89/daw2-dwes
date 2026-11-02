<?php
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['pagar'])) {
    header('Location: cesta.php');
    exit;
}

// La compra es simulada: solo eliminamos la cesta de la sesión.

unset($_SESSION['cesta']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra - JAMM</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Compra finalizada</h1>
        <p>La cesta se ha vaciado.</p>
        <p><a href="productos.php">Volver a productos</a></p>
    </main>
</body>

</html>
