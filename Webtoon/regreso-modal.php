<?php
if (isset($_GET['borrar'])) {
   $link = "./?borrar=&accion=HOY";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['enviar'])) {
   $link = "./?enviar=&accion=HOY";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = $estado;
   $valor = $estado;
} else if (isset($_GET['buscar'])) {
   $link = "./?busqueda=$busqueda&buscar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['filtrar'])) {
   $link = "./?estado=$estado&accion=Filtro&filtrar=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else if (isset($_GET['link'])) {
   $link = "./?accion=HOY&link=";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
} else {
   $link = "./";
   echo "<input type='hidden' name='link' value='$link'>";
   $lista = "Seleccione";
   $valor = "";
}
