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

$tabla = "pendientes_manga";
$tabla2 = "lista";
$tabla3 = "estado";
$tabla4 = "tachiyomi";
$tabla5 = "manga";
$tabla6 = "estado_link";
$tabla7 = "diferencias_pendientes";
$tabla8 = "diferencias";
$tabla9 = "finalizados_manga";

$fila1 = "Nombre";
$fila2 = "Link";
$fila3 = "Capitulos Vistos";
$fila4 = "Capitulos Totales";
$fila5 = "Faltantes";
$fila6 = "Lista";
$fila8 = "Estado";
$fila7 = "ID";
$fila9 = "ID_Pendientes";

$fila10 = "Fecha_Cambio1";
$fila11 = "Fecha_Cambio2";
$fila12 = "Diferencia";
$fila13 = "Estado_Link";

$fila14 = "ID_Eliminado";
$fila15 = "ID_Manga";
$fila16 = "Modulo";


$titulo1 = "Estado del Link";
$titulo2 = "Fecha de Ultima Actualizacion";
$titulo3 = "Cantidad";
$titulo4 = "Fecha";
$titulo5 = "Fecha de Penultimo Capitulo";
$titulo6 = "Tachiyomi";
$titulo7 = "Pendientes";

$ver = "verificado";
