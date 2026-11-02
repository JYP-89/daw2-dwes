<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexion.php';

 // Añadir el producto seleccionado a la cesta.


if (isset($_POST['agregar'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

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

    if (!isset($_SESSION['cesta'])) {
        $_SESSION['cesta'] = [];
    }

    $_SESSION['cesta'][$producto['id']] = $producto;

    header('Location: productos.php');
    exit;
}


$sql = 'SELECT id, nombre, precio FROM productos ORDER BY id';
$resultado = $pdo->query($sql);
$productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de productos-JAMM</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Productos</h1>
        <p><a href="crear.php">Añadir nuevo producto</a></p>
        <p>Usamos la base de datos `dwes_T4 (productos)`.</p>
        <p><a href="cesta.php">Ver cesta</a></p>

        <?php if (count($productos) > 0): ?>
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $producto['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) $producto['precio'], ENT_QUOTES, 'UTF-8') ?> €</td>
                            <td>
                                <form action="editar.php" method="get" class="formulario-inline">
                                    <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">
                                    <button type="submit">Editar</button>
                                </form>
                                <form action="borrar.php" method="post" class="formulario-inline">
                                    <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">
                                    <button type="submit">Borrar</button>
                                </form>
                                <form action="productos.php" method="post" class="formulario-inline">
                                    <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">
                                    <button type="submit" name="agregar">Añadir a la cesta</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos en la tabla.</p>
        <?php endif; ?>

        <p><a href="../index.php">Volver al inicio</a></p>
    </main>
</body>

</html>
