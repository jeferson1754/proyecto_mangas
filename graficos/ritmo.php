<?php
// Asegúrate de que la ruta sea correcta y la variable de conexión coincida (usualmente $pdo o $db)
include('../bd.php');

// 1. Obtener ID de la URL o usar uno por defecto
$id_manga = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// 2. Consulta de historial
$sql_ritmo = "
    SELECT 
        Fecha, 
        Diferencia 
    FROM diferencias 
    WHERE ID_Manga = :id 
    ORDER BY Fecha ASC
";

// Usamos $db (ajusta a $pdo si recibes error de variable indefinida)
$stmt_ritmo = $db->prepare($sql_ritmo);
$stmt_ritmo->bindParam(':id', $id_manga, PDO::PARAM_INT);
$stmt_ritmo->execute();
$historial = $stmt_ritmo->fetchAll(PDO::FETCH_ASSOC);

// 3. Preparar los datos para JS
$fechas = [];
$diferencias = [];
foreach ($historial as $h) {
    $fechas[] = $h['Fecha'];
    $diferencias[] = (int)$h['Diferencia'];
}

// Fallback si no hay datos para evitar errores de JS
if (empty($fechas)) {
    $fechas = ['Sin datos'];
    $diferencias = [0];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salud del Ritmo - Manga Pulse</title>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-4">

    <div class="max-w-6xl mx-auto">
        <div class="bg-white shadow-xl w-full p-6 rounded-lg">
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Salud del Ritmo: Evolución de Espera</h2>
                    <p class="text-sm text-gray-500">Muestra los días que pasan entre cada actualización</p>
                </div>
                <div class="mt-2 md:mt-0 flex gap-2">
                    <span class="flex items-center text-xs text-gray-600"><span class="w-3 h-3 bg-[#10b981] rounded-full mr-1"></span> Estable</span>
                    <span class="flex items-center text-xs text-gray-600"><span class="w-3 h-3 bg-[#f59e0b] rounded-full mr-1"></span> Lento</span>
                    <span class="flex items-center text-xs text-gray-600"><span class="w-3 h-3 bg-[#ef4444] rounded-full mr-1"></span> Crítico</span>
                </div>
            </div>

            <div id="ritmoChart" class="w-full h-[450px]"></div>
        </div>
    </div>

    <script>
        // Inyección de datos desde PHP
        const fechasRitmo = <?php echo json_encode($fechas); ?>;
        const datosRitmo = <?php echo json_encode($diferencias); ?>;

        const ritmoDom = document.getElementById('ritmoChart');
        const myRitmoChart = echarts.init(ritmoDom);

        const ritmoOption = {
            tooltip: {
                trigger: 'axis',
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                formatter: function(params) {
                    let p = params[0];
                    return `<div class="font-bold border-b mb-1">${p.name}</div>
                            Espera: <span class="font-bold" style="color:${p.color}">${p.value} días</span>`;
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: fechasRitmo,
                boundaryGap: false,
                axisLine: {
                    lineStyle: {
                        color: '#9ca3af'
                    }
                }
            },
            yAxis: {
                type: 'value',
                name: 'Días de espera',
                splitLine: {
                    lineStyle: {
                        type: 'dashed',
                        color: '#e5e7eb'
                    }
                }
            },
            visualMap: {
                show: false,
                dimension: 1,
                pieces: [{
                        gt: 0,
                        lte: 15,
                        color: '#10b981'
                    }, // Saludable
                    {
                        gt: 15,
                        lte: 45,
                        color: '#f59e0b'
                    }, // Riesgo
                    {
                        gt: 45,
                        color: '#ef4444'
                    } // Crítico
                ]
            },
            series: [{
                name: 'Diferencia',
                type: 'line',
                data: datosRitmo,
                smooth: true,
                symbolSize: 8,
                lineStyle: {
                    width: 4
                },
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgba(16, 185, 129, 0.2)'
                        },
                        {
                            offset: 1,
                            color: 'rgba(16, 185, 129, 0)'
                        }
                    ])
                },
                markLine: {
                    silent: true,
                    data: [{
                        type: 'average',
                        name: 'Promedio'
                    }],
                    label: {
                        formatter: 'Promedio: {c}d',
                        position: 'end'
                    },
                    lineStyle: {
                        color: '#6b7280',
                        type: 'dotted'
                    }
                }
            }]
        };

        myRitmoChart.setOption(ritmoOption);

        // Ajuste responsivo
        window.addEventListener('resize', () => {
            myRitmoChart.resize();
        });
    </script>
</body>

</html>