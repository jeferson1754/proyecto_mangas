<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';

$fecha_actual = date('Y-m-d');

$idRegistros      = $_REQUEST['id'];
$nombre           = $_REQUEST['name'];
$modulo           = $_REQUEST['modulo'];
$ID_Manga         = $_REQUEST['id_manga'];

// Realizar la conexión a la base de datos una sola vez
try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}

// Obtener datos de emision
$sql1 = "SELECT * FROM finalizados_manga WHERE ID = :idRegistros";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute(['idRegistros' => $idRegistros]);
$emision = $stmt1->fetch(PDO::FETCH_ASSOC);

// Preparar datos para eliminar emision
$nombre = $emision['Nombre'];
$caps_total = $emision['Capitulos Totales'];
$link = $emision['Link'];


try {
    $sql = "DELETE FROM `$tabla` WHERE $fila7='$idRegistros';";
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "Error elimando $tabla : " . $e->getMessage();
}

echo $modulo . "<br>";



if ($modulo == "manga") {

    try {
        $sql = "DELETE FROM `$tabla7` WHERE $fila9='$ID_Manga';";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }

    try {
        $sql = "DELETE FROM `nombres_mangas` WHERE ID_Manga='$ID_Manga';";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }
} else if (($modulo == "pendientes_manga")) {

    try {
        $sql = "DELETE FROM `diferencias_pendientes` WHERE $fila15='$ID_Manga';";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }

    try {
        $sql = "DELETE FROM `nombres_pendientes` WHERE ID_Pendientes='$ID_Manga';";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }
}



// Lógica para Calificar
if (isset($_POST['Calificar_Ahora'])) {
    $sql = "INSERT INTO calificaciones_mangas (`Nombre`,`Link`, `Capitulos_Totales`) VALUES (:nombre, :enlace, :caps_total)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'enlace' => $link,
        'caps_total' => $caps_total
    ]);
    echo "Calificación insertada correctamente.";
    header("location:../Calificaciones/editar_stars.php?id=&nombre=$nombre");
} else if (isset($_POST['Calificar_Luego'])) {
    try {
        $sql = "INSERT INTO calificaciones_mangas (`Nombre`,`Link`, `Capitulos_Totales`) VALUES (:nombre, :enlace, :caps_total)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'nombre' => $nombre,
            'enlace' => $link,
            'caps_total' => $caps_total
        ]);
        echo "Calificación insertada correctamente.";
    } catch (PDOException $e) {
        echo "Error al insertar calificación: " . $e->getMessage();
    }


    echo '<script>
    Swal.fire({
    icon: "success",
    title: "Elimando registro de ' . $nombre . ' en ' . $titulo2 . ' y Creando Calificación en Pendiente",
    confirmButtonText: "OK"
    }).then(function() {
        window.location = "index.php";
    });
    </script>';
} else {
    echo '<script>
    Swal.fire({
    icon: "success",
    title: "Elimando registro de ' . $nombre . ' en ' . $titulo2 . '",
    confirmButtonText: "OK"
    }).then(function() {
        window.location = "index.php";
    });
    </script>';
}


//header("location:index.php");
?>