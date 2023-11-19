<!----->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';

$hora_actual = date('H:i:s');
$idRegistros  = $_REQUEST['id'];
$idManga      = $_REQUEST['id_manga'];
$nombre       = $_REQUEST['nombre'];
$total        = $_REQUEST['total'];
$caps         = $_REQUEST['capitulos'];
$link         = $_REQUEST['link'];
$fecha_ultima = $_REQUEST['fecha'];
$fecha_actual = $_REQUEST['fecha_cap'];
$cantidad     = $_REQUEST['cantidad'];


$sql = ("SELECT * FROM $tabla WHERE $fila7='$idRegistros';");
$sql2 = ("SELECT * FROM $tabla2 where $fila7='$idManga';");

$consulta1    = mysqli_query($conexion, $sql2);
$consulta      = mysqli_query($conexion, $sql);

//Busca el fecha de la ultima actualizacion en mangas
$sql3 = ("SELECT `$fila11` FROM $tabla where $fila9='$idManga';");
$consulta2 = mysqli_query($conexion, $sql3);

//Saca la ultima fecha registrada
while ($columna = mysqli_fetch_assoc($consulta2)) {
    $fecha_antigua = $columna[$fila11];
}

// Convierte la fecha a un timestamp
$timestamp = strtotime(str_replace('-', '/', $fecha_actual));

// Array asociativo para traducir nombres de días
$diasSemana = array(
    'Monday'    => 'Lunes',
    'Tuesday'   => 'Martes',
    'Wednesday' => 'Miercoles',
    'Thursday'  => 'Jueves',
    'Friday'    => 'Viernes',
    'Saturday'  => 'Sabado',
    'Sunday'    => 'Domingo'
);

// Obtiene el nombre del día en español
$nombreDia = date('l', $timestamp);
$nombreDiaEspañol = $diasSemana[$nombreDia];

echo $nombreDiaEspañol;
echo "<br>";

echo $fecha_ultima;
echo "<br>";
echo $fecha_actual;
echo "<br>";
echo $fecha_antigua;

$nueva_fecha = date('Y-m-d H:i:s', strtotime($fecha_actual . ' ' . $hora_actual));

echo "<br>";
echo $nueva_fecha;
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
echo $sql2;
echo "<br>";
echo $sql3;
echo "<br>";
echo $link;
echo "<br>";
echo $cantidad;
echo "<br>";
$nueva_cantidad = $cantidad + 1;
echo $nueva_cantidad;
echo "Fecha Ultimo Capitulo : " . $fecha_ultima;
echo "<br>";
echo "Fecha Nuevo Capitulo : " . $fecha_actual;
echo "<br>";

$fechaInicio = new DateTime($fecha_actual);
$fechaFin = new DateTime($fecha_ultima);
$diferencia = $fechaInicio->diff($fechaFin);

$dias = $diferencia->days;
echo $dias;
echo "<br>";
try {

    $sql = "UPDATE $tabla SET `$fila4` ='" . $total . "',`$fila11` ='" . $fecha_actual . "' WHERE $fila9='" . $idManga . "';";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
    echo '<script>
            Swal.fire({
                icon: "success",
                title: "Actualizando Capitulos Totales de ' . $nombre . ' en ' . $titulo2 . ' y en ' . $titulo1 . '",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '";
            });
            </script>';
} catch (PDOException $e) {
    $conn = null;
}

echo "<br>";

try {

    $sql = "UPDATE $tabla2 SET `$fila4` ='" . $total . "',`$fila11` ='" . $fecha_actual . "',`$fila12` ='" . $fecha_ultima . "' WHERE $fila7='" . $idManga . "';";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
}

echo "<br>";

if ($fecha_antigua == $fecha_actual) {
    echo "Las ultimas dos fechas son iguales";
    echo "<br>";
} else {
    echo "Las ultimas dos fechas  no son iguales";
    echo "<br>";

    //Hace el ingreso de datos en diferencias
    try {
        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila13`,`$titulo4`,`Dia`) VALUES ('" . $idManga . "', '" . $dias . "', '" . $nueva_fecha . "','" . $nombreDiaEspañol . "');";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql . "<br>";
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }

    if ($nueva_cantidad % 5 == 0) {
        echo "El número $nueva_cantidad es múltiplo de 5.<br>";

        try {
            $sql2 = "UPDATE $tabla2 SET $ver='NO' where $fila7='$idManga';";
            $resultado = mysqli_query($conexion, $sql2);
            echo $sql2 . "<br>";
        } catch (PDOException $e) {
            echo $e;
            echo "<br>";
            echo $sql2;
        }
    } else {
        echo "El número $nueva_cantidad no es múltiplo de 5.<br>";
    }
}

try {
    $sql = "UPDATE $tabla2 SET `$fila5`= (`$fila4`-`$fila3`);";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    $conn = null;
    echo $e;
    echo "<br>";
    echo $sql;
}

echo "<br>";

try {
    $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`)";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    $conn = null;
    echo $e;
    echo "<br>";
    echo $sql;
}

echo "<br>";

try {
    $sql = "UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga) ;";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    $conn = null;
    echo $e;
    echo "<br>";
    echo $sql;
}
