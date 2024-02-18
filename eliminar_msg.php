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
// Incluir el archivo de conexión a la base de datos
include 'conexion.php';

// Verificar si se recibió el ID del mensaje a eliminar
if(isset($_POST['idMensaje'])) {
    // Obtener el ID del mensaje desde la solicitud AJAX
    $idMensaje = $_POST['idMensaje'];

    // Preparar la consulta para eliminar el mensaje de la base de datos
    $sql = "DELETE FROM mensajes WHERE id = $idMensaje";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        // La eliminación fue exitosa
        echo "El mensaje ha sido eliminado.";
    } else {
        // Hubo un error al eliminar el mensaje
        echo "Error al eliminar el mensaje: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se recibió el ID del mensaje a eliminar, mostrar un mensaje de error
    echo "Error: No se recibió el ID del mensaje a eliminar.";
}
?>