<?php
require_once __DIR__ . '/../includes/auth.php';

// auth.php inicia la sesión y comprueba que el usuario haya iniciado sesión.

// Si se abre la página sin haber añadido productos, usamos una cesta vacía.

$cesta = $_SESSION['cesta'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta - JAMM</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Carrito</h1>

        <?php if (count($cesta) > 0): ?>
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cesta as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $producto['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) $producto['precio'], ENT_QUOTES, 'UTF-8') ?> €</td>
                        </tr>
                        <?php $total += $producto['precio']; // Sumamos el precio de cada producto al total. ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p><strong>Total: <?= htmlspecialchars((string) $total, ENT_QUOTES, 'UTF-8') ?> €</strong></p>
            <form action="pagar.php" method="post">
                <button type="submit" name="pagar">Pagar</button>
            </form>
        <?php else: ?>
            <p>La cesta está vacía.</p>
        <?php endif; ?>

        <p><a href="productos.php">Volver a productos</a></p>
    </main>
</body>

</html>


