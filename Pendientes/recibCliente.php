<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';

$hora_actual = date('H:i:s');

// Obtener datos del formulario
$dato1        = $_REQUEST['fila1'];
$dato2        = $_REQUEST['fila2'];
$dato3        = $_REQUEST['fila3'];
$dato4        = $_REQUEST['fila4'];
$dato6        = $_REQUEST['fila6'];
$dato8        = $_REQUEST['fila8'];
$fecha_nueva  = $_REQUEST['fila10'];
$fecha_ultima = $_REQUEST['fila11'];
$link         = $_REQUEST['link'];

// Verificar si la casilla "Anime" está marcada
$checkbox = isset($_REQUEST["Anime"]) ? $_REQUEST['Anime'] : "NO";
echo ($checkbox ? "Anime_Verdadero" : "Anime_Falso") . "<br>";

$fecha_now = date('Y-m-d H:i:s', strtotime($fecha_nueva . ' ' . $hora_actual));

// Consulta para verificar si existe un registro con el mismo dato1
$sql      = "SELECT * FROM $tabla WHERE $fila1='$dato1'";
$consulta = mysqli_query($conexion, $sql);

// Mostrar algunos resultados y detalles
echo $sql . "<br>";
echo "$fila1: $dato1<br>";
echo "Fecha Ultimo Capitulo: $fecha_ultima<br>";
echo "Fecha Nuevo Capitulo: $fecha_nueva<br>";

// Calcular la diferencia de fechas
$fechaInicio = new DateTime($fecha_nueva);
$fechaFin    = new DateTime($fecha_ultima);
$diferencia  = $fechaInicio->diff($fechaFin);
$dias        = $diferencia->days;
echo "Días de diferencia: $dias<br>";

// Determinar el estado
$estado = ($dato2 == "") ? "Faltante" : "Correcto";
echo "Estado: $estado<br>";

$Tabla = ucfirst($tabla);

if (mysqli_num_rows($consulta) == 0) {
    // Registro no existe, realizar inserción y otras operaciones

    echo "$dato1 no existe en $tabla<br>";

    try {
        $sql = "INSERT INTO $tabla(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila6`,`$fila8`,`$fila10`,`$fila11`,`$fila13`,`$ver`,`Anime`,`$fila17`) 
                VALUES('$dato1', '$dato2', '$dato3', '$dato4', '$dato6', '$dato8', '$fecha_nueva', '$fecha_ultima', '$estado', 'SI', '$checkbox', NOW())";

        $resultado = mysqli_query($conexion, $sql);
        echo $sql . "<br>";
    } catch (PDOException $e) {
        $conn = null;
        echo $sql . "<br>";
        echo $e . "<br>";
    }

    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Creando Registro de ' . $dato1 . '  en  ' . $titulo7 . '",
            confirmButtonText: "OK"
        }).then(() => {
            window.location = "' . $link . '"; 
        });
        </script>';

    $consulta1 = "SELECT * FROM `$tabla` WHERE Nombre='$dato1'";
    $resultado1 = mysqli_query($conexion, $consulta1);
    echo $consulta1 . "<br>";

    while ($fila1 = mysqli_fetch_assoc($resultado1)) {
        $iden = $fila1['ID'];
    }

    echo "ID: $iden<br>";

    try {
        $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`)";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql . "<br>";
    } catch (PDOException $e) {
        $conn = null;
        echo $e . "<br>";
        echo $sql . "<br>";
    }

    try {
        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`) VALUES ('$iden', '$dias', '$fecha_now')";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql . "<br>";
    } catch (PDOException $e) {
        $conn = null;
        echo $e . "<br>";
        echo $sql . "<br>";
    }

    $sql1 = "UPDATE $tabla SET Cantidad = (SELECT COUNT(*) AS cantidad_productos FROM $tabla7 WHERE $tabla.ID = $tabla7.$fila9);";
    echo $sql1 . "<br>";
    $consulta = mysqli_query($conexion, $sql1);
} else {
    // Registro existe, realizar operaciones de actualización y mostrar error

    echo "$dato1 existe en $tabla<br>";

    try {
        $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`)";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql . "<br>";
    } catch (PDOException $e) {
        $conn = null;
        echo $e . "<br>";
        echo $sql . "<br>";
    }

    $sql1 = "UPDATE $tabla SET Cantidad = (SELECT COUNT(*) AS cantidad_productos FROM $tabla7 WHERE $tabla.ID = $tabla7.$fila9);";
    echo $sql1 . "<br>";
    $consulta = mysqli_query($conexion, $sql1);
    
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "Registro de ' . $dato1 . ' Existe en  ' . $titulo7 . '",
            confirmButtonText: "OK"
        }).then(() => {
            window.location = "' . $link . '"; 
        });
        </script>';
}

