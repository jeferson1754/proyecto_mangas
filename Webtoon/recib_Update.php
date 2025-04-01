<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';

$idRegistros = $_REQUEST['id'];
$dato1      = $_REQUEST['fila1'];
$dato2      = $_REQUEST['fila2'];
$dato3      = $_REQUEST['fila3'];
$dato4      = $_REQUEST['fila4'];
$dato8      = $_REQUEST['fila8'];
$fecha_ultima  = $_REQUEST['fecha_ultima'];

if (isset($_POST['check_lista']) && is_array(value: $_POST['check_lista']) && !empty($_POST['check_lista'])) {
    $dato6 = addslashes(implode(", ", $_POST['check_lista']));
} else {
    // Aquí puedes manejar el caso de que no se hayan seleccionado días
    $dato6 = 'Indefinido';  // O asignar algún valor predeterminado
}


$link       = $_REQUEST['link'];

$sql = ("SELECT * FROM $tabla where $fila7='$idRegistros';");
$consulta = mysqli_query($conexion, $sql);


echo $sql;
echo "<br>";
$Tabla = ucfirst($tabla);
echo $link;
echo "<br>";

if (mysqli_num_rows($consulta) == 0) {
    echo "No Existe en $tabla";
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "No se puede editar porque ' . $fila1 . ' no existe en ' . $tabla . '",
            confirmButtonText: "OK"
    
        }).then(function() {
            window.location = "' . $link . '"; 
        });
        </script>';
} else {
    echo "Existe en $tabla";
    echo "<br>";

    try {
        // Conexión PDO con UTF-8
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos;charset=utf8mb4", $usuario, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Consulta SQL con parámetros preparados
        $sql = "UPDATE $tabla SET 
            `$fila1` = :dato1,
            `$fila2` = :dato2,
            `$fila3` = :dato3,
            `$fila4` = :dato4,
            `$fila8` = :dato8,
            `$fila6` = :dato6,
            `Fecha_Ultimo_Capitulo` = :dato7
        WHERE `$fila7` = :idRegistros";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':dato1' => $dato1,
            ':dato2' => $dato2,
            ':dato3' => $dato3,
            ':dato4' => $dato4,
            ':dato8' => $dato8,
            ':dato6' => $dato6,
            ':dato7' => $fecha_ultima,
            ':idRegistros' => $idRegistros
        ]);

        // SweetAlert de éxito
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Actualizando registro de ' . htmlspecialchars($dato1, ENT_QUOTES, 'UTF-8') . ' en ' . htmlspecialchars($Tabla, ENT_QUOTES, 'UTF-8') . '",
                confirmButtonText: "OK"
            }).then(() => {
                window.location = "' . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . '"; 
            });
        </script>';
    } catch (PDOException $e) {
        // SweetAlert de error
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error en la actualización",
                text: "' . addslashes($e->getMessage()) . '",
                confirmButtonText: "OK"
            }).then(() => {
                window.location = "' . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . '"; 
            });
        </script>';
    }


    echo "<br>";

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`)";
        $conn->exec($sql);
        echo $sql;
    } catch (PDOException $e) {
        $conn = null;
        echo $e;
        echo "<br>";
        echo $sql;
    }
}
    

//UPDATE `emision` SET `Capitulos` = '1' WHERE `emision`.`ID` = 19;
//SELECT SUM(Capitulos)+1 total FROM emision Where Nombre="Dragon Ball";




//$result_update = mysqli_query($conexion, $update);

//header("location:index.php");
