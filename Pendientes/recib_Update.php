<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
function alerta($alertTitle, $alertText, $alertType, $redireccion)
{

    echo '
 <script>
        Swal.fire({
            title: "' . $alertTitle . '",
            text: "' . $alertText . '",
            html: "' . $alertText . '",
            icon: "' . $alertType . '",
            showCancelButton: false,
            confirmButtonText: "OK",
            closeOnConfirm: false
        }).then(function() {
          ' . $redireccion . '  ; // Redirigir a la página principal
        });
    </script>';
}

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
$cantidad    = $_REQUEST['cantidad'];

$checkbox = $_REQUEST["Anime"] ?? "NO";
echo ($checkbox === "SI") ? "Anime_Verdadero<br>$checkbox<br>" : "Anime_Falso<br>$checkbox<br>";

// Verificación de Estado del Link
$estado = empty($dato2) ? "Faltante" : $estado;

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
echo $cantidad;
echo "<br>";
$nueva_cantidad = $cantidad + 1;
echo $nueva_cantidad;
$Tabla = ucfirst($tabla);
$Tabla4 = ucfirst($tabla4);

//Hacer la resta de dias
$dias = calcularDiferenciaDias($fecha_nueva, $fecha_ultima);
echo "Dias :" . $dias;
echo "<br>";
echo $estado;
echo "<br>";
echo "$dato1 existe en $tabla";
echo "<br>";

// Convierte la fecha a un timestamp
$timestamp = strtotime(str_replace('-', '/', $fecha_nueva));

$nombreDiaEspañol = obtenerDiaSemana($fecha_nueva); // Salida: 

echo "<br>";

if ($fecha_antigua == $fecha_nueva) {
    echo "Las ultimas dos fechas son iguales";
} else {
    echo "Las ultimas dos fechas  no son iguales";
    echo "<br>";

    //Hace el ingreso de datos en diferencias
    try {

        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`,`Dia`) VALUES
        ('" . $idRegistros . "', '" . $dias . "', '" . $fecha_now . "','" . $nombreDiaEspañol . "');";
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
echo "<br>";

echo $cantidad;
echo "<br>";

if ($cantidad <= 0) {
    echo "igual a cero:" . $cantidad;
    echo "<br>";
    //Hace el ingreso de datos en diferencias
    try {

        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`,`Dia`) VALUES
        ('" . $idRegistros . "', '" . $dias . "', '" . $fecha_now . "','" . $nombreDiaEspañol . "');";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql;
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }
} else {
    echo "mayor a cero:" . $cantidad;
}
echo "<br>";

try {
    $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`);";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    echo $e;
    echo "<br>";
    echo $sql;
}

//Hace una actualizacion general de las cantidad de diferencias con el ID Manga
$sql3 = ("UPDATE $tabla SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM $tabla7 WHERE $tabla.ID = $tabla7.$fila9) ;");
echo $sql3;
$consulta3 = mysqli_query($conexion, $sql3);
echo "<br>";
echo $link;
echo "<br>";

try {
    // Verificar si el nombre ya existe en la tabla
    $sql_check = "SELECT COUNT(*) AS count FROM nombres_pendientes WHERE `$fila9` = '$idRegistros' AND `Nombre` = '$dato1'";
    $result_check = mysqli_query($conexion, $sql_check);
    $row = mysqli_fetch_assoc($result_check);

    if ($row['count'] == 0) { // Si no existe, insertar
        $sql = "INSERT INTO nombres_pendientes (`$fila9`, `Nombre`) VALUES ('$idRegistros', '$dato1')";
        $resultado = mysqli_query($conexion, $sql);
        echo "Registro insertado: " . $sql;
    } else {
        echo "El nombre ya existe en la tabla.";
    }
} catch (PDOException $e) {
    $conn = null;
    echo "Error: " . $e->getMessage();
}

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
    `Anime`='" . $checkbox . "',
    `$fila17`=NOW()
    WHERE `$fila7`='" . $idRegistros . "'";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    echo $e;
    echo "<br>";
    echo $sql;


    $alertTitle = '¡Registro No Existe!';
    $alertText = 'Registro de ' . $dato1 . ' No Existe en  ' . $titulo7 . '';
    $alertType = 'error';
    $redireccion = "window.location='$link'";

    alerta($alertTitle, $alertText, $alertType, $redireccion);
    die();
}



$alertTitle = '¡Registro Actualizado!';
$alertText = 'Actualizando ' . $dato1 . ' en ' . $titulo7 . '';
$alertType = 'success';
$redireccion = "window.location='$link'";

alerta($alertTitle, $alertText, $alertType, $redireccion);
die();
