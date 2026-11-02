# UT3-02 · CRUD de productos con PHP + MySQL (ejercicio de clase)

Ejercicio previo a la Tarea DWES03: listado de productos con su categoría (LEFT JOIN) y operaciones de crear, editar y eliminar mediante consultas preparadas con PDO.

## Uso

```bash
cp .env.example .env      # y cambiar las contraseñas
docker compose up -d --build
```

Abrir http://localhost:9302. Las tablas y los datos se crean solos desde `sql/` la primera vez.

Entrar en MySQL desde la terminal:

```bash
docker exec -it dwes-ut3-02-db mysql -u root -p
```

Parar y borrar los datos:

```bash
docker compose down -v
```

| Servicio | Contenedor | Imagen |
|---|---|---|
| `db` | `dwes-ut3-02-db` | mysql:8.4 |
| `web` | `dwes-ut3-02-web` | build `.` (php:8.2-apache + pdo_mysql) |