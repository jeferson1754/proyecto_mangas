<?php
require 'bd.php';

// --- MÉTRICA 1: Conteo por nivel de diagnóstico ---
$sql_stats = "SELECT 
    SUM(CASE WHEN Dias_Inactividad > (Promedio * 8) THEN 1 ELSE 0 END) as abandonados,
    SUM(CASE WHEN Dias_Inactividad BETWEEN (Promedio * 4) AND (Promedio * 8) THEN 1 ELSE 0 END) as criticos,
    SUM(CASE WHEN Dias_Inactividad BETWEEN (Promedio * 2.2) AND (Promedio * 4) THEN 1 ELSE 0 END) as retrasados
FROM (
    SELECT 
        DATEDIFF(CURDATE(), MAX(d.Fecha)) AS Dias_Inactividad,
        AVG(d.Diferencia) AS Promedio
    FROM manga m
    JOIN diferencias d ON m.ID = d.ID_Manga
    WHERE m.Estado <> 'Finalizado'
    GROUP BY m.ID
    HAVING COUNT(d.ID) >= 5 
       AND DATEDIFF(CURDATE(), MAX(d.Fecha)) > (AVG(d.Diferencia) * 2.2) 
       AND DATEDIFF(CURDATE(), MAX(d.Fecha)) > 30
) as subquery";

$res_stats = $conexion->query($sql_stats);
$stats = $res_stats->fetch_assoc();

// --- MÉTRICA 2: Top 10 Mangas con mayor retraso (para el gráfico de barras) ---
$sql_top_retraso = "SELECT m.Nombre, DATEDIFF(CURDATE(), MAX(d.Fecha)) as Dias 
    FROM manga m JOIN diferencias d ON m.ID = d.ID_Manga 
    WHERE m.Estado <> 'Finalizado' 
    GROUP BY m.ID HAVING COUNT(d.ID) >= 5 
    ORDER BY Dias DESC LIMIT 10";
$res_top = $conexion->query($sql_top_retraso);

// Configuración de paginación
$por_pagina = 10;
$pagina_actual = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;
$offset = ($pagina_actual - 1) * $por_pagina;

// 1. Consulta para contar el TOTAL
$sql_conteo = "SELECT COUNT(*) as total FROM (
    SELECT m.ID FROM manga m
    JOIN diferencias d ON m.ID = d.ID_Manga
    WHERE m.Estado <> 'Finalizado' 
    GROUP BY m.ID
    HAVING COUNT(d.ID) >= 5 
       AND DATEDIFF(CURDATE(), MAX(d.Fecha)) > (AVG(d.Diferencia) * 2.2) 
       AND DATEDIFF(CURDATE(), MAX(d.Fecha)) > 30
) as subconsulta";

$res_conteo = $conexion->query($sql_conteo);
$total_registros = $res_conteo->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $por_pagina);

// 2. Consulta con LIMIT y OFFSET
$sql_riesgo = "SELECT 
    m.ID, m.Nombre, m.Link,m.Estado_Link,
    MAX(d.Fecha) AS Ultima_Publicacion,
    COUNT(d.ID) AS Total_Registros,
    ROUND(AVG(d.Diferencia)) AS Promedio,
    DATEDIFF(CURDATE(), MAX(d.Fecha)) AS Dias_Inactividad
FROM manga m
JOIN diferencias d ON m.ID = d.ID_Manga
WHERE m.Estado <> 'Finalizado' 
GROUP BY m.ID
HAVING Total_Registros >= 5 
   AND Dias_Inactividad > (Promedio * 2.2) 
   AND Dias_Inactividad > 30
ORDER BY Dias_Inactividad DESC
LIMIT $por_pagina OFFSET $offset";

$res_riesgo = $conexion->query($sql_riesgo);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Dashboard - Riesgo</title>


