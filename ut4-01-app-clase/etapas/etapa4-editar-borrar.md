# Etapa 4: editar y borrar productos

## Objetivo

Completar el CRUD añadiendo la edición y la eliminación de productos existentes.

## Editar

1. El listado enlaza a `editar.php` pasando el identificador por GET (`?id=...`).
2. `editar.php` comprueba el identificador y busca el producto con una consulta preparada.
3. El formulario muestra los datos encontrados y envía los cambios por POST a la misma página.
4. PHP valida los campos y ejecuta un `UPDATE` preparado.
5. Después de guardar, redirige al listado.

## Borrar

1. Cada fila del listado contiene un formulario POST con el identificador oculto.
2. `borrar.php` acepta únicamente solicitudes POST, valida el identificador y ejecuta un `DELETE` preparado.
3. Después redirige al listado.

## Conceptos practicados

- Pasar un identificador en la URL mediante GET y recibirlo mediante POST.
- Buscar un único registro con `fetch()`.
- Preparar consultas `UPDATE` y `DELETE` con PDO.
- Separar el método GET (consultar/mostrar el formulario) del POST (guardar cambios o borrar).

## Para revisar en la máquina virtual

- Editar un producto y comprobar que cambia en el listado.
- Intentar guardar un nombre vacío y un precio no válido.
- Borrar un producto y comprobar que desaparece.
- Abrir `editar.php` con un identificador inexistente o inválido y observar el mensaje.

El borrado se ejecuta al pulsar el botón. La confirmación visual antes de borrar puede añadirse en otro momento si forma parte de lo que se quiera estudiar.
