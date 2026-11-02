<?php
require_once __DIR__ . '/../includes/conexion.php';

$usuario = '';
$error = '';
$mensaje = '';

if (isset($_GET['registro']) && $_GET['registro'] === 'ok') {
    $mensaje = 'Registro correcto.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usuario === '') {
        $error = 'Escribe un nombre de usuario.';
    } elseif ($password === '') {
        $error = 'Escribe una contraseña para él.';
    } else {
        $sql = 'SELECT id FROM usuarios WHERE usuario = :usuario';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $usuarioExistente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioExistente) {
            $error = 'Ese nombre de usuario ya está registrado.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $sql = 'INSERT INTO usuarios (usuario, password_hash) VALUES (:usuario, :password_hash)'; // También podríamos usar marcadores posicionales (?).
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':usuario' => $usuario,
                ':password_hash' => $passwordHash
                // Asociamos cada valor con el marcador correspondiente.
            ]);

            header('Location: register.php?registro=ok');
            // Redirigimos para evitar repetir el registro al actualizar la página.
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario - JAMM</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Registro de usuario</h1>
        <p>Usamos la base de datos `dwes_T4 (usuarios)`.</p>
        <?php if ($mensaje !== ''): ?>
            <p class="mensaje" role="status"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <p class="mensaje-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="register.php" method="post">
            <label for="usuario">Nombre de usuario:</label>
            <input type="text" id="usuario" name="usuario" maxlength="50" value="<?= htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required> <!-- El navegador solicita una contraseña nueva para el registro. -->

            <button type="submit">Crear cuenta</button>
        </form>
        <p><a href="usuarios.php">Ver usuarios autorizados</a></p>
        <p><a href="../index.php">Volver al inicio</a></p>

    </main>
</body>

</html>
