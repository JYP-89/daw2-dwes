<?php

/*
=================================================
TAREA DWES02 — JAMM AGENDA TELEFÓNICA
==================================================

La aplicación mantiene una pequeña agenda utilizando
un array asociativo.

Cada contacto tendrá:

    CLAVE  -> nombre
    VALOR  -> teléfono

Por ejemplo:

    [
        'Juan' => '600111111',
        'Ana'  => '600222222'
    ]


Iintervienen tres conceptos importantes:

    POST, SESSION y HIDDEN

POST
----
Sirve para transportar los datos del formulario desde
el navegador hasta PHP.

Por ejemplo:

    $_POST['nombre']
    $_POST['telefono']


SESSION
-------
Permite conservar información entre diferentes peticiones.

Aquí utilizamos:

    $_SESSION['agenda']

para guardar nuestra agenda, que es un array asociativo.


HIDDEN
------
Es un campo de formulario que no se muestra visualmente
al usuario, pero que sí se envía cuando se envía el formulario.

En esta práctica utilizaremos los campos hidden para
introducir los datos actuales de la agenda dentro del
formulario.

De esta forma, la agenda también forma parte de los
datos enviados mediante POST.


Es importante distinguir las funciones:

    POST
        ↓
    transporta información

    SESSION
        ↓
    conserva información entre peticiones

    HIDDEN
        ↓
    permite incluir información adicional dentro
    del formulario y enviarla mediante POST


En esta implementación SESSION ya conserva la agenda,
por lo que los hidden no son necesarios para conseguir
la persistencia.

Sin embargo, el enunciado de la práctica dice:

    "Introducir los datos de la agenda como campos
     ocultos en el formulario."

Por tanto, los metemos.
*/


// 
// UNO — INICIAR LA SESIÓN
// 

session_start();

/*
session_start() inicia una sesión si todavía no existe
o recupera una sesión que ya existía.

NO significa que cada vez que ejecutamos este archivo
se cree una sesión completamente nueva.

Si el navegador ya tiene una sesión asociada, PHP
recuperará esa misma sesión.


Por eso podemos hacer:

    petición 1
        ↓
    $_SESSION['agenda']

y posteriormente:

    petición 2
        ↓
    $_SESSION['agenda']

La información que guardamos en SESSION permanece
disponible entre ambas peticiones.

Además, diferentes archivos PHP pueden acceder a
la misma sesión si se ejecutan dentro del mismo
contexto de sesión.

Por ejemplo:

    agenda.php
    prueba.php

podrían acceder ambos a:

    $_SESSION['agenda']


Esto es diferente de una variable normal como:

    $agenda

Una variable normal pertenece a la ejecución actual
del script.

Cuando esa ejecución termina, esa variable deja
de existir.

SESSION permite conservar los datos entre peticiones.
*/


// 
// DOS — COMPROBAR SI LA AGENDA EXISTE
// 

/*
$_SESSION es una variable superglobal de PHP.

Dentro de ella vamos a guardar nuestra agenda.


La estructura será:

    $_SESSION
        │
        └── 'agenda'
                │
                └── array asociativo
                        │
                        ├── 'Juan' => '600111111'
                        └── 'Ana'  => '600222222'


Es decir:

    $_SESSION['agenda']

es la posición llamada "agenda" dentro de la sesión.

**El valor almacenado en esa posición será nuestro array asociativo.**


Comprobamos si esa posición existe:

    isset($_SESSION['agenda'])

Si no existe, significa que todavía no hemos creado la agenda dentro de esta sesión.

En ese caso creamos un array vacío.
*/

if (!isset($_SESSION['agenda'])) {

    $_SESSION['agenda'] = [];
}


/*
A partir de aquí podemos trabajar con:

    $_SESSION['agenda']

sabiendo que existe.


La primera vez que abramos la página tendremos:

    $_SESSION['agenda'] = [];


Después de añadir un contacto:

    $_SESSION['agenda'] = [
        'Juan' => '600111111'
    ];


Después de añadir otro:

    $_SESSION['agenda'] = [
        'Juan' => '600111111',
        'Ana'  => '600222222'
    ];


Aquí aparece una característica importante del
array asociativo.

**El nombre es la CLAVE y el teléfono es el VALOR**

             CLAVE          VALOR
                ↓              ↓
        'Juan' => '600111111'


Esto permite que no tengamos dos entradas con la
misma clave.


Si hacemos:

    $_SESSION['agenda']['Juan'] = '600111111';


y después:

    $_SESSION['agenda']['Juan'] = '600999999';


no tendremos dos Juan.

El segundo valor sustituirá al primero:

    'Juan' => '600999999'


Esto nos  permite modificar el teléfono de un contacto existente.
*/


