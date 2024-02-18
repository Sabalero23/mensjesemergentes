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
    <title>Mostrar Mensajes Programados</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .modal {
            display: none;
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
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 80%;
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
        .datetime {
            position: fixed;
            top: 10px;
            right: 10px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

<!-- Mostrar fecha y hora del navegador -->
<div class="datetime" id="datetime"></div>

<div class="container">
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Función para obtener la fecha y hora actual y mostrarla en la página
    function mostrarFechaHora() {
        var now = new Date();
        var datetimeElement = document.getElementById('datetime');
        var fechaHora = now.toLocaleString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' });
        datetimeElement.textContent = fechaHora;
    }

// Función para solicitar permiso al usuario para reproducir audios automáticamente
function solicitarPermisoReproduccionAutomatica() {
    Swal.fire({
        title: 'Permitir reproducción automática de audios',
        text: 'Para disfrutar de una experiencia completa, permítenos reproducir audios automáticamente.',
        icon: 'info',
        showDenyButton: true,
        confirmButtonText: 'Permitir',
        denyButtonText: 'No permitir'
    }).then((result) => {
        if (result.isConfirmed) {
            // El usuario permitió la reproducción automática
            Swal.fire('Permitido', 'success');
            // Aquí podrías realizar alguna acción adicional si lo deseas
        } else if (result.isDenied) {
            // El usuario no permitió la reproducción automática
            Swal.fire('No permitido', 'No se reproducirán audios automáticamente.', 'warning');
            // Aquí podrías realizar alguna acción adicional si lo deseas
        }
    });
}


    // Llamar a la función al cargar la página para solicitar permiso
    solicitarPermisoReproduccionAutomatica();

    // Función para obtener y mostrar los mensajes programados
    function obtenerYMostrarMensajes() {
        fetch('../msg/obtener_msg.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(mensaje => {
                // Obtener el ID del mensaje y guardarlo en una variable
                var idMensaje = mensaje.id;

                // Obtener la fecha y hora actual
                var now = new Date();
                console.log('Fecha y hora actual:', now); // Imprimir la fecha y hora actual en la consola

                // Convertir la fecha y hora del mensaje a un objeto Date
                var fechaMostrar = new Date(mensaje.fecha_hora_mostrar);
                console.log('Fecha y hora del mensaje programado:', fechaMostrar); // Imprimir la fecha y hora del mensaje programado en la consola

                // Verificar el ID del mensaje
                console.log('ID del mensaje:', idMensaje); // Verificar el ID del mensaje en la consola

                // Si la fecha y hora actual es mayor o igual a la fecha y hora del mensaje programado, mostrar el mensaje modal
                if (now >= fechaMostrar) {
                    // Crear un objeto de audio y reproducir el sonido
                    var audio = new Audio('airport-bell.mp3');
                    audio.play();

                    // Mostrar el mensaje modal
                    Swal.fire({
                        title: mensaje.titulo,
                        html: mensaje.contenido,
                        icon: 'info',
                        showConfirmButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirigir a modificar_msg.php después de hacer clic en OK
                            window.location.href = 'modificar_msg.php?id=' + idMensaje;
                        }
                    });
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            // Mostrar un mensaje de error si ocurre un problema al obtener los mensajes
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al obtener los mensajes programados. Por favor, inténtalo de nuevo más tarde.'
            });
        });
    }

    // Llamar a la función al cargar la página
    obtenerYMostrarMensajes();

    // Actualizar los mensajes programados cada minuto
    setInterval(obtenerYMostrarMensajes, 60000);

    // Actualizar la hora cada segundo
    setInterval(mostrarFechaHora, 1000);

</script>


</body>
</html>