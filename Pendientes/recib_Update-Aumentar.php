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

$nombreDiaEspañol = obtenerDiaSemana($fecha_actual);


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

$dias = calcularDiferenciaDias($fecha_actual, $fecha_ultima);

echo "Dias :" . $dias;
echo "<br>";
echo "$nombre existe en $tabla";
echo "<br>";

// Buscamos si este número de capítulo ya existe para este manga en el historial de diferencias
$capitulo_repetido = false;
try {
    // $idRegistros es el ID del manga, $total es el número de capítulo actual
    $sql_check_cap = "SELECT COUNT(*) as existe FROM $tabla7 
                      WHERE `$fila9` = '$idRegistros' 
                      AND `Numero_Capitulo` = '$total'";

    $query_check_cap = mysqli_query($conexion, $sql_check_cap);
    $res_check_cap = mysqli_fetch_assoc($query_check_cap);

    if ($res_check_cap['existe'] > 0) {
        $capitulo_repetido = true;
    }
} catch (Exception $e) {
    echo "Error al verificar duplicado de capítulo: " . $e->getMessage() . "<br>";
}

// NUEVA LÓGICA: Si es la misma fecha PERO el capítulo es diferente (no está repetido), SÍ lo deja pasar.
if ($fecha_antigua == $fecha_actual && $capitulo_repetido) {
    echo "Las últimas dos fechas son iguales Y este capítulo ya fue registrado hoy.";
    echo "<br>";
} else {
    echo "Insertando en diferencias (Nueva fecha o nuevo capítulo decimal en el mismo día).";
    echo "<br>";

    // Hace el ingreso de datos en diferencias (Tu código original intacto)
    try {
        $sql_historial = "INSERT INTO $tabla7 (`$fila9`, `$fila12`, `Numero_Capitulo`, `$titulo4`, `Dia`) 
                             VALUES ('$idRegistros', '$dias', '$total', '$nueva_fecha', '$nombreDiaEspañol')";
        mysqli_query($conexion, $sql_historial);
        echo $sql_historial . "<br>";
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql_historial;
    }

    // Sistema de validación de múltiplos de 5 (Tu código original intacto)
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
