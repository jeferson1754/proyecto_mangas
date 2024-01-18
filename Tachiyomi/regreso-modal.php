<?php
if (isset($_GET['borrar'])) {
    $link = "./?busqueda_tachi=&borrar=";
    echo "<input type='hidden' name='link' value='$link'>";
 }else if (isset($_GET['buscar'])) {
    $link = "./?busqueda_tachi=$busqueda&buscar=&accion=Busqueda";
    echo "<input type='hidden' name='link' value='$link'>";
}else if (isset($_GET['filtrar'])) {
    $link = "./?estado=$estado&accion=Filtro1&filtrar=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista=$estado;
    $valor=$estado;
}else if (isset($_GET['linkeado'])) {
    $link = "./?linkeado=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="";
    $valor="";
}else if (isset($_GET['sin-actividad'])) {
    $link = "./?sin-actividad=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="";
    $valor="";
}else if (isset($_GET['mayor-actividad'])) {
    $link = "./?mayor-actividad=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="";
    $valor="";
}else if (isset($_GET['sin-fechas'])) {
    $link = "./?sin-fechas=";
    echo "<input type='hidden' name='link' value='$link'>";
    $lista="";
    $valor="";
}else{
    $link = "./";
    echo "<input type='hidden' name='link' value='$link'>";
 }
