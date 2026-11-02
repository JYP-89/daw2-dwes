<?php

include 'bd.php';
//conexión con base de datos


//Obtener el producto para editar

$id = $_GET['id'];  //get-> PARA RECOGER LA INFORMACION DE LA URL

//Creo la consulta del sql
$sqlProductos = "SELECT * FROM productos WHERE id = ?";  // ? es como un hueco para consultas preparadas de pdo

//Preparo la consulta
$stmt = $pdo->prepare($sqlProductos);   // $pdo= conexion con mysql       $stmt = consulta preparada y lista para ejecutarse
//Ejecuto la consulta pasandole el id
$stmt->execute([$id]);
//Obtengo el producto encontrado
$producto = $stmt->fetch();  // fetch significa dame una fila del resultado


//Obtener todas las categorias
$sqlCategorias = "SELECT * FROM categorias";
$stmt = $pdo->query($sqlCategorias);
$categorias = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $id_categoria = $_POST['id_categoria'];

    //Actualizar producto
    $sql = "UPDATE productos SET nombre = ?, precio = ?, id_categoria = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $precio, $id_categoria, $id]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<h1>Edición</h1>
<form method="post" action="">
    <label for="nombre">NOMBRE</label>
    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

    <label for="precio">PRECIO</label>
    <input type="text" id="precio" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required>

    <label for="id_categoria">CATEGORIA</label>
    <select name="id_categoria" id="id_categoria" required>
        <?php foreach ($categorias as $laCategoria): ?>
            <option value="<?= htmlspecialchars($laCategoria['id']) ?>"
                <?= $laCategoria['id'] == $producto['id_categoria'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($laCategoria['nombre']) ?>
                
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">GUARDAR CAMBIOS</button>
</form>

<body>

</body>

</html>