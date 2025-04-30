<?php
include('./bd.php');

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
    #main{
        margin-top: -50px;
    }
</style>

<body class="font-sans">


    <!-- Contenedor del gráfico -->
    <main class="flex justify-center items-center px-4">
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
    </script>

</body>

</html>