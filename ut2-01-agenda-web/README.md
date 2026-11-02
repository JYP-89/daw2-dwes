# UT2-01 · Agenda web (Tarea DWES02)

Agenda telefónica en una sola página PHP, sin base de datos. Los contactos se guardan en un array asociativo (nombre → teléfono) que viaja en campos ocultos del formulario (POST + hidden) y se conserva en la sesión.

- Nombre vacío: muestra una advertencia.
- Nombre nuevo con teléfono: lo añade.
- Nombre existente con teléfono: sustituye el teléfono.
- Nombre existente sin teléfono: elimina el contacto.

## Uso

```bash
docker compose up -d
```

Abrir http://localhost:9201

```bash
docker compose down
```

| Servicio | Contenedor | Imagen |
|---|---|---|
| `web` | `dwes-ut2-01-web` | php:8.2-apache |
