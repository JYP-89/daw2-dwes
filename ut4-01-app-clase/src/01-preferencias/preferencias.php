<?php
session_start();
require_once __DIR__ . '/../includes/auth.php';

$mensaje = '';

if (isset($_POST['guardar'])) {
    $idioma = $_POST['idioma'] ?? '';
    $perfilPublico = $_POST['perfil_publico'] ?? '';
    $zonaHoraria = $_POST['zona_horaria'] ?? '';

    $idiomasValidos = ['español', 'inglés'];
    $perfilesValidos = ['sí', 'no'];
    $zonasValidas = ['GMT-2', 'GMT-1', 'GMT', 'GMT+1', 'GMT+2'];

    if (
        in_array($idioma, $idiomasValidos, true) &&
        in_array($perfilPublico, $perfilesValidos, true) &&
        in_array($zonaHoraria, $zonasValidas, true)
    ) {
        $_SESSION['preferencias'] = [
            'idioma' => $idioma,
            'perfil_publico' => $perfilPublico,
            'zona_horaria' => $zonaHoraria
        ];
        $mensaje = 'Información guardada en la sesión.';
    } else {
        $mensaje = 'Selecciona una opción válida en cada apartado.';
    }
}

$preferencias = $_SESSION['preferencias'] ?? [
    'idioma' => 'español',
    'perfil_publico' => 'sí',
    'zona_horaria' => 'GMT'
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecer preferencias</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Preferencias del usuario</h1>

        <?php if ($mensaje !== ''): ?>
            <p class="mensaje" role="status"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="preferencias.php" method="post">
            <label for="idioma">Idioma</label>
            <select id="idioma" name="idioma">
                <option value="español" <?= $preferencias['idioma'] === 'español' ? 'selected' : '' ?>>Español</option>
                <option value="inglés" <?= $preferencias['idioma'] === 'inglés' ? 'selected' : '' ?>>Inglés</option>
            </select>

            <label for="perfil_publico">Perfil público</label>
            <select id="perfil_publico" name="perfil_publico">
                <option value="sí" <?= $preferencias['perfil_publico'] === 'sí' ? 'selected' : '' ?>>Sí</option>
                <option value="no" <?= $preferencias['perfil_publico'] === 'no' ? 'selected' : '' ?>>No</option>
            </select>

            <label for="zona_horaria">Zona horaria</label>
            <select id="zona_horaria" name="zona_horaria">
                <option value="GMT-2" <?= $preferencias['zona_horaria'] === 'GMT-2' ? 'selected' : '' ?>>GMT-2</option>
                <option value="GMT-1" <?= $preferencias['zona_horaria'] === 'GMT-1' ? 'selected' : '' ?>>GMT-1</option>
                <option value="GMT" <?= $preferencias['zona_horaria'] === 'GMT' ? 'selected' : '' ?>>GMT</option>
                <option value="GMT+1" <?= $preferencias['zona_horaria'] === 'GMT+1' ? 'selected' : '' ?>>GMT+1</option>
                <option value="GMT+2" <?= $preferencias['zona_horaria'] === 'GMT+2' ? 'selected' : '' ?>>GMT+2</option>
            </select>

            <button type="submit" name="guardar">Establecer preferencias</button>
        </form>

        <p><a href="mostrar.php">Mostrar preferencias</a></p>
        <p><a href="../index.php">Volver al inicio</a></p>

    </main>
</body>

</html>