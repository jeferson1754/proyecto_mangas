<?php
//include('../bd.php');
// Consulta para obtener el progreso global de lectura
$sql_stats = "
SELECT 
Estado,
        SUM(`Capitulos Vistos`) as vistos, 
        SUM(`Capitulos Totales`) as totales 
    FROM (
        SELECT Estado, `Capitulos Vistos`, `Capitulos Totales` FROM manga
        UNION ALL
        SELECT Estado, `Capitulos Vistos`, `Capitulos Totales` FROM pendientes_manga
        UNION ALL
        SELECT Estado, `Capitulos Vistos`, `Capitulos Totales` FROM webtoon
    ) as biblioteca
    GROUP BY (Estado = 'Finalizado');
";
$stmt_stats = $db->query($sql_stats);
$resultados = $stmt_stats->fetchAll(PDO::FETCH_ASSOC);

$data_emision = ['vistos' => 0, 'totales' => 0, 'porcentaje' => 0];
$data_finalizado = ['vistos' => 0, 'totales' => 0, 'porcentaje' => 0];

foreach ($resultados as $res) {
    $porc = ($res['totales'] > 0) ? round(($res['vistos'] / $res['totales']) * 100, 1) : 0;
    if ($res['Estado'] == 'Finalizado') {
        $data_finalizado = ['vistos' => $res['vistos'], 'totales' => $res['totales'], 'porcentaje' => $porc];
    } else {
        // Asumimos que los que no están finalizados están en emisión/pausa
        $data_emision['vistos'] += $res['vistos'];
        $data_emision['totales'] += $res['totales'];
    }
}
// Recalcular porcentaje de emisión tras el sumatorio
$data_emision['porcentaje'] = ($data_emision['totales'] > 0)
    ? round(($data_emision['vistos'] / $data_emision['totales']) * 100, 1) : 0;
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white shadow-xl p-6 rounded-lg relative">
            <h2 class="text-lg font-bold text-center text-gray-700">Progreso: En Emisión</h2>
            <div id="gaugeEmision" class="w-full h-[300px]"></div>
            <div class="flex justify-between px-10 -mt-10 text-sm font-bold text-gray-500">
                <span>Vistos: <?= number_format($data_emision['vistos'], 0, ',', '.') ?></span>
                <span>Total: <?= number_format($data_emision['totales'], 0, ',', '.') ?></span>
            </div>
        </div>

        <div class="bg-white shadow-xl p-6 rounded-lg relative">
            <h2 class="text-lg font-bold text-center text-gray-700">Progreso: Finalizados</h2>
            <div id="gaugeFinalizado" class="w-full h-[300px]"></div>
            <div class="flex justify-between px-10 -mt-10 text-sm font-bold text-gray-500">
                <span>Vistos: <?= number_format($data_finalizado['vistos'], 0, ',', '.') ?></span>
                <span>Total: <?= number_format($data_finalizado['totales'], 0, ',', '.') ?></span>
            </div>
        </div>
    </div>
    <script>
        function createGauge(elementId, title, value, color) {
            const chart = echarts.init(document.getElementById(elementId));
            const option = {
                series: [{
                    type: 'gauge',
                    startAngle: 200,
                    endAngle: -20,
                    min: 0,
                    max: 100,
                    splitNumber: 10,
                    itemStyle: {
                        color: color
                    },
                    progress: {
                        show: true,
                        width: 18
                    },
                    pointer: {
                        show: false
                    },
                    axisLine: {
                        lineStyle: {
                            width: 18
                        }
                    },
                    axisTick: {
                        show: false
                    },
                    splitLine: {
                        show: false
                    },
                    axisLabel: {
                        show: false
                    },
                    anchor: {
                        show: false
                    },
                    title: {
                        show: false
                    },
                    detail: {
                        valueAnimation: true,
                        offsetCenter: [0, '0%'],
                        fontSize: 30,
                        fontWeight: 'bold',
                        formatter: '{value}%',
                        color: 'inherit'
                    },
                    data: [{
                        value: value
                    }]
                }]
            };
            chart.setOption(option);
            return chart;
        }

        const gaugeE = createGauge('gaugeEmision', 'Emisión', <?= $data_emision['porcentaje'] ?>, '#3b82f6');
        const gaugeF = createGauge('gaugeFinalizado', 'Finalizados', <?= $data_finalizado['porcentaje'] ?>, '#10b981');

        window.addEventListener('resize', () => {
            gaugeE.resize();
            gaugeF.resize();
        });
    </script>
</body>

</html>