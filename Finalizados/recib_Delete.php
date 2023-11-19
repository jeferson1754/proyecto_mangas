<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$idRegistros      = $_REQUEST['id'];
$nombre           = $_REQUEST['name'];
$modulo           = $_REQUEST['modulo'];
$ID_Manga         = $_REQUEST['id_manga'];

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM `$tabla` WHERE $fila7='$idRegistros';";
    $conn->exec($sql);
    echo $sql;
    echo "<br>";
} catch (PDOException $e) {
    $conn = null;
    echo $e;
    echo "<br>";
    echo $sql;
}

if ($modulo == "manga") {

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM `$tabla7` WHERE $fila9='$ID_Manga';";
        $conn->exec($sql);
        echo $sql;
    } catch (PDOException $e) {
        $conn = null;
        echo $e;
        echo "<br>";
        echo $sql;
    }
} else {

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM `diferencias_pendientes` WHERE $fila15='$ID_Manga';";
        $conn->exec($sql);
        echo $sql;
    } catch (PDOException $e) {
        $conn = null;
        echo $e;
        echo "<br>";
        echo $sql;
    }
}


echo '<script>
    Swal.fire({
    icon: "success",
    title: "Elimando registro de ' . $nombre . ' en ' . $titulo2 . '",
    confirmButtonText: "OK"
    }).then(function() {
        window.location = "index.php";
    });
    </script>';

//header("location:index.php");
?>