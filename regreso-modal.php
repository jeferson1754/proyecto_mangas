<?php
if (isset($_GET['borrar'])) {
   $link = "./?busqueda_manga=&borrar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
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
} else if (isset($_GET['buscar'])) { //
   // Nos aseguramos de que ninguna variable sea un array o contenga el texto "Array"
   $busqueda_clean = (is_array($busqueda) || strtolower($busqueda) === 'array') ? '' : $busqueda;
   $listas_clean = (is_array($listas) || strtolower($listas) === 'array') ? '' : $listas;
   $capitulos_clean = (is_array($capitulos) || strtolower($capitulos) === 'array') ? '' : $capitulos;
   $estado_clean = (is_array($estado) || strtolower($estado) === 'array') ? '' : $estado;

   // Construimos el enlace codificando correctamente los parámetros
   $link = "./?busqueda_manga=" . urlencode($busqueda_clean) . "&todos=" . urlencode($listas_clean) . "&capitulos=" . urlencode($capitulos_clean) . "&estado=" . urlencode($estado_clean) . "&buscar="; //
   echo "<input type='hidden' name='link' value='$link'>"; //
   $lista = "Seleccione"; //
   $valor = ""; //
}else if (isset($_GET['tmo'])) {
   $link = "./?tmo=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['cantidad-tmo'])) {
   $link = "./?cantidad-tmo=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else {
   $link = "./";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
}
