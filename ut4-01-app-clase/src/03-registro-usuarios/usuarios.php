<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexion.php';

$sql = 'SELECT id, usuario FROM usuarios ORDER BY id';
$resultado = $pdo->query($sql);
$usuarios = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de usuarios-JAMM</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <main class="contenedor">
        <h1>Usuarios</h1>
        <p><a href="register.php">Registrar nuevo usuario</a></p>
        <p>Usamos la base de datos `dwes_T4 (usuarios)`.</p>

        <?php if (count($usuarios) > 0): ?>
            <table class="tabla-usuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Acciones</th>                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $usuario['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($usuario['usuario'], ENT_QUOTES, 'UTF-8') ?></td>                            
                            <td>                                
                                <form action="borrar.php" method="post" class="formulario-inline">
                                    <input type="hidden" name="id" value="<?= (int) $usuario['id'] ?>">
                                    <button type="submit">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay usuarios en la tabla.</p>
        <?php endif; ?>

        <p><a href="../index.php">Volver al inicio</a></p>
    </main>
</body>

</html>
