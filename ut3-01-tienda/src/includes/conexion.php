<?php

/* Conexión a la base de datos (mismo bloque que en clase).
// Únicos cambios por Docker:
//  - host: el servicio "db" del docker-compose, no 127.0.0.1
//  - credenciales: se leen del .env a través de docker-compose (host,dbname,user y pass)
En docker-compose.yml, DB_HOST: db está escrito directamente en el compose. 
Del .env salen solo DB_NAME, DB_USER y DB_PASSWORD. 
Conviene tener clara la diferencia : 
    el .env guarda valores que cambian según dónde despliegues (credenciales), 
    y el host db es fijo porque es el nombre que le das al servicio en el propio compose.
*/
try {
    $dsn = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME');
    $username = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    );
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}