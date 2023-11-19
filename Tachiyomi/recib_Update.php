<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$hora_actual = date('H:i:s');

$idRegistros = $_REQUEST['id'];
$dato1       = $_REQUEST['fila1'];
$dato2       = $_REQUEST['fila2'];
$dato8       = $_REQUEST['fila8'];
$dato6       = $_REQUEST['fila6'];
$estado      = $_REQUEST['fila10'];
$link        = $_REQUEST['link'];
$id_manga    = $_REQUEST['id_manga'];


//Verificacion de Estado del Link
if($dato2 == ""){
    $estado = "Faltante";
}

//Agranda la primera letra de la varible
$Tabla = ucfirst($tabla);

//Busca el registro en manga
$sql = ("SELECT * FROM $tabla2 where $fila7='$id_manga';");
$consulta = mysqli_query($conexion, $sql);

while ($resultado1 = mysqli_fetch_assoc($consulta)) {
    $fecha_nueva = $resultado1[$fila11];
}

//Busca el registro en tachiyomi
$sql1 = ("SELECT * FROM $tabla where $fila9='$idRegistros';");
$consulta1=mysqli_query($conexion, $sql1);

$Tabla = ucfirst($tabla);
$Tabla2 = ucfirst($tabla2);

echo $sql;
echo "<br>";
echo $sql1;
echo "<br>";
echo $estado;
echo "<br>";
echo $fecha_nueva;
echo "<br>";
echo $id_manga;
echo "<br>";
echo "$dato1 existe en $tabla";
echo "<br>";

//Hace la actualizacion en tachiyomi
try {
    $sql = "UPDATE $tabla SET 
    `$nombre`='" . $dato1 . "',
    `$fila2` ='" . $dato2 . "',
    `$fila8` ='" . $dato8 . "',
    `$fila6` ='" . $dato6 . "',
    `$fila10`='" . $estado . "',
    `$fila11`='" . $fecha_nueva . "'
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
        title: "Registro de ' . $dato1 . ' Existe en  ' . $Tabla . '",
        confirmButtonText: "OK"
    }).then(function() {
         window.location = "' . $link . '"; 
    });
    </script>';
}

echo "<br>";

try {
    $sql = "UPDATE $tabla2 SET 
    `$fila2` ='" . $dato2 . "',
    `$fila8` ='" . $dato8 . "',
    `$fila6` ='" . $dato6 . "',
    `$fila10`='" . $estado . "'
    WHERE `$fila7`='" . $id_manga . "'";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;

} catch (PDOException $e) {
    echo $e;
    echo "<br>";
    echo $sql;
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
    $sql = "UPDATE $tabla2 SET `$fila5`= (`$fila4`-`$fila3`);";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    echo $e;
    echo "<br>";
    echo $sql;
}

echo "<br>";

echo '<script>
    Swal.fire({
        icon: "success",
        title: "Actualizando ' . $dato1 . ' en ' . $Tabla . ' y ' . $Tabla2 . '",
        confirmButtonText: "OK"
    }).then(function() {
        window.location = "' . $link . '"; 
    });
</script>';

