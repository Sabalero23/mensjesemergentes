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
    <title>Mensajes Programados</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'mostrar_msg.php'; ?>

<div class="container mt-4">
    <div class="text-center mb-4">
        <button class="btn btn-primary" data-toggle="modal" data-target="#crearMensajeModal">Crear Mensaje</button>
        <a href="modificar_msg.php" class="btn btn-secondary ml-2">Modificar Mensaje</a>
    </div>
</div>

<!-- Modal para crear mensaje -->
<div class="modal fade" id="crearMensajeModal" tabindex="-1" aria-labelledby="crearMensajeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearMensajeModalLabel">Crear Mensaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearMensajeForm">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="contenido">Contenido</label>
                        <textarea class="form-control" id="contenido" name="contenido" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fechaHora">Fecha y Hora de Mostrar</label>
                        <input type="datetime-local" class="form-control" id="fechaHora" name="fechaHora" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- jQuery y Bootstrap JS (para el modal) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Script personalizado para enviar el formulario y crear un nuevo mensaje -->
<script>
    // Cuando se envía el formulario para crear un nuevo mensaje
    $('#crearMensajeForm').submit(function(event) {
        event.preventDefault(); // Evitar envío normal del formulario
        var formData = $(this).serialize(); // Obtener datos del formulario

        // Enviar datos del formulario al servidor
        $.ajax({
            type: 'POST',
            url: 'guardar_msg.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Mensaje Creado',
                    text: 'El mensaje se ha creado correctamente.'
                });
                // Cerrar el modal
                $('#crearMensajeModal').modal('hide');
                // Limpiar el formulario
                $('#crearMensajeForm')[0].reset();
            },
            error: function(xhr, status, error) {
                // Mostrar mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al crear el mensaje. Por favor, inténtalo de nuevo.'
                });
            }
        });
    });
</script>

</body>
</html>