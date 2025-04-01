<?php
if (isset($_GET['borrar'])) {
   $link = "./?borrar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['enviar'])) {
   $link = "./?enviar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "";
   $valor = "";
} else if (isset($_GET['buscar'])) {
   $link = "./?estado=$estado_manga&busqueda_webtoon=$busqueda&buscar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['link'])) {
   $link = "./?link=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['faltantes'])) {
   $link = "./?faltantes=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['sin-actividad'])) {
   $link = "./?sin-actividad=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else {
   $link = "./";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
}
