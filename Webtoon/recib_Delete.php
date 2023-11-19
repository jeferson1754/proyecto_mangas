<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php

include 'bd.php';

$idRegistros = $_REQUEST['id'];
$dato1      = $_REQUEST['nombre'];
$link       = $_REQUEST['link'];

echo $link;
echo "<br>";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM `$tabla` WHERE id='$idRegistros'";
    $conn->exec($sql);
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
            title: "Eliminado registro de ' . $dato1 . ' en ' . $tabla . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
        </script>';

//header("location:index.php");
?>