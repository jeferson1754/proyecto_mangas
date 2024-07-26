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

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <title>Listas</title>
    <style>
        /* Google Fonts */
        @import url(https://fonts.googleapis.com/css?family=Open+Sans);

        /* set global font to Open Sans */
        body {
            font-family: 'Open Sans', 'sans-serif';
            background-image: url(http://benague.ca/files/pw_pattern.png);
        }

        /* header */
        h1 {
            color: #55acee;
            text-align: center;
        }

        /* header/copyright link */
        .link {
            text-decoration: none;
            color: #55acee;
            border-bottom: 2px dotted #55acee;
            transition: .3s;
            -webkit-transition: .3s;
            -moz-transition: .3s;
            -o-transition: .3s;
            cursor: url(http://cur.cursors-4u.net/symbols/sym-1/sym46.cur), auto;
        }

        .link:hover {
            color: #2ecc71;
            border-bottom: 2px dotted #2ecc71;
        }

        /* button div */
        #buttons {
            padding-top: 50px;
            text-align: center;
        }

        /* start da css for da buttons */
        .btn {
            border-radius: 5px;
            padding: 15px 25px;
            font-size: 22px;
            text-decoration: none;
            margin: 20px;
            color: #fff;
            position: relative;
            display: inline-block;
        }

        .btn:active {
            transform: translate(0px, 5px);
            -webkit-transform: translate(0px, 5px);
            box-shadow: 0px 1px 0px 0px;
        }

        .blue {
            background-color: #55acee;
            box-shadow: 0px 5px 0px 0px #3C93D5;
        }

        .blue:hover {
            background-color: #6FC6FF;
        }

        .green {
            background-color: #2ecc71;
            box-shadow: 0px 5px 0px 0px #15B358;
        }

        .green:hover {
            background-color: #48E68B;
        }

        .red {
            background-color: #e74c3c;
            box-shadow: 0px 5px 0px 0px #CE3323;
        }

        .red:hover {
            background-color: #FF6656;
        }

        .purple {
            background-color: #9b59b6;
            box-shadow: 0px 5px 0px 0px #82409D;
        }

        .purple:hover {
            background-color: #B573D0;
        }

        .orange {
            background-color: #e67e22;
            box-shadow: 0px 5px 0px 0px #CD6509;
        }

        .orange:hover {
            background-color: #FF983C;
        }

        .yellow {
            background-color: #f1c40f;
            box-shadow: 0px 5px 0px 0px #D8AB00;
        }

        .yellow:hover {
            background-color: #FFDE29;
        }

        .pink {
            background-color: #FF33CC;
            box-shadow: 0px 5px 0px 0px #CC0099;
        }

        .pink:hover {
            background-color: #FF80DF;
        }

        .gray {
            background-color: #BDBDBD;
            box-shadow: 0px 5px 0px 0px #8C8C8C;
        }

        .gray:hover {
            background-color: #E0E0E0;
        }

        .soft-purple {
            background-color: #CBC3E3;
            box-shadow: 0px 5px 0px 0px #8F89AB;
        }

        .soft-purple:hover {
            background-color: #ada3cc;
        }

        .cyan {
            background-color: #00BCD4;
            box-shadow: 0px 5px 0px 0px #0097A7;
        }

        .cyan:hover {
            background-color: #4DD0E1;
        }

        .dark-yellow {
            background-color: #FFD600;
            box-shadow: 0px 5px 0px 0px #FFA000;
        }

        .dark-yellow:hover {
            background-color: #FFE57F;
        }

        .lime {
            background-color: #CDDC39;
            box-shadow: 0px 5px 0px 0px #A4B42B;
        }

        .lime:hover {
            background-color: #D4E157;
        }

        .magenta {
            background-color: #FF00FF;
            box-shadow: 0px 5px 0px 0px #C71585;
        }

        .magenta:hover {
            background-color: #FF80AB;
        }

        .dark-blue {
            background-color: #1976D2;
            box-shadow: 0px 5px 0px 0px #1565C0;
        }

        .dark-blue:hover {
            background-color: #42A5F5;
        }

        .dark-gray {
            background-color: #616161;
            box-shadow: 0px 5px 0px 0px #424242;
        }

        .dark-gray:hover {
            background-color: #757575;
        }

        .dark-orange {
            background-color: #FF6D00;
            box-shadow: 0px 5px 0px 0px #E65100;
        }

        .dark-orange:hover {
            background-color: #FFA726;
        }


        /* copyright stuffs.. */
        p {
            text-align: center;
            color: #55acee;
            padding-top: 20px;
        }

        .linea-negra {
            height: 5px;
            background-color: gray;
            margin: 0px 15px;
            /* border: 2px solid gray;*/
        }


        @media screen and (max-width:870px) {

            body {
                background-color: black;
            }

            .btn {
                width: 45%;
                font-size: 18px;
                margin: 5px;
            }

            .linea-negra {
                height: 15px;
                margin: 10px 25px;
            }

        }
    </style>
</head>

<body>
    <?php include('menu.php');  ?>

    <div id="buttons">
        <a href="../?busqueda=&buscar=&accion=Busqueda" class="btn blue">Total Mangas<br><?= $totalMangas ?></a>
        <a href="../Tachiyomi/?busqueda=&buscar=" class="btn gray">Tachiyomi<br><?= $totalTachiyomi ?></a>
        <a href="../Webtoon/?borrar=&accion=HOY" class="btn green">Webtoon<br><?= $totalWebtoon ?></a>

        <!--Si la consulta da 0 no se muestra-->
        <?php if ($totalFaltantes > 0) : ?>
            <a href="../" class="btn red">Faltantes<br><?= $totalFaltantes ?></a>

        <?php endif; ?>

        <a href="../Pendientes/" class="btn orange">Pendientes<br><?= $totalPendientes ?></a>
        <a href="../Finalizados/" class="btn yellow">Finalizados<br><?= $totalFinalizados ?></a>

        <br>
        <div class="linea-negra"></div><!--LINEA DE LISTAS -->

        <a href="../?todos=Al+dia&accion=Filtro1" class="btn blue">Al dia<br><?= $lista1 ?></a>

        <a href="../?todos=Al+dia+2&accion=Filtro1&filtrar=" class="btn blue">Al dia 2<br><?= $lista2 ?></a>


        <a href="../?todos=Al+dia+3&accion=Filtro1&filtrar=" class="btn blue">Al dia 3<br><?= $lista3 ?></a>


        <a href="../?todos=Mangas&accion=Filtro1&filtrar=" class="btn green">Mangas<br><?= $lista4 ?></a>

        <a href="../?todos=Echii&accion=Filtro1&filtrar=" class="btn red">Echii<br><?= $lista5 ?></a>

        <a href="../?todos=Mangas+2&accion=Filtro1&filtrar=" class="btn green">Mangas 2<br><?= $lista6 ?></a>

        <a href="../?todos=Echii+2&accion=Filtro1&filtrar=" class="btn red">Echii 2<br><?= $lista7 ?></a>

        <a href="../?todos=Mangas+3&accion=Filtro1&filtrar=" class="btn green">Mangas 3<br><?= $lista8 ?></a>

        <a href="../?todos=Los+que+le+faltan+50+o+mas&accion=Filtro1&filtrar=" class="btn purple">Los que le faltan 50 o mas<br><?= $lista9 ?></a>

        <a href="../?todos=Otros&accion=Filtro1&filtrar=" class="btn yellow">Otros<br><?= $lista10 ?></a>

        <?php if ($lista11 > 0) : ?>

            <a href="../?todos=Sin+Lista&accion=Filtro1&filtrar=" class="btn orange">Sin Lista<br><?= $lista11 ?></a>

        <?php endif; ?>


        <br>

        <div class="linea-negra"></div><!--LINEA DE MANGA -->

        <?php if ($sinver1 > 0) : ?>
            <a href="../?sin-fechas=" class="btn green">Sin Verificar<br><?= $sinver1 ?></a>

        <?php endif; ?>

        <?php if ($sinact1 > 0) : ?>
            <a href="../?sin-actividad=" class="btn blue">Sin Actividad Reciente (3 Años)<br><?= $sinact1 ?></a>

        <?php endif; ?>

        <?php if ($max_50 > 0) : ?>
            <a class="btn purple">+50<br><?= $max_50 ?></a>

        <?php endif; ?>

        <?php if ($min_50 > 0) : ?>
            <a class="btn soft-purple">-50<br><?= $min_50 ?></a>

        <?php endif; ?>

        <?php if ($min_50_final > 0) : ?>
            <a class="btn yellow">-50 Finalizados<br><?= $min_50_final ?></a>

        <?php endif; ?>

        <?php if ($min_50_emision > 0) : ?>
            <a class="btn green">-50 Emision<br><?= $min_50_emision ?></a>

        <?php endif; ?>

        <?php if ($finalizados > 0) : ?>
            <a href="../?estado=Finalizado&accion=Filtro&filtrar4=" class="btn yellow">Finalizados<br><?= $finalizados ?></a>

        <?php endif; ?>

        <?php if ($pausados > 0) : ?>
            <a href="../?estado=Pausado&accion=Filtro&filtrar4=" class="btn orange">Pausados<br><?= $pausados ?></a>

        <?php endif; ?>



        <a class="btn cyan">Leidos Sin Faltantes<br><?= $sin_faltantes ?></a>

        <?php
        $query = $conexion->query("SELECT SUM(Faltantes) AS conteo FROM manga;");
        while ($valores = mysqli_fetch_array($query)) {
            $totalcaps_faltantes = $valores['conteo'];
        }
        ?>


        <?php if ($totalcaps_faltantes > 0) : ?>
            <a class="btn gray">Total de Capitulos Faltantes<br><?= $totalcaps_faltantes ?></a>

        <?php endif; ?>



        <a href="../?anime=" class="btn dark-gray">Mangas con Anime<br><?= $mangas_anime ?></a>

        <?php
        $query = $conexion->query("SELECT SUM(Faltantes) AS conteo FROM manga WHERE Faltantes<=3;");
        while ($valores = mysqli_fetch_array($query)) {
            $sinact6 = $valores['conteo'];
        }

        if ($sinact6 == 0) {
            $sinact6 = "4";
        }

        ?>


        <a href="../?capitulos=1&accion=Filtro3" class="btn dark-blue">Capitulos por Leer<br><?= $sinact6 ?></a>

        <div class="linea-negra"></div><!--LINEA DE TACHIYOMI -->

        <?php if ($sinact2 > 0) : ?>

            <a href="../Tachiyomi/?sin-actividad=" class="btn blue">Sin Actividad Reciente Tachiyomi<br>(3 Meses)<br><?= $sinact2 ?></a>

        <?php endif; ?>

        <?php if ($faltantes_tachiyomi > 0) : ?>

            <a href="../Tachiyomi" class="btn red">Faltantes<br><?= $faltantes_tachiyomi ?></a>

        <?php endif; ?>


        <div class="linea-negra"></div><!--LINEA DE PENDIENTES -->

        <?php if ($sinver2 > 0) : ?>

            <a href="../Pendientes/?sin-fechas=" class="btn green">Sin Verificar Pendientes <br><?= $sinver2 ?></a>

        <?php endif; ?>


        <?php if ($sinact3 > 0) : ?>

            <a href="../Pendientes/?sin-actividad=" class="btn blue">Sin Actividad Reciente Pendientes<br> (3 Años)<br><?= $sinact3 ?></a>

        <?php endif; ?>


        <a href="../Pendientes/?anime=" class="btn dark-gray">Pendientes con Anime<br><?= $pendientes_anime ?></a>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>


    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>