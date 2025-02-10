<?php
if (isset($_GET['borrar'])) {
   $link = "./?busqueda_manga=&borrar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['todos'])) {
   $link = "./?todos=$estado&accion=Filtro1";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = $estado;
   $valor = $estado;
} else if (isset($_GET['linkeado'])) {
   $link = "./?linkeado=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['sin-fechas'])) {
   $link = "./?sin-fechas=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['sin-actividad'])) {
   $link = "./?sin-actividad=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['mayor-actividad'])) {
   $link = "./?mayor-actividad=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['anime'])) {
   $link = "./?anime=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['tachiyomi'])) {
   $link = "./?tachiyomi=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['buscar'])) {
   $link = "./?busqueda_manga=$busqueda&todos=&capitulos=&estado=&buscar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else {
   $link = "./?borrar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
}
