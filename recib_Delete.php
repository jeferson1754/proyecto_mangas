<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';

$sql = ("select Date_FORMAT(DATE_SUB(NOW(),INTERVAL 5 HOUR),'%W');");

$dia      = mysqli_query($conexion, $sql);

while ($rows = mysqli_fetch_array($dia)) {

    $day = $rows[0];
    // echo $day;
}

$idRegistros = $_REQUEST['id'];
$nombre = $_REQUEST['name'];
$link = $_REQUEST['link'];

$query = "SELECT * FROM `$tabla7` WHERE `$fila9`='$idRegistros';";
$resultado3 = mysqli_query($conexion, $query);

// Mapeo de días de la semana en inglés a español
$dias_semana = array(
    "Monday" => "Lunes",
    "Tuesday" => "Martes",
    "Wednesday" => "Miércoles",
    "Thursday" => "Jueves",
    "Friday" => "Viernes",
    "Saturday" => "Sábado",
    "Sunday" => "Domingo"
);

if (isset($_POST['Finalizados'])) {
    // Verifica si el día actual está presente en el array y establece el equivalente en español
    if (array_key_exists($day, $dias_semana)) {
        $week = $dias_semana[$day];
    }

    // Consulta para verificar si la manga tiene capítulos faltantes
    $sql = "SELECT * FROM $tabla WHERE $fila7 = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("i", $idRegistros);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($mostrar = $resultado->fetch_assoc()) {
        // Recuperar datos si hay resultados
        $dato1 = $mostrar[$fila1];
        $dato2 = $mostrar[$fila2];
        $dato3 = $mostrar[$fila3];
        $dato4 = $mostrar[$fila4];
        $dato5 = $mostrar[$fila5];
        $dato6 = $mostrar[$fila6];
        $dato8 = $mostrar[$fila8];
        $dato10 = $mostrar[$fila10];
        $dato11 = $mostrar[$fila11];
        $dato13 = $mostrar[$fila13];

        // Comprobar si hay capítulos faltantes
        if ($mostrar[$fila5] == 0) {
            // Si no hay capítulos faltantes, mueve la manga a la tabla de finalizados
            try {
                $sql = "INSERT INTO `finalizados_manga`(`Nombre`, `Link`, `Capitulos Vistos`, `Capitulos Totales`, `Faltantes`, `Estado`, `Lista`, `Estado_Link`, `Fecha_Cambio1`, `Fecha_Cambio2`, `ID_Eliminado`, `Modulo`) VALUES
                ( '" . $dato1 . "','" . $dato2 . "','" . $dato3 . "','" . $dato4 . "','" . $dato5 . "','Finalizado','" . $dato6 . "','" . $dato13 . "','" . $dato10 . "','" . $dato11 . "','" . $idRegistros . "', 'Manga')";
                $resultado = mysqli_query($conexion, $sql);
                echo $sql;
                echo "<br>";
            } catch (PDOException $e) {
                echo $e;
                echo "<br>";
                echo $sql;
            }

            // Elimina la manga de la tabla original
            $sql_delete = "DELETE FROM `$tabla` WHERE $fila7 = ?";
            $stmt_delete = $conexion->prepare($sql_delete);
            $stmt_delete->bind_param("i", $idRegistros);
            $stmt_delete->execute();

            // Mensaje de éxito
            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Eliminando ' . $nombre . ' de ' . ucfirst($tabla) . ' y insertando en Finalizados",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '";
            });
        </script>';
        } else {
            // Mensaje de error si hay capítulos faltantes
            echo '<script>
            Swal.fire({
                icon: "error",
                title: "' . $nombre . ' tiene Capítulos Faltantes",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '";
            });
        </script>';
        }
    } else {
        // No se encontraron resultados
        echo "No se encontraron resultados para el ID: $idRegistros";
    }
} elseif (isset($_POST['Pendientes'])) {
    // Consulta para obtener información de la manga
    $sql = "SELECT * FROM $tabla WHERE $fila7 = '$idRegistros'";
    $consulta = mysqli_query($conexion, $sql);
    $resultado = mysqli_fetch_array($consulta);

    // Consulta para verificar si ya existe la manga en la tabla de tachiyomi
    $sql = "SELECT * FROM $tabla4 WHERE $fila9 = '$idRegistros'";
    $consulta_tachiyomi = mysqli_query($conexion, $sql);

    // Si no existe la manga en la tabla de tachiyomi, la inserta
    if (mysqli_num_rows($consulta_tachiyomi) == 0) {

        $sql = "INSERT INTO `$tabla8`(`$fila1`, `$fila2`, `$fila3`, `$fila4`, `$fila5`, `$fila6`, `$fila8`, `$fila10`, `$fila11`, `$fila13`,`$titulo3`, `$ver`, `$fila17`, `Anime`)
        VALUES ('" . $resultado[$fila1] . "', '" . $resultado[$fila2] . "', '" . $resultado[$fila3] . "', '" . $resultado[$fila4] . "', '" . $resultado[$fila5] . "', '" . $resultado[$fila6] . "', '" . $resultado[$fila8] . "', '" . $resultado[$fila10] . "', '" . $resultado[$fila11] . "', '" . $resultado[$fila13] . "', '" . $resultado[$titulo3] . "', '" . $resultado[$ver] . "', '" . $resultado[$fila17] . "', '" . $resultado['Anime'] . "')";
        mysqli_query($conexion, $sql);


        // Actualiza la cantidad de capítulos faltantes en la manga
        $sql = "UPDATE `$tabla8` SET `$fila5` = (`$fila4` - `$fila3`)";
        mysqli_query($conexion, $sql);

        // Elimina la manga de la tabla original y de la tabla de tachiyomi
        $sql = "DELETE FROM `$tabla` WHERE $fila7 = '$idRegistros'";
        mysqli_query($conexion, $sql);

        // Mensaje de éxito
        echo '<script>
    Swal.fire({
        icon: "success",
        title: "Eliminando registro de ' . $nombre . ' en ' . ucfirst($tabla) . ' e insertando en Pendientes",
        confirmButtonText: "OK"
    }).then(function() {
        window.location = "' . $link . '";
    });
</script>';
    } else {
        $sql = "INSERT INTO `$tabla8`(`$fila1`, `$fila2`, `$fila3`, `$fila4`, `$fila5`, `$fila6`, `$fila8`, `$fila10`, `$fila11`, `$fila13`,`$titulo3`, `$ver`, `$fila17`, `Anime`)
        VALUES ('" . $resultado[$fila1] . "', '" . $resultado[$fila2] . "', '" . $resultado[$fila3] . "', '" . $resultado[$fila4] . "',
        '" . $resultado[$fila5] . "', '" . $resultado[$fila6] . "', '" . $resultado[$fila8] . "', '" . $resultado[$fila10] . "',
        '" . $resultado[$fila11] . "', '" . $resultado[$fila13] . "', '" . $resultado[$titulo3] . "', '" . $resultado[$ver] . "', '" . $resultado[$fila17] . "', '" . $resultado['Anime'] . "')";
        mysqli_query($conexion, $sql);

        // Actualiza la cantidad de capítulos faltantes en la pendientes
        $sql = "UPDATE `$tabla8` SET `$fila5` = (`$fila4` - `$fila3`)";
        mysqli_query($conexion, $sql);

        // Si la manga ya existe en la tabla de tachiyomi, simplemente la elimina de las tablas originales
        $sql = "DELETE FROM `$tabla` WHERE $fila7 = '$idRegistros'";
        mysqli_query($conexion, $sql);

        $sql = "DELETE FROM `$tabla4` WHERE $fila9 = '$idRegistros'";
        mysqli_query($conexion, $sql);

        // Mensaje de éxito
        echo '<script>
    Swal.fire({
        icon: "success",
        title: "Eliminando registro de ' . $nombre . ' en ' . ucfirst($tabla) . ' y ' . ucfirst($tabla4) . ' e insertando en Pendientes",
        confirmButtonText: "OK"
    }).then(function() {
        window.location = "' . $link . '";
    });
</script>';
    }

    // Verificar si hay resultados
    if (mysqli_num_rows($resultado3) > 0) {
        // Buscar el ID de la manga recién insertado
        $consulta1 = "SELECT * FROM `$tabla8` WHERE Nombre = '$nombre'";
        $resultado1 = mysqli_query($conexion, $consulta1);
        $fila1 = mysqli_fetch_assoc($resultado1);
        $iden = $fila1['ID'];

        // Preparar la consulta de inserción en la nueva tabla
        $insertQuery = "INSERT INTO $tabla9 ($fila15, $fila12, $titulo4) VALUES ";

        // Arreglo para almacenar los valores de inserción
        $valores = array();

        // Recorrer los resultados y guardar los valores de inserción en el arreglo
        while ($fila = mysqli_fetch_assoc($resultado3)) {
            $columna1 = $fila['Diferencia'];
            $columna2 = $fila['Fecha'];
            $valores[] = "('$iden', '$columna1', '$columna2')";
        }

        // Combinar los valores de inserción en una cadena
        $insertQuery .= implode(",", $valores);

        // Ejecutar la consulta de inserción
        $resultado2 = mysqli_query($conexion, $insertQuery);

        // Intentar eliminar los registros de la tabla $tabla7
        try {
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM `$tabla7` WHERE $fila9='$idRegistros';";
            $conn->exec($sql);
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }
    } else {
        echo "No se encontraron resultados.";
    }
    // Liberar memoria
    mysqli_free_result($resultado3);
}

// Liberar memoria
mysqli_free_result($consulta);
mysqli_free_result($consulta_tachiyomi);
?>