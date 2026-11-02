<?php
// Extracción segura mediante variables de entorno (Docker-ready)
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";



$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Arrays asociativos por defecto
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desactivar emulación para seguridad real
];
//2c onstruye constructor; aquí entra el segundo paso, crear $pdo en base a lo que extraemos del entorno
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die($e->getMessage());
    // Pro-Tip: Loguear el error real internamente, mostrar mensaje genérico al usuario
    /*error_log("Fallo de conexión en " . $e->getFile() . " (Código: " . $e->getCode() . "): " . $e->getMessage());
    die("Error crítico: No se ha podido establecer contacto con el servicio de datos.");
    modo desarrollo Vs modo producción.
    */
}
?>