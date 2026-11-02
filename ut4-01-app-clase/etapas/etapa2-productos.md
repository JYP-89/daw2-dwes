# Etapa 2: listado de productos

## Objetivo

Leer productos de la tabla `productos` de la base `dwes_T4` y mostrarlos en una página PHP.

## Recorrido

1. `index.php` enlaza con `productos.php`.
2. `productos.php` incluye `conexion.php`.
3. `conexion.php` recoge los datos de conexión del entorno del servicio `web` y crea el objeto PDO.
4. `productos.php` ejecuta una consulta `SELECT`, recupera las filas y las muestra en una tabla HTML.

## Docker

- El servicio `web` usa Apache con PHP y PDO MySQL.
- El servicio `db` ejecuta MySQL.
- Compose coloca ambos servicios en una red común; desde PHP, `DB_HOST` es `db` y el puerto es `3306`.
- La variable `MYSQL_APP_PASSWORD` de `.env` se pasa a ambos servicios para que coincida la clave del usuario de aplicación.

## Alcance

Esta etapa solo lista productos. Crear, editar y eliminar se añadirán en pasos posteriores.
