<?php
session_start();
require_once __DIR__ . '/../includes/auth.php';

$mensaje = '';

if (isset($_POST['borrar'])) {
    unset($_SESSION['preferencias']);
    $mensaje = 'Información de la sesión borrada.';
}

$preferencias = $_SESSION['preferencias'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar preferencias</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Preferencias guardadas</h1>

        <?php if ($mensaje !== ''): ?>
            <p class="mensaje" role="status"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <?php if ($preferencias !== null): ?>
            <dl>
                <dt>Idioma</dt>
                <dd><?= htmlspecialchars($preferencias['idioma'], ENT_QUOTES, 'UTF-8') ?></dd>
                <dt>Perfil público</dt>
                <dd><?= htmlspecialchars($preferencias['perfil_publico'], ENT_QUOTES, 'UTF-8') ?></dd>
                <dt>Zona horaria</dt>
                <dd><?= htmlspecialchars($preferencias['zona_horaria'], ENT_QUOTES, 'UTF-8') ?></dd>
            </dl>

            <form action="mostrar.php" method="post">
                <button type="submit" name="borrar">Borrar preferencias</button>
            </form>
        <?php else: ?>
            <p>No hay preferencias guardadas en la sesión.</p>
        <?php endif; ?>

        <p><a href="preferencias.php">Establecer preferencias</a></p>
        <p><a href="../index.php">Volver al inicio</a></p>

    </main>
</body>

</html>