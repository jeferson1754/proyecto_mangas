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
$cantidad    = $_REQUEST['cantidad'];


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

//Busca el registro en tachiyomi
$sql1 = ("SELECT * FROM $tabla4 where $fila9='$idRegistros';");
$consulta1 = mysqli_query($conexion, $sql1);

//Busca el fecha de la ultima actualizacion en mangas
$sql2 = ("SELECT `$fila10` FROM $tabla where $fila7='$idRegistros';");
$consulta2 = mysqli_query($conexion, $sql2);

//Saca la ultima fecha registrada
while ($fila1 = mysqli_fetch_assoc($consulta2)) {
    $fecha_antigua = $fila1[$fila10];
}

$sql3 = "SELECT COUNT(Lista) as listen FROM `manga` where Lista='$dato6'";
$resultado2 = mysqli_query($conexion, $sql3);
echo $sql3;
echo "<br>";

while ($fila1 = mysqli_fetch_assoc($resultado2)) {
    $listen = $fila1['listen'];
}

echo $fecha_antigua;
echo "<br>";

//Une la fecha nueva con la hora actual para hacer la fecha_now
$fecha_now = date('Y-m-d H:i:s', strtotime($fecha_nueva . ' ' . $hora_actual));

echo $sql;
echo "<br>";
echo $sql1;
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

// Convierte la fecha a un timestamp
$timestamp = strtotime(str_replace('-', '/', $fecha_nueva));

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

if ($fecha_antigua == $fecha_nueva) {
    echo "Las ultimas dos fechas son iguales";
} else {
    echo "Las ultimas dos fechas  no son iguales";
    echo "<br>";

    //Hace el ingreso de datos en diferencias
    try {

        $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`,`Dia`) VALUES
        ('" . $idRegistros . "', '" . $dias . "', '" . $nueva_fecha . "','" . $nombreDiaEspañol . "');";
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
        ('" . $idRegistros . "', '" . $dias . "', '" . $nueva_fecha . "','" . $nombreDiaEspañol . "');";
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
if ($listen < 101) {
    echo "Menor a 100";

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

    if (mysqli_num_rows($consulta1) > 0) {
        echo "Existe en $tabla4 y en $tabla";
        echo "<br>";

        //Actualiza los datos requeridos en tachiyomi
        try {
            $sql = "UPDATE $tabla4 SET 
        `$fila2` ='" . $dato2 . "',
        `$fila3` ='" . $dato3 . "',
        `$fila4` ='" . $dato4 . "',
        `$fila8` ='" . $dato8 . "',
        `$fila6` ='" . $dato6 . "',
        `$fila13`='" . $estado . "',
        `$fila10`='" . $fecha_nueva . "'
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
            title: "Registro de ' . $dato1 . ' Existe en  ' . $Tabla . ' y en ' . $Tabla4 . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
        </script>';
        }

        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Actualizando ' . $dato1 . ' en ' . $Tabla . ' y en ' . $Tabla4 . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';
    }

    echo '<script>
        Swal.fire({
            icon: "success",
            title: "Actualizando ' . $dato1 . ' en ' . $Tabla . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';
} else {

    echo '<script>
    Swal.fire({
        icon: "error",
        title: "El registro de ' . $dato1 . ' supera el limite de la Lista ' . $dato6 . '",
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
