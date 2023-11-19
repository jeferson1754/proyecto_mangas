<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$ID_Manga         = $_REQUEST['id_manga'];
$nombre           = $_REQUEST['nombre'];
$link           = $_REQUEST['link'];


if (isset($_REQUEST["checkbox"])) {
    $checkbox = $_REQUEST["checkbox"];
    // Hacer algo con $checkbox1Value
    echo "Verificado_Verdadero";
    echo "<br>";
    echo $checkbox;

}else{
    $checkbox ="NO";
    echo "Verificado_Falso";
    echo "<br>";
    echo $checkbox;
}

echo "<br>";
echo $ID_Manga;
echo "<br>";

try {
    $sql = "UPDATE `$tabla` SET $ver='$checkbox' WHERE $fila7='$ID_Manga';";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    echo $e;
    echo "<br>";
    echo $sql;
}

 echo '<script>
        Swal.fire({
        icon: "success",
        title: "Manga:' . $nombre . ' - Verificado Exitosamente",
        confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';