/*
--------------------------------------------------
SESSION Vs A POST
--------------------------------------------------
Esto me llamó mucho la atención por alguna razón mezclé conceptos:

Aquí (en este php) estamos almacenando la agenda en:

    $_SESSION['agenda']

Por tanto, cuando llegue una nueva petición, PHP
podrá recuperar la agenda desde SESSION.

En cambio, $_POST solamente contiene los datos que
el navegador ha enviado EN ESA PETICIÓN.

Por ejemplo:

    $_POST
        ├── nombre
        └── telefono

puede cambiar en cada envío.

Mientras que:

    $_SESSION['agenda']

mantiene la agenda entre las diferentes peticiones.
*/


// 
// TRES — COMPROBAR EL ENVÍO DEL FORMULARIO
// 

/*
El formulario HTML utilizará:

    method="post"

Cuando el usuario pulse el botón, el navegador
enviará una petición POST al servidor.

PHP puede comprobar qué método HTTP se ha utilizado
mediante $_SERVER["REQUEST_METHOD"]


Si devuelve POST significa que estamos procesando un envío realizado
mediante POST.


Tengo claro que:

El utilizar SESSION NO significa que dejemos
de utilizar POST.

POST y SESSION tienen funciones diferentes:

    POST
        transporta los datos enviados por el formulario.

    SESSION
        conserva la agenda entre peticiones.
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // 
    // CUATRO — COMPROBAR QUE HAN LLEGADO LOS DATOS
    // 

    /*
    Si estamos dentro de este if significa que el
    formulario se ha enviado mediante POST.

    Ahora comprobamos que dentro de $_POST existan
    las posiciones:

        nombre
        telefono

    Estas posiciones existen porque en el formulario html tendremos:

        name="nombre"y name="telefono"


    IMPORTANMTE entender:

    El atributo "name" del HTML es el que determina
    el nombre de la posición que recibiremos en $_POST.

    Por ejemplo:

        <input name="nombre">

    produce:

        $_POST['nombre']
    */


    if (isset($_POST['nombre']) && isset($_POST['telefono'])) {


        /*
        Recuperamos los valores enviados mediante POST
        y los guardamos temporalmente en variables.

        trim() elimina espacios al principio y al final
        del texto recibido.
      
        */

        $nombre = trim($_POST['nombre']);
        $telefono = trim($_POST['telefono']);


        /*
        print_r($_POST) lo usamos de prueba.

        Permite ver exactamente qué ha recibido PHP
        mediante POST.

        <pre> permite que el resultado mantenga un
        formato más óptimo.

        Quería poder ver que efecto tenía hidden:

            Array
            (
                [nombre] => Juan
                [telefono] => 600111111
            )

        POr eso imprimo $_POST, para ver los campos hidden que contiene.
        */

        echo "Este es lo que recibe PHP: ";
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";


        /*
        Ya tenemos las variables.
            $nombre
            $telefono
        */

        // 
        // CINCO — COMPROBAR SI EL NOMBRE ESTÁ VACÍO
        // 

        /*
        El primer requisito es:

            "Si el nombre está vacío, se mostrará
             una advertencia."


        Comprobamos si $nombre está vacío con empty().

        El formulario HTML también tiene:

            required

        en el campo nombre.

        Eso hace que el navegador intente impedir
        que el usuario envíe el formulario vacío.

        **Pero son dos comprobaciones diferentes.**

        required
            ↓
        comprobación realizada por el navegador.


        empty($nombre)
            ↓
        comprobación realizada por PHP en el servidor.


        No debemos depender únicamente de la validación
        realizada por HTML, porque PHP DEBE comprobar
        también los datos que recibe.
        */

        if (empty($nombre)) {

            echo "Required de HTML, campo obligatorio";
        }


        // 
        // SEIS — AÑADIR O MODIFICAR EL CONTACTO
        // 

        /*S
        Llegamos aquí cuando tenemos un nombre.


        El siguiente filtro es:

            Si el nombre no existe y el teléfono
            NO está vacío, se añadirá a la agenda.

        Y también:

            Si el nombre YA EXISTE y se indica
            un teléfono, se sustituirá el anterior.

        Podemos usar:

            $_SESSION['agenda'][$nombre] = $telefono;


        ¿Qué hace?

        1 — EL NOMBRE NO EXISTE

        Si tenemos:

            $nombre = "Juan"
            $telefono = "600111111"


        PHP hace:

            $_SESSION['agenda']['Juan'] = '600111111';


        Como "Juan" no existía, se crea una nueva
        posición del array.


        2 — EL NOMBRE YA EXISTE

        Si tenemos:

            'Juan' => '600111111'


        y enviamos:

            $nombre = "Juan"
            $telefono = "600999999"


        PHP hace:

            $_SESSION['agenda']['Juan'] = '600999999';


        Como la clave "Juan" ya existía, su valor
        se sustituye.


        Por tanto:

            nombre nuevo
                → añadir

            nombre existente
                → modificar teléfono


        Esta es una de las ventajas de utilizar un array asociativo.
        */


        if (!empty($nombre) && !empty($telefono)) {

            $_SESSION['agenda'][$nombre] = $telefono;
        }


        // ==================================================
        // SIETE — BORRAR / DAR DE BAJA UN CONTACTO
        // ==================================================

        /*
        El último comportamiento de la agenda es:

            Si el nombre EXISTE y el teléfono está vacío,
            se elimina ese contacto.


        Por ejemplo:

            [
                'Juan' => '600111111',
                'Ana'  => '600222222'
            ]


        e introduzco:

            Nombre:
                Juan

            Teléfono:
                [vacío]


        interpretamos que se quiere dar de baja a Juan.


        unset() elimina una posición del array.

        Por tanto:

            unset($_SESSION['agenda'][$nombre]);


        Si $nombre contiene:

            "Juan"


        PHP ejecutará conceptualmente:

            unset($_SESSION['agenda']['Juan']);


        El resultado será:

            [
                'Ana' => '600222222'
            ]
        */


        if (!empty($nombre) && empty($telefono)) {

            unset($_SESSION['agenda'][$nombre]);


            /*
            Aquí suponemos que si llega un nombre pero el teléfono está vacío,
            queremos ELIMINAR esa entrada.

            Podríamos comprobar además si el nombre
            existe antes de hacer unset():

                ...&& array_key_exists($nombre,$_SESSION['agenda']
                )

            Esto permitiría distinguir entre:

                "el contacto existe y queremos borrarlo"

            y:

                "el contacto no existe".   
            
                sirve precisamente para buscar índices en arrays
                
            */
        }
    }
}


