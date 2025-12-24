<?php
require 'bd.php';

// Obtener los totales de diferentes consultas
$totalMangas = getCountFromTable($conexion, 'manga');
$totalTachiyomi = getCountFromTable($conexion, 'tachiyomi');
$totalWebtoon = getCountFromTable($conexion, 'webtoon');
$totalPendientes = getCountFromTable($conexion, 'pendientes_manga');
$totalFinalizados = getCountFromTable($conexion, 'finalizados_manga');

$totalFaltantes = getCountFromTableWithCondition($conexion, 'manga', 'Faltantes>0');

$lista1 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Al Dia"');
$lista2 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Al Dia 2"');
$lista3 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Al Dia 3"');
$lista4 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Mangas"');
$lista5 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Echii"');
$lista6 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Mangas 2"');
$lista7 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Echii 2"');
$lista8 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Mangas 3"');
$lista9 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Los que le faltan 50 o mas"');
$lista10 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Otros"');
$lista11 = getCountFromTableWithCondition($conexion, 'manga', 'Lista LIKE "Sin Lista"');

$sinver1        = getCountFromTableWithCondition($conexion, 'manga', 'verificado="NO"');
$sinact1        = getCountFromTableWithCondition($conexion, 'manga', 'Fecha_Cambio1 < DATE_SUB(CURDATE(), INTERVAL 36 MONTH) AND Faltantes=0');
$max_50         = getCountFromTableWithCondition($conexion, 'manga', 'Faltantes>=50');
$min_50         = getCountFromTableWithCondition($conexion, 'manga', 'Faltantes>0 AND Faltantes<50');
$min_50_emision = getCountFromTableWithCondition($conexion, 'manga', 'Faltantes>0 AND Faltantes<50 AND Estado="Emision"');
$min_50_final   = getCountFromTableWithCondition($conexion, 'manga', 'Faltantes>0 AND Faltantes<50 AND Estado="Finalizado"');
$finalizados    = getCountFromTableWithCondition($conexion, 'manga', 'Estado="Finalizado"');
$pausados       = getCountFromTableWithCondition($conexion, 'manga', 'Estado="Pausado"');
$sin_faltantes  = getCountFromTableWithCondition($conexion, 'manga', 'Faltantes=0');
$mangas_anime   = getCountFromTableWithCondition($conexion, 'manga', 'Anime="SI"');

$sinact2             = getCountFromTableWithCondition($conexion, 'tachiyomi', 'Fecha_Cambio1 < DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND Faltantes=0');
$faltantes_tachiyomi = getCountFromTableWithCondition($conexion, 'tachiyomi', 'Faltantes>0;');

$sinver2          = getCountFromTableWithCondition($conexion, 'pendientes_manga', 'verificado="NO"');
$sinact3          = getCountFromTableWithCondition($conexion, 'pendientes_manga', 'Fecha_Cambio1 < DATE_SUB(CURDATE(), INTERVAL 36 MONTH) AND Faltantes=0');
$pendientes_anime = getCountFromTableWithCondition($conexion, 'pendientes_manga', 'Anime="SI";');

$faltantes_webtoon = getCountFromTableWithCondition($conexion, 'webtoon', 'Faltantes>0;');

function getCountFromTable($connection, $table)
{
    $query = $connection->query("SELECT COUNT(*) AS conteo FROM $table;");
    return mysqli_fetch_assoc($query)['conteo'];
}

function getCountFromTableWithCondition($connection, $table, $condition)
{
    $query = $connection->query("SELECT COUNT(*) AS conteo FROM $table WHERE $condition;");
    return mysqli_fetch_assoc($query)['conteo'];
}

$query = $conexion->query("SELECT SUM(Faltantes) AS conteo FROM manga;");
while ($valores = mysqli_fetch_array($query)) {
    $totalcaps_faltantes = $valores['conteo'];
}

$query = $conexion->query("SELECT SUM(Faltantes) AS conteo FROM manga WHERE Faltantes<=3;");
while ($valores = mysqli_fetch_array($query)) {
    $sinact6 = $valores['conteo'];
}

$query = $conexion->query("SELECT SUM(Faltantes) AS conteo FROM tachiyomi");
while ($valores = mysqli_fetch_array($query)) {
    $sum_faltantes_tachi = $valores['conteo'];
}

$query = $conexion->query("SELECT SUM(Faltantes) AS conteo FROM webtoon");
while ($valores = mysqli_fetch_array($query)) {
    $sum_faltantes_webtoon = $valores['conteo'];
}

