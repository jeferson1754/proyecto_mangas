<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';


$sql2 = "UPDATE `webtoon` SET `Capitulos Vistos` = `Capitulos Vistos` + `Faltantes` WHERE `$fila6` LIKE '%" . $day . "%' AND $fila8 ='Emision'";
$result2 = mysqli_query($conexion, $sql2);
//echo $sql2 . "<br>";


$sql3 = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`);";
$resultado3 = mysqli_query($conexion, $sql3);

header('location: index.php');