</head>

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Análisis Avanzado de Mangas</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/barra.css?v=<?php echo time(); ?>">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/echarts@6.0.0/dist/echarts.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<style>
    .metric-card {
        border-radius: 12px;
        transition: 0.3s;
        border: none;
    }

    .bg-gradient-dark {
        background: linear-gradient(45deg, #212529, #495057);
    }

    .chart-container {
        height: 400px;
        width: 100%;
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .mb-0 {
        color: white;
    }

    h3 {
        color: white !important;
    }

    .dataTables_filter {
        display: none;
    }
</style>

<body class="bg-light">
    <div class="container py-4">

        <div class="table-container mt-4">
            <div class="mb-5">

                <!-- TÍTULO PRINCIPAL -->
                <h1 class="text-danger fw-bold mb-4 text-center" style="font-size: xx-large !important;">
                    <i class="fas fa-exclamation-triangle me-3"></i>
                    Mangas en Riesgo
                </h1>

                <!-- DETALLES INFERIORES -->
                <div class="d-flex justify-content-between align-items-center">

                    <!-- IZQUIERDA -->
                    <div>
                        <span class="badge bg-danger fs-6 px-3 py-2">
                            <?php echo $total_registros; ?> en total
                        </span>
                    </div>

                    <!-- DERECHA -->
                    <div>
                        <a href="/Manga/" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>

                </div>

            </div>


            <table id="tabla-riesgo" class="table table-striped custom-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Manga</th>
                        <th>Última Actividad</th>
                        <th>Retraso Actual</th>
                        <th>Diagnóstico</th>
                        <th class="actions-cell text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($m = $res_riesgo->fetch_assoc()):
                        $retraso = $m['Dias_Inactividad'];
                        $promedio = $m['Promedio'];
                        $es_critico = ($retraso > $promedio * 5);
                        $clase_alerta = $es_critico ? "text-danger fw-bold" : "text-warning";
                    ?>
                        <tr class="manga-row cursor-pointer hover:bg-blue-50" data-name="<?= $m['Nombre'] ?>">
                            <td><strong><a href="<?php echo $m["Link"] ?>" title="<?php echo $m["Estado_Link"] ?>" target="_blanck" class="link" style="text-decoration: none; color:black"><?php echo $m["Nombre"] ?></a></strong></td>
                            <td><?php echo date("d/m/Y", strtotime($m['Ultima_Publicacion'])); ?></td>
                            <td class="<?php echo $clase_alerta; ?>"><?php echo $retraso; ?> días</td>
                            <td>
                                <span class="badge <?php echo $es_critico ? 'bg-danger' : 'bg-warning text-dark'; ?>">
                                    <?php echo $es_critico ? "Crítico" : "Retrasado"; ?>
                                </span>
                            </td>
                            <td class="actions-cell text-center">
                                <a href="ejemplo-barra.php?variable=<?php echo $m['ID']; ?>" class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                    <i class="fas fa-chart-bar" style="transform: rotate(270deg);"></i>


                                </a>
                                <a href="./?busqueda_manga=<?php echo $m['Nombre']; ?>&todos=&capitulos=&estado=&buscar=" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-search-plus"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if ($total_paginas > 1): ?>
                <nav aria-label="Navegacion" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?p=<?php echo $pagina_actual - 1; ?>">Anterior</a>
                        </li>
                        <li class="page-item disabled">
                            <span class="page-link text-dark">Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?></span>
                        </li>
                        <li class="page-item <?php echo ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?p=<?php echo $pagina_actual + 1; ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>



        <div class="row mb-4 text-white text-center">
            <div class="col-md-4 mb-4 ">
                <div class="card metric-card bg-gradient-dark p-3">
                    <h3><?php echo $stats['abandonados'] ?? 0; ?></h3>
                    <p class="mb-0"><i class="fas fa-skull-crossbones"></i> Abandonados</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 ">
                <div class="card metric-card bg-danger p-3">
                    <h3><?php echo $stats['criticos'] ?? 0; ?></h3>
                    <p class="mb-0"><i class="fas fa-exclamation-triangle"></i> Críticos</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 ">
                <div class="card metric-card bg-warning text-dark p-3">
                    <h3><?php echo $stats['retrasados'] ?? 0; ?></h3>
                    <p class="mb-0"><i class="fas fa-clock"></i> Retrasados</p>
                </div>
            </div>
        </div>

        <?php include 'graficos/catalogo.php';


        include 'graficos/dispersion.php';


        //include 'graficos/graficos.php'; 

        include 'graficos/mapa_calor.php';

        ?>

        <div class="row mt-3">
            <div class="col-lg-8">
                <div class="chart-container">
                    <h5>Top 10 Retrasos Actuales (Días)</h5>
                    <div id="barChart" style="height: 330px;"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chart-container text-center">
                    <h5>Distribución de Riesgo</h5>
                    <div id="pieChart" style="height: 330px;"></div>
                </div>
            </div>
        </div>
    </div>



    <script>
        //DataTables configuración
        $(document).ready(function() {
            $('#tabla-riesgo').DataTable({
                "paging": false,
                "info": false,
                "order": [
                    [2, "desc"]
                ], // Ordenar por retraso por defecto
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es.json"
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": 4
                }]
            });
        });

        // Gráfico de Barras Invertido (como el icono que querías)
        var barChart = echarts.init(document.getElementById('barChart'));
        barChart.setOption({
            tooltip: {
                trigger: 'axis'
            },
            xAxis: {
                type: 'value'
            },
            yAxis: {
                type: 'category',
                data: [<?php while ($t = $res_top->fetch_assoc()) {
                            echo "'" . $t['Nombre'] . "',";
                            $data_top[] = $t['Dias'];
                        } ?>].reverse()
            },
            series: [{
                data: [<?php echo implode(',', array_reverse($data_top)); ?>],
                type: 'bar',
                itemStyle: {
                    color: '#0d6efd'
                }
            }]
        });

        // Gráfico de Pastel
        var pieChart = echarts.init(document.getElementById('pieChart'));
        pieChart.setOption({
            tooltip: {
                trigger: 'item',
                formatter: '{b}: {c} mangas ({d}%)'
            },
            legend: {
                bottom: 0,
            },
            series: [{
                type: 'pie',
                radius: ['40%', '70%'],
                data: [{
                        value: <?php echo $stats['abandonados']; ?>,
                        name: 'Abandonado',
                        itemStyle: {
                            color: '#212529'
                        }
                    },
                    {
                        value: <?php echo $stats['criticos']; ?>,
                        name: 'Crítico',
                        itemStyle: {
                            color: '#dc3545'
                        }
                    },
                    {
                        value: <?php echo $stats['retrasados']; ?>,
                        name: 'Retrasado',
                        itemStyle: {
                            color: '#ffc107'
                        }
                    }
                ]
            }]
        });

        document.querySelectorAll('.manga-row').forEach(row => {
            row.addEventListener('mouseenter', function() {
                const mangaName = this.getAttribute('data-name');
                console.log("Resaltando en gráfico:", mangaName);

                // 1. Activar el estado gigante (Emphasis)
                myScatterChart.dispatchAction({
                    type: 'highlight',
                    seriesIndex: 0,
                    name: mangaName
                });

                // 2. Mostrar el Tooltip
                myScatterChart.dispatchAction({
                    type: 'showTip',
                    seriesIndex: 0,
                    name: mangaName
                });
            });

            // 3. Quitar el resaltado al salir de la fila
            row.addEventListener('mouseleave', function() {
                const mangaName = this.getAttribute('data-name');

                myScatterChart.dispatchAction({
                    type: 'downplay',
                    seriesIndex: 0,
                    name: mangaName
                });

                // Opcional: Ocultar el tooltip al salir
                myScatterChart.dispatchAction({
                    type: 'hideTip'
                });
            });
        });
    </script>


</body>

</html>