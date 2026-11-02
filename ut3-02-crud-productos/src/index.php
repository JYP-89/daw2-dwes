<?php
/*
MySQL
  ↓
PDO
  ↓
$stmt
  ↓
fetchAll()
  ↓
$productos
  ↓
foreach
  ↓
$elProducto
  ↓
HTML */

// 1 Carga aquí el contenido de bd.php

include 'bd.php';

//***aqui entra el pdo de bd.php, separamos responsabilidades

//Obtener productor con categorías
//la query a $sql
$sql = "SELECT productos.id, productos.nombre AS PRODUCTO, productos.precio, categorias.nombre AS CATEGORIA
FROM productos
LEFT JOIN categorias ON productos.id_categoria = categorias.id"; // Dame los productos y, cuando encuentres una categoría cuyo id coincida con productos.id_categoria, dame también su nombre.

//guarda el resultado en stmt
$stmt = $pdo->query($sql);
//y jecuta la query/consulta SQL utilizando esta conexión ($pdo)
$productos = $stmt->fetchAll();
//ahora $productos recogerá ALL filas

/*
Tmbién se puede usar 
$stmt = $pdo->prepare(...);
$stmt->execute(...);para evitar inyecciones sql
La diferencia importante es que prepare() 
es especialmente necesario cuando introduces datos proporcionados
por el usuario

----

$productos = [
    [
        'id' => 1,
        'ID_PRODUCTO' => 'Mesa',
        'precio' => 120,
        'CATEGORIA_PRECIO' => 'Muebles'
    ],
    [
        'id' => 2,
        'ID_PRODUCTO' => 'Portátil',
        'precio' => 800,
        'CATEGORIA_PRECIO' => 'Portatiles'
    ]
];*/
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index JAMM</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <h1>Lista Productos JAMM</h1>
    <a href="crear.php"> AÑADIR </a>
    <table border="1">

        <tr>
            <th>ID</th>
            <th>PRODUCTO</th>
            <th>PRECIO</th>
            <th>CATEGORIA</th>
            <th>Acciones</th>
        </tr>
        <!-- ahora usamos una auxiliar elProducto para imprimir los valores en la tabla html -->
        <?php foreach ($productos as $elProducto): ?>
            <tr>
                <td><?= htmlspecialchars($elProducto['id']) ?> </td>
                <td><?= htmlspecialchars($elProducto['PRODUCTO']) ?> </td>
                <td><?= htmlspecialchars($elProducto['precio']) ?> </td>
                <!-- ?? Si existe y tiene valor, utiliza lo de la izquierda; si no, utiliza lo de la derecha -->
                <td><?= htmlspecialchars($elProducto['CATEGORIA'] ?? 'Sin categoría') ?></td>
                <!-- una en blanco ¿?-->
                <td>
                    <a href="editar.php?id=<?= $elProducto['id'] ?>">Editar</a>
                    <a href="eliminar.php?id=<?= $elProducto['id'] ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>