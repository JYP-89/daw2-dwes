# Etapa 5: registro, login y gestión de usuarios

## Objetivo

Registrar usuarios guardando el hash de su contraseña, permitirles iniciar y cerrar sesión y practicar la lectura y eliminación de usuarios.

## Recorrido

1. `03-registro-usuarios/register.php` recibe el nombre de usuario y la contraseña por POST.
2. Una consulta preparada comprueba si el nombre ya existe.
3. `password_hash()` genera un hash con `PASSWORD_BCRYPT`; una consulta preparada guarda el usuario y el hash.
4. `login.php` busca el usuario y `password_verify()` compara la contraseña introducida con el hash almacenado.
5. Si coincide, PHP regenera el identificador de sesión y guarda el nombre en `$_SESSION['usuario']`.
6. `includes/auth.php` inicia la sesión cuando hace falta y protege las páginas que requieren login.
7. `logout.php` vacía los datos de sesión y vuelve al login.
8. `usuarios.php` lista identificadores y nombres de usuario; `borrar.php` elimina una fila mediante POST y una consulta preparada.

## Conceptos practicados

- Consultas preparadas con PDO.
- `password_hash()` y `password_verify()`.
- `$_SESSION`, autenticación y redirecciones con `header()`.
- Formularios POST para borrar y `FILTER_VALIDATE_INT` para comprobar el identificador.

## Base de datos

En un volumen MySQL nuevo, `sql/02-usuarios.sql` crea la tabla automáticamente. Si se reutiliza un volumen antiguo sin esa tabla, sigue los pasos de [DOCKER.md](../DOCKER.md) para aplicarla sin borrar los productos existentes. El login actual consulta esta tabla y ya no usa credenciales de prueba.
