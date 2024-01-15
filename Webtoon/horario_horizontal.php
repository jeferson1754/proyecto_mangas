<?php
require 'bd.php';

// Obtener la última temporada y año
$num_query = "SELECT * FROM `num_horario` ORDER BY `num_horario`.`Num` DESC LIMIT 1";
$num_result = mysqli_query($conexion, $num_query);

while ($mostrar = mysqli_fetch_array($num_result)) {
    $temp = strtoupper($mostrar['Temporada']);
    $ano = $mostrar['Ano'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css?v=<?php echo time(); ?>"">
    <link rel=" stylesheet" href="../css/horarios.css?v=<?php echo time(); ?>">
    <title>Horario Webtoon</title>

</head>


<body>
    <?php include('../menu.php'); ?>

    <div class="col-sm">
        <div class="auto-style12" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 22px; font-weight: bold;">
            <?php echo $ano . " " . $temp; ?>
        </div>
        <div class="auto-style11"><span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 62px; ">
                <span>HORARIO DE WEBTOON</span>
        </div>
    </div>

    <div class="main-container">
        <?php
        require 'bd.php';

        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        // Inicializar el array para almacenar los resultados
        $resultados = [];

        // Consultas y resultados
        foreach ($dias as $dia) {
            $consulta = "SELECT Nombre, `Dias Emision` FROM `webtoon` WHERE Estado='Emision' AND `Dias Emision`='$dia' ORDER BY LENGTH(Nombre) DESC";
            $resultado = mysqli_query($conexion, $consulta);

            // Verificar si hay resultados
            if ($resultado) {
                // Guardar los resultados en el array
                $resultados[$dia] = $resultado;
            } else {
                // Manejar errores si es necesario
                echo "Error en la consulta para $dia";
            }
        }

        $consulta = "SELECT COUNT(*) AS Total_Registros FROM webtoon WHERE Estado='Emisión' AND `Dias Emision`!='Indefinido';";
        $resultado = mysqli_query($conexion, $consulta);

        // Verificar si hay resultados
        if ($resultado) {
            // Obtener el resultado directamente
            $fila = mysqli_fetch_assoc($resultado);

            // Asignar el valor a la variable
            $final_webtoon = $fila['Total_Registros'];

            // Liberar memoria del resultado
            mysqli_free_result($resultado);
        } else {
            // Manejar errores si es necesario
            echo "Error en la consulta";
        }
        ?>

    </div>

    <div class="contenedor-flex">
        <?php

        $dias = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');

        foreach ($dias as $dia) {
            $resultadosDia = mysqli_fetch_all($resultados[$dia], MYSQLI_ASSOC);

            if (!empty($resultadosDia)) {
                echo "<article class='base'>";
                echo "<header class='$dia'>$dia</header>";

                foreach ($resultadosDia as $mostrar) {
                    echo "<div class='borde'>" . $mostrar['Nombre'] . "</div>";
                }

                echo "</article>";
            }
        }
        ?>
    </div>

    <br><br>
    <div style="text-align: center;">
        <h2 class="auto-style14">Total Webtoon Semana : <?php echo $final_webtoon ?> </h2>
    </div>
</body>

<?php
$conexion = null;
?>

</html>