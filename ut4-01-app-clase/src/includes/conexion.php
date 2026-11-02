<?php

// Leemos los datos de conexión definidos en el entorno del servicio web.

$host = getenv('DB_HOST');
$puerto = getenv('DB_PORT');
$baseDatos = getenv('DB_NAME');
$usuario = getenv('DB_USER');
$contrasena = getenv('DB_PASSWORD');

$dsn = "mysql:host=$host;port=$puerto;dbname=$baseDatos;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('Error al conectar con base de datos: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