?>

<!DOCTYPE html>

<html lang="es">

<head>


    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Agenda telefónica dinámica JAMM</title>


</head>

<body>


    <h1>Agenda telefónica dinámica JAMM</h1>


    <div>

        <h2>Rellena los datos:</h2>


        <!--
    
    FORMULARIO
    

    Aquí comienza le HTML de la aplicación.

    El formulario utiliza:

        method="post"

    Por tanto y como ya hemos dicho, al pulsar el botón, los datos de
    los campos se enviarán mediante POST.

    Los atributos name="nombre" y name="telefono"

    Ojo, esto es igual de clave que el php.

    Son los nombres que este utilizará para acceder
    a los datos recibidos:

        $_POST['nombre']
        $_POST['telefono']
    -->
        <?php
        echo "la ruta del php es " . $_SERVER['PHP_SELF'];
        ?>
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?> " method="post" id="formContacto">

            <!-- $_SERVER['PHP_SELF'] Es una variable que contiene la ruta del archivo PHP que se está ejecutando. 
                En nuestro caso, el mismo. 
            -->

            <label for="nombre">
                Nombre
            </label>


            <input
                id="nombre"
                name="nombre"
                type="text"
                placeholder="Tu nombre"
                required>


            <label for="telefono">
                Teléfono
            </label>


            <input
                id="telefono"
                name="telefono"
                type="tel"
                placeholder="Tu teléfono">


            <!--
        
        HIDDEN — INTRODUCIR LA AGENDA EN EL FORMULARIO
        

        Esta parte es por la que he estado varios días escribiendo código.


        hidden significa que el campo:

            NO se muestra visualmente al usuario

        pero:

            SÍ forma parte del formulario
            y SÍ se envía cuando hacemos POST.


        Recorremos la agenda que tenemos almacenada
        en SESSION:

            $_SESSION['agenda']


        y por cada contacto generamos un campo hidden.


        Por ejemplo, si tenemos:

            $_SESSION['agenda'] = [
                'Juan' => '600111111',
                'Ana'  => '600222222'
            ];


        el foreach generará algo como:

            <input
                type="hidden"
                name="agenda[Juan]"
                value="600111111"
            >

            <input
                type="hidden"
                name="agenda[Ana]"
                value="600222222"
            >


        El usuario NO verá estos campos, pero el
        navegador sí los incluirá al enviar el formulario.


        Por tanto, en el siguiente POST podremos recibir:

            $_POST['agenda']


        que tendrá una estructura parecida a:

            [
                'Juan' => '600111111',
                'Ana'  => '600222222'
            ]


        Esto explica el nombre:

            agenda[Juan]

        PHP interpreta los corchetes como una estructura
        de array y puede construir automáticamente:

            $_POST['agenda']['Juan']       

        En esta versión la agenda ya está guardada en SESSION, por lo que realmente no
        necesitamos los hidden para conservarla, por eso me volví loco.
        -->


            <?php

            if (
                isset($_SESSION['agenda'])
                && !empty($_SESSION['agenda'])
            ) {

                /*
            Recorremos la agenda.

            En cada vuelta obtenemos:

                $nombre
                $telefono

            y generamos un 'input hidden'.
            */


                foreach (
                    $_SESSION['agenda']
                    as $nombre => $telefono
                ) {

                    echo '<input
                    type="hidden"
                    name="agenda[' . $nombre . ']"
                    value="' . $telefono . '">';
                }
            }

            ?>


            <button
                type="submit">
                Apuntar en agenda
                <span>-></span>
            </button>


        </form>

    </div>


    <?php

    // OCHO — MOSTRAR LA AGENDA

    /*
Llegamos a esta parte después de haber procesado
el posible envío del formulario.


Comprobamos:

    1. Que exista $_SESSION['agenda']

    2. Que no esté vacía


Si existen contactos, mostramos la agenda.


Esta parte es a parte del formulario.

La agenda está en:

    $_SESSION['agenda']


y recorremos ese array asociativo con foreach.
*/


    if (
        isset($_SESSION['agenda'])
        && !empty($_SESSION['agenda'])
    ) {


        /*
    Creamos una tabla HTML.

    border="1" se utiliza aquí simplemente para
    visualizar claramente la tabla durante las
    pruebas.
    */

        echo "<table border='1'>";


        // Creamos la fila de encabezados.

        echo "<tr>";
        echo "<th>Nombre</th>";
        echo "<th>Teléfono</th>";
        echo "</tr>";
        /*
    foreach recorre el array asociativo.
    Si tenemos:
        [
            'Juan' => '600111111',
            'Ana'  => '600222222'
        ]
    en la primera vuelta tendremos:

        $nombre = 'Juan'
        $telefono = '600111111'

    y en la segunda:

        $nombre = 'Ana'
        $telefono = '600222222'

    Las variables reciben en cada vuelta:

        $nombre
            → clave del array

        $telefono
            → valor del array
    */
        foreach (
            $_SESSION['agenda']
            as $nombre => $telefono
        ) {
            echo "<tr>";
            /*
        htmlspecialchars() convierte determinados
        caracteres especiales para que puedan mostrarse
        correctamente dentro del HTML.

        Los datos de la agenda pueden ser privados, debemos
        tener cuidado al mostrarlos directamente dentro
        de HTML.
        */

            echo "<td>"
                . htmlspecialchars($nombre)
                . "</td>";


            echo "<td>"
                . htmlspecialchars($telefono)
                . "</td>";


            echo "</tr>";
        }


        echo "</table>";
    }

    ?>

</body>

</html>