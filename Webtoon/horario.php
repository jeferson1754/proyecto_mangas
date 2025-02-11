<?php
require 'bd.php';

// Obtener la última temporada y año
$num_query = "SELECT * FROM `num_horario` ORDER BY `num_horario`.`Num` DESC LIMIT 1";
$num_result = mysqli_query($conexion, $num_query);
$mostrar = mysqli_fetch_array($num_result);
$temp = strtoupper($mostrar['Temporada']);
$ano = $mostrar['Ano'];

// Días de la semana
$dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

// Array para almacenar los resultados
$resultados = [];
$resultados2 = [];

// Consultas y resultados en un solo ciclo
foreach ($dias as $dia) {
    // Obtener los nombres de los webtoons y el conteo
    $consulta = "SELECT Nombre, `Dias Emision` 
                 FROM `webtoon` 
                 WHERE Estado='Emision' AND `Dias Emision` LIKE '%$dia%' 
                 ORDER BY LENGTH(Nombre) DESC";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        // Guardar los resultados
        $resultados[$dia] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    } else {
        echo "Error en la consulta para $dia";
    }
}

// Consulta para obtener el total de Webtoons
$consulta_total = "SELECT COUNT(*) AS Total_Registros FROM webtoon WHERE Estado='Emisión' AND `Dias Emision`!='Indefinido'";
$resultado_total = mysqli_query($conexion, $consulta_total);
$final_webtoon = mysqli_fetch_assoc($resultado_total)['Total_Registros'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/horarios.css?v=<?php echo time(); ?>">
    <title>Horario Webtoon</title>
</head>

<body>

    <?php include('../menu.php'); ?>

    <div class="col-sm">
        <div class="auto-style12" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 22px; font-weight: bold;">
            <?php echo $ano . " " . $temp; ?>
        </div>
        <div class="auto-style11">
            <span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 62px;">HORARIO DE WEBTOON</span>
        </div>
    </div>

    <div class="main-container">
        <table>
            <?php foreach ($dias as $dia) {
                $resultadosDia = $resultados[$dia] ?? [];

                if (!empty($resultadosDia)) {
                    echo "<tr><td rowspan='" . count($resultadosDia) . "' class='auto-style3 $dia'>
                            <div class='auto-style8'>$dia</div></td>";

                    foreach ($resultadosDia as $mostrar) {
                        echo "<td>{$mostrar['Nombre']}</td></tr>";
                    }
                }
            } ?>
        </table>
    </div>

    <div class="contenedor-flex">
        <?php foreach ($dias as $dia) {
            $resultadosDia = $resultados[$dia] ?? [];

            if (!empty($resultadosDia)) {
                echo "<article class='base'><header class='$dia'>$dia</header>";

                foreach ($resultadosDia as $mostrar) {
                    echo "<div class='borde'>{$mostrar['Nombre']}</div>";
                }

                echo "</article>";
            }
        } ?>
    </div>

    <div style="text-align: center;">
        <h2 class="auto-style14">Total Webtoon Semana: <?php echo $final_webtoon ?> </h2>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conexion = null;
?>