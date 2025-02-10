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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dato1      = $_REQUEST['fila1'];
    $dato2      = $_REQUEST['fila2'];
    $dato3      = $_REQUEST['fila3'];
    $dato4      = $_REQUEST['fila4'];
    $dato6      = $_REQUEST['fila6'];
    $dato8      = $_REQUEST['fila8'];
    $fecha_nueva  = $_REQUEST['fila10'];
    $fecha_ultima = $_REQUEST['fila11'];
    $link       = $_REQUEST['link'];

    // Verificar si 'Anime' está presente en la solicitud
    $checkbox = isset($_REQUEST["Anime"]) ? $_REQUEST["Anime"] : "NO";
    echo $checkbox === "NO" ? "Anime_Falso<br>" : "Anime_Verdadero<br>";
    echo $checkbox . "<br>";

    // Formatear la fecha y hora actual
    $fecha_now = date('Y-m-d H:i:s', strtotime("$fecha_nueva $hora_actual"));

    // Ejecutar la primera consulta
    $consulta = mysqli_query($conexion, "SELECT * FROM $tabla WHERE $fila1='$dato1'");

    // Ejecutar la segunda consulta y obtener el resultado
    $sql2 = "SELECT COUNT(Lista) as listen FROM manga WHERE Lista='$dato6'";
    $resultado2 = mysqli_query($conexion, $sql2);
    echo $sql2 . "<br>";

    $listen = ($fila = mysqli_fetch_assoc($resultado2)) ? $fila['listen'] : 0;

    echo "<br>";
    echo $listen;
    echo "<br>";
    echo $dato2;
    echo "<br>";
    echo "Fecha Ultimo Capitulo : " . $fecha_ultima;
    echo "<br>";
    echo "Fecha Nuevo Capitulo : " . $fecha_nueva;
    echo "<br>";
    $Tabla = ucfirst($tabla);

    $dias = calcularDiferenciaDias($fecha_nueva, $fecha_ultima);
    echo $dias;
    echo "<br>";

    $estado = empty($dato2) ? "Faltante" : "Correcto";

    echo $estado;
    echo "<br>";



    if (mysqli_num_rows($consulta) == 0) {

        echo "$dato1 no existe en $tabla";
        echo "<br>";

        if ($listen < 100) {
            echo "Menor a 100";

            try {
                $sql = "INSERT INTO $tabla(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila6`,`$fila8`,`$fila10`,`$fila11`,`$fila13`,`$ver`,`Anime`,`Hora_Cambio`) 
                        VALUES ('$dato1', '$dato2', '$dato3', '$dato4', '$dato6', '$dato8', '$fecha_nueva', '$fecha_ultima', '$estado', 'NO', '$checkbox', NOW())";

                $resultado = mysqli_query($conexion, $sql);

                if ($resultado) {
                    $idRegistros = mysqli_insert_id($conexion);
                    echo "ID insertado: " . $idRegistros . "<br>";
                } else {
                    echo "Error en la inserción: " . mysqli_error($conexion) . "<br>";
                }

                echo $sql . "<br>";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage() . "<br>";
            }


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

            $nombreDiaEspañol = obtenerDiaSemana($fecha_nueva); // Salida: Miércoles

            try {

                $sql = "INSERT INTO $tabla7 (`$fila9`, `$fila12`,`$titulo4`,`Dia`) VALUES ('" . $idRegistros . "', '" . $dias . "', '" . $fecha_now . "','" . $nombreDiaEspañol . "');";
                $resultado = mysqli_query($conexion, $sql);
                echo $sql;
            } catch (PDOException $e) {
                $conn = null;
                echo $e;
                echo "<br>";
                echo $sql;
            }

            try {

                $sql = "INSERT INTO nombres_mangas (`$fila9`,`$fila1`) VALUES ('" . $idRegistros . "', '" . $dato1 . "');";
                $resultado = mysqli_query($conexion, $sql);
                echo $sql;
            } catch (PDOException $e) {
                $conn = null;
                echo $e;
                echo "<br>";
                echo $sql;
            }

            $sql1      = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga) ;");
            echo $sql1;
            $consulta = mysqli_query($conexion, $sql1);
            echo "<br>";


            $alertTitle = '¡Registro Creado!';
            $alertText = 'Creando Registro de ' . $dato1 . '  en  ' . $Tabla . '';
            $alertType = 'success';
            $redireccion = "window.location='$link'";

            alerta($alertTitle, $alertText, $alertType, $redireccion);
            die();
        } else {

            $sql1      = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga) ;");
            echo $sql1;
            $consulta = mysqli_query($conexion, $sql1);
            echo "<br>";

            $alertTitle = '¡Error!';
            $alertText = 'La Creacion del registro de ' . $dato1 . ' supera el limite de la Lista ' . $dato6 . '';
            $alertType = 'error';
            $redireccion = "window.location='$link'";

            alerta($alertTitle, $alertText, $alertType, $redireccion);
            die();
        }
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

        $sql1      = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga) ;");
        echo $sql1;
        $consulta = mysqli_query($conexion, $sql1);
        echo "<br>";

        $alertTitle = '¡Error!';
        $alertText = 'Registro de ' . $dato1 . ' Existe en  ' . $Tabla . '';
        $alertType = 'error';
        $redireccion = "window.location='$link'";

        alerta($alertTitle, $alertText, $alertType, $redireccion);
        die();
    }
}
