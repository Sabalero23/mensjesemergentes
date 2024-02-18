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

// Verificar si se recibieron los datos del mensaje
if(isset($_POST['idMensaje']) && isset($_POST['titulo']) && isset($_POST['contenido']) && isset($_POST['fecha_mostrar'])) {
    // Obtener los datos del mensaje desde la solicitud AJAX
    $idMensaje = $_POST['idMensaje'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $fecha_mostrar = $_POST['fecha_mostrar'];

    // Preparar la consulta para actualizar los datos del mensaje en la base de datos
    $sql = "UPDATE mensajes SET titulo = '$titulo', contenido = '$contenido', fecha_hora_mostrar = '$fecha_mostrar' WHERE id = $idMensaje";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        // La actualización fue exitosa
        echo "Los cambios del mensaje han sido guardados exitosamente.";
    } else {
        // Hubo un error al actualizar el mensaje
        echo "Error al guardar los cambios del mensaje: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se recibieron todos los datos necesarios, mostrar un mensaje de error
    echo "Error: No se recibieron todos los datos necesarios para guardar los cambios del mensaje.";
}
?>