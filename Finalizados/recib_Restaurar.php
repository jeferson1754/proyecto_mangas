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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idRegistros      = $_REQUEST['id'];
    $modulo      = $_REQUEST['modulo'];
    $ID_Eliminado         = $_REQUEST['id_manga'];
    $verif = "NO";

    $sql = "SELECT * FROM $tabla WHERE $fila7 = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("i", $idRegistros);
    $consulta->execute();
    $resultado = $consulta->get_result();


    if ($mostrar = $resultado->fetch_assoc()) {
        $nombre = $mostrar['Nombre'];
        $link = $mostrar['Link'];
        $cap_vistos = $mostrar['Capitulos Vistos'];
        $cap_total = $mostrar['Capitulos Totales'];
        $cap_faltantes = $mostrar['Faltantes'];
        $estado = $mostrar['Estado'];
        $lista = $mostrar['Lista'];
        $estdo_link = $mostrar['Estado_Link'];
        $fecha_1 = $mostrar['Fecha_Cambio1'];
        $fecha_2 = $mostrar['Fecha_Cambio2'];
    }


    try {
        $sql = "INSERT INTO `$modulo`(`ID`, 
        `Nombre`, 
        `Link`, 
        `Capitulos Vistos`, 
        `Capitulos Totales`, 
        `Faltantes`,
        `Estado`, 
        `Lista`, 
        `Estado_Link`, 
        `Fecha_Cambio1`, 
        `Fecha_Cambio2`,
         `verificado`)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param(
            "issiiissssss",
            $ID_Eliminado,
            $nombre,
            $link,
            $cap_vistos,
            $cap_total,
            $cap_faltantes,
            $estado,
            $lista,
            $estdo_link,
            $fecha_1,
            $fecha_2,
            $verif
        );

        if ($stmt->execute()) {
            $iden = $conexion->insert_id;
            echo "Registro recuperado correctamente .<br>";
        } else {
            echo "Error al insertar: " . $stmt->error . "<br>";
        }


        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }

    // Elimina el manga de la tabla finalizados
    $sql_delete = "DELETE FROM `finalizados_manga` WHERE ID = ?";
    $stmt_delete = $conexion->prepare($sql_delete);
    $stmt_delete->bind_param("i", $idRegistros);
    $stmt_delete->execute();


    if ($modulo == "Manga") {

        //Hace una actualizacion general de las cantidad de diferencias
        $update_cantidad = ("UPDATE manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias WHERE manga.ID = diferencias.ID_Manga);");
        $result_cantidad = mysqli_query($conexion, $update_cantidad);
    } else {

        //Hace una actualizacion general de las cantidad de diferencias pendientes
        $update_cantidad = ("UPDATE pendientes_manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias_pendientes WHERE pendientes_manga.ID = diferencias_pendientes.ID_Pendientes);");
        $result_cantidad = mysqli_query($conexion, $update_cantidad);
    }

    $alertTitle = '¡Manga Recuperado!';
    $alertText = 'Recuperando ' . $nombre . ' a ' . ucfirst($modulo) . '';
    $alertType = 'success';
    $redireccion = "window.location='../'";

    alerta($alertTitle, $alertText, $alertType, $redireccion);
    die();
} else {
    $alertTitle = '¡ID Registro no Ingresado!';
    $alertText = 'No se detecto ID Registro, favor intentarlo denuevo';
    $alertType = 'error';
    $redireccion = "window.location='../'";

    alerta($alertTitle, $alertText, $alertType, $redireccion);
    die();
}
?>