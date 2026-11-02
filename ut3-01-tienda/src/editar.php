<?php
//conexión BBDD 
require_once 'includes/conexion.php';

//obtener los datos producto pero antes hay que declarar por defecto a null la variab product.
/* Si alguien entra en editar.php directamente, sin pasar por el listado, no hay $_POST['cod'],
el if no se ejecuta y $producto no existiría. 
Entonces <?php if ($producto): ?> daría un aviso de "variable no definida". 
    Si lo declaramos así, muestra "Producto no encontrado".*/
$producto = null;
if (isset($_POST['cod'])) {
    try {
        $codigoProducto = $_POST['cod'];
        $stmt = $pdo->prepare('SELECT * FROM producto WHERE cod = ?');
        $stmt->bindParam(1, $codigoProducto);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $excepcion) {
        echo "<p>Error consultando: " . $excepcion->getMessage() . "</p>";
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarea: edición de producto</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <h1>Edicion</h1>
    <?php if ($producto): ?>
        <form action="actualizar.php" method="post">
            <input type="hidden" name="cod" value="<?= $producto['cod'] ?>">

            <label for="nombre_corto">Nombre corto</label>
            <input required type="text" id="nombre_corto" name="nombre_corto" value="<?= htmlspecialchars($producto['nombre_corto']) ?>">

            <label for="nombre">Nombre</label>
            <input required type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>">

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" required><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>

            <label for="PVP">PVP</label>
            <input required type="text" id="PVP" name="PVP" value="<?= htmlspecialchars($producto['PVP']) ?>">

            <button type="submit" name="accion" value="actualizar">Actualizar</button>
            <!-- formnovalidate porque usan required 
    ?? '': el operador de fusión de null. Si $producto['nombre'] es null, usa ''. 
    Desde PHP 8.1, pasar null a htmlspecialchars() está obsoleto y genera un aviso. 
    Isabel usa XAMPP, que tenía otra versión de PHP segutamente.
formnovalidate: le dice al navegador que no compruebe los required cuando se pulsa ese botón.
 Sin él, en un producto sin nombre no se podría cancelar. 
    -->
            <button type="submit" name="accion" value="cancelar" formnovalidate>Cancelar</button>
        </form>
    <?php else: ?>
        <p>No se encuentra el prod.</p>
    <?php endif; ?>
</body>

</html>
