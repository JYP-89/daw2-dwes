<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    exit('El identificador del producto no es válido.');
}

$sql = 'SELECT id, nombre, precio FROM productos WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    exit('No se ha encontrado el producto.');
}

$nombre = $producto['nombre'];
$precio = $producto['precio'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $precio = trim($_POST['precio'] ?? '');

    if ($nombre === '') {
        $error = 'Escribe el nombre del producto.';
    } elseif ($precio === '' || !is_numeric($precio) || (float) $precio < 0) {
        $error = 'Escribe un precio válido igual o mayor que cero.';
    } else {
        $sql = 'UPDATE productos SET nombre = :nombre, precio = :precio WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':id' => $id
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
    <title>Editar producto</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Editar producto</h1>

        <?php if ($error !== ''): ?>
            <p class="mensaje-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="editar.php?id=<?= (int) $id ?>" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" maxlength="100" value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" min="0" step="0.01" value="<?= htmlspecialchars($precio, ENT_QUOTES, 'UTF-8') ?>" required>

            <button type="submit">Guardar cambios</button>
        </form>

        <p><a href="productos.php">Volver al listado</a></p>
    </main>
</body>

</html>