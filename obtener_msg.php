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

// Obtener la fecha y hora actual en formato datetime de MySQL
$currentDateTime = date('Y-m-d H:i:s');

// Consultar los mensajes marcados como no leídos (valor 0 en la columna "leido")
$sql = "SELECT * FROM mensajes WHERE leido = 0 AND fecha_hora_mostrar <= '$currentDateTime'";
$result = $conn->query($sql);

// Array para almacenar los mensajes
$mensajes = array();

// Verificar si hay resultados y agregarlos al array de mensajes
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Ajustar el formato de la fecha y hora del mensaje para que sea compatible con JavaScript
        $fechaMostrar = date("Y-m-d\TH:i:s", strtotime($row['fecha_hora_mostrar'])); // Convertir a formato ISO 8601
        // Agregar el mensaje al array
        $mensaje = array(
            'id' => $row['id'], // Agregar el ID del mensaje
            'titulo' => $row['titulo'],
            'contenido' => $row['contenido'],
            'fecha_hora_mostrar' => $fechaMostrar // Incluir la fecha y hora ajustada en el formato correcto
        );
        array_push($mensajes, $mensaje);
    }
}

// Devolver los mensajes como respuesta en formato JSON
echo json_encode($mensajes);

// Cerrar la conexión a la base de datos
$conn->close();
?>