if ($sinact6 == 0) {
    $sinact6 = "4";
}

$query = $conexion->query("SELECT COUNT(*) AS conteo  FROM webtoon WHERE Fecha_Ultimo_Capitulo < DATE_SUB(CURDATE(), INTERVAL 3 YEAR)");
while ($valores = mysqli_fetch_array($query)) {
    $sinact_webtoon = $valores['conteo'];
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Listas</title>
    <style>
        :root {
            --card-width: 150px;
            --grid-gap: 30px;
            --cards-per-row: 6;
        }

        .dashboard-container {
            max-width: calc((var(--card-width) * var(--cards-per-row)) + (var(--grid-gap) * (var(--cards-per-row))));
            margin: 0 auto;
        }

        .cards-grid {
            display: flex;
            flex-wrap: wrap;
            gap: var(--grid-gap);
            justify-content: center;
        }

        .stat-card {
            width: var(--card-width);
            height: 120px;
            background: white;
            border-radius: 0.75rem;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            text-decoration: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--card-color, #4776E6);
            opacity: 0.8;
        }

        .stat-card.blue {
            --card-color: #4776E6;
        }

        .stat-card.green {
            --card-color: #2ecc71;
        }

        .stat-card.red {
            --card-color: #e74c3c;
        }

        .stat-card.gray {
            --card-color: #95a5a6;
        }

        .stat-card.purple {
            --card-color: #9b59b6;
        }

        .stat-card.orange {
            --card-color: #e67e22;
        }

        .stat-card.yellow {
            --card-color: #f1c40f;
        }

        .stat-card.pink {
            --card-color: #FF33CC;
        }

        .stat-card.soft-purple {
            --card-color: #CBC3E3;
        }

        .stat-card.cyan {
            --card-color: #00BCD4;
        }

        .stat-card.dark-yellow {
            --card-color: #FFD600;
        }

        .stat-card.lime {
            --card-color: #CDDC39;
        }

        .stat-card.magenta {
            --card-color: #FF00FF;
        }

        .stat-card.dark-blue {
            --card-color: #1976D2;
        }

        .stat-card.dark-gray {
            --card-color: #616161;
        }

        .stat-card.dark-orange {
            --card-color: #FF6D00;
        }

        .stat-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3436;
            margin-top: 0.7rem;
            white-space: normal;
            /* Cambiado de nowrap a normal */
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0 0.5rem;
            word-wrap: break-word;
            /* Esto permite que el texto se divida si es necesario */
        }


        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--card-color, #4776E6);
        }

        .stat-icon {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            font-size: 1rem;
            color: var(--card-color, #4776E6);
            opacity: 0.2;
        }

        .section-divider {
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, transparent, #dee2e6, transparent);
            margin: 2rem 0;
            position: relative;
        }

        .section-divider .title {
            position: absolute;
            top: -10px;
            /* Ajusta la posición vertical del título */
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            /* Color de fondo para el título (puedes cambiarlo) */
            padding: 0 10px;
            font-weight: bold;
            font-size: 1.2rem;
            /* Tamaño del texto */
            color: var(--gray);
            /* Color del texto */
        }

        #iframe-container {
            display: none;
            /* Oculto por defecto */
            margin-top: 20px;
            height: max-content;
        }

        iframe {
            width: 1100px;
            height: 600px;
        }

        @media (min-width: 1400px) {
            :root {
                --cards-per-row: 8;
            }
        }

        @media (max-width: 1200px) {
            :root {
                --cards-per-row: 4;
            }
        }

        @media (max-width: 992px) {
            :root {
                --cards-per-row: 3;
            }
        }

        @media (max-width: 768px) {
            :root {
                --cards-per-row: 2;
            }

            .stat-card {
                height: 100px;
            }

            .stat-value {
                font-size: 1.2rem;
            }

            .stat-title {
                font-size: 0.8rem;
            }

            iframe {
                width: 400px;
                height: 600px;
            }

        }
    </style>
</head>

