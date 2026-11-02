<?php
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $id_categoria = $_POST['id_categoria'];

    $sql = "INSERT INTO productos (nombre, precio, id_categoria) VALUES (?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $precio, $id_categoria]);

    header('Location: index.php');
    exit();
}


$sql = "SELECT * FROM categorias";
$stmt = $pdo->query($sql);
$categorias = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREACION DE ITEM</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <h1>CREAR</h1>
    <form method="post">
        <label for="">NOMBRE</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="">PRECIO</label>
        <input type="text" id="precio" name="precio" required>

        <label for="id_categoria">CATEGORIA</label>
        <select name="id_categoria" id="id_categoria" required>
            <option value="">SELECT CAT</option>
            <?php foreach ($categorias as $laCategoria): ?>
                <option value="<?= htmlspecialchars($laCategoria['id']) ?>">
                    <?= htmlspecialchars($laCategoria['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">GUARDAR CAMBIOS</button>
    </form>
    <a href="index.php">BACK</a>
</body>

</html>