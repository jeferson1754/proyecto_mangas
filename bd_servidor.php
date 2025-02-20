<?php

$usuario  = "epiz_32740026";
$password = "eJWcVk2au5gqD";
$servidor = "sql208.epizy.com";
$basededatos = "epiz_32740026_r_user";
$conexion = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
mysqli_query($conexion, "SET SESSION collation_connection ='utf8_unicode_ci'");
$db = mysqli_select_db($conexion, $basededatos) or die("Upps! Error en conectar a la Base de Datos");

try {
    $connect = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}


//Linea para los caracteres �

if (!mysqli_set_charset($conexion, "utf8mb4")) {
    printf("Error loading character set utf8mb4: %s\n", mysqli_error($conexion));
    exit();
}

if (mysqli_connect_errno()) {
    die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
}


$max_queries_per_hour = 700;

$current_time = date("Y-m-d H:i:s", time());

// Consultamos el número de consultas realizadas en la última hora
$query = "SELECT COUNT(*) AS num_queries FROM consultas WHERE fecha > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
$result = mysqli_query($conexion, $query);

// Si la consulta falla, lanzamos un error
if (!$result) {
    die("La consulta falló: " . mysqli_error($conexion));
}

$row = mysqli_fetch_assoc($result);
$num_queries_last_hour = $row["num_queries"];

// Liberamos el resultado de la consulta
mysqli_free_result($result);

// Si se han superado las consultas permitidas, lanzamos un error
if ($num_queries_last_hour >= $max_queries_per_hour) {
    mysqli_close($conexion); // Cerramos la conexión a la base de datos
    die("Lo siento, has superado el límite de consultas por hora.");
}

$query = "INSERT INTO consultas (fecha) VALUES ('$current_time')";
$result = mysqli_query($conexion, $query);

if (!$result) {
    die("La consulta falló: " . mysqli_error($conexion));
}

try {
    $db = new PDO("mysql:host={$servidor};dbname={$basededatos}", $usuario, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    die("Connection error: " . $exception->getMessage());
}

include('funciones.php');

$tabla="manga";
$tabla2="lista";
$tabla3="estado";
$tabla4="tachiyomi";
$tabla5="finalizados_manga";
$tabla6="estado_link";
$tabla7="diferencias";
$tabla8="pendientes_manga";
$tabla9="diferencias_pendientes";

$fila1="Nombre";
$fila2="Link";
$fila3="Capitulos Vistos";
$fila4="Capitulos Totales";
$fila5="Faltantes";
$fila6="Lista";
$fila8="Estado";
$fila7="ID";
$fila9 = "ID_Manga";

$fila10 ="Fecha_Cambio1";
$fila11 ="Fecha_Cambio2";
$fila12 ="Diferencia";
$fila13="Estado_Link";

$fila14="ID_Eliminado";
$fila15="ID_Pendientes";
$fila16="Modulo";

$fila17="Hora_Cambio";

$titulo1="Estado del Link";
$titulo2="Fecha de Ultima Actualizacion";
$titulo3="Cantidad";
$titulo4="Fecha";
$titulo5="Fecha de Penultimo Capitulo";
$titulo6="Tachiyomi";
$titulo7="Pendientes";

$ver="verificado";

/*
$sql1      = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga );");
echo $sql1;
$consulta = mysqli_query($conexion, $sql1);
*/