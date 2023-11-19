<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$dato1      = $_REQUEST['fila1'];
$dato2      = $_REQUEST['fila2'];
$dato3      = $_REQUEST['fila3'];
$dato4      = $_REQUEST['fila4'];
$dato8      = $_REQUEST['fila8'];
$link       = $_REQUEST['link'];

$sql      = ("SELECT * FROM $tabla where $fila1='$dato1';");
$consulta = mysqli_query($conexion, $sql);

echo $sql;
echo "<br>";
echo $fila1;
echo "<br>";
echo $dato1;
echo "<br>";
echo $link;
echo "<br>";
$Tabla = ucfirst($tabla);



if (mysqli_num_rows($consulta) == 0) {

    echo "$dato1 no existe en $tabla";
    echo "<br>";


    ob_start();
    require_once 'bd.php';
    $dato1 = htmlentities($_POST['fila1']);
    $dato2 = htmlentities($_POST['fila2']);
    $dato3 = htmlentities($_POST['fila3']);
    $dato4 = htmlentities($_POST['fila4']);
    $dato8 = htmlentities($_POST['fila8']);
    $check = addslashes(implode(", ", $_POST['check_lista']));

    $query = $db->prepare("INSERT INTO $tabla(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila6`,`$fila8`) VALUES (:nombres,:link,:vistos,:totales,:dias,:estado)");

    $query->bindParam(":nombres", $dato1);
    $query->bindParam(":link", $dato2);
    $query->bindParam(":vistos", $dato3);
    $query->bindParam(":totales", $dato4);
    $query->bindParam(":dias", $check);
    $query->bindParam(":estado", $dato8);
    $query->execute();

    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Creando Registro de ' . $dato1 . '  en  ' . $Tabla . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
        </script>';

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
} else {

    echo "$dato1 existe en $tabla";

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

    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Registro de ' . $dato1 . ' Existe en  ' . $Tabla . '",
        confirmButtonText: "OK"
    }).then(function() {
        window.location = "' . $link . '"; 
    });
    </script>';
}
