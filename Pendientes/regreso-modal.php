<?php
if (isset($_GET['borrar'])) {
    $link = "./?borrar=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";
 }else if (isset($_GET['buscar'])) {
    $link = "./?busqueda_webtoon=$busqueda&buscar=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";
 }else if (isset($_GET['filtrar'])) {
    $link = "./?estado=$estado&accion=Filtro&filtrar=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="Seleccione";
    $valor="";

 }else if (isset($_GET['linkeado'])) {
    $link = "./?link=";
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
