<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$idRegistros      = $_REQUEST['id'];
$diferencia       = $_REQUEST['dif'];
$fecha            = $_REQUEST['fecha'];
$link             = $_REQUEST['link'];
$ID_Manga         = $_REQUEST['ID_Manga'];


$sql      = ("SELECT * FROM $tabla7 where ID='$idRegistros';");
echo $sql;
$consulta = mysqli_query($conexion, $sql);


echo $ID_Manga;
echo "<br>";

$sql1      = ("SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE diferencias.ID_Manga='$ID_Manga';");
echo $sql1;
$consulta1 = mysqli_query($conexion, $sql1);

echo "<br>";

while ($fila = mysqli_fetch_assoc($consulta1)) {
    echo "Nombre: " . $fila['cantidad_productos'] . "<br>";
    $total=$fila['cantidad_productos'];
}

echo $total;


echo "<br>";
echo $idRegistros;
echo "<br>";
echo $diferencia;
echo "<br>";
echo $fecha;
echo "<br>";
echo $link;
echo "<br>";
/*
echo $dato5;
echo "<br>";
echo $dato6;
echo "<br>";
echo $dato8;
echo "<br>";
*/
echo "<br>";



        try {
            $sql = "DELETE FROM `$tabla7` WHERE $fila7='$idRegistros';";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }



        echo '<script>
    Swal.fire({
    icon: "success",
    title: "Elimando registro de ' . $fecha . ' en ' . $tabla7 . '",
    confirmButtonText: "OK"
    }).then(function() {
            window.location = "' . $link . '"; 
    });
    </script>';
        echo "<br>";


$sql2      = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga) ;");
echo $sql2;
$consulta = mysqli_query($conexion, $sql2);
echo "<br>";