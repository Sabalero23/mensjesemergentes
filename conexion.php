<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // El nombre del servidor de la base de datos. Puede ser diferente si la base de datos está en un servidor remoto.
$username = "root"; // Nombre de usuario de la base de datos.
$password = ""; // Contraseña del usuario de la base de datos.
$dbname = "msg"; // Nombre de la base de datos a la que se conectará.

// Crear la conexión utilizando la clase mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si hay errores en la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error); // Si hay un error, se muestra un mensaje y se termina la ejecución del script.
}

// Establecer el conjunto de caracteres a UTF-8 para evitar problemas con la codificación de caracteres
$conn->set_charset("utf8");
?>