<?php
//include('../bd.php');
// Consulta para obtener la actividad diaria
$sql_heatmap = "
    SELECT 
        DATE(Fecha) as fecha, 
        COUNT(*) as total 
    FROM diferencias 
    WHERE Fecha >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) 
    GROUP BY DATE(Fecha)
";

$stmt_heatmap = $db->query($sql_heatmap);
$data_heatmap = $stmt_heatmap->fetchAll(PDO::FETCH_ASSOC);

// Formateamos los datos para ECharts: [[fecha, valor], [fecha, valor]]
$heatmap_values = [];
foreach ($data_heatmap as $row) {
    $heatmap_values[] = [$row['fecha'], (int)$row['total']];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="bg-white shadow-xl w-full p-6 rounded-lg mt-6">
        <h2 class="text-xl font-semibold text-center text-gray-800 mb-4">Calendario de Actividad (Último Año)</h2>
        <div id="heatmapChart" class="w-full h-[300px]"></div>
    </div>
</body>
<script>
    const dataHeatmap = <?php echo json_encode($heatmap_values); ?>;
    const heatmapDom = document.getElementById('heatmapChart');
    const myHeatmap = echarts.init(heatmapDom);

    // Obtenemos el año actual para el rango del calendario
    const currentYear = new Date().getFullYear();

    const heatmapOption = {
        tooltip: {
            position: 'top',
            formatter: function(p) {
                return p.data[0] + ': Se agregaron ' + p.data[1] + ' capítulos';
            }
        },
        visualMap: {
            min: 0,
            max: 10, // Ajusta este valor según tu volumen promedio de publicaciones diarias
            type: 'piecewise',
            orient: 'horizontal',
            left: 'center',
            top: 0,
            pieces: [{
                    gt: 0,
                    lte: 2,
                    label: 'Baja',
                    color: '#e1f5fe'
                },
                {
                    gt: 2,
                    lte: 5,
                    label: 'Media',
                    color: '#4fc3f7'
                },
                {
                    gt: 5,
                    lte: 8,
                    label: 'Alta',
                    color: '#0288d1'
                },
                {
                    gt: 8,
                    label: 'Intensa',
                    color: '#01579b'
                }
            ]
        },
        calendar: {
            top: 80,
            left: 30,
            right: 30,
            cellSize: ['auto', 20],
            range: currentYear,
            itemStyle: {
                borderWidth: 0.5,
                borderColor: '#eee'
            },
            yearLabel: {
                show: true
            },
            dayLabel: {
                nameMap: 'es'
            },
            monthLabel: {
                nameMap: 'es'
            }
        },
        series: {
            type: 'heatmap',
            coordinateSystem: 'calendar',
            data: dataHeatmap
        }
    };

    myHeatmap.setOption(heatmapOption);

    window.addEventListener('resize', () => {
        myHeatmap.resize();
    });
</script>

</html>