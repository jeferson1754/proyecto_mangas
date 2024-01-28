<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$hora_actual = date('H:i:s');

$dato1      = $_REQUEST['fila1'];
$dato2      = $_REQUEST['fila2'];
$dato3      = $_REQUEST['fila3'];
$dato4      = $_REQUEST['fila4'];
$dato6      = $_REQUEST['fila6'];
$dato8      = $_REQUEST['fila8'];
$fecha_nueva  = $_REQUEST['fila10'];
$fecha_ultima = $_REQUEST['fila11'];
$link       = $_REQUEST['link'];

if (isset($_REQUEST["Anime"])) {
    $checkbox    = $_REQUEST['Anime'];
    // Hacer algo con $checkbox1Value
    echo "Anime_Verdadero<br>";
    echo $checkbox . "<br>";
} else {
    $checkbox = "NO";
    echo "Anime_Falso<br>";
    echo $checkbox . "<br>";
}

$fecha_now = date('Y-m-d H:i:s', strtotime($fecha_nueva . ' ' . $hora_actual));

$sql      = ("SELECT * FROM $tabla where $fila1='$dato1';");
$consulta = mysqli_query($conexion, $sql);

echo $sql;
echo "<br>";
echo $fila1;
echo "<br>";
echo $dato2;
echo "<br>";
echo "Fecha Ultimo Capitulo : " . $fecha_ultima;
echo "<br>";
echo "Fecha Nuevo Capitulo : " . $fecha_nueva;
echo "<br>";
$Tabla = ucfirst($tabla);

$fechaInicio = new DateTime($fecha_nueva);
$fechaFin = new DateTime($fecha_ultima);
$diferencia = $fechaInicio->diff($fechaFin);

$dias = $diferencia->days;
echo $dias;
echo "<br>";

if ($dato2 == "") {
    $estado = "Faltante";
} else {
    $estado = "Correcto";
}
echo $estado;
echo "<br>";


if (mysqli_num_rows($consulta) == 0) {

    echo "$dato1 no existe en $tabla";
    echo "<br>";


    try {
        $sql = "INSERT INTO $tabla(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila6`,`$fila8`,`$fila10`,`$fila11`,`$fila13`,`$ver`,`Anime`,`$fila17`) VALUES( '" . $dato1 . "','" . $dato2 . "','" . $dato3 . "','" . $dato4 . "','" . $dato6 . "','" . $dato8 . "','" . $fecha_nueva . "','" . $fecha_ultima . "','" . $estado . "','NO','" . $checkbox . "',NOW())";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql;
        echo "<br>";
    } catch (PDOException $e) {
        $conn = null;
        echo $sql;
        echo "<br>";
        echo $e;
    }

    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Creando Registro de ' . $dato1 . '  en  ' . $titulo7 . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
        </script>';

    $consulta1 = "SELECT * FROM `$tabla` where Nombre='$dato1'";
    $resultado1 = mysqli_query($conexion, $consulta1);
    echo $consulta1;
    echo "<br>";

    while ($fila1 = mysqli_fetch_assoc($resultado1)) {
        $iden = $fila1['ID'];
    }

    echo "ID:" . $iden;
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
        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`) VALUES ('" .   $iden . "', '" . $dias . "', '" . $fecha_now . "');";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql;
    } catch (PDOException $e) {
        $conn = null;
        echo $e;
        echo "<br>";
        echo $sql;
    }

    $sql1      = ("UPDATE $tabla SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM $tabla7 WHERE $tabla.ID = $tabla7.$fila9) ;");
    echo $sql1;
    $consulta = mysqli_query($conexion, $sql1);
    echo "<br>";
} else {

    echo "$dato1 existe en $tabla";
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

    $sql1      = ("UPDATE $tabla SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM $tabla7 WHERE $tabla.ID = $tabla7.$fila9) ;");
    echo $sql1;
    $consulta = mysqli_query($conexion, $sql1);
    echo "<br>";

    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Registro de ' . $dato1 . ' Existe en  ' . $titulo7 . '",
        confirmButtonText: "OK"
    }).then(function() {
         window.location = "' . $link . '"; 
    });
    </script>';
}
