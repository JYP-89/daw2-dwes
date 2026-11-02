# Docker y base de datos

Este archivo recoge comandos y detalles de la base de datos.

## Servicios y puertos

- `web`: Apache con PHP 8.4 y `pdo_mysql`, publicado en el puerto `9401` del ordenador.
- `db`: MySQL 8.4. PHP accede por la red interna de Compose con el host `db` y el puerto `3306`.
- El puerto `19401` del ordenador está enlazado solo a `127.0.0.1`; sirve para conectar un cliente MySQL local y no se expone al resto de la red.

## Comandos 

Para abrir un cliente MySQL dentro del contenedor:

docker compose exec db mysql -u root -p


La contraseña solicitada es el valor `MYSQL_ROOT_PASSWORD` del `.env`. Una vez dentro:


USE dwes_T4;
SHOW TABLES;
SELECT * FROM productos;
SELECT id, usuario FROM usuarios;


También se puede conectar un cliente MySQL instalado en el mismo ordenador con host `127.0.0.1`, puerto `3307`, base `dwes_T4` y usuario `JAMM`. La contraseña es el valor `MYSQL_APP_PASSWORD` del `.env`.

## Inicialización y persistencia

Los archivos `sql/01-productos.sql` y `sql/02-usuarios.sql` se montan en `/docker-entrypoint-initdb.d/`. MySQL los ejecuta en orden al inicializar por primera vez un volumen vacío. Si el volumen ya existe, `docker compose up` conserva sus datos y no vuelve a ejecutar esos archivos.

## Extensión PDO MySQL

El `Dockerfile` parte de `php:8.4-apache` e instala `pdo_mysql`, necesario para que la aplicación conecte con MySQL mediante PDO.
