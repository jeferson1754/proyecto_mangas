<!---->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$idRegistros = $_REQUEST['id'];
$nombre      = $_REQUEST['nombre'];
$vistos      = $_REQUEST['vistos'];
$caps      = $_REQUEST['capitulos'];
$link       = $_REQUEST['link'];

$sql = ("SELECT * FROM $tabla WHERE '$fila3' > '$fila4' and $fila7='$idRegistros';");
$sql1 = ("SELECT (`$fila4`-`$fila3`) FROM `$tabla` where $fila7='$idRegistros';");

$emision      = mysqli_query($conexion, $sql);
$validar      = mysqli_query($conexion, $sql1);

while ($rows = mysqli_fetch_array($validar)) {


    //UPDATE `emision` SET `Capitulos` = '1' WHERE `emision`.`ID` = 19;
    //UPDATE `emision` SET `Capitulos`=Capitulos+1 WHERE Nombre="Dragon Ball";

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
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE $tabla SET `$fila3` ='" . $caps . "'+'" . $vistos . "' WHERE $fila1='" . $nombre . "' AND '$fila3' > '$fila4';";
            $conn->exec($sql);
            echo $sql;
            echo "<br>";
            echo "<br>";
            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Actualizando Capitulos  de ' . $nombre . ' en Mangas",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '"; 
            });
            </script>';
        } catch (PDOException $e) {
            $conn = null;
        }

        try {
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`);";
            $conn->exec($sql);
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

        try {
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`);";
            $conn->exec($sql);
            echo $sql;
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }

        try {
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE $tabla4 SET `$fila5`= (`$fila4`-`$fila3`)";
            $conn->exec($sql);
            echo $sql;
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }
    }
}



//$result_update = mysqli_query($conexion, $update);

//header("location:index.php");
