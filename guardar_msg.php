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

// Obtener los datos del formulario
$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];
$fechaHora = $_POST['fechaHora'];

// Preparar la consulta para insertar el mensaje en la base de datos
$sql = "INSERT INTO mensajes (titulo, contenido, fecha_hora_mostrar) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Enlazar parámetros
$stmt->bind_param("sss", $titulo, $contenido, $fechaHora);

// Ejecutar la consulta
if ($stmt->execute()) {
    // La inserción fue exitosa
    $response = array('success' => true);
} else {
    // Error en la inserción
    $response = array('success' => false, 'error' => $conn->error);
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

// Cerrar la conexión a la base de datos
$conn->close();
?>