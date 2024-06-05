<!-- Tu código HTML -->
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css?v=<?php echo time(); ?>">
    <style>
        .inline-input {
            display: inline-block;
            width: 54% !important;
        }

        .inline-boton {
            display: inline-block;
            width: 45% !important;
        }

        .boton {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            color: white;
            background-color: #171717;
            padding: 0.6em;
            border: none;
            border-radius: .6rem;
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }

        .boton span:not(:nth-child(6)) {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            height: 70px;
            width: 70px;
            background-color: #0c66ed;
            border-radius: 50%;
            transition: .6s ease;
        }

        .boton span:nth-child(6) {
            position: relative;
        }

        .boton span:nth-child(1) {
            transform: translate(-3.3em, -4em);
        }

        .boton span:nth-child(2) {
            transform: translate(-6em, 1.3em);
        }

        .boton span:nth-child(3) {
            transform: translate(-.2em, 1.8em);
        }

        .boton span:nth-child(4) {
            transform: translate(3.5em, 1.4em);
        }

        .boton span:nth-child(5) {
            transform: translate(3.5em, -3.8em);
        }

        .boton:hover span:not(:nth-child(6)) {
            transform: translate(-50%, -50%) scale(4);
            transition: 1.5s ease;
        }

        .form-control {
            font-size: 1rem;
            height: auto;
        }

        body {
            margin-top: -20px;
        }

        @media screen and (max-width: 400px) {

            .form-control {
                width: 100% !important;
                height: 60px;
                font-size: 1.8rem;
            }

        }
    </style>
</head>

<body>
    <?php
    require 'bd.php';

    if (isset($_GET['variable'])) {
        $variable = urldecode($_GET['variable']);
        //echo "La variable recibida es: " . $variable;
    }
    $sql1 = "SELECT * FROM `manga` WHERE ID='$variable' ORDER BY `manga`.`Fecha_Cambio1` DESC limit 1";

    $result = mysqli_query($conexion, $sql1);
    //echo $sql1;

    while ($mostrar = mysqli_fetch_array($result)) {
    ?>
        <br>
        <!-- Input para la fecha actual -->
        <!-- ... resto del código ... -->
        <div class="form-group">
            <!-- Input para la fecha actual -->
            <label for="date1-<?php echo $mostrar['ID']; ?>" class="col-form-label">Fecha de Ultima Actualizacion:</label><br>
            <input type="date" id="date1-<?php echo $mostrar['ID']; ?>" style="width:50%" value="<?php echo $mostrar["Fecha_Cambio1"]; ?>" class="inline-input form-control">

            <button type="button" class="inline-boton boton cambiar-fecha" data-id="<?php echo $mostrar['ID']; ?>">
                <span class="circle1"></span>
                <span class="circle2"></span>
                <span class="circle3"></span>
                <span class="circle4"></span>
                <span class="circle5"></span>
                <span class="text">Intercambiar Fechas</span>
            </button>

        </div>
        <!-- Input para la fecha de destino -->
        <div class="form-group">
            <label for="date2-<?php echo $mostrar['ID']; ?>" class="col-form-label">Fecha de Penultimo Capitulo:</label>
            <input type="date" id="date2-<?php echo $mostrar['ID']; ?>" value="<?php echo $mostrar["Fecha_Cambio2"]; ?>" class="form-control">
        </div>
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

                //if (state === '0') {
                // Si el estado es 0, intercambiar las fechas
                fechaInput2.value = fechaInput1.value;
                //this.setAttribute('data-state', '1');
                //} else {
                // Si el estado no es 0 (es 1), asignar la fecha actual a "date1"
                fechaInput1.value = fechaActualFormatted;
                //this.setAttribute('data-state', '0');
                //}
            });
        }
    </script>

    <!-- ... resto del código ... -->


</body>

</html>