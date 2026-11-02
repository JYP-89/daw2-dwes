# Notas de clase

## Etapa 1: sesiones y preferencias

- Una sesión permite conservar información del usuario entre páginas.
- Cada página que necesita leer o modificar la sesión ejecuta `session_start()` antes de mostrar HTML.
- En esta etapa guardamos un único array `$_SESSION['preferencias']` con tres valores.
- Borrar preferencias significa ejecutar `unset($_SESSION['preferencias'])`; no hace falta destruir toda la sesión.
- Los datos enviados por un formulario se validan y se escapan antes de mostrarse en la página.

## Preguntas para repasar

1. ¿Por qué hay que llamar a `session_start()` antes de imprimir contenido?
2. ¿Qué diferencia hay entre `$_POST` y `$_SESSION`?
3. ¿Qué elimina exactamente `unset($_SESSION['preferencias'])`?
4. ¿Por qué comprobamos que los valores recibidos pertenecen a las opciones permitidas?
