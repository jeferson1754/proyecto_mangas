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

$fecha_actual = date('Y-m-d');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idRegistros = $_REQUEST['id'];
    $nombre      = $_REQUEST['nombre'];
    $link       = $_REQUEST['link'];


    $sql = "SELECT * FROM webtoon WHERE ID= ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("i", $idRegistros);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($mostrar = $resultado->fetch_assoc()) {
        // Recuperar datos si hay resultados
        $link_webtoon = $mostrar['Link'];
        $cap_vistos = $mostrar['Capitulos Vistos'];
        $cap_total = $mostrar['Capitulos Totales'];
        $cap_faltantes = $mostrar['Faltantes'];
        $estadolink_webtoon = $mostrar['Estado_Link'];
        $dato6 = "Sin Lista";
    }



    if ($cap_faltantes == 0) {
        try {
            $sql = "INSERT INTO `finalizados_manga` (`Nombre`, `Link`, `Capitulos Vistos`, `Capitulos Totales`, `Faltantes`, `Estado`, `Lista`, `Estado_Link`, `Fecha_Cambio1`, `Fecha_Cambio2`, `ID_Eliminado`, `Modulo`) 
                    VALUES (?, ?, ?, ?, ?, 'Finalizado', ?, ?, ?, ?, ?, 'webtoon')";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssiiissssi", $nombre, $link_webtoon, $cap_vistos, $cap_total, $cap_faltantes, $dato6, $estadolink_webtoon, $fecha_actual, $fecha_actual, $idRegistros);

            if ($stmt->execute()) {
                echo "Registro insertado correctamente en finalizados_manga.<br>";
            } else {
                echo "Error al insertar: " . $stmt->error . "<br>";
            }

            $stmt->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }

        $sql_delete = "DELETE FROM `webtoon` WHERE ID = ?";
        $stmt_delete = $conexion->prepare($sql_delete);
        $stmt_delete->bind_param("i", $idRegistros);
        $stmt_delete->execute();

        $alertTitle = 'Webtoon Eliminado!';
        $alertText = 'Eliminando ' . $nombre . ' de ' . ucfirst($tabla) . '  y insertando en Finalizados';
        $alertType = 'success';
        $redireccion = "window.location='$link'";

        alerta($alertTitle, $alertText, $alertType, $redireccion);
        die();
    } else {
        $alertTitle = '¡Capitulos Faltantes!';
        $alertText = $nombre . ' tiene ' . $cap_faltantes . ' Capitulos Faltantes';
        $alertType = 'error';
        $redireccion = "window.location='$link'";

        alerta($alertTitle, $alertText, $alertType, $redireccion);
        die();
    }
} else {
    $alertTitle = '¡ID Webtoon no Ingresado!';
    $alertText = 'No se detecto ID Webtoon, favor intentarlo denuevo';
    $alertType = 'error';
    $redireccion = "window.location='index.php'";

    alerta($alertTitle, $alertText, $alertType, $redireccion);
    die();
}
?>