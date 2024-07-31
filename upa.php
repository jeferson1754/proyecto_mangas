
<?php

date_default_timezone_set('America/Santiago');

$max_queries_per_hour = 1;

$current_time = date("Y-m-d H:i:s", time());

// Consultamos el número de consultas realizadas en la última hora
$query = "SELECT COUNT(*) AS num_queries FROM actualizaciones_webtoon WHERE Fecha > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$result = mysqli_query($conexion, $query);

// Si la consulta falla, lanzamos un error
if (!$result) {
    die("La consulta falló: " . mysqli_error($conexion));
}

$row = mysqli_fetch_assoc($result);
$num_queries_last_hour = $row["num_queries"];

// Liberamos el resultado de la consulta
mysqli_free_result($result);

$sql1 = ("SELECT CONCAT( CASE WEEKDAY(CURDATE()) 
    WHEN 0 THEN 'Lunes' 
    WHEN 1 THEN 'Martes' 
    WHEN 2 THEN 'Miercoles' 
    WHEN 3 THEN 'Jueves' 
    WHEN 4 THEN 'Viernes' 
    WHEN 5 THEN 'Sabado' 
    WHEN 6 THEN 'Domingo' 
    END ) 
    AS DiaActual;");

$date      = mysqli_query($conexion, $sql1);

while ($rows = mysqli_fetch_array($date)) {

    $day = $rows[0];
    //echo $day . "<br>";
}

$consulta = "SELECT COUNT(*) FROM webtoon WHERE `Dias Emision`='$day' and Estado='Emision';";
$result = mysqli_query($conexion, $consulta);
//echo $consulta;

while ($rows = mysqli_fetch_array($result)) {

    $count = $rows[0];
    //echo $count . "<br>";
}
/*
echo $num_queries_last_hour."<br>";
echo $max_queries_per_hour."<br>";
*/

// Si se han superado las consultas permitidas, lanzamos un error
if ($count >= 1) {


    if ($num_queries_last_hour < $max_queries_per_hour) {
        $query = "INSERT INTO actualizaciones_webtoon (Fecha) VALUES ('$current_time')";
        $result = mysqli_query($conexion, $query);

        $sql = "UPDATE webtoon SET Capitulos Totales=Capitulos Totales+1 WHERE Dias Emision='$day' and Estado='Emision';";
        $resultado = mysqli_query($conexion, $sql);
        //echo "Bien";

        $sql2 = "UPDATE webtoon SET Faltantes=Capitulos Totales-Capitulos Vistos;";
        $resultado2 = mysqli_query($conexion, $sql2);
    } else {
    }
} else {
}
