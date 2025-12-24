<?php
// Configuración de conexión (Descomenta la línea de producción cuando subas al servidor)
include('../bd.php');
#$pdo = new PDO('mysql:host='.$servidor.';dbname='.$basededatos, $usuario, $password);
// 1. Obtener el ID de la variable o de la URL
$id_manga = isset($_GET['id']) ? (int)$_GET['id'] : null;

// 2. Definir la consulta con el filtro WHERE
// Si no hay ID, mantenemos tu lógica de "LIMIT 1" para mostrar el más popular
if ($id_manga) {
    $where_clause = "WHERE m.ID = :id";
} else {
    $where_clause = ""; // Sin filtro específico
}

$sql_radar = "
SELECT 
    m.Nombre,
    LEAST(100, ROUND(3000 / NULLIF(AVG(d.Diferencia), 0))) AS Frecuencia,
    LEAST(500, COUNT(d.ID)) AS Volumen_Capitulos,
    LEAST(100, ROUND(100 - COALESCE(STDDEV(d.Diferencia), 0))) AS Estabilidad,
    GREATEST(0, ROUND(100 - (DATEDIFF(CURDATE(), MAX(d.Fecha)) / 2))) AS Recencia
FROM manga m
JOIN diferencias d ON m.ID = d.ID_Manga
$where_clause
GROUP BY m.ID
ORDER BY Volumen_Capitulos DESC
LIMIT 1";

// 3. Ejecución segura con PDO
$stmt_radar = $db->prepare($sql_radar);

if ($id_manga) {
    $stmt_radar->bindParam(':id', $id_manga, PDO::PARAM_INT);
}

$stmt_radar->execute();
$datos_radar = $stmt_radar->fetch(PDO::FETCH_ASSOC);

// Manejo de error si el ID no existe
if (!$datos_radar) {
    $datos_radar = [
        'Nombre' => 'Manga no encontrado',
        'Frecuencia' => 0,
        'Volumen_Capitulos' => 0,
        'Estabilidad' => 0,
        'Recencia' => 0
    ];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manga Pulse - Radar de Consistencia</title>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-4 md:p-10">

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-xl w-full p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-center text-gray-800 mb-4">Análisis de Consistencia (Radar)</h2>
            <div id="radarChart" class="w-full h-[450px]"></div>
        </div>
    </div>

    <script>
        // Inyectamos los datos de PHP de forma segura
        const datosRadar = <?php echo json_encode($datos_radar); ?>;

        const radarDom = document.getElementById('radarChart');
        const myRadarChart = echarts.init(radarDom);

        const radarOption = {
            title: {
                text: 'Métricas de: ' + datosRadar.Nombre,
                left: 'center',
                textStyle: {
                    color: '#374151',
                    fontSize: 16
                }
            },
            tooltip: {
                trigger: 'item',
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                borderWidth: 1,
                borderColor: '#ccc'
            },
            radar: {
                indicator: [{
                        name: 'Frecuencia (Ritmo)',
                        max: 100
                    },
                    {
                        name: 'Capítulos (Volumen)',
                        max: 500
                    },
                    {
                        name: 'Estabilidad (Constancia)',
                        max: 100
                    },
                    {
                        name: 'Recencia (Actualidad)',
                        max: 100
                    }
                ],
                center: ['50%', '60%'],
                radius: '65%',
                axisName: {
                    color: '#6B7280',
                    backgroundColor: '#F3F4F6',
                    borderRadius: 3,
                    padding: [3, 5]
                },
                splitArea: {
                    areaStyle: {
                        color: ['#fff', '#f9fafb']
                    }
                }
            },
            series: [{
                name: 'Métricas del Manga',
                type: 'radar',
                data: [{
                    value: [
                        parseFloat(datosRadar.Frecuencia),
                        parseFloat(datosRadar.Volumen_Capitulos),
                        parseFloat(datosRadar.Estabilidad),
                        parseFloat(datosRadar.Recencia)
                    ],
                    name: datosRadar.Nombre,
                    areaStyle: {
                        color: 'rgba(59, 130, 246, 0.4)'
                    },
                    lineStyle: {
                        color: '#2563EB',
                        width: 2
                    },
                    itemStyle: {
                        color: '#1D4ED8'
                    }
                }]
            }]
        };

        myRadarChart.setOption(radarOption);

        // Ajuste responsivo para que no se deforme al cambiar tamaño de ventana
        window.addEventListener('resize', () => {
            myRadarChart.resize();
        });
    </script>
</body>

</html>