<?php
if (isset($_GET['borrar'])) {
    $link = "./?busqueda_pendientes_manga=&borrar=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";
 }else if (isset($_GET['buscar'])) {
    $link = "./?busqueda_pendientes_manga=$busqueda&buscar=&accion=Busqueda";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";
 }else if (isset($_GET['filtrar'])) {
    $link = "./?estado=$estado&accion=Filtro2&filtrar=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";

 }else if (isset($_GET['linkeado'])) {
    $link = "./?linkeado=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";

 }else if (isset($_GET['sin-fechas'])) {
    $link = "./?sin-fechas=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";

 }else if (isset($_GET['anime'])) {
   $link = "./?anime=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista="Seleccione";
   $valor="";

}else{
    $link = "./";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";
 }
