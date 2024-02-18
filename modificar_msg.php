<?php
/*
 * Sistema de Mensajes Emergentes
 * Desarrollador: Brach Gabriel
 * Versión: 1.0
 * Fecha de Creación: 18-02-2024
 * Contacto: [webmaster@cellcomweb.com.ar]
 */
 ?>
 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Mensajes</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            display: flex;
            justify-content: space-around;
        }
        .column {
            width: 45%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .column h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .mensaje {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: relative;
        }
        .mensaje h3 {
            margin-top: 0;
        }
        .mensaje.leido {
            background-color: #f0f0f0;
        }
        .boton {
            margin-top: 10px;
            display: inline-block;
            cursor: pointer;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
        .boton:hover {
            background-color: #0056b3;
        }
        .modal {
            display: none;
            align-items: center; /* Centra verticalmente */
            justify-content: center; /* Centra horizontalmente */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto; /* Para centrar horizontalmente */
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: fit-content; /* Ajusta el ancho al contenido */
            max-width: 80%; /* Establece un ancho máximo */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="column">
        <h2>Mensajes No Leídos</h2>
        <?php
        include 'conexion.php';

        $sql = "SELECT * FROM mensajes WHERE leido = 0";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="mensaje">';
                echo '<h3>' . $row['titulo'] . '</h3>';
                echo '<p>' . $row['contenido'] . '</p>';
                echo '<button class="boton" onclick="editarMensaje(' . $row['id'] . ', \'' . $row['titulo'] . '\', \'' . $row['contenido'] . '\', \'' . $row['fecha_hora_mostrar'] . '\', \'' . $row['leido'] . '\')">Editar</button>';
                echo '<button class="boton" onclick="marcarComoLeido(' . $row['id'] . ')">Leído</button>';
                echo '<button class="boton" onclick="confirmarEliminar(' . $row['id'] . ')">Eliminar</button>';
                echo '</div>';
            }
        } else {
            echo '<p>No hay mensajes no leídos.</p>';
        }

        $conn->close();
        ?>
    </div>
    <div class="column">
        <h2>Mensajes Leídos</h2>
        <?php
        include 'conexion.php';

        $sql = "SELECT * FROM mensajes WHERE leido = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="mensaje leido">';
                echo '<h3>' . $row['titulo'] . '</h3>';
                echo '<p>' . $row['contenido'] . '</p>';
                echo '<button class="boton" onclick="editarMensaje(' . $row['id'] . ', \'' . $row['titulo'] . '\', \'' . $row['contenido'] . '\', \'' . $row['fecha_hora_mostrar'] . '\', \'' . $row['leido'] . '\')">Editar</button>';
                echo '<button class="boton" onclick="marcarComoNoLeido(' . $row['id'] . ')">No Leído</button>';
                echo '<button class="boton" onclick="confirmarEliminar(' . $row['id'] . ')">Eliminar</button>';
                echo '</div>';
            }
        } else {
            echo '<p>No hay mensajes leídos.</p>';
        }

        $conn->close();
        ?>
    </div>
</div>
<div style="position: fixed; bottom: 10px; left: 10px;">
    <a href="index.php">Volver al Inicio</a>
