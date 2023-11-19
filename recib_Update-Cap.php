<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';

$idRegistros  = $_REQUEST['id'];
$nombre       = $_REQUEST['nombre'];
$caps         = $_REQUEST['capitulos'];
$link         = $_REQUEST['link'];
$id_manga     = $_REQUEST['id_manga'];
$vistos        = $_REQUEST['vistos'];

//Agranda la primera letra de la varible
$Tabla = ucfirst($tabla);
$Tabla4 = ucfirst($tabla4);

$sql = ("SELECT * FROM $tabla WHERE $fila7='$idRegistros';");
$sql2 = ("SELECT * FROM $tabla4 where $fila9='$idRegistros';");

$consulta1    = mysqli_query($conexion, $sql2);
$consulta      = mysqli_query($conexion, $sql);

//Busca el fecha de la ultima actualizacion en mangas
$sql3 = ("SELECT `$fila5` FROM $tabla where $fila7='$idRegistros';");
$consulta2=mysqli_query($conexion, $sql3);

//Saca la ultima fecha registrada
while ($fila1 = mysqli_fetch_assoc($consulta2)) {
    $total = $fila1[$fila5];
}

echo $idRegistros;
echo "<br>";
echo $nombre;
echo "<br>";
echo "Faltantes: ".$total;
echo "<br>";
echo $caps;
echo "<br>";
echo $vistos;
echo "<br>";
echo $sql;
echo "<br>";
echo $sql2;
echo "<br>";
echo $link;
echo "<br>";


if($vistos <= $total){
    echo "Los capitulos vistos son menores a los totales";
    echo "<br>";
    //Hace la actualizacion en mangas
    try {
        $sql = "UPDATE $tabla SET 
        `$fila3` =" . $caps . " + " . $vistos . "
        WHERE `$fila7`='" . $idRegistros . "'";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql;
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Registro de ' . $nombre . ' Existe en  ' . $Tabla . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
        </script>';
    }

    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Actualizando Capitulos Vistos de ' . $nombre . ' en ' . $Tabla . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';

    if(mysqli_num_rows($consulta1) > 0) {
        echo "Existe en $tabla4 y en $tabla";
        echo "<br>";

        //Actualiza los datos requeridos en tachiyomi
        try {
            $sql = "UPDATE $tabla4 SET 
            `$fila3` =" . $caps . " + " . $vistos . "
            WHERE `$fila9`='" . $idRegistros . "';";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
        } catch (PDOException $e) {
            echo $e;
            echo "<br>";
            echo $sql;
            echo '<script>
            Swal.fire({
                icon: "error",
                title: "Registro de ' . $nombre . ' Existe en  ' . $Tabla . ' y en ' . $Tabla4 . '",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '"; 
            });
            </script>';
        }  

    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Actualizando Capitulos Vistos de ' . $nombre . ' en ' . $Tabla . ' y en ' . $Tabla4 . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';

    }

}else{
    echo"Los capitulos vistos son mayores a los totales";
    echo "<br>";
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "Los Capitulos Vistos de ' . $nombre . ' son Mayores al Total",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';
}



echo "<br>";

//Hace la actualizacion general de faltantes de mangas
try {
    $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`);";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    echo $e;
    echo "<br>";
    echo $sql;
}
    
echo "<br>";

//Hace la actualizacion general de faltantes de tachiyomi
try {
    $sql = "UPDATE $tabla4 SET `$fila5`= (`$fila4`-`$fila3`);";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    echo $e;
    echo "<br>";
    echo $sql;
}

echo "<br>";

//Hace una actualizacion general de las cantidad de diferencias con el ID Manga
$sql3 = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga) ;");
echo $sql3;
$consulta3 = mysqli_query($conexion, $sql3);
echo "<br>";
echo $link;
echo "<br>";



