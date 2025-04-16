<?php
require '../bd.php';

setlocale(LC_ALL, "es_ES");
$año = date("Y");
$mes = date("F");

// Determinar temporada e imagen
if (in_array($mes, ["January", "February", "March"])) {
    $tempo = "Invierno";
    $img = "../img/winter.png";
} elseif (in_array($mes, haystack: ["April", "May", "June"])) {
    $tempo = "Primavera";
    $img = "../img/spring.png";
} elseif (in_array($mes, ["July", "August", "September"])) {
    $tempo = "Verano";
    $img = "../img/sun.png";
} else {
    $tempo = "Otoño";
    $img = "../img/autumn.png";
}

// Días de la semana
$dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

// Colores para cada día
$day_colors = [
    'Domingo' => 'blue',
    'Lunes' => 'blue',
    'Martes' => 'green',
    'Miercoles' => 'yellow',
    'Jueves' => 'red',
    'Viernes' => 'pink',
    'Sabado' => 'purple'
];



// Preparar resultados para cada día
$daily_results = [];
$total_anime = 0;

foreach ($dias as $dia) {
    // Obtener animes para el día
    $anime_query = "SELECT *
                 FROM `webtoon` 
                 WHERE Estado='Emision' AND `Dias Emision` LIKE '%$dia%' 
                 ORDER BY LENGTH(Nombre) DESC";
    $anime_result = mysqli_query($conexion, $anime_query);

    $daily_results[$dia] = [
        'animes' => mysqli_fetch_all($anime_result, MYSQLI_ASSOC)
    ];
}


$total_anime_query = "SELECT 
        COUNT(*) AS Total_Registros, 
        SUM(Faltantes) AS Total_Faltantes
        FROM webtoon
        WHERE Estado = 'Emisión' 
        AND `Dias Emision` != 'Indefinido';
        ";
$total_anime_result = mysqli_query($conexion, $total_anime_query);
$total_anime_row = mysqli_fetch_assoc($total_anime_result);
$total_anime = $total_anime_row['Total_Registros'];

$total_faltantes =  $total_anime_row['Total_Faltantes'];;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario Semanal de Webtoon</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f8;
            font-family: 'Inter', sans-serif;
        }

        .day-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .day-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 98% !important;
            }
        }

        .circle-count {
            border-radius: 50%;
            width: 22px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 0.8rem;
            font-weight: bold;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .text-orange-600 {
            --tw-text-opacity: 1;
            color: rgba(255, 165, 0, var(--tw-text-opacity));
        }
    </style>

</head>
<?php include('../menu.php'); ?>

<body class="bg-gray-100">
    <div class="container mx-auto">

        <header class="text-center mb-10">

            <div class="flex justify-center items-center mb-4">

                <img src="<?php echo $img; ?>" alt="Ícono de Temporada" class="w-12 mr-4">
                <h1 class="text-4xl font-bold text-gray-800">Horario de Webtoon <?php echo $año; ?></h1>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-2 rounded-lg shadow-md">
                <p class="text-xl font-semibold">Programación Semanal de Webtoon </p>
            </div>
        </header>

        <div class="grid md:grid-cols-7 gap-6">
            <?php foreach ($dias as $dia):
                $color = $day_colors[$dia];
                $animes = $daily_results[$dia]['animes'];
            ?>
                <div class="day-card relative bg-white rounded-lg shadow-md p-4 transform transition hover:scale-105">
                    <h2 class="text-2xl font-bold text-<?php echo $color; ?>-600 mb-4 flex justify-between">
                        <?php echo $dia; ?>

                    </h2>
                    <ul class="space-y-2">
                        <?php foreach ($animes as $anime):
                            $faltantes = $anime['Faltantes'];
                        ?>
                            <li class="bg-<?php echo $color; ?>-100 p-2 rounded hover:bg-<?php echo $color; ?>-200 transition flex justify-between items-center">
                                <!-- Nombre del anime -->
                                <span class="font-medium text-gray-700"><?php echo htmlspecialchars($anime['Nombre']); ?></span>

                                <!-- Mostrar el círculo solo si faltantes > 0 -->
                                <?php if ($faltantes > 0):
                                ?>
                                    <div
                                        class="circle-count flex items-center justify-center border border-<?php echo $color; ?>-500 bg-<?php echo $color; ?>-100 hover:bg-<?php echo $color; ?>-200 text-<?php echo $color; ?>-600 font-bold"
                                        style="width: 24px; height: 24px; border-radius: 50%; font-size: 0.875rem; transition: all 0.3s ease;">
                                        <?php echo htmlspecialchars($faltantes); ?>
                                    </div>
                                <?php endif; ?>
                            </li>

                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-10 text-center bg-white rounded-lg shadow-md p-6">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-700">
                        <i class="fas fa-tasks mr-2 text-orange-600"></i>Capitulos Faltantes
                    </h3>
                    <p class="text-3xl font-bold text-orange-600"><?php echo $total_faltantes; ?></p>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-700">
                        <i class="fas fa-book-open mr-2 text-purple-500"></i>Total de Webtoon en la Semana
                    </h3>
                    <p class="text-3xl font-bold text-indigo-600"><?php echo $total_anime; ?></p>
                </div>
            </div>
        </div>

        <footer class="mt-10 text-center text-gray-500">
            <p>© <?php echo $año; ?> Seguimiento de Horario de Webtoon</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>
<?php
mysqli_close($conexion);
?>