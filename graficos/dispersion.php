<?php
include('../bd.php');
// Consulta para obtener el cruce de volumen vs retraso
$sql_scatter = "
    SELECT 
        m.Nombre,
        COUNT(d.ID) AS Total_Capitulos,
        DATEDIFF(CURDATE(), MAX(d.Fecha)) AS Dias_Retraso
    FROM manga m
    JOIN diferencias d ON m.ID = d.ID_Manga
    WHERE m.Estado <> 'Finalizado'
    GROUP BY m.ID
    HAVING Total_Capitulos > 0
";

$stmt_scatter = $db->query($sql_scatter);
$data_scatter = $stmt_scatter->fetchAll(PDO::FETCH_ASSOC);

// Formateamos para ECharts: [[capitulos, retraso, nombre], ...]
$scatter_values = [];
foreach ($data_scatter as $row) {
    $scatter_values[] = [
        (int)$row['Total_Capitulos'],
        (int)$row['Dias_Retraso'],
        $row['Nombre']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/echarts-stat@1.2.0/dist/ecStat.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="bg-white shadow-xl w-full p-6 rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-center text-gray-800 mb-2">Relación: Esfuerzo (Caps) vs. Retraso (Días)</h2>
        <p class="text-sm text-gray-500 text-center mb-4">Ayuda a identificar si el parón es por abandono del scan o pausa del autor</p>
        <div id="scatterChart" class="w-full h-[500px]"></div>
    </div>
</body>
<script>
    // 1. Registrar el transformador estadístico
    echarts.registerTransform(ecStat.transform.regression);

    const dataScatter = <?php echo json_encode($scatter_values); ?>;
    const scatterDom = document.getElementById('scatterChart');
    const myScatterChart = echarts.init(scatterDom);

    const scatterOption = {
        dataset: [{
                source: dataScatter
            },
            {
                transform: {
                    type: 'ecStat:regression',
                    config: {
                        method: 'linear'
                    } // Línea de tendencia lineal
                }
            }
        ],
        tooltip: {
            trigger: 'item',
            formatter: function(params) {
                if (params.componentType === 'series' && params.seriesType === 'scatter') {
                    return `<strong>${params.data[2]}</strong><br/>Capítulos: ${params.data[0]}<br/>Retraso: ${params.data[1]} días`;
                }
                return `Tendencia: ${params.data[1].toFixed(2)} días`;
            }
        },
        // HERRAMIENTAS DE ZOOM
        dataZoom: [{
                type: 'slider', // Barra inferior
                show: true,
                xAxisIndex: [0],
                start: 0,
                end: 100
            },
            {
                type: 'inside', // Zoom con rueda del ratón
                xAxisIndex: [0],
                start: 0,
                end: 100
            },
            {
                type: 'slider', // Barra lateral para el eje Y
                show: true,
                yAxisIndex: [0],
                left: 'right',
                start: 0,
                end: 100
            }
        ],
        xAxis: {
            name: 'Capítulos',
            splitLine: {
                lineStyle: {
                    type: 'dashed'
                }
            }
        },
        yAxis: {
            name: 'Días Retraso',
            min: 0, // Esto evita que el eje baje de cero
            splitLine: {
                lineStyle: {
                    type: 'dashed'
                }
            },
            axisLabel: {
                formatter: function(value) {
                    // Aplicamos formato de puntos a las etiquetas del eje
                    return value.toLocaleString('de-DE');
                }
            }
        },
        series: [{
                name: 'Mangas',
                type: 'scatter',
                datasetIndex: 0,
                data: dataScatter,
                symbolSize: 15,
                emphasis: {
                    focus: 'self', // Esto oscurece todos los demás puntos excepto el seleccionado
                    itemStyle: {
                        symbolSize: 30, // El punto crece notablemente
                        shadowBlur: 20,
                        shadowColor: 'rgba(0, 0, 0, 0.8)'
                    }
                },
                itemStyle: {
                    color: function(params) {
                        // Rojo: retraso alto y pocos capítulos (abandono probable)
                        if (params.data[1] > 180 && params.data[0] < 50) return '#ef4444';

                        // Azul: serie larga pausada
                        if (params.data[0] >= 200) return '#3b82f6';

                        // Verde: comportamiento normal
                        return '#10b981';
                    },
                    opacity: 0.7,
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 0, 0, 0.2)'
                }
            }, {
                name: 'Línea de Tendencia',
                type: 'line',
                datasetIndex: 1,
                symbol: 'none',
                lineStyle: {
                    type: 'dashed',
                    color: '#ef4444',
                    width: 3
                },
                zIndex: 10
            }

        ],
        // Marcas visuales para cuadrantes
        visualMap: {
            show: false,
            dimension: 1,
            pieces: [{
                    gt: 365,
                    color: '#991b1b'
                }, // Más de un año (Crítico)
                {
                    gt: 180,
                    lte: 365,
                    color: '#f59e0b'
                }, // 6 meses a un año
                {
                    lte: 180,
                    color: '#10b981'
                } // Menos de 6 meses
            ]
        }
    };

    myScatterChart.setOption(scatterOption);
    window.addEventListener('resize', () => myScatterChart.resize());
</script>

</html>