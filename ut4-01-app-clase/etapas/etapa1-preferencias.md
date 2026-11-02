# Etapa 1: preferencias con sesión

## Objetivo

Cumplir la tarea DWES04: permitir elegir idioma, perfil público y zona horaria, guardar esos valores en la sesión, mostrarlos y borrarlos.

## Recorrido

1. `index.php` enlaza con las dos páginas de la tarea.
2. `preferencias.php` muestra los tres desplegables y guarda sus datos en `$_SESSION['preferencias']`.
3. `mostrar.php` enseña los datos guardados y permite eliminarlos de la sesión.
4. Desde ambas páginas se puede ir a la otra.

## Conceptos practicados

- `session_start()` al comienzo de cada página que utiliza la sesión.
- `$_POST` para recibir el formulario.
- `$_SESSION` para mantener preferencias entre solicitudes.
- `isset()`, `unset()` e `in_array()` para comprobar y eliminar datos.
- `htmlspecialchars()` al insertar valores en el HTML.
- Formularios POST y enlaces entre páginas.

## Alcance

Esta tarea no necesita registro ni login. La autenticación y las preferencias con cookies quedan como etapas posteriores.
