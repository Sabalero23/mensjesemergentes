Sistema de Mensajes Emergentes con PHP y MySQL
Este es un sistema desarrollado en PHP que te permite crear mensajes emergentes, guardarlos en una base de datos MySQL, y que luego se mostrarán automáticamente en un día y hora determinados que hayas configurado. Además, al mostrar el mensaje, reproduce un sonido. También puedes marcar los mensajes como leídos, volver a ponerlos como no leídos, editarlos o eliminarlos según tus necesidades. Todas las acciones se muestran utilizando SweetAlert2 para una experiencia de usuario mejorada.

Configuración del Sistema
Antes de comenzar a utilizar el sistema, asegúrate de seguir estos pasos de configuración:

Configuración del entorno PHP y MySQL:

Asegúrate de tener un entorno de desarrollo PHP instalado en tu servidor.
Configura una base de datos MySQL donde almacenarás los mensajes.
Importar la estructura de la base de datos:

Importa el archivo SQL proporcionado (msg.sql) en tu base de datos MySQL para crear las tablas necesarias.

Configuración de la conexión a la base de datos:

En el archivo conexion.php, modifica las variables de conexión ($servername, $username, $password y $dbname) con los detalles de tu servidor MySQL.

Uso del Sistema
Una vez configurado, puedes utilizar el sistema siguiendo estos pasos:

Crear un nuevo mensaje emergente:

Ingresa al Sistema, al cargar el inicio mostrara un mensaje preguntando "Permitir reproducción automática de audios. Para disfrutar de una experiencia completa, permítenos reproducir audios automáticamente. Dar en Permitir si quieres que se esuche un audio al mostrar el mensaje, en No Permitir si no quieres que reproduxca el audio.

Accede al formulario de creación de mensajes (crear_mensaje.php) e ingresa los detalles del mensaje, incluyendo el contenido, la fecha y hora de visualización y el sonido asociado.

Visualización automática de mensajes:

El sistema verificará automáticamente la base de datos y mostrará los mensajes emergentes en la fecha y hora especificadas.

Marcar mensajes como leídos o no leídos:

Luego de que el Sistema muestre un Mensaje, se verá un botón OK, que al hacer click en el, te llevará a modificar_msg.php para poder editar, marcar como leído o eliminar el mensaje

Estructura de Archivos
El sistema consta de los siguientes archivos principales:

index.php: Página principal y proporciona opciones de gestión.
crear_msg.php: Formulario para crear un nuevo mensaje emergente.
modificar_msg.php: Página para modificar un mensaje seleccionado.
guardar_msg.php: Script que guarda el mensaje en la base de datos.
mostar_msg.php: Página que muestra los mensajes emergentes automáticamente en la fecha y hora configurada.
guardar_cambios.php: Formulario para editar un mensaje existente.
obtener_msg.php: Script que lee la base de datos para ver si hay mensajes No leídos para mostrar.
marcar_leido.php: Script que ejecuta la acción de marcar un mensaje como leído.
marcar_no_leído.php: Script que ejecuta la acción de marcar un mensaje como no leído.
eliminar_msg.php: Script que ejecuta la acción de eliminar el mensaje.
conexion.php: Archivo de configuración con los detalles de conexión a la base de datos.
funciones.php: Archivo que contiene funciones útiles para el sistema.
msg.sql: Archivo SQL para crear las tablas necesarias en la base de datos.


Tecnologías Utilizadas
PHP: Lenguaje de programación utilizado para el desarrollo del sistema.
MySQL: Sistema de gestión de bases de datos relacional utilizado para almacenar los mensajes.
HTML/CSS/Bootstrap: Utilizados para la estructura, diseño y estilo de las páginas web.
JavaScript/SweetAlert2: Utilizados para funciones interactivas y mostrar acciones con SweetAlert2 para mejorar la experiencia del usuario.
¡Disfruta utilizando este sistema de mensajes emergentes y haz que la comunicación con tus usuarios sea más efectiva y atractiva con SweetAlert2!# mensjesemergentes
