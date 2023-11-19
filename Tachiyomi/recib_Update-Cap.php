<!--- -->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$idRegistros = $_REQUEST['id'];
$nombre      = $_REQUEST['nombre'];
$vistos      = $_REQUEST['vistos'];
$caps        = $_REQUEST['capitulos'];
$id_manga    = $_REQUEST['id_manga'];
$link        = $_REQUEST['link'];


$sql  = ("SELECT * FROM $tabla WHERE '$fila3' > '$fila4' and $fila7='$idRegistros';");
$sql1 = ("SELECT (`$fila4`-`$fila3`) FROM `$tabla` where $fila7='$idRegistros';");

$emision      = mysqli_query($conexion, $sql);
$validar      = mysqli_query($conexion, $sql1);

while ($rows = mysqli_fetch_array($validar)) {

    echo $idRegistros;
    echo "<br>";
    echo $nombre;
    echo "<br>";
    echo $vistos;
    echo "<br>";
    echo $sql;
    echo "<br>";
    echo $sql1;
    echo "<br>";
    echo $caps;
    echo "<br>";
    echo $link;
    echo "<br>";


    if ($vistos <= $rows[0]) {
        echo "capitulos permitidos: " . $rows[0] . "<br>";
        echo "Esta bien  ";
        echo "<br>";
        echo "" . $rows[0] . "<=" . $vistos . "";
        echo "<br>";
        try {

            $sql = "UPDATE $tabla SET `$fila3` ='" . $caps . "'+'" . $vistos . "' WHERE $fila7='" . $idRegistros . "' AND '$fila3' > '$fila4';";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
            echo "<br>";
            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Actualizando Capitulos Vistos de ' . $nombre . ' en Tachiyomi",
                confirmButtonText: "OK"
            }).then(function() {
      window.location = "' . $link . '";
            });
            </script>';
        } catch (PDOException $e) {
            $conn = null;
        }

        try {
            $sql = "UPDATE $tabla2 SET `$fila3` ='" . $caps . "'+'" . $vistos . "' WHERE $fila7='" . $id_manga . "' AND '$fila3' > '$fila4';";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
        } catch (PDOException $e) {
            $conn = null;
        }

         echo "<br>";

        try {
            $sql = "UPDATE $tabla2 SET `$fila5`= (`$fila4`-`$fila3`);";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }

         echo "<br>";

        try {
            $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`);";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }
    } else {
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Los Capitulos Ingresados  de ' . $nombre . ' Superan el Total Permitido",
            confirmButtonText: "OK"
        }).then(function() {
             window.location = "' . $link . '";
        });
        </script>';
        echo "capitulos permitidos: " . $rows[0] . "<br>";
        echo "" . $rows[0] . "<=" . $vistos . "";
        echo "<br>";
        echo "los capitulos vistos superan el total";
        echo "<br>";
        try {

            $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`);";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }

        echo "<br>";

        try {
            $sql = "UPDATE $tabla2 SET `$fila5`= (`$fila4`-`$fila3`)";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }
    }
}
