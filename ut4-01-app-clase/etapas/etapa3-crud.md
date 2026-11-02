# Etapa 3: crear productos

## Objetivo de esta parte

Añadir productos a la tabla existente con un formulario. Las operaciones de edición y eliminación se incorporarán después.

## Recorrido

1. `productos.php` enlaza con `crear.php`.
2. `crear.php` muestra un formulario que envía el nombre y el precio por POST a la misma página.
3. PHP comprueba que el nombre no esté vacío y que el precio sea numérico y no negativo.
4. Si los datos son válidos, se prepara un `INSERT` con PDO y se ejecuta.
5. `header()` vuelve al listado después de guardar.

## Conceptos practicados

- Distinguir una solicitud GET de una solicitud POST mediante `$_SERVER['REQUEST_METHOD']`.
- Recuperar valores de `$_POST` y comprobarlos en PHP.
- Usar `PDO::prepare()` y `execute()` para insertar datos.
- Redirigir después de guardar con `header()` y `exit`.
- Mantener el valor introducido si la validación falla.

## Alcance

Esta parte solo permite crear. Todavía no añade edición ni eliminación.
