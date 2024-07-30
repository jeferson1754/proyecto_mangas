<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>

    <style>
        .status-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
            text-align: center;
            display: flex;
            align-items: center;
            position: fixed;
            top: 50%;
            right: -350px;
            /* Start off-screen */
            transform: translateY(-50%);
            transition: right 0.5s ease;

            z-index: 10;
        }

        .status {
            width: 10%;
            height: 20px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .activo {
            background-color: #28a745;
            /* Verde */
        }


        .finalizado {
            background-color: #dc3545;
            /* Rojo */
        }

        .status-text {
            font-weight: bold;
            font-size: 16px;
        }

        .toggle-button {
            width: 10%;
            height: 20%;
            max-width: 40px;
            max-height: 120px;
            /* Ajuste para móviles */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            font-size: 20px;
            /* Ajustar tamaño de fuente para móviles */
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            text-align: center;
        }

        .show {
            right: 80px;
            /* Position inside the screen */
        }

        @media (max-width: 600px) {
            .toggle-button {

                /* Ajustar el tamaño del botón en pantallas pequeñas */
                font-size: 18px;
                /* Ajustar el tamaño de fuente */
            }

            .status-container {
                width: 50%;
                padding: 15px;
            }

            .status {
                width: 30px;
            }
        }
    </style>
</head>

<?php

date_default_timezone_set('America/Santiago');

$max_queries_per_hour = 1;

$current_time = date("Y-m-d H:i:s");
$Hoy = date("Y-m-d");

// Consultamos el número de consultas realizadas en la última hora
$query = "
    SELECT COUNT(*) AS num_queries, MAX(Fecha) AS ultima_actualizacion 
    FROM actualizaciones_webtoon 
    WHERE Fecha > DATE_SUB(NOW(), INTERVAL 1 HOUR);
";

$result = mysqli_query($conexion, $query);
if (!$result) {
    die("La consulta falló: " . mysqli_error($conexion));
}

$row = mysqli_fetch_assoc($result);
$num_queries_last_hour = $row['num_queries'];
$ultima_actualizacion = $row['ultima_actualizacion'];

mysqli_free_result($result);

// Formatear la fecha y hora de la última actualización a "HH:MM"
if ($ultima_actualizacion) {
    $datetime = new DateTime($ultima_actualizacion);
    $formatted_time = $datetime->format('H:i');
    $new_time = $datetime->format('Y-m-d');
} else {
    $formatted_time = "No disponible"; // Manejo de caso donde no haya actualizaciones
    $new_time = "";
}




// Obtenemos el día actual
$sql1 = "SELECT CASE WEEKDAY(CURDATE()) 
             WHEN 0 THEN 'Lunes'
             WHEN 1 THEN 'Martes'
             WHEN 2 THEN 'Miercoles'
             WHEN 3 THEN 'Jueves'
             WHEN 4 THEN 'Viernes'
             WHEN 5 THEN 'Sabado'
             WHEN 6 THEN 'Domingo'
          END AS DiaActual";
$date = mysqli_query($conexion, $sql1);
$day = mysqli_fetch_assoc($date)['DiaActual'];
mysqli_free_result($date);

// Consultamos el número de webtoons en emisión para el día actual
$consulta = "SELECT COUNT(*) AS count FROM `webtoon` WHERE `Dias Emision`='$day' AND Estado='Emision'";
$result = mysqli_query($conexion, $consulta);
$count = mysqli_fetch_assoc($result)['count'];
mysqli_free_result($result);

// Si se han superado las consultas permitidas, lanzamos un error
if ($count >= 1 && $num_queries_last_hour < $max_queries_per_hour) {
    $query = "INSERT INTO actualizaciones_webtoon (Fecha) VALUES ('$current_time')";
    mysqli_query($conexion, $query);

    $sql = "UPDATE `webtoon` SET `Capitulos Totales` = `Capitulos Totales` + 1 WHERE `Dias Emision`='$day' AND Estado='Emision'";
    mysqli_query($conexion, $sql);

    $sql2 = "UPDATE `webtoon` SET `Faltantes` = `Capitulos Totales` - `Capitulos Vistos`";
    mysqli_query($conexion, $sql2);
}

if ($new_time == $Hoy) {
    $text = "Hoy se actualizo a las " . $formatted_time;
    $estatus = "activo";
} else  if ($new_time == "") {
    $text = "No se actualizo";
    $estatus = "finalizado";
}

?>
<button class="toggle-button" onclick="toggleVisibility('estado-card', this)">
    <i class='fa-solid fa-chevron-left'></i>
</button>

<div class="status-container" id="estado-card">
    <div class="status <?php echo $estatus ?>"></div>
    <div class="status-text"><?php echo $text ?></div>
</div>

<script>
    function toggleVisibility(id, button) {
        var element = document.getElementById(id);
        if (element.classList.contains("show")) {
            element.classList.remove("show");
            button.innerHTML = "<i class='fa-solid fa-chevron-left'></i>";
        } else {
            element.classList.add("show");
            button.innerHTML = "<i class='fa-solid fa-chevron-right'></i>";
        }
    }
</script>