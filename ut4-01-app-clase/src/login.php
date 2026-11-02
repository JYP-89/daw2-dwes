<?php
// Formulario de inicio de sesión.
session_start();
require_once __DIR__ . '/includes/conexion.php';

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

$usuario = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    $sql = 'SELECT usuario, password_hash FROM usuarios WHERE usuario = :usuario'; // :usuario es un marcador con nombre que se asocia al valor en execute().
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':usuario' => $usuario]);
    $usuarioEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioEncontrado && password_verify($password, $usuarioEncontrado['password_hash'])) {
        session_regenerate_id(true); // nueva id de sesión
        $_SESSION['usuario'] = $usuarioEncontrado['usuario'];

        header('Location: index.php');
        exit();
    }

    $error = 'Usuario o contraseña incorrectos.';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN -JAMM</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Iniciar sesión</h1>

        <?php if ($error !== ''): ?>
            <p class="mensaje" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <label for="usuario">Usuario</label>
            <input
                type="text"
                id="usuario"
                name="usuario"
                value="<?= htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') ?>"
                required>

            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required>

            <button type="submit">Entrar</button>
        </form>

        <p><a href="03-registro-usuarios/register.php">Crear una cuenta autorizada</a></p>
    </main>
</body>

</html>
