<?php

require("../bd.php");

$tabla = "manga";
$tabla2 = "lista";
$tabla3 = "estado";
$tabla4 = "tachiyomi";
$tabla5 = "finalizados_manga";
$tabla6 = "estado_link";
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

$fila10 = "Fecha_Cambio1";
$fila11 = "Fecha_Cambio2";
$fila12 = "Diferencia";
$fila13 = "Estado_Link";

$fila14 = "ID_Eliminado";
$fila15 = "ID_Pendientes";
$fila16 = "Modulo";

$fila17 = "Hora_Cambio";
$fila18 = "Dia";

$titulo1 = "Estado del Link";
$titulo2 = "Fecha de Ultima Actualizacion";
$titulo3 = "Cantidad";
$titulo4 = "Fecha";
$titulo5 = "Fecha de Penultimo Capitulo";
$titulo6 = "Tachiyomi";
$titulo7 = "Pendientes";

$ver = "verificado";

/*
$sql1      = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga );");
echo $sql1;
$consulta = mysqli_query($conexion, $sql1);
*/