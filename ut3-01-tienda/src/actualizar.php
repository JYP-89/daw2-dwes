<?php
require_once 'includes/conexion.php';

//aquí oasa lo mismo que en editar.
//hay qu declarar y dar valor por defecto
//también hay que controlar aquí si se introducen datos "erroneos
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['accion'] == 'actualizar') {
        //Actualización con try
        //y ojo, hayq ue usar getEMssage (si queremos ver cual es).
        // Y, ¿qué pasa con el "WHERE ?"?
        /*
        Por qué el WHERE necesita el quinto valor. execute() asigna los valores a los ? por orden: 
        el primero a nombre_corto, el segundo a nombre, el tercero a descripcion, 
        el cuarto a PVP y el quinto, $_POST['cod'], al ? del WHERE. 
        El cod llega desde el input hidden de editar.php. 
        Sin ese campo oculto, actualizar.php no sabría qué producto modificar.
        */
        try {
            $stmt = $pdo->prepare("UPDATE producto SET nombre_corto = ?, nombre = ?, descripcion = ?, PVP = ? WHERE cod = ?");
            $stmt->execute([$_POST['nombre_corto'], $_POST['nombre'], $_POST['descripcion'], $_POST['PVP'], $_POST['cod']]);
            $mensaje = "Se han actualizado los datos";
        } catch (PDOException $excepcion) {
            $mensaje = "error en actualización: " . $excepcion->getMessage();
        }
        //else queda fuera
    } else {
        $mensaje = "Actualización cancelada.";
        //ojo 
        /*
        Los dos botones (en editar.php) tienen name="accion", pero el navegador solo envía el value del botón que se pulsa. 
        Por eso $_POST['accion'] vale tanto para 'actualizar' o 'cancelar'.
        */
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <h1>Actualizador de productos</h1>
    <p><?= $mensaje ?></p>
    <form action="listado.php" method="get">
        <button type="submit">Continuar</button>
    </form>
</body>

</html>
