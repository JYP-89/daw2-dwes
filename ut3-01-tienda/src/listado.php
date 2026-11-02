    <?php
    require_once 'includes/conexion.php';

    /* La página se envía a sí misma (action="listado.php"). 
La primera vez llega por GET, sin $_POST['familia'], y solo muestra el desplegable. 
Al pulsar el botón llega por POST con la familia elegida,
 y entonces el if (isset(...)) hace la segunda consulta.
selected sirve para que, después de enviar, el desplegable siga mostrando la familia que elegí.
Sin él volvería a la primera de la lista.
Un formulario por producto. 
Cada botón "Editar" es un form> distinto con su cod en un input hidden. 
Así editar.php recibe por POST el código del producto pulsado. 
Es la opción que sugiere el enunciado 
("una opción es crear un formulario distinto por cada producto"). 
*/
    ?>

    <?php

    //Familias

    $familias = $pdo->query("SELECT * FROM familia")->fetchAll(PDO::FETCH_ASSOC);

    $productos = [];
    if (isset($_POST['familia'])) {
        $familiaSeleccionada = $_POST['familia'];
        $stmt = $pdo->prepare("SELECT * FROM producto WHERE familia = ?");
        $stmt->execute([$familiaSeleccionada]);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>


    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tarea: Listado de productos de una familia</title>
        <link rel="stylesheet" href="css/styles.css">

    </head>

    <body>
        <h1>Tarea: Listado de productos de una familia</h1>
        <form action="listado.php" method="post">
            <label for="familia">Elige familia:</label>
            <select name="familia" id="familia">
                <?php foreach ($familias as $unaFamilia): ?>
                    <option value="<?= $unaFamilia['cod'] ?>" <?= (isset($familiaSeleccionada) && $familiaSeleccionada == $unaFamilia['cod']) ? 'selected' : '' ?>><?= $unaFamilia['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Mostrar productos</button>
        </form>

        <?php if (!empty($productos)): ?>
            <h2>Productos de una familia</h2>

            <ul>
                <?php foreach ($productos as $unProducto): ?>
                    <li>
                        <?= htmlspecialchars($unProducto['nombre_corto']) ?> - <?= htmlspecialchars($unProducto['PVP']) ?> €
                        <form method="post" action="editar.php" style="display:inline;">
                            <input type="hidden" name="cod" value="<?= $unProducto['cod'] ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </body>

    </html>