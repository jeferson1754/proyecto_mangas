<?php

$fechaPenultima = "2023-09-20"; // Reemplaza esto con tu fecha penúltima
$fechaUltima = "2023-09-25";    // Reemplaza esto con tu fecha última

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <label for="">Fecha Ultima</label>
    <input type="date" id="date-ultima" name="date-ultima" value="<?php echo $fechaUltima; ?>">
    <label for="">Fecha Penultima</label>
    <input type="date" id="date-penultima" name="date-penultima" value="<?php echo $fechaPenultima; ?>">

    <button onclick="validarFechas()">Validar Fechas</button>

    <script>
        function validarFechas() {
            // Obtener los elementos de los campos de fecha
            var fechaPenultima = document.getElementById("date-penultima");
            var fechaUltima = document.getElementById("date-ultima");

            // Convertir las fechas en objetos Date
            var fechaPenultimaObj = new Date(fechaPenultima.value);
            var fechaUltimaObj = new Date(fechaUltima.value);

            // Comparar las fechas
            if (fechaPenultimaObj <= fechaUltimaObj) {
                // Si la fecha penúltima es menor o igual, quitar el estilo de borde rojo
                fechaPenultima.style.border = "";
            } else {
                // Si la fecha penúltima es mayor, aplicar el estilo de borde rojo
                fechaPenultima.style.border = "5px solid red";
            }
        }
    </script>

</body>

</html>