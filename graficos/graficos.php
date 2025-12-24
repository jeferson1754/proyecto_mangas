<?php

$pdo = new PDO('mysql:host=localhost;dbname=epiz_32740026_r_user', 'root', '');
#$pdo = new PDO('mysql:host='.$servidor.';dbname='.$basededatos, $usuario, $password);


// Consulta de mangas descargados agrupados por dominio
$sqlMangas = "
   SELECT REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(Link, '/', 3), '//', -1), 'www.', '') AS dominio, COUNT(*) AS total FROM manga GROUP BY dominio;
";
$descargados = $pdo->query($sqlMangas)->fetchAll(PDO::FETCH_KEY_PAIR);

// Consulta de mangas pendientes agrupados por dominio
$sqlPendientes = "
  SELECT REPLACE(SUBSTRING_INDEX(SUBSTRING_INDEX(Link, '/', 3), '//', -1), 'www.', '') AS dominio, COUNT(*) AS total FROM pendientes_manga GROUP BY dominio;
";
$pendientes = $pdo->query($sqlPendientes)->fetchAll(PDO::FETCH_KEY_PAIR);

// Combinar y sumar
$dominios = array_unique(array_merge(array_keys($descargados), array_keys($pendientes)));
sort($dominios);

$colores = [
    'zonatmo.com' => '#3357FF',
    'dragontranslation.net' => '#b81414',
    'es.novelcool.com' => '#ff7b0a',
    'mangaplus.shueisha.co.jp' => '#5d0914',
    'manhwa-latino.com' => '#ffc107',
    'webtoons.com' => '#00dc64',
];

$totales = [];
foreach ($dominios as $dominio) {
    $totales[] = [
        'name' => $dominio,
        'value' => ($descargados[$dominio] ?? 0) + ($pendientes[$dominio] ?? 0),
        'color' => $colores[$dominio] ?? '#D3D3D3'
    ];
}

$sqlFaltantes = "
SELECT m.Faltantes, COUNT(*) AS cantidad_mangas FROM manga m WHERE m.Faltantes > 0 GROUP BY m.Faltantes ORDER BY m.Faltantes ASC LIMIT 10;
";
$faltantes = $pdo->query($sqlFaltantes)->fetchAll(PDO::FETCH_KEY_PAIR);

$paleta = [
    '#4A90E2', // azul
    '#5BC0DE', // celeste
    '#5CB85C', // verde
    '#8BC34A', // verde lima
    '#CDDC39', // verde amarillento
    '#FFC107', // amarillo
    '#FF9800', // naranjo claro
    '#FF7043', // naranjo intenso
    '#F44336', // rojo suave
    '#D32F2F'  // rojo oscuro
];

$totales_faltantes = [];

$index = 0;
foreach ($faltantes as $cantidadFaltantes => $cantidadMangas) {
    $totales_faltantes[] = [
        'name' => "$cantidadFaltantes faltantes",
        'value' => $cantidadMangas,
        'color' => $paleta[$index] ?? '#D3D3D3'
    ];
    $index++;
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Total de mangas por dominio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
    #main {
        margin-top: -50px;
    }
</style>

<body class="font-sans">

    <main class="flex flex-col gap-6 justify-center items-center px-4">
        <div class="bg-white shadow-xl w-full p-6">
            <h2 class="text-xl font-semibold text-center text-gray-800">Distribución de mangas según capítulos faltantes</h2>
            <div id="bar" class="w-full h-[400px]"></div>
        </div>

        <div class="bg-white shadow-xl w-full p-6">
            <h2 class="text-xl font-semibold text-center text-gray-800">Total de mangas por dominio</h2>
            <div id="main" class="w-full h-[400px]"></div>
        </div>
    </main>



    <script>
        const data = <?= json_encode($totales) ?>;
        const chart = echarts.init(document.getElementById('main'));

        const option = {
            tooltip: {
                trigger: 'item',
                formatter: '{b}: {c} mangas ({d}%)'
            },
            legend: {
                bottom: -5,
            },
            series: [{
                name: 'Dominios',
                type: 'pie',
                radius: ['40%', '70%'],
                avoidLabelOverlap: false,
                itemStyle: {
                    borderRadius: 8,
                    borderColor: '#fff',
                    borderWidth: 2
                },
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: '18',
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: data.map(item => ({
                    name: item.name,
                    value: item.value,
                    itemStyle: {
                        color: item.color
                    }
                }))
            }]
        };

        chart.setOption(option);
        window.addEventListener('resize', () => {
            chart.resize();
        });

        const data_2 = <?= json_encode($totales_faltantes) ?>;

        // Extraemos categorías y valores
        const categorias_2 = data_2.map(item => item.name);
        const valores_2 = data_2.map(item => item.value);
        const colores_2 = data_2.map(item => item.color || '#D3D3D3');

        var dom_2 = document.getElementById('bar');
        var myChart_2 = echarts.init(dom_2, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });

        var option_2 = {
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
                data: categorias_2,
                axisTick: {
                    alignWithLabel: true
                }
            }],
            yAxis: [{
                type: 'value'
            }],
            series: [{
                name: 'Mangas',
                type: 'bar',
                barWidth: '60%',
                data: valores_2,
                itemStyle: {
                    color: function(params) {
                        return colores_2[params.dataIndex];
                    }
                }
            }]
        };

        myChart_2.setOption(option_2);

        window.addEventListener('resize', () => {
            myChart_2.resize();
        });
    </script>

</body>

</html>