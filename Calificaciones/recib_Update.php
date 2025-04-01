<!---->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include '../bd.php';
$idRegistros    = $_POST['id'];
$nombre         = $_REQUEST['nombre'];
$link_imagen    = $_REQUEST['link_imagen'];
$caps_total    = $_REQUEST['caps_total'];
$link           = $_REQUEST['link'];

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE `calificaciones_mangas` SET Link_Imagen='" . $link_imagen . "', Capitulos_Totales='" . $caps_total . "' WHERE ID='" . $idRegistros . "'";
    $conn->exec($sql);
    //echo $sql;
    echo "<br>";
    $conn = null;
} catch (PDOException $e) {
    $conn = null;
    echo $e;
    echo '<script>
            Swal.fire({
                icon: "error",
                title: "La imagen de ' . $nombre . 'no se puede actualizar ",
                confirmButtonText: "OK"

            }).then(function() {
                window.location = "' . $link . '"; 
            });
            </script>';
}

echo '<script>
            Swal.fire({
                icon: "success",
                title: "Se actualizo la imagen de ' . $nombre . '",
                confirmButtonText: "OK"
            }).then(function() {
                window.location =  "' . $link . '"; 
            });
            </script>';
