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
    $sql1 = "SELECT * FROM `diferencias` WHERE ID_Manga = ? ORDER BY `Fecha` DESC limit 50";
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

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <link rel="stylesheet" type="text/css" href="./css/barra.css?v=<?php echo time(); ?>">
    <!-- Bootstrap JS y jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="dashboard-container">
        <!-- Nombre -->
        <div class="manga-title">
            <h2>
                <a href="<?php echo $enlace ?>" target="_blank" style="text-decoration: none; color: inherit;">
                    <?php echo $titulo ?>
                    <i class="fas fa-external-link-alt" style="font-size: 0.7em; margin-left: 10px;"></i>
                </a>
            </h2>
        </div>

        <!-- Contenido Principal -->
        <div class="main-content">
            <!-- Gráfico -->
            <div class="chart-container">
                <div id="chart-container" style="height: 100%;"></div>
            </div>

            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-card">
                    <h3><i class="fas fa-calendar-alt me-2"></i>Día más común:</h3>
                    <p class="h2 mb-0"><?php echo $diaMasRepetido ?></p>
                </div>
                <div class="stat-card">
                    <h3><i class="fas fa-chart-bar me-2"></i>Repeticiones:</h3>
                    <p class="h2 mb-0"><?php echo $cantidadRepeticiones ?></p>
                </div>
                <div class="stat-card">
                    <h3><i class="fas fa-clock me-2"></i>Frecuencia:</h3>
                    <p class="h2 mb-0"><?php echo $frecuencia ?></p>
                </div>
            </div>
        </div>

        <!-- Tabla -->


        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Diferencia</th>
                        <th>Día</th>
                        <th class="actions-cell">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($mostrar = mysqli_fetch_array($result)) {
                        $id = $mostrar['ID']; ?>
                        <tr>
                            <td class="fecha"><?php echo $mostrar['Fecha'] ?></td>
                            <td><?php echo $mostrar['Diferencia'] ?></td>
                            <td><?php echo $mostrar['Dia'] ?></td>
                            <td class="actions-cell">
                                <button
                                    class="action-btn edit-btn" title="Editar" data-bs-toggle="modal" data-bs-target="#edit-dif<?php echo $id; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn" title="Eliminar" data-bs-toggle="modal" data-bs-target="#dif<?php echo $id; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                        include('Modal-Diferencias.php');
                        include('Modal-EditDiferencias.php');
                    } ?>
                </tbody>
            </table>
        </div>
    </div>



    <div class="verification-container">
        <div class="verification-badge <?php echo ($verif == 'SI') ? 'verified' : 'not-verified'; ?>">
            <i class="fas <?php echo ($verif == 'SI') ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
            <?php echo ($verif == 'SI') ? 'Verificado' : 'No Verificado';
            $display = ($verif == 'SI') ? "none" : "fixed";
            ?>
        </div>

        <form action="verif.php" method="GET" style="display:<?php echo $display ?>">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

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