# UT4-01 · Tarea DWES04 y ampliaciones (app de clase).

Aplicación didáctica en PHP y MySQL para reunir, por módulos, ejercicios de Desarrollo Web en Entorno Servidor. 

## Contenidos

- **Preferencias con sesión:** guardar, mostrar y borrar idioma, perfil público y zona horaria.
- **Usuarios:** registro, inicio y cierre de sesión. Las contraseñas se guardan mediante `password_hash()` y se comprueban con `password_verify()`.
- **Productos:** listado y operaciones CRUD (crear, consultar, editar y borrar) con PDO.
- **Cesta:** guardar productos en la sesión, ver el total y simular la finalización de la compra. No se procesa ningún pago ni se registra un pedido.
- **Cookies:** comparar un contador guardado en `$_SESSION` con otro guardado en una cookie del navegador.

## Preparación



Desde la carpeta del proyecto, crea el archivo local `.env` a partir del ejemplo:


cp .env.example .env


Editar `.env` y asignar valores propios a `MYSQL_ROOT_PASSWORD` y `MYSQL_APP_PASSWORD`. Usa valores distintos. mi usuario `JAMM` es de la aplicación y no utiliza la cuenta `root`.

## Arrancar la aplicación

Desde la carpeta que contiene `compose.yaml`:


docker compose up -d --build
docker compose ps

Cuando los servicios estén iniciados:

- En el mismo ordenador: <http://localhost:9401>
- Para registrar el primer usuario: <http://localhost:8401/03-registro-usuarios/register.php>

No hay credenciales predeterminadas. Registra una cuenta y después inicia sesión. En el primer arranque, MySQL crea la base `dwes_T4` y ejecuta los scripts SQL de `sql/` para crear las tablas y añadir los productos de ejemplo.

La aplicación web se publica en el puerto **9401**. MySQL se publica en el puerto **19401** enlazado a `127.0.0.1`, de modo que solo se accede a él desde el propio ordenador. PHP se conecta a MySQL por la red interna de Compose usando el servicio `db` y el puerto `3306`.



## Acceso desde TU ordenador si algo no furula


http://IP_DEL_EQUIPO:9401

Ambos equipos deben estar en la misma red y el cortafuegos del PC servidor debe permitir el puerto `8401`. El compañero no necesita Docker si solo va a probar la aplicación desde el navegador. El puerto de MySQL no se publica en la red local.

Si el compañero descarga el proyecto y quiere ejecutarlo en su propio PC, deberá instalar Docker, crear su `.env` a partir de `.env.example` y seguir los pasos de arranque anteriores.

## Estructura

src/                         Aplicación PHP servida por Apache
  01-preferencias/           Preferencias guardadas en sesión
  02-productos/               CRUD y cesta de productos
  03-registro-usuarios/       Registro y administración de usuarios
  04-cookies/                 Comparación de sesión y cookie
  includes/                   Autenticación y conexión PDO
  css/                        Hoja de estilos
sql/                         Creación y datos iniciales de las tablas
compose.yaml                 Servicios web y base de datos
Dockerfile                   PHP con PDO MySQL
DOCKER.md                    Comandos y notas de la base de datos
