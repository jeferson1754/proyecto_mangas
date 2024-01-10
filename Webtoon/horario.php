<?php

require 'bd.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/horarios.css">
    <title>Horario Webtoon
    </title>
</head>

<body>

    <?php
    include('../menu.php');

    // Obtener el último registro de num_horario
    $query = "SELECT Temporada, Ano FROM num_horario ORDER BY Num DESC LIMIT 1";
    $resultado = mysqli_query($conexion, $query);

    // Verificar si hay resultados
    if ($mostrar = mysqli_fetch_assoc($resultado)) {
        // Obtener los valores
        $temp = $mostrar['Temporada'];
        $ano = $mostrar['Ano'];

        // Convertir a mayúsculas
        $mayusculas = strtoupper($temp);

        // Puedes utilizar $mayusculas y $ano según tus necesidades
    } else {
        // Manejar errores si es necesario
        echo "No se encontraron resultados";
    }

    // Liberar memoria del resultado
    mysqli_free_result($resultado);

    ?>

    <div class="col-sm">

        <!--- Formulario para registrar Cliente --->
        <div class="auto-style12" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 22px; font-weight: bold;"><?php echo $ano . " " . $mayusculas; ?></div>
        <div class="auto-style11"><span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 62px; ">HORARIO DE WEBTOON</span></div>
    </div>

    <div class="main-container">

        <table>

            <?php

            // Días de la semana
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

            // Array para almacenar los resultados
            $resultados2 = [];

            // Consultas y resultados
            foreach ($dias as $dia) {
                $consulta = "SELECT COUNT(`Dias Emision`), `Dias Emision` FROM webtoon WHERE `Dias Emision`='$dia' AND Estado='Emision';";
                $resultado = mysqli_query($conexion, $consulta);

                // Verificar si hay resultados
                if ($resultado) {
                    // Guardar los resultados en el array
                    $resultados2[$dia] = $resultado;
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


            //Lunes
            $LunesResultados = mysqli_fetch_all($resultados['Lunes'], MYSQLI_ASSOC);
            $LunesResultados2 = mysqli_fetch_all($resultados2['Lunes'], MYSQLI_ASSOC);

            // Verificar si hay resultados
            if (!empty($LunesResultados) && !empty($LunesResultados2)) {
                // Iterar sobre los resultados
                foreach ($LunesResultados2 as $mostrar2) {
            ?>
                    <tr>
                        <td rowspan="<?php echo $mostrar2['COUNT(`Dias Emision`)'] ?>" class="auto-style3">
                            <div class="auto-style8"><?php echo $mostrar2['Dias Emision'] ?></div>
                        </td>
                    <?php
                }

                // Iterar sobre los resultados
                foreach ($LunesResultados as $mostrar) {
                    ?>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                    </tr>
                <?php
                }
            } //Fin Lunes

            //Martes


            $MartesResultados = mysqli_fetch_all($resultados['Martes'], MYSQLI_ASSOC);
            $MartesResultados2 = mysqli_fetch_all($resultados2['Martes'], MYSQLI_ASSOC);

            // Verificar si hay resultados
            if (!empty($MartesResultados) && !empty($MartesResultados2)) {
                // Iterar sobre los resultados
                foreach ($MartesResultados2 as $mostrar2) {
                ?>
                    <tr>
                        <td rowspan="<?php echo $mostrar2['COUNT(`Dias Emision`)'] ?>" class="auto-style9" style="background-color: #B9CDD9">
                            <div class="auto-style8"><?php echo $mostrar2['Dias Emision'] ?></div>
                        </td>
                    <?php
                }

                // Iterar sobre los resultados
                foreach ($MartesResultados as $mostrar) {
                    ?>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                    </tr>
            <?php
                }
            } //Fin Martes

            ?>


            <?php

            //Miercoles
            $MiercolesResultados = mysqli_fetch_all($resultados['Miercoles'], MYSQLI_ASSOC);
            $MiercolesResultados2 = mysqli_fetch_all($resultados2['Miercoles'], MYSQLI_ASSOC);

            // Verificar si hay resultados
            if (!empty($MiercolesResultados) && !empty($MiercolesResultados2)) {
                // Iterar sobre los resultados
                foreach ($MiercolesResultados2 as $mostrar2) {
            ?>
                    <tr>
                        <td rowspan="<?php echo $mostrar2['COUNT(`Dias Emision`)'] ?>" class="auto-style3" style="background-color: #EBC6C8">
                            <div class="auto-style8"><?php echo $mostrar2['Dias Emision'] ?></div>
                        </td>
                    <?php
                }

                // Iterar sobre los resultados
                foreach ($MiercolesResultados as $mostrar) {
                    ?>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                    </tr>
                <?php
                }
            } //Fin Miercoles

            //Jueves
            $JuevesResultados = mysqli_fetch_all($resultados['Jueves'], MYSQLI_ASSOC);
            $JuevesResultados2 = mysqli_fetch_all($resultados2['Jueves'], MYSQLI_ASSOC);

            // Verificar si hay resultados
            if (!empty($JuevesResultados) && !empty($JuevesResultados2)) {
                // Iterar sobre los resultados
                foreach ($JuevesResultados2 as $mostrar2) {
                ?>
                    <tr>
                        <td rowspan="<?php echo $mostrar2['COUNT(`Dias Emision`)'] ?>" class="auto-style3" style="background-color: #E4B1C2">
                            <div class="auto-style8"><?php echo $mostrar2['Dias Emision'] ?></div>
                        </td>
                    <?php
                }

                // Iterar sobre los resultados
                foreach ($JuevesResultados as $mostrar) {
                    ?>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                    </tr>
                <?php
                }
            }  //Fin Jueves


            //Viernes
            $ViernesResultados = mysqli_fetch_all($resultados['Viernes'], MYSQLI_ASSOC);
            $ViernesResultados2 = mysqli_fetch_all($resultados2['Viernes'], MYSQLI_ASSOC);

            // Verificar si hay resultados
            if (!empty($ViernesResultados) && !empty($ViernesResultados2)) {
                // Iterar sobre los resultados
                foreach ($ViernesResultados2 as $mostrar2) {
                ?>
                    <tr>
                        <td rowspan="<?php echo $mostrar2['COUNT(`Dias Emision`)'] ?>" class="auto-style3" style="background-color: #BFD5FD">
                            <div class="auto-style8"><?php echo $mostrar2['Dias Emision'] ?></div>
                        </td>
                    <?php
                }

                // Iterar sobre los resultados
                foreach ($ViernesResultados as $mostrar) {
                    ?>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                    </tr>
                <?php
                }
            } //Fin Viernes

            //Sabado
            $SabadoResultados = mysqli_fetch_all($resultados['Sabado'], MYSQLI_ASSOC);
            $SabadoResultados2 = mysqli_fetch_all($resultados2['Sabado'], MYSQLI_ASSOC);

            // Verificar si hay resultados
            if (!empty($SabadoResultados) && !empty($SabadoResultados2)) {
                // Iterar sobre los resultados
                foreach ($SabadoResultados2 as $mostrar2) {
                ?>
                    <tr>
                        <td rowspan="<?php echo $mostrar2['COUNT(`Dias Emision`)'] ?>" class="auto-style3" style="background-color: #75E7FD">
                            <div class="auto-style8"><?php echo $mostrar2['Dias Emision'] ?></div>
                        </td>
                    <?php
                }

                // Iterar sobre los resultados
                foreach ($SabadoResultados as $mostrar) {
                    ?>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                    </tr>
                <?php
                }
            }

            //Fin Sabado

            //Domingo
            $domingoResultados = mysqli_fetch_all($resultados['Domingo'], MYSQLI_ASSOC);
            $domingoResultados2 = mysqli_fetch_all($resultados2['Domingo'], MYSQLI_ASSOC);

            // Verificar si hay resultados
            if (!empty($domingoResultados) && !empty($domingoResultados2)) {
                // Iterar sobre los resultados
                foreach ($domingoResultados2 as $mostrar2) {
                ?>
                    <tr>
                        <td rowspan="<?php echo $mostrar2['COUNT(`Dias Emision`)'] ?>" class="auto-style3" style="background-color: #E1FDD1">
                            <div class="auto-style8"><?php echo $mostrar2['Dias Emision'] ?></div>
                        </td>
                    <?php
                }

                // Iterar sobre los resultados
                foreach ($domingoResultados as $mostrar) {
                    ?>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                    </tr>
            <?php
                }
            }

            ?>


        </table>
    </div>
    <div style="text-align: center;">
        <h2 class="auto-style14">Total Webtoon Semana : <?php echo $final_webtoon ?> </h2>
    </div>
    <br>
    <br>
</body>
<?php

foreach ($resultados as $resultado) {
    mysqli_free_result($resultado);
}

foreach ($resultados2 as $resultado) {
    mysqli_free_result($resultado);
}

$conexion = null;
?>

</html>