</div>
<div id="modalEditar" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Editar Mensaje</h2>
        <form id="formEditar">
            <input type="hidden" id="idMensaje" name="idMensaje">
            <label for="titulo">Título:</label><br>
            <input type="text" id="titulo" name="titulo"><br>
            <label for="contenido">Contenido:</label><br>
            <textarea id="contenido" name="contenido"></textarea><br>
            <label for="fecha_mostrar">Fecha y Hora:</label><br>
            <input type="datetime-local" id="fecha_mostrar" name="fecha_mostrar"><br><br>

            <button type="button" onclick="guardarCambios()" class="boton">Guardar Cambios</button>
        </form>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Función para abrir el modal de edición de mensaje y cargar los datos del mensaje
    function editarMensaje(idMensaje, titulo, contenido, fecha_mostrar, leido) {
        var modal = document.getElementById('modalEditar');
        modal.style.display = 'block'; // Mostrar el modal
        document.getElementById('idMensaje').value = idMensaje;
        document.getElementById('titulo').value = titulo;
        document.getElementById('contenido').value = contenido;
        document.getElementById('fecha_mostrar').value = fecha_mostrar;
    }

    // Función para marcar el mensaje como leído
    function marcarComoLeido(idMensaje) {
        // Enviar una solicitud AJAX para marcar el mensaje como leído
        $.ajax({
            url: 'marcar_leido.php', // URL del archivo PHP que procesa la solicitud
            method: 'POST', // Método de la solicitud
            data: { // Datos a enviar al servidor
                idMensaje: idMensaje
            },
            success: function(response) { // Función que se ejecuta cuando la solicitud es exitosa
                // Mostrar un mensaje de confirmación
                Swal.fire({
                    title: 'Mensaje marcado como leído',
                    text: 'El mensaje ha sido marcado como leído.',
                    icon: 'success',
                    timer: 3500 // Tiempo en milisegundos (3.5 segundos)
                });
                // Recargar la página para reflejar los cambios
                location.reload();
            },
            error: function(xhr, status, error) { // Función que se ejecuta si hay un error en la solicitud
                console.error('Error en la solicitud AJAX:', error);
                // Mostrar un mensaje de error
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al marcar el mensaje como leído. Por favor, inténtalo de nuevo más tarde.',
                    icon: 'error'
                });
            }
        });
    }
    // Función para marcar el mensaje como no leído
    function marcarComoNoLeido(idMensaje) {
        // Enviar una solicitud AJAX para marcar el mensaje como no leído
        $.ajax({
            url: 'marcar_no_leido.php', // URL del archivo PHP que procesa la solicitud
            method: 'POST', // Método de la solicitud
            data: { // Datos a enviar al servidor
                idMensaje: idMensaje
            },
            success: function(response) { // Función que se ejecuta cuando la solicitud es exitosa
                // Mostrar un mensaje de confirmación
                Swal.fire({
                    title: 'Mensaje marcado como No leído',
                    text: 'El mensaje ha sido marcado como No leído.',
                    icon: 'success',
                    timer: 3500 // Tiempo en milisegundos (3.5 segundos)
                });
                // Recargar la página para reflejar los cambios
                location.reload();
            },
            error: function(xhr, status, error) { // Función que se ejecuta si hay un error en la solicitud
                console.error('Error en la solicitud AJAX:', error);
                // Mostrar un mensaje de error
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al marcar el mensaje como no leído. Por favor, inténtalo de nuevo más tarde.',
                    icon: 'error'
                });
            }
        });
    }
    // Función para guardar los cambios del mensaje editado
    function guardarCambios() {
        var idMensaje = document.getElementById('idMensaje').value;
        var titulo = document.getElementById('titulo').value;
        var contenido = document.getElementById('contenido').value;
        var fecha_mostrar = document.getElementById('fecha_mostrar').value;

        // Enviar los datos del mensaje al servidor utilizando AJAX
        $.ajax({
            url: 'guardar_cambios.php', // URL del archivo PHP que procesa la solicitud
            method: 'POST', // Método de la solicitud
            data: { // Datos a enviar al servidor
                idMensaje: idMensaje,
                titulo: titulo,
                contenido: contenido,
                fecha_mostrar: fecha_mostrar
            },
            success: function(response) { // Función que se ejecuta cuando la solicitud es exitosa
                // Mostrar un mensaje de confirmación
                Swal.fire({
                    title: 'Cambios Guardados',
                    text: 'Los cambios del mensaje han sido guardados exitosamente.',
                    icon: 'success',
                    timer: 3500 // Tiempo en milisegundos (3.5 segundos)
                });
                // Cerrar el modal de edición
                var modal = document.getElementById('modalEditar');
                modal.style.display = 'none';
                // Recargar la página para reflejar los cambios
                location.reload();
            },
            error: function(xhr, status, error) { // Función que se ejecuta si hay un error en la solicitud
                console.error('Error en la solicitud AJAX:', error);
                // Mostrar un mensaje de error
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al guardar los cambios del mensaje. Por favor, inténtalo de nuevo más tarde.',
                    icon: 'error'
                });
            }
        });
    }

    // Función para mostrar confirmación antes de eliminar un mensaje
    function confirmarEliminar(idMensaje) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el mensaje permanentemente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar una solicitud AJAX para eliminar el mensaje
                fetch('eliminar_msg.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded' // Cambiar el tipo de contenido
                    },
                    body: 'idMensaje=' + idMensaje // Enviar el ID del mensaje como parte de los datos del formulario
                })
                .then(response => response.text())
                .then(data => {
                    // Mostrar un mensaje de éxito al usuario
                    Swal.fire({
                        title: 'Eliminado!',
                        text: data, // El mensaje de éxito proviene del servidor
                        icon: 'success',
                    timer: 3500 // Tiempo en milisegundos (3.5 segundos)
                    });
                    // Recargar la página para reflejar los cambios
                    location.reload();
                })
                .catch(error => {
                    // Mostrar un mensaje de error si ocurre un problema
                    Swal.fire({
                        title: 'Error!',
                        text: 'Hubo un problema al eliminar el mensaje: ' + error,
                        icon: 'error'
                    });
                });
            }
        });
    }

    // Función para cerrar el modal de edición al hacer clic en la "X"
    var closeButtons = document.getElementsByClassName('close');
    for (var i = 0; i < closeButtons.length; i++) {
        closeButtons[i].addEventListener('click', function() {
            var modal = document.getElementById('modalEditar');
            modal.style.display = 'none';
        });
    }
</script>