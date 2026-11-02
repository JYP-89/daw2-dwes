# UT3 · Tarea DWES03 · Gestión de productos

Aplicación PHP que gestiona la tabla `producto` de la base de datos `dwes`
usando PDO y excepciones. Tres páginas:

- **listado.php**: desplegable de familias y botón para mostrar sus productos
  (nombre corto y PVP), cada uno con un botón "Editar".
- **editar.php**: formulario con los datos del producto (nombre corto, nombre,
  descripción y PVP) y los botones "Actualizar" y "Cancelar".
- **actualizar.php**: si se pulsó "Actualizar", ejecuta el UPDATE; muestra el
  resultado y un botón "Continuar" que vuelve al listado.

## Puesta en marcha

cp .env.example .env
docker compose up -d --build


Abrir: http://localhost:9301/listado.php

La base de datos se crea y se carga automáticamente la primera vez, con los
scripts de `sql/` (se ejecutan en orden: `00-esquema.sql` y después
`01-datos.sql`). Para volver a cargarla desde cero:


docker compose down -v
docker compose up -d --build


## Estructura

```
ut3-01-tienda/
├── .env                  credenciales de la base de datos (las lee docker compose)
├── docker-compose.yml    servicios: db (MySQL 8.0) y web (PHP 8.2 + Apache)
├── Dockerfile            imagen web con la extensión pdo_mysql
├── sql/
│   ├── 00-esquema.sql    tablas y claves foráneas
│   └── 01-datos.sql      datos de ejemplo
├── src/                  se monta en /var/www/html
│   ├── listado.php
│   ├── editar.php
│   ├── actualizar.php
│   ├── includes/conexion.php
│   └── css/styles.css
└── docs/                 capturas del código visto en clase
```

## Cambios respecto al código de isabel

El código parte del visto en clase. Solo se ha cambiado lo necesario para
desplegarlo con Docker y corregir los fallos que han ido surgiendo:

1. **Conexión en un archivo aparte.** El bloque `try { new PDO(...) }` que en
   el cod original se repetía en cada página está en `includes/conexion.php` y se carga con
   `require_once`.
2. **Host `db` en lugar de `127.0.0.1`.** Cada servicio va en su propio
   contenedor; el servidor web llega a MySQL por el nombre del servicio.
   Las credenciales se leen de variables de entorno definidas en el `.env`.
3. **`00-esquema.sql` sin `CREATE DATABASE` ni `CREATE USER`.** La base de
   datos la crea el contenedor de MySQL con `MYSQL_DATABASE`.
4. **Variables con valor por defecto** (`$producto = null` en editar.php y
   `$mensaje = ""` en actualizar.php), para evitar avisos de variable no
   definida si se accede a la página directamente.
5. **Productos sin nombre.** muchos productos tienen `nombre` NULL:
   - `htmlspecialchars($producto['nombre'] ?? '')`, porque desde PHP 8.1 pasar
     `null` está obsoleto.
   - `formnovalidate` en "Cancelar", para poder cancelar aunque haya campos
     `required` vacíos.
6. **`try/catch` en el UPDATE**, para mostrar un mensaje en lugar de un error
   fatal si falla (por ejemplo, un `nombre_corto` repetido, que es `UNIQUE`).

## Pruebas

| Caso | Resultado esperado |
|---|---|
| Editar un producto, cambiar el PVP y pulsar Actualizar | "Se han actualizado los datos." y el cambio aparece en el listado |
| Editar un producto y pulsar Cancelar | "Actualización cancelada." y el producto no cambia |
| Poner un nombre corto que ya existe (p. ej. `Nintendo 3DS negro`) | Mensaje de error controlado (Duplicate entry), sin error fatal |

## Problemas en mi MV

- **Permisos en Ubuntu.** Si la carpeta viene de otra máquina o de una carpeta
  compartida, los contenedores pueden no tener permiso de lectura sobre `sql/`
  y `src/`. MySQL no carga los scripts y Apache devuelve 403. Solución:
  `chmod -R o+rX sql src` y volver a levantar con `docker compose down -v`.
  

Preguntas recopiladas durante la conversación con ia

¿Por qué PDO y no mysqli? 
PDO funciona con varios gestores de bases de datos (MySQL, PostgreSQL, SQLite...) con la misma interfaz, y tiene consultas preparadas y excepciones. Además, lo pide el enunciado. 

¿Qué diferencia hay entre query() y prepare()? 
query() ejecuta un SQL fijo de una vez. prepare() envía el SQL con ? y los valores se pasan después con execute(). Se usa prepare() siempre que la consulta lleve datos del usuario (S9). 

¿Y entre bindParam() y pasar un array a execute()? 
El resultado es el mismo. bindParam(1, $var) asocia una variable a un ? concreto; execute([$a, $b]) asigna los valores a los ? por orden. En editar.php se usa la primera forma y en las otras páginas la segunda (S7). 

¿Qué diferencia hay entre fetch() y fetchAll()? 
fetch() devuelve una fila (o false); fetchAll(), todas en un array. En editar.php se busca por clave primaria, así que solo puede haber una. 

¿Para qué sirve PDO::FETCH_ASSOC? 
Para que cada fila sea un array con los nombres de columna como claves ($producto['PVP']), sin duplicarla también con índices numéricos. 

¿Cómo sabe editar.php qué producto mostrar? 
Cada botón "Editar" del listado está en su propio formulario con un input hidden que lleva el cod del producto. Llega en $_POST['cod'] (S6). 

¿Cómo sabe actualizar.php si se pulsó Actualizar o Cancelar? 
Los dos botones se llaman accion y tienen distinto value. El navegador solo envía el del botón pulsado (S7). 

¿Qué pasaría sin el WHERE en el UPDATE? 
Se modificarían todas las filas de la tabla con los mismos datos. Con el código de clase, además, sobraría un valor y PDO lanzaría un error (S8). 

¿Por qué se usa POST y no GET para enviar los formularios? 
Los datos no aparecen en la URL, y POST es el método indicado para peticiones que pueden modificar datos en el servidor. El botón "Continuar" usa GET porque solo vuelve al listado. 

¿Qué hace htmlspecialchars()? 
Convierte <, >, & y comillas en entidades HTML para que un dato no se interprete como código de la página (S9). 

¿Qué es ('??')? 
El operador de fusión de null: $a ?? 'x' vale $a si existe y no es null, y 'x' en caso contrario. 

¿Qué diferencia hay entre require_once e include? 
Si el archivo falta, require detiene la página e include solo avisa. _once evita cargarlo dos veces (S4). 

¿Por qué el host es db y no localhost? 
PHP y MySQL están en contenedores distintos. Dentro de web, localhost es el propio contenedor; db es el nombre del servicio MySQL en la red de Docker Compose (S4). 

¿Quién lee el .env? 
Docker Compose, no PHP. Sustituye los ${...} del compose y pasa los valores al contenedor como variables de entorno; PHP los lee con getenv() (S2). 

¿Por qué hace falta un Dockerfile? 
La imagen php:8.2-apache no trae la extensión pdo_mysql; el Dockerfile la instala (S2). 

¿Por qué los scripts SQL llevan 00- y 01-? 
MySQL los ejecuta en orden alfabético y las tablas tienen que existir antes de insertar datos (S3). 

¿Qué mejora la aplicación respecto al código de clase? 
Corrige cuatro fallos que el original tenía con PHP 8.2 y estos datos: variables sin definir, el aviso por null, el botón Cancelar bloqueado y el error fatal en el UPDATE (S10). 
