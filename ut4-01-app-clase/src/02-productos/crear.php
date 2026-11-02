<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexion.php';

$nombre = '';
$precio = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = trim($_POST['precio'] ?? '');

    if ($nombre === '') {
        $error = 'Escribe el nombre del producto.';
    } elseif (!is_numeric($precio) || (float) $precio < 0) {
        $error = 'Escribe un precio válido igual o mayor que cero.';
    } else {
        $sql = 'INSERT INTO productos (nombre, precio) VALUES (:nombre, :precio)'; // Usamos marcadores con nombre; también podríamos usar marcadores posicionales (?).
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre, // Cada valor se asocia al marcador con el mismo nombre.
            ':precio' => $precio
        ]);

        header('Location: productos.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir producto</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Añadir producto</h1>

        <?php if ($error !== ''): ?>
            <p class="mensaje-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="crear.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" maxlength="100" value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" min="0" step="0.01" value="<?= htmlspecialchars($precio, ENT_QUOTES, 'UTF-8') ?>" required>

            <button type="submit">Guardar producto</button>
        </form>

        <p><a href="productos.php">Volver al listado</a></p>
    </main>
</body>

</html>