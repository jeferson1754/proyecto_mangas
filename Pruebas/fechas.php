<!-- Tu código HTML -->
<!DOCTYPE html>
<html>

<head>
    <!-- Resto de las etiquetas de encabezado -->
</head>

<body>
    <?php
    require '../bd.php';
    $sql1 = "SELECT * FROM `manga` ORDER BY `manga`.`Fecha_Cambio1` DESC limit 20";

    $result = mysqli_query($conexion, $sql1);
    echo $sql1;

    while ($mostrar = mysqli_fetch_array($result)) {
    ?>
        <br>
        <!-- Input para la fecha actual -->
        <!-- ... resto del código ... -->

        <!-- Input para la fecha actual -->
        <label for="date1-<?php echo $mostrar['ID']; ?>">Fecha actual:</label>
        <input type="date" id="date1-<?php echo $mostrar['ID']; ?>" value="<?php echo $mostrar["Fecha_Cambio1"]; ?>">

        <!-- Input para la fecha de destino -->
        <label for="date2-<?php echo $mostrar['ID']; ?>">Fecha de destino:</label>
        <input type="date" id="date2-<?php echo $mostrar['ID']; ?>" value="<?php echo $mostrar["Fecha_Cambio2"]; ?>">

        <button class="cambiar-fecha" data-id="<?php echo $mostrar['ID']; ?>">Cambiar fecha</button>

        <!-- ... resto del código ... -->
    <?php
    }
    ?>

    <script>
        // Asignar el evento click a cada botón "cambiar-fecha"
        var buttons = document.getElementsByClassName('cambiar-fecha');
        for (var i = 0; i < buttons.length; i++) {
            // Inicializar el estado a 0 (fecha original)
            buttons[i].setAttribute('data-state', '0');

            buttons[i].addEventListener('click', function(event) {
                event.preventDefault();

                // Obtener el id del registro asociado al botón
                var id = this.getAttribute('data-id');

                // Obtener los valores actuales de "date1" y "date2" para el registro correspondiente
                var fechaInput1 = document.getElementById('date1-' + id);
                var fechaInput2 = document.getElementById('date2-' + id);

                // Obtener la fecha actual en formato "yyyy-MM-dd"
                var fechaActual = new Date();
                var dia = ('0' + fechaActual.getDate()).slice(-2);
                var mes = ('0' + (fechaActual.getMonth() + 1)).slice(-2);
                var anio = fechaActual.getFullYear();
                var fechaActualFormatted = anio + '-' + mes + '-' + dia;

                // Obtener el estado actual del botón
                var state = this.getAttribute('data-state');

                if (state === '0') {
                    // Si el estado es 0, intercambiar las fechas
                    fechaInput2.value = fechaInput1.value;
                    this.setAttribute('data-state', '1');
                } else {
                    // Si el estado no es 0 (es 1), asignar la fecha actual a "date1"
                    fechaInput1.value = fechaActualFormatted;
                    this.setAttribute('data-state', '0');
                }
            });
        }
    </script>

    <!-- ... resto del código ... -->


</body>

</html>

