<!--coment
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>
-->
<?php
include 'bd.php';

$hora_actual = date('H:i:s');
$idRegistros  = $_REQUEST['id'];
$nombre       = $_REQUEST['nombre'];
$total        = $_REQUEST['total'];
$caps         = $_REQUEST['capitulos'];
$link         = $_REQUEST['link'];
$fecha_ultima = $_REQUEST['fecha'];
$fecha_actual = $_REQUEST['fecha_cap'];

//Agranda la primera letra de la varible
$Tabla = ucfirst($tabla);
$Tabla4 = ucfirst($tabla4);

$sql = ("SELECT * FROM $tabla WHERE $fila7='$idRegistros';");

$consulta      = mysqli_query($conexion, $sql);

//Busca el fecha de la ultima actualizacion en mangas
$sql3 = ("SELECT `$fila10` FROM $tabla where $fila7='$idRegistros';");
$consulta2 = mysqli_query($conexion, $sql3);

//Saca la ultima fecha registrada
while ($fila1 = mysqli_fetch_assoc($consulta2)) {
    $fecha_antigua = $fila1[$fila10];
}

echo $fecha_ultima;
echo "<br>";
echo $fecha_actual;
$nueva_fecha = date('Y-m-d H:i:s', strtotime($fecha_actual . ' ' . $hora_actual));
echo "<br>";
echo $nueva_fecha;
echo "<br>";
echo $fecha_antigua;
echo "<br>";
echo $idRegistros;
echo "<br>";
echo $nombre;
echo "<br>";
echo $total;
echo "<br>";
echo $caps;
echo "<br>";
echo $sql;
echo "<br>";
echo $link;
echo "<br>";
echo "Fecha Ultimo Capitulo : " . $fecha_ultima;
echo "<br>";
echo "Fecha Nuevo Capitulo : " . $fecha_actual;
echo "<br>";

//Hacer la resta de dias
$fechaInicio = new DateTime($fecha_nueva);
$fechaFin = new DateTime($fecha_ultima);
$diferencia = $fechaInicio->diff($fechaFin);

$dias = $diferencia->days;
echo "Dias :" . $dias;
echo "<br>";
echo "$nombre existe en $tabla";
echo "<br>";

if ($fecha_antigua == $fecha_nueva) {
    echo "Las ultimas dos fechas son iguales";
} else {
    echo "Las ultimas dos fechas  no son iguales";
    echo "<br>";

    //Hace el ingreso de datos en diferencias
    try {
        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`) VALUES ('" . $idRegistros . "', '" . $dias . "', '" . $nueva_fecha . "');";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql;
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }
}

echo "<br>";

//Hace la actualizacion en mangas
try {
    $sql = "UPDATE $tabla SET 
    `$fila4` ='" . $total . "',
    `$fila10`='" . $fecha_actual . "',
    `$fila11`='" . $fecha_antigua . "'
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
        title: "Registro de ' . $nombre . ' Existe en  ' . $titulo7 . '",
        confirmButtonText: "OK"
    }).then(function() {
         window.location = "' . $link . '"; 
    });
    </script>';
}



echo '<script>
        Swal.fire({
            icon: "success",
            title: "Actualizando Capitulos Totales de ' . $nombre . ' en ' . $titulo7 . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';


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
$sql3 = ("UPDATE $tabla SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM $tabla7 WHERE $tabla.ID = $tabla7.$fila9) ;");
echo $sql3;
$consulta3 = mysqli_query($conexion, $sql3);
echo "<br>";
echo $link;
echo "<br>";
