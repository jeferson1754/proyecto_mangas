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
$dato3       = $_REQUEST['fila3'];
$dato4       = $_REQUEST['fila4'];
$dato8       = $_REQUEST['fila8'];
$dato6       = $_REQUEST['fila6'];
$estado      = $_REQUEST['fila13'];
$link        = $_REQUEST['link'];
$fecha_nueva = $_REQUEST['fila10'];
$fecha_ultima = $_REQUEST['fila11'];

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

//Verificacion de Estado del Link
if ($dato2 == "") {
    $estado = "Faltante";
}

//Agranda la primera letra de la varible
$Tabla = ucfirst($tabla);

//Busca el registro en manga
$sql = ("SELECT * FROM $tabla where $fila7='$idRegistros';");
$consulta = mysqli_query($conexion, $sql);

//Busca el fecha de la ultima actualizacion en mangas
$sql2 = ("SELECT `$fila10` FROM $tabla where $fila7='$idRegistros';");
$consulta2 = mysqli_query($conexion, $sql2);

//Saca la ultima fecha registrada
while ($fila1 = mysqli_fetch_assoc($consulta2)) {
    $fecha_antigua = $fila1[$fila10];
}

echo $fecha_antigua;
echo "<br>";

//Une la fecha nueva con la hora actual para hacer la fecha_now
$fecha_now = date('Y-m-d H:i:s', strtotime($fecha_nueva . ' ' . $hora_actual));

echo $sql;
echo "<br>";
echo $sql2;
echo "<br>";
echo "Fecha Ultimo Capitulo : " . $fecha_ultima;
echo "<br>";
echo "Fecha Nuevo Capitulo : " . $fecha_nueva;
echo "<br>";
$Tabla = ucfirst($tabla);
$Tabla4 = ucfirst($tabla4);

//Hacer la resta de dias
$fechaInicio = new DateTime($fecha_nueva);
$fechaFin = new DateTime($fecha_ultima);
$diferencia = $fechaInicio->diff($fechaFin);
$dias = $diferencia->days;
echo "Dias :" . $dias;
echo "<br>";
echo $estado;
echo "<br>";
echo "$dato1 existe en $tabla";
echo "<br>";

if ($fecha_antigua == $fecha_nueva) {
    echo "Las ultimas dos fechas son iguales";
} else {
    echo "Las ultimas dos fechas  no son iguales";
    echo "<br>";

    //Hace el ingreso de datos en diferencias
    try {
        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`) VALUES ('" . $idRegistros . "', '" . $dias . "', '" . $fecha_now . "');";
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
    `Nombre` ='" . $dato1 . "',
    `$fila2` ='" . $dato2 . "',
    `$fila3` ='" . $dato3 . "',
    `$fila4` ='" . $dato4 . "',
    `$fila8` ='" . $dato8 . "',
    `$fila6` ='" . $dato6 . "',
    `$fila13`='" . $estado . "',
    `$fila10`='" . $fecha_nueva . "',
    `$fila11`='" . $fecha_ultima . "',
    `Anime`='" . $checkbox . "'
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
        title: "Registro de ' . $dato1 . ' Existe en  ' . $titulo7 . '",
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

//Hace una actualizacion general de las cantidad de diferencias con el ID Manga
$sql3 = ("UPDATE $tabla SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM $tabla7 WHERE $tabla.ID = $tabla7.$fila9) ;");
echo $sql3;
$consulta3 = mysqli_query($conexion, $sql3);
echo "<br>";
echo $link;
echo "<br>";

echo '<script>
        Swal.fire({
            icon: "success",
            title: "Actualizando ' . $dato1 . ' en ' . $titulo7 . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';
