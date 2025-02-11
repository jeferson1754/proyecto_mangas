<!DOCTYPE html>
<html>


<head>
    <title>Gráfico</title>
    <!-- Incluir la librería Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./css/barra.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php
    $hora_actual = date('H:i:s');
    require 'bd.php';

    if (isset($_GET['variable'])) {
        $variable = urldecode($_GET['variable']);
        //echo "La variable recibida es: " . $variable;
    }
    $consulta1 = "SELECT * FROM `manga` where ID='$variable'";
    $resultado1 = mysqli_query($conexion, $consulta1);
    //echo $consulta1;

    // Consulta SQL para encontrar el día más repetido para el ID_Manga
    $sql = "SELECT Dia, COUNT(*) AS Cantidad, (SELECT AVG(Diferencia) FROM diferencias WHERE ID_Manga = $variable) AS PromedioGeneral FROM diferencias WHERE ID_Manga = $variable GROUP BY Dia ORDER BY Cantidad DESC LIMIT 1;";
    //echo $sql;
    $result = $conexion->query($sql);

    // Verificar si se obtuvieron resultados
    if ($result->num_rows > 0) {
        // Obtener la fila de resultados como un arreglo asociativo
        $row = $result->fetch_assoc();

        // Almacenar el día más repetido y su cantidad en variables PHP
        $diaMasRepetido = $row["Dia"];
        $cantidadRepeticiones = $row["Cantidad"];
        $promedio = $row["PromedioGeneral"];
        $promedioRedondeado = round($promedio);
    } else {
        echo "No se encontraron resultados.";
    }

    if ($promedioRedondeado <= 7) {
        $frecuencia = "Semanal";
    } else if ($promedioRedondeado > 7 && $promedioRedondeado <= 15) {
        $frecuencia = "Quincenal";
    } else if ($promedioRedondeado > 15 && $promedioRedondeado <= 30) {
        $frecuencia = "Mensual";
    } else if ($promedioRedondeado > 30 && $promedioRedondeado <= 90) {
        $frecuencia = "Trimestral";
    } else {
        $frecuencia = "Indefinido";
    }

    while ($fila1 = mysqli_fetch_assoc($resultado1)) {
        $titulo = $fila1['Nombre'];
        $enlace = $fila1['Link'];
        $verif  = $fila1['verificado'];
    }
    ?>
    <a href="<?php echo $enlace ?>" title="<?php echo $titulo ?>" target="_blanck">
        <h1 style="font-family:Segoe UI;font-weight: 600;"> <?php echo $titulo; ?></h1>
    </a>
    <!-- Crear un lienzo para el gráfico -->

    <?php echo "<h3>Dia:$diaMasRepetido - Cantidad:$cantidadRepeticiones - Frecuencia:$frecuencia</h3>"; ?>

    <div class="grafico">
        <div id="chart-container"></div>
    </div>
    <div class="tabla" style="width:50%; margin: 0 auto;">
        <table id="example" class="display">
            <thead>
                <tr>
                    <th style="text-align: center;">Fecha</th>
                    <th style="text-align: center;">Diferencia</th>
                    <th style="text-align: center;">Dia</th>
                    <th style="text-align: center; width:120px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = "SELECT * FROM `diferencias` where ID_Manga='$variable' ORDER BY `diferencias`.`Fecha` DESC";

                $result = mysqli_query($conexion, $sql1);
                echo $sql1;

                while ($mostrar = mysqli_fetch_array($result)) {
                    $id = $mostrar['ID'];
                ?>
                    <tr>
                        <td class="normal"><?php echo $mostrar['Fecha'] ?></td>
                        <td class="normal"><?php echo $mostrar['Diferencia'] ?></td>
                        <td class="normal"><?php echo $mostrar['Dia'] ?></td>

                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-dif<?php echo $id; ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dif<?php echo $id; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>

                    <?php include('Modal-Diferencias.php'); ?>
                    <?php include('Modal-EditDiferencias.php'); ?>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>



    <div class="bottom-right">
        Verificado:
        <?php

        if ($verif == "SI") {
        ?>
            <form action="verif.php" method="GET">
                <div class="todo">

                    <label class="container">
                        <input type="checkbox" name="checkbox" checked value='SI'>

                        <div class="checkmark"></div>
                        <!--
                <span class="text">Etiqueta IP</span>
                -->
                    </label>
                    <input type="hidden" name="id_manga" value="<?php echo $variable ?>">
                    <input type="hidden" name="nombre" value="<?php echo $titulo ?>">
                    <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $variable  ?>">

                </div>
                <button type="submit" class="btn btn-info" name="verif">
                    Guardar
                </button>
            </form>
        <?php
        } else {

        ?>
            <form action="verif.php" method="GET">
                <div class="todo">

                    <label class="container">
                        <input type="checkbox" name="checkbox" value='SI'>

                        <div class="checkmark"></div>
                        <!--
                <span class="text">Etiqueta IP</span>
                -->
                    </label>
                    <input type="hidden" name="id_manga" value="<?php echo $variable ?>">
                    <input type="hidden" name="nombre" value="<?php echo $titulo ?>">
                    <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $variable  ?>">

                </div>
                <button type="submit" class="btn btn-info" name="verif">
                    Guardar
                </button>
            </form>
        <?php
        }

        ?>



    </div>


    <script src="https://echarts.apache.org/en/js/vendors/echarts/dist/echarts.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>

    <?php
    // Consulta SQL para obtener los datos del gráfico
    $consulta = "SELECT Fecha, Diferencia FROM `diferencias` where ID_Manga='$variable' ORDER BY `diferencias`.`Fecha` DESC";
    $resultado = mysqli_query($conexion, $consulta);

    //echo $consulta;

    // Arrays para almacenar los datos del gráfico
    $labels = array();
    $data = array();

    // Obtener los datos de la consulta y almacenarlos en los arrays
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $labels[] = $fila['Fecha'];
        $data[] = $fila['Diferencia'];
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
    ?>

    <script>
        // Obtener los datos del gráfico desde variables PHP
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($data); ?>;

        var dom = document.getElementById('chart-container');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                data: labels,
                axisTick: {
                    alignWithLabel: true
                }
            }],
            yAxis: [{
                type: 'value'
            }],
            series: [{
                name: 'Diferencia',
                type: 'bar',
                barWidth: '60%',
                data: data
            }]
        };

        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }

        window.addEventListener('resize', myChart.resize);
    </script>
</body>

</html>