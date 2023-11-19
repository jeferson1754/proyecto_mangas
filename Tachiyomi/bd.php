<?php

$usuario  = "root";
$password = "";
$servidor = "localhost";
$basededatos = "epiz_32740026_r_user";
$conexion = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
//mysqli_query($conexion,"SET SESSION collation_connection ='utf8'");
$dbo = mysqli_select_db($conexion, $basededatos) or die("Upps! Error en conectar a la Base de Datos");

//Linea para los caracteres �

// AGREGANDO CHARSET UTF8
if (!mysqli_set_charset($conexion, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($conexion));
    exit();
}

try {
    $db = new PDO("mysql:host={$servidor};dbname={$basededatos}", $usuario, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    die("Connection error: " . $exception->getMessage());
}

$tabla = "tachiyomi";
$tabla2 = "manga";
$tabla3 = "estado";
$tabla4 = "lista";
$tabla5 = "estado_link";
$tabla6 = "finalizados_manga";
$tabla7 = "diferencias";
$tabla8 = "pendientes_manga";
$tabla9 = "diferencias_pendientes";

$fila1 = "Nombre";
$fila2 = "Link";
$fila3 = "Capitulos Vistos";
$fila4 = "Capitulos Totales";
$fila5 = "Faltantes";
$fila6 = "Lista";
$fila8 = "Estado";
$fila7 = "ID";
$fila9 = "ID_Manga";
$fila10 = "Estado_Link";

$fila11 = "Fecha_Cambio1";
$fila12 = "Fecha_Cambio2";
$fila13 = "Diferencia";

$fila14 = "ID_Eliminado";
$fila15 = "ID_Pendientes";

$nombre = "Nombre";
$ver = "verificado";

$titulo1 = "Mangas";
$titulo2 = "Tachiyomi";
$titulo3 = "Estado del Link";
$titulo4 = "Fecha";
