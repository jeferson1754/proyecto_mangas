<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

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
$cantidad     = $_REQUEST['cantidad'];

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
echo $cantidad;
echo "<br>";
$nueva_cantidad = $cantidad + 1;
echo $nueva_cantidad;
echo "<br>";
echo "Fecha Ultimo Capitulo : " . $fecha_ultima;
echo "<br>";
echo "Fecha Nuevo Capitulo : " . $fecha_actual;
echo "<br>";

//Hacer la resta de dias
$fechaInicio = new DateTime($nueva_fecha);
$fechaFin = new DateTime($fecha_ultima);
$diferencia = $fechaInicio->diff($fechaFin);

$dias = $diferencia->days;
echo "Dias :" . $dias;
echo "<br>";
echo "$nombre existe en $tabla";
echo "<br>";

if ($fecha_antigua == $fecha_actual) {
    echo "Las ultimas dos fechas son iguales";
} else {
    echo "Las ultimas dos fechas  no son iguales";
    echo "<br>";

    //Hace el ingreso de datos en diferencias
    try {
        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`,`Dia`) VALUES ('" . $idRegistros . "', '" . $dias . "', '" . $nueva_fecha . "','" . $nombreDiaEspañol . "');";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql;
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }

    if ($nueva_cantidad % 5 == 0) {
        echo "El número $nueva_cantidad es múltiplo de 5.<br>";

        try {
            $sql2 = "UPDATE $tabla SET $ver='NO' where $fila7='$idRegistros';";
            //$resultado = mysqli_query($conexion, $sql2);
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

echo "<br>";

//Hace la actualizacion en mangas
try {
    $sql = "UPDATE $tabla SET 
    `$fila4` ='" . $total . "',
    `$fila10`='" . $fecha_actual . "',
    `$fila11`='" . $fecha_antigua . "',
    `$fila17`=NOW()
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

//Hace la actualizacion general de faltantes de pendientes
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


//Hace una actualizacion general de las cantidad de diferencias con el ID Manga
$sql3 = ("UPDATE $tabla SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM $tabla7 WHERE $tabla.ID = $tabla7.$fila9) ;");
echo $sql3;
$consulta3 = mysqli_query($conexion, $sql3);
echo "<br>";
echo $link;
echo "<br>";
