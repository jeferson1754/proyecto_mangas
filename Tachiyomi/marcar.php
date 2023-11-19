<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';


$sql2 = "UPDATE `tachiyomi` INNER JOIN `manga` ON `manga`.`ID` = `tachiyomi`.`ID_Manga` 
SET `tachiyomi`.`Capitulos Vistos` = `tachiyomi`.`Capitulos Vistos` + `tachiyomi`.`Faltantes`,
    `manga`.`Capitulos Vistos` = `manga`.`Capitulos Vistos` + `manga`.`Faltantes`
WHERE `tachiyomi`.`Faltantes` <= 3 AND `tachiyomi`.`Faltantes` != 0;";
$result2 = mysqli_query($conexion, $sql2);
//echo $sql2 . "<br>";

$sql3 = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`);";
$resultado3 = mysqli_query($conexion, $sql3);
//echo $sql3 . "<br>";

$sql5 = "UPDATE $tabla2 SET `$fila5`= (`$fila4`-`$fila3`);";
$resultado5 = mysqli_query($conexion, $sql5);
//echo $sql5;


echo '<script>
    Swal.fire({
        title: "Exito!",
        text: "Se actualizaron los mangas con 3 capitulos o menos.",
        icon: "success",
        showConfirmButton: false,
        timer: 2500
    }).then(function() {
        window.location = "index.php";
    });
    </script>';
echo "<br>";
