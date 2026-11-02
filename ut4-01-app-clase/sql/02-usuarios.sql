-- La contraseña original nunca se guarda: almacenamos el hash generado por PHP.
-- VARCHAR(255) deja espacio suficiente para hashes actuales y futuros.
-- La tabla se crea automáticamente al inicializar un volumen MySQL vacío.
-- Las cuentas se registran desde src/03-registro-usuarios/register.php.
CREATE TABLE usuarios (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    usuario        VARCHAR(50)  NOT NULL UNIQUE,
    password_hash  VARCHAR(255) NOT NULL
) ENGINE = INNODB DEFAULT CHARSET = utf8mb4;
