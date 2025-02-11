<?php
require 'bd.php';

// Obtener la hora actual
$hora_actual = date('H:i:s');

// Validar la variable GET
$variable = isset($_GET['variable']) ? urldecode($_GET['variable']) : null;

if ($variable) {
    // Consulta principal del manga
    $consulta1 = $conexion->prepare("SELECT * FROM `manga` WHERE ID = ?");
    $consulta1->bind_param("i", $variable);
    $consulta1->execute();
    $resultado1 = $consulta1->get_result();

    if ($fila1 = $resultado1->fetch_assoc()) {
        $titulo = $fila1['Nombre'];
        $enlace = $fila1['Link'];
        $verif  = $fila1['verificado'];
    }

    // Consulta para el día más repetido y promedio de diferencias
    $sql = "SELECT Dia, COUNT(*) AS Cantidad, (SELECT AVG(Diferencia) FROM diferencias WHERE ID_Manga = ?) AS PromedioGeneral 
            FROM diferencias WHERE ID_Manga = ? GROUP BY Dia ORDER BY Cantidad DESC LIMIT 1";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $variable, $variable);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $diaMasRepetido = $row["Dia"];
        $cantidadRepeticiones = $row["Cantidad"];
        $promedioRedondeado = round($row["PromedioGeneral"]);

        // Determinar la frecuencia
        switch (true) {
            case $promedioRedondeado <= 7:
                $frecuencia = "Semanal";
                break;
            case $promedioRedondeado <= 15:
                $frecuencia = "Quincenal";
                break;
            case $promedioRedondeado <= 30:
                $frecuencia = "Mensual";
                break;
            case $promedioRedondeado <= 90:
                $frecuencia = "Trimestral";
                break;
            default:
                $frecuencia = "Indefinido";
        }
    } else {
        $diaMasRepetido = "No disponible";
        $cantidadRepeticiones = 0;
        $frecuencia = "Indefinido";
    }

    // Consulta para obtener diferencias ordenadas por fecha
    $sql1 = "SELECT * FROM `diferencias` WHERE ID_Manga = ? ORDER BY `Fecha` DESC";
    $stmt = $conexion->prepare($sql1);
    $stmt->bind_param("i", $variable);
    $stmt->execute();
    $result = $stmt->get_result();

    // Consulta para datos del gráfico
    $sql2 = "SELECT Fecha, Diferencia FROM `diferencias` WHERE ID_Manga = ? ORDER BY `Fecha` DESC";
    $stmt = $conexion->prepare($sql2);
    $stmt->bind_param("i", $variable);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Arrays para almacenar los datos del gráfico
    $labels = [];
    $data = [];

    while ($fila = $resultado->fetch_assoc()) {
        $labels[] = $fila['Fecha'];
        $data[] = $fila['Diferencia'];
    }
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>


    <link rel="stylesheet" type="text/css" href="./css/barra.css?v=<?php echo time(); ?>">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f5f6fa;
            --accent-color: #2ecc71;
            --text-color: #2c3e50;
        }

        body {
            background-color: var(--secondary-color);
            color: var(--text-color);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .manga-header {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .manga-title {
            color: var(--text-color);
            font-size: 2rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .manga-title a {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        .manga-title a:hover {
            color: var(--primary-color);
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 400px;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table th {
            background-color: var(--secondary-color);
            padding: 1rem;
            font-weight: 600;
        }

        .custom-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        .action-btn {
            padding: 0.5rem;
            border-radius: 8px;
            border: none;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }

        .edit-btn {
            background-color: var(--primary-color);
            color: white;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        .verified-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: var(--accent-color);
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            gap: 0.5rem;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }

            .table-container {
                overflow-x: auto;
            }

            .manga-title {
                font-size: 1.5rem;
            }
        }

        /* Modal styles */
        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem;
        }

        .verification-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .verification-badge {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .verified {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .not-verified {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Switch Toggle */
        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            transform: translateX(14px);
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Manga Header -->
        <div class="manga-header text-center">
            <h1 class="manga-title">
                <a href="<?php echo $enlace ?>" target="_blank">
                    <?php echo $titulo ?>
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </h1>
        </div>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <h3><i class="fas fa-calendar-alt me-2"></i>Día más común</h3>
                <p class="h2 mb-0"><?php echo $diaMasRepetido ?></p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-clock me-2"></i>Frecuencia</h3>
                <p class="h2 mb-0"><?php echo $frecuencia ?></p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-chart-bar me-2"></i>Repeticiones</h3>
                <p class="h2 mb-0"><?php echo $cantidadRepeticiones ?></p>
            </div>
        </div>

        <!-- Chart -->
        <div class="chart-container">
            <div id="chart-container" style="height: 100%;"></div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Diferencia</th>
                        <th>Día</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($mostrar = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?php echo $mostrar['Fecha'] ?></td>
                            <td><?php echo $mostrar['Diferencia'] ?></td>
                            <td><?php echo $mostrar['Dia'] ?></td>
                            <td>
                                <button class="action-btn edit-btn" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $mostrar['ID'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $mostrar['ID'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Verified Badge -->
        <div class="verified-badge">
            <i class="fas fa-check-circle"></i>
            Verificado
        </div>

        <div class="verification-container">
            <div class="verification-badge <?php echo ($verif == 'SI') ? 'verified' : 'not-verified'; ?>">
                <i class="fas <?php echo ($verif == 'SI') ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                <?php echo ($verif == 'SI') ? 'Verificado' : 'No Verificado'; ?>
            </div>

            <form action="verif.php" method="GET">
                <div class="toggle-container">
                    <label class="switch">
                        <input type="checkbox" name="checkbox" value="SI" <?php echo ($verif == "SI") ? "checked" : ""; ?>>
                        <span class="slider round"></span>
                    </label>
                </div>

                <input type="hidden" name="id_manga" value="<?php echo $variable ?>">
                <input type="hidden" name="nombre" value="<?php echo $titulo ?>">
                <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $variable ?>">

                <button type="submit" class="btn btn-<?php echo ($verif == 'SI') ? 'success' : 'danger'; ?>" name="verif">
                    Guardar
                </button>
            </form>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Configuración del gráfico
        var chartDom = document.getElementById('chart-container');
        var myChart = echarts.init(chartDom);
        var option = {
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
                data: <?php echo json_encode($labels) ?>,
                axisTick: {
                    alignWithLabel: true
                },
                axisLabel: {
                    rotate: 45
                }
            }],
            yAxis: [{
                type: 'value',
                name: 'Diferencia'
            }],
            series: [{
                name: 'Diferencia',
                type: 'bar',
                barWidth: '60%',
                data: <?php echo json_encode($data) ?>,
                itemStyle: {
                    color: '#4a90e2'
                }
            }]
        };

        myChart.setOption(option);

        // Hacer el gráfico responsivo
        window.addEventListener('resize', function() {
            myChart.resize();
        });
    </script>
</body>

</html>