# DAW2 · Desarrollo Web en Entorno Servidor

Prácticas de la asignatura Desarrollo Web en Entorno Servidor (2.º DAW), con PHP y MySQL, desplegadas con Docker Compose.
Cada carpeta es un proyecto independiente con su propio `docker-compose.yml` y su `README.md`.

## Proyectos

| UT | Tarea | Carpeta | Contenido | Puerto |
|---|---|---|---|---|
| 1 | DWES01 | — | Trabajo escrito sin código | — |
| 2 | DWES02 | `ut2-01-agenda-web` | Agenda en una sola página: array asociativo, POST, campos ocultos y sesión | 9201 |
| 3 | DWES03 | `ut3-01-tienda` | Listado y edición de productos por familia con PDO y excepciones | 9301 |
| 3 | Ejercicio de clase | `ut3-02-crud-productos` | CRUD de productos con categorías | 9302 |
| 4 | DWES04 | `ut4-01-app-clase` | Preferencias en sesión, y como ampliación login con `password_hash`, cesta y cookies | 9401 |

## Uso

```bash
git clone https://github.com/JYP-89/daw2-dwes.git
cd daw2-dwes/<carpeta>
```

Seguir el `README.md` de esa carpeta. Si tiene `.env.example`, copiarlo como `.env` antes de levantar.

## Convenciones

- **Carpetas:** `utN-NN-descripcion`, en minúsculas y sin espacios.
- **Proyecto Compose:** `dwes-utN-NN`. **Contenedores:** `dwes-utN-NN-<servicio>`.
- **Puertos:** `9` + UT + NN (UT3-01 → 9301). Base de datos publicada (solo en `127.0.0.1`): +10000.
- **Secretos:** en `.env`, que nunca se sube. La plantilla está en `.env.example`.
- **Base de datos:** las aplicaciones se conectan con un usuario propio, nunca con root.
