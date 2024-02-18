<?php
/*
 * Sistema de Mensajes Emergentes
 * Desarrollador: Brach Gabriel
 * Versión: 1.0
 * Fecha de Creación: 18-02-2024
 * Contacto: [webmaster@cellcomweb.com.ar]
 */
 ?>
 <?php
// Verificar si se recibió un ID de mensaje válido
if (isset($_POST['idMensaje']) && !empty($_POST['idMensaje'])) {
    // Incluir el archivo de conexión a la base de datos
    include 'conexion.php';

    // Obtener el ID del mensaje desde la solicitud POST
    $idMensaje = $_POST['idMensaje'];

    // Actualizar el valor de la columna "leido" a 0 para el mensaje correspondiente
    $sql = "UPDATE mensajes SET leido = 0 WHERE id = $idMensaje";

    if ($conn->query($sql) === TRUE) {
        // La consulta se ejecutó correctamente, enviar una respuesta exitosa
        echo "El mensaje ha sido marcado como no leído correctamente.";
    } else {
        // Si hubo un error al ejecutar la consulta, enviar un mensaje de error
        echo "Error al marcar el mensaje como no leído: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se recibió un ID de mensaje válido, enviar un mensaje de error
    echo "ID de mensaje no válido.";
}
?>