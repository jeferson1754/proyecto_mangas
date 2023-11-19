<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$idRegistros      = $_REQUEST['id'];
$nombre           = $_REQUEST['name'];
$ID_Manga         = $_REQUEST['id_manga'];

$sql = ("SELECT * FROM $tabla WHERE $fila7='$idRegistros';");
$consulta      = mysqli_query($conexion, $sql);
echo $sql;
echo "<br>";

while ($mostrar = mysqli_fetch_array($consulta)) {
    $dato1 = $mostrar[$fila1];
    $dato2 = $mostrar[$fila2];
    $dato3 = $mostrar[$fila3];
    $dato4 = $mostrar[$fila4];
    $dato5 = $mostrar[$fila5];
    $dato6 = $mostrar[$fila6];
    $dato8 = $mostrar[$fila8];
    $dato10 = $mostrar[$fila10];
    $dato11 = $mostrar[$fila11];
    $dato13 = $mostrar[$fila13];
    $dato16 = $mostrar[$fila16];
}

echo $dato1;
echo "<br>";
echo $dato2;
echo "<br>";
echo $dato3;
echo "<br>";
echo $dato4;
echo "<br>";
echo $dato5;
echo "<br>";
echo $dato6;
echo "<br>";
echo $dato8;
echo "<br>";
echo $dato10;
echo "<br>";
echo $dato11;
echo "<br>";
echo $dato13;
echo "<br>";
echo $dato16;
echo "<br>";
echo $idRegistros;
echo "<br>";
echo $ID_Manga;
echo "<br>";

try {
    $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO `$dato16`(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila5`, `$fila6`,`$fila8`,`$fila10`,`$fila11`,`$fila13`,`$ver`) VALUES
    ('" . $dato1 . "','" . $dato2 . "','" . $dato3 . "','" . $dato4 . "','" . $dato5 . "','" . $dato6 . "','Finalizado','" . $dato10 . "','" . $dato11 . "','" . $dato13 . "','NO')";
    $conn->exec($sql);
    echo $sql;
    echo "<br>";
} catch (PDOException $e) {
    $conn = null;
    echo $e;
    echo "<br>";
    echo $sql;
}
            
//Busca el id de la manga recien insertado
$consulta1 = "SELECT * FROM `$dato16` where Nombre='$dato1'";
$resultado1 = mysqli_query($conexion, $consulta1);
echo $consulta1;
echo "<br>";

while ($fila1 = mysqli_fetch_assoc($resultado1)) {
    $iden = $fila1['ID'];
}

echo "ID :".$iden;
echo "<br>";


if($dato16=="manga"){

    echo "Modulo - Manga";
     echo "<br>";

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE `diferencias` SET $fila9='$iden' where diferencias.ID_Manga = $ID_Manga;";
        //$conn->exec($sql);
        echo $sql;
        echo "<br>";
    } catch (PDOException $e) {
        $conn = null;
        echo $e;
        echo "<br>";
        echo $sql;
    }

    //Hace una actualizacion general de las cantidad de diferencias con el ID Manga
    $sql3 = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga) ;");
    echo $sql3;
    $consulta3 = mysqli_query($conexion, $sql3);
    echo "<br>";

}else{
    echo "Modulo - Pendientes";
     echo "<br>";
    
    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE `diferencias_pendientes` SET ID_Pendientes='$iden' where diferencias_pendientes.ID_Pendientes = $ID_Manga;";
        $conn->exec($sql);
        echo $sql;
        echo "<br>";
    } catch (PDOException $e) {
        $conn = null;
        echo $e;
        echo "<br>";
        echo $sql;
    }

    //Hace una actualizacion general de las cantidad de diferencias con el ID Manga
    $sql3 = ("UPDATE pendientes_manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias_pendientes WHERE pendientes_manga.ID = diferencias_pendientes.ID_Pendientes) ;");
    echo $sql3;
    $consulta3 = mysqli_query($conexion, $sql3);
    echo "<br>";
}


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





echo '<script>
    Swal.fire({
    icon: "success",
    title: "Recuperando Manga de ' . $nombre . ' en ' . $dato16 . '",
    confirmButtonText: "OK"
    }).then(function() {
        window.location = "index.php";
    });
    </script>';

//header("location:index.php");
?>