<body>
    <?php include('menu.php'); ?>

    <div class="dashboard-container">
        <div class="section-divider">
            <span class="title">General</span>
        </div>
        <div class="cards-grid">
            <a href="../?busqueda=&buscar=&accion=Busqueda" class="stat-card blue">
                <i class="fas fa-book stat-icon"></i>
                <div class="stat-title">Total Mangas</div>
                <div class="stat-value"><?= $totalMangas ?></div>
            </a>

            <a href="../Tachiyomi/?busqueda_tachi=&buscar=" class="stat-card purple">
                <i class="fas fa-mobile-alt stat-icon"></i>
                <div class="stat-title">Tachiyomi</div>
                <div class="stat-value"><?= $totalTachiyomi ?></div>
            </a>

            <a href="../Webtoon/?busqueda_webtoon=&buscar=" class="stat-card green">
                <i class="fas  fa-book-open stat-icon"></i>
                <div class="stat-title">Webtoon</div>
                <div class="stat-value"><?= $totalWebtoon ?></div>
            </a>

            <?php if ($totalFaltantes > 0): ?>
                <a href="../" class="stat-card red">
                    <i class="fas fa-exclamation-circle stat-icon"></i>
                    <div class="stat-title">Faltantes</div>
                    <div class="stat-value"><?= $totalFaltantes ?></div>
                </a>
            <?php endif; ?>

            <a href="../Pendientes/" class="stat-card orange">
                <i class="fas fa-clock stat-icon"></i>
                <div class="stat-title">Pendientes</div>
                <div class="stat-value"><?= $totalPendientes ?></div>
            </a>

            <a href="../Finalizados/" class="stat-card green">
                <i class="fas fa-check-circle stat-icon"></i>
                <div class="stat-title">Finalizados</div>
                <div class="stat-value"><?= $totalWebtoon ?></div>
            </a>

        </div>
        <div class="section-divider">
            <span class="title">Listas</span>
        </div>

        <div class="cards-grid">

            <a href="../?busqueda_manga=&todos=Al+dia&capitulos=&estado=&buscar=" class="stat-card cyan">
                <i class="fas fa-sync-alt stat-icon"></i>
                <div class="stat-title">Al dia</div>
                <div class="stat-value"><?= $lista1 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Al+dia+2&capitulos=&estado=&buscar=" class="stat-card lime">
                <i class="fas fa-check-circle stat-icon"></i>
                <div class="stat-title">Al dia 2</div>
                <div class="stat-value"><?= $lista2 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Al+dia+3&capitulos=&estado=&buscar=" class="stat-card cyan">
                <i class="fas fa-sync-alt stat-icon"></i>
                <div class="stat-title">Al dia 3</div>
                <div class="stat-value"><?= $lista3 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Mangas&capitulos=&estado=&buscar=" class="stat-card purple">
                <i class="fas fa-book stat-icon"></i>
                <div class="stat-title">Mangas</div>
                <div class="stat-value"><?= $lista4 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Echii&capitulos=&estado=&buscar=" class="stat-card pink">
                <i class="fas fa-heart stat-icon"></i>
                <div class="stat-title">Echii</div>
                <div class="stat-value"><?= $lista5 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Mangas+2&capitulos=&estado=&buscar=" class="stat-card green">
                <i class="fas fa-book-open stat-icon"></i>
                <div class="stat-title">Mangas 2</div>
                <div class="stat-value"><?= $lista6 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Echii+2&capitulos=&estado=&buscar=" class="stat-card pink">
                <i class="fas fa-heart stat-icon"></i>
                <div class="stat-title">Echii 2</div>
                <div class="stat-value"><?= $lista7 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Mangas+3&capitulos=&estado=&buscar=" class="stat-card purple">
                <i class="fas fa-book stat-icon"></i>
                <div class="stat-title">Mangas 3</div>
                <div class="stat-value"><?= $lista8 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Los+que+le+faltan+50+o+mas&capitulos=&estado=&buscar=" class="stat-card orange">
                <i class="fas fa-bolt stat-icon"></i>
                <div class="stat-title">Los que le faltan 50 o mas</div>
                <div class="stat-value"><?= $lista9 ?></div>
            </a>

            <a href="../?busqueda_manga=&todos=Otros&capitulos=&estado=&buscar=" class="stat-card gray">
                <i class="fas fa-ellipsis-h stat-icon"></i>
                <div class="stat-title">Otros</div>
                <div class="stat-value"><?= $lista10 ?></div>
            </a>

            <?php if ($lista11 > 0): ?>
                <a href="../?busqueda_manga=&todos=Sin+Lista&capitulos=&estado=&buscar=" class="stat-card dark-gray">
                    <i class="fas fa-ban stat-icon"></i>
                    <div class="stat-title">Sin Lista</div>
                    <div class="stat-value"><?= $lista11 ?></div>
                </a>
            <?php endif; ?>
        </div>

        <div class="section-divider">
            <span class="title">Mangas</span>
        </div>

        <div class="cards-grid">

            <?php if ($sinver1 > 0): ?>
                <a href="../?sin-fechas=" class="stat-card dark-orange">
                    <i class="fas fa-exclamation-triangle stat-icon"></i>
                    <div class="stat-title">Sin Verificar</div>
                    <div class="stat-value"><?= $sinver1 ?></div>
                </a>
            <?php endif; ?>

            <?php if ($sinact1 > 15): ?>
                <a href="../?sin-actividad=" class="stat-card gray">
                    <i class="fas fa-hourglass stat-icon"></i>
                    <div class="stat-title">Sin Actividad Reciente (3 Años)</div>
                    <div class="stat-value"><?= $sinact1 ?></div>
                </a>
            <?php endif; ?>

            <?php if ($max_50 > 0): ?>
                <a class="stat-card yellow">
                    <i class="fas fa-star stat-icon"></i>
                    <div class="stat-title">+50</div>
                    <div class="stat-value"><?= $max_50 ?></div>
                </a>
            <?php endif; ?>

            <?php if ($min_50 > 0): ?>
                <a class="stat-card orange">
                    <i class="fas fa-minus stat-icon"></i>
                    <div class="stat-title">-50</div>
                    <div class="stat-value"><?= $min_50 ?></div>
                </a>
            <?php endif; ?>

            <?php if ($min_50_final > 0): ?>
                <a class="stat-card blue">
                    <i class="fas fa-thumbs-up stat-icon"></i>
                    <div class="stat-title">-50 Finalizados</div>
                    <div class="stat-value"><?= $min_50_final ?></div>
                </a>
            <?php endif; ?>

            <?php if ($min_50_emision > 0): ?>
                <a class="stat-card yellow">
                    <i class="fas fa-play-circle stat-icon"></i>
                    <div class="stat-title">-50 Emision</div>
                    <div class="stat-value"><?= $min_50_emision ?></div>
                </a>
            <?php endif; ?>

            <?php if ($finalizados > 0): ?>
                <a href="../?busqueda_manga=&todos=&capitulos=&estado=Finalizado&buscar=" class="stat-card green">
                    <i class="fas fa-check-circle stat-icon"></i>
                    <div class="stat-title">Finalizados</div>
                    <div class="stat-value"><?= $finalizados ?></div>
                </a>
            <?php endif; ?>

            <?php if ($pausados > 0): ?>
                <a href="../?busqueda_manga=&todos=&capitulos=&estado=Pausado&buscar=" class="stat-card cyan">
                    <i class="fas fa-clock stat-icon"></i>
                    <div class="stat-title">Pausados</div>
                    <div class="stat-value"><?= $pausados ?></div>
                </a>
            <?php endif; ?>

            <a class="stat-card purple">
                <i class="fas fa-check stat-icon"></i>
                <div class="stat-title">Leidos Sin Faltantes</div>
                <div class="stat-value"><?= $sin_faltantes ?></div>
            </a>


            <?php if ($totalcaps_faltantes > 0): ?>
                <a href="../" class="stat-card red">
                    <i class="fas fa-times-circle stat-icon"></i>
                    <div class="stat-title">Total de Capitulos Faltantes</div>
                    <div class="stat-value"><?= $totalcaps_faltantes ?></div>
                </a>
            <?php endif; ?>


            <a href="../?anime=" class="stat-card purple">
                <i class="fas fa-tv stat-icon"></i>
                <div class="stat-title">Mangas con Anime</div>
                <div class="stat-value"><?= $mangas_anime ?></div>
            </a>


            <a href="../?busqueda_manga=&todos=&capitulos=1&estado=&buscar=" class="stat-card orange">
                <i class="fas fa-book stat-icon"></i>
                <div class="stat-title">Capitulos por Leer</div>
                <div class="stat-value"><?= $sinact6 ?></div>
            </a>

        </div>
        <?php if (($sinact2 > 0) || ($faltantes_tachiyomi > 0)): ?>
            <div class="section-divider">
                <span class="title">Tachiyomi</span>
            </div>

            <div class="cards-grid">
                <?php if ($sinact2 > 0): ?>
                    <a href="../Tachiyomi/?sin-actividad=" class="stat-card gray">
                        <i class="fas fa-pause stat-icon"></i>
                        <div class="stat-title">Sin Actividad Reciente Tachiyomi(3 Meses)</div>
                        <div class="stat-value"><?= $sinact2 ?></div>
                    </a>
                <?php endif; ?>

                <?php if ($faltantes_tachiyomi > 0): ?>
                    <a href="../Tachiyomi/" class="stat-card orange">
                        <i class="fas fa-exclamation-circle stat-icon"></i>
                        <div class="stat-title">Faltantes</div>
                        <div class="stat-value"><?= $faltantes_tachiyomi ?></div>
                    </a>
                <?php endif; ?>

                <?php if ($sum_faltantes_tachi > 0): ?>
                    <a href="../Tachiyomi/" class="stat-card gray">
                        <i class="fas fa-pause stat-icon"></i>
                        <div class="stat-title">Total Capitulos Faltantes</div>
                        <div class="stat-value"><?= $sum_faltantes_tachi ?></div>
                    </a>
                <?php endif; ?>

            </div>
        <?php endif; ?>
        <?php if (($sinact_webtoon > 0) || ($faltantes_webtoon > 0)): ?>
            <div class="section-divider">
                <span class="title">Webtoon</span>
            </div>

            <div class="cards-grid">
                <?php if ($sinact_webtoon > 0): ?>
                    <a href="../Webtoon/?sin-actividad=" class="stat-card red">
                        <i class="fas fa-book-open stat-icon"></i>
                        <div class="stat-title">Sin Actividad Reciente Webtoon(3 Años)</div>
                        <div class="stat-value"><?= $sinact_webtoon ?></div>
                    </a>
                <?php endif; ?>

                <?php if ($faltantes_webtoon > 0): ?>
                    <a href="../Webtoon/?faltantes=" class="stat-card purple">
                        <i class="fas fa-exclamation-circle stat-icon"></i>
                        <div class="stat-title">Faltantes</div>
                        <div class="stat-value"><?= $faltantes_webtoon ?></div>
                    </a>
                <?php endif; ?>

                <?php if ($sum_faltantes_webtoon > 0): ?>
                    <a href="../Webtoon/" class="stat-card dark-gray">
                        <i class="fas fa-pause stat-icon"></i>
                        <div class="stat-title">Total Capitulos Faltantes</div>
                        <div class="stat-value"><?= $sum_faltantes_webtoon ?></div>
                    </a>
                <?php endif; ?>

            </div>
        <?php endif; ?>
        <div class="section-divider">
            <span class="title">Pendientes</span>
        </div>

        <div class="cards-grid">
            <?php if ($sinver2 > 0): ?>
                <a href="../Pendientes/?sin-fechas=" class="stat-card gray">
                    <i class="fas fa-hourglass-half stat-icon"></i>
                    <div class="stat-title">Sin Verificar Pendientes</div>
                    <div class="stat-value"><?= $sinver2 ?></div>
                </a>
            <?php endif; ?>

            <?php if ($sinact3 > 0): ?>
                <a href="../Pendientes/?sin-actividad=" class="stat-card dark-gray">
                    <i class="fas fa-times-circle stat-icon"></i>
                    <div class="stat-title">Sin Actividad Reciente Pendientes (3 Años)</div>
                    <div class="stat-value"><?= $sinact3 ?></div>
                </a>
            <?php endif; ?>

            <a href="../Pendientes/?anime=" class="stat-card cyan">
                <i class="fas fa-tv stat-icon"></i>
                <div class="stat-title">Pendientes con Anime</div>
                <div class="stat-value"><?= $pendientes_anime ?></div>
            </a>
        </div>
    </div>

    <div class="section-divider text-center">

        <!-- Botón para mostrar/ocultar iframe -->
        <button id="toggle-btn" class="btn btn-primary">Mostrar Graficos</button>

        <!-- Contenedor para el iframe -->
        <div id="iframe-container">
            <iframe src="../graficos/graficos.php"></iframe>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggle-btn').addEventListener('click', function() {
            var iframeContainer = document.getElementById('iframe-container');
            if (iframeContainer.style.display === 'none') {
                iframeContainer.style.display = 'block';
                this.textContent = 'Ocultar Graficos'; // Cambiar texto del botón
            } else {
                iframeContainer.style.display = 'none';
                this.textContent = 'Mostrar Graficos'; // Cambiar texto del botón
            }
        });
    </script>
</body>

</html>