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

// Establecer la zona horaria para Santiago de Chile.
date_default_timezone_set('America/Santiago');

// Obtener la fecha y hora actual con 5 horas de retraso.
$fecha_actual_retrasada = date('Y-m-d H:i:s', strtotime('-5 hours'));

$fecha_hora_actual = date('Y-m-d H:i:s');

// Array con los nombres de los días en español.
$nombres_dias = array(
    'Domingo',
    'Lunes',
    'Martes',
    'Miercoles',
    'Jueves',
    'Viernes',
    'Sabado'
);

// Obtener el número del día de la semana (0 para domingo, 1 para lunes, etc.).
$numero_dia = date('w', strtotime($fecha_actual_retrasada));

// Obtener el nombre del día actual en español.
$day = $nombres_dias[$numero_dia];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idRegistros = $_REQUEST['id'];
    $idManga     = $_REQUEST['id_manga'];
    $nombre = $_REQUEST['name'];
    $capitulos_faltantes = $_REQUEST['faltantes'];
    $lista       = $_REQUEST['lista'];
    $link = $_REQUEST['link'];


    $sql = "SELECT * FROM manga WHERE ID = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("i", $idManga);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($mostrar = $resultado->fetch_assoc()) {
        // Recuperar datos si hay resultados
        $nombre_manga = $mostrar['Nombre'];
        $Link_manga = $mostrar['Link'];
        $cap_vistos = $mostrar['Capitulos Vistos'];
        $cap_total = $mostrar['Capitulos Totales'];
        $cap_faltantes = $mostrar['Faltantes'];
        $estado_manga = $mostrar['Estado'];
        $lista_manga = $mostrar['Lista'];
        $estadolink_manga = $mostrar['Estado_Link'];
        $fecha_cambio1 = $mostrar['Fecha_Cambio1'];
        $fecha_cambio2 = $mostrar['Fecha_Cambio2'];

        $verificado = $mostrar['verificado'];
        $anime = $mostrar['Anime'];
    }

    $sql_diferencias = "SELECT * FROM diferencias WHERE ID_Manga = ?";
    $consulta_diferencias = $conexion->prepare($sql_diferencias);
    $consulta_diferencias->bind_param("i", $idManga);
    $consulta_diferencias->execute();
    $resultado_diferencias = $consulta_diferencias->get_result();

    if (isset($_POST['Tachiyomi'])) {
        if ($lista == "Sin Lista") {
            $alertTitle = '¡Error al Eliminar!';
            $alertText = 'No se puede eliminar  ' . $nombre . ' de ' . ucfirst($tabla) . ' porque no tiene Lista';
            $alertType = 'error';
            $redireccion = "window.location='$link'";

            alerta($alertTitle, $alertText, $alertType, $redireccion);
            die();
        } else {
            // Elimina la manga de la tabla original
            $sql_delete = "DELETE FROM `tachiyomi` WHERE ID = ?";
            $stmt_delete = $conexion->prepare($sql_delete);
            $stmt_delete->bind_param("i", $idRegistros);
            $stmt_delete->execute();

            $alertTitle = '¡Manga Eliminado!';
            $alertText = 'Eliminando ' . $nombre . ' de ' . ucfirst($tabla) . '';
            $alertType = 'success';
            $redireccion = "window.location='$link'";

            alerta($alertTitle, $alertText, $alertType, $redireccion);
            die();
        }
    } else if (isset($_POST['Finalizados'])) {

        if ($capitulos_faltantes == 0) {
            // Si no hay capítulos faltantes, mueve la manga a la tabla de finalizados
            try {
                $sql = "INSERT INTO `finalizados_manga` (`Nombre`, `Link`, `Capitulos Vistos`, `Capitulos Totales`, `Faltantes`, `Estado`, `Lista`, `Estado_Link`, `Fecha_Cambio1`, `Fecha_Cambio2`, `ID_Eliminado`, `Modulo`) 
                        VALUES (?, ?, ?, ?, ?, 'Finalizado', ?, ?, ?, ?, ?, 'Manga')";

                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ssiiissssi", $nombre_manga, $Link_manga, $cap_vistos, $cap_total, $cap_faltantes, $lista_manga, $estadolink_manga, $fecha_cambio1, $fecha_cambio2, $idManga);

                if ($stmt->execute()) {
                    echo "Registro insertado correctamente en finalizados_manga.<br>";
                } else {
                    echo "Error al insertar: " . $stmt->error . "<br>";
                }

                $stmt->close();
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage() . "<br>";
            }


            // Elimina la manga de la tabla original
            $sql_delete = "DELETE FROM `manga` WHERE ID = ?";
            $stmt_delete = $conexion->prepare($sql_delete);
            $stmt_delete->bind_param("i", $idManga);
            $stmt_delete->execute();

            // Elimina el manga de la tabla nombres_mangas
            $sql_delete_nombres = "DELETE FROM `nombres_mangas` WHERE ID_Manga = ?";
            $stmt_delete_nombres = $conexion->prepare($sql_delete_nombres);
            $stmt_delete_nombres->bind_param("i", $idManga);
            $stmt_delete_nombres->execute();

            // eliminando de tachiyomi
            $sql = "DELETE FROM `tachiyomi` WHERE ID = ?";
            $stmt_delete_tachiyomi = $conexion->prepare($sql);
            $stmt_delete_tachiyomi->bind_param("i", $idRegistros);
            $stmt_delete_tachiyomi->execute();

            $alertTitle = '¡Manga Eliminado!';
            $alertText = 'Eliminando ' . $nombre . ' de ' . ucfirst($tabla) . '  y Mangas e insertando en Finalizados';
            $alertType = 'success';
            $redireccion = "window.location='$link'";

            alerta($alertTitle, $alertText, $alertType, $redireccion);
            die();
        } else {
            $alertTitle = '¡Capitulos Faltantes!';
            $alertText = $nombre . ' tiene ' . $capitulos_faltantes . ' Capitulos Faltantes';
            $alertType = 'error';
            $redireccion = "window.location='$link'";

            alerta($alertTitle, $alertText, $alertType, $redireccion);
            die();
        }
    } elseif (isset($_POST['Pendientes'])) {

        try {
            $sql = "INSERT INTO `pendientes_manga`(`Nombre`, `Link`, `Capitulos Vistos`, `Capitulos Totales`, `Faltantes`, `Estado`, `Lista`, `Estado_Link`, `Fecha_Cambio1`, `Fecha_Cambio2`, `Hora_Cambio`, `verificado`, `Anime`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssiiissssssss", $nombre_manga, $Link_manga, $cap_vistos, $cap_total, $cap_faltantes, $estado_manga, $lista_manga, $estadolink_manga, $fecha_cambio1, $fecha_cambio2, $fecha_hora_actual, $verificado, $anime);

            if ($stmt->execute()) {
                $iden = $conexion->insert_id;
                echo "Registro insertado correctamente en pendientes.<br>";
            } else {
                echo "Error al insertar: " . $stmt->error . "<br>";
            }

            $stmt->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }

        // Elimina la manga de la tabla original
        $sql_delete = "DELETE FROM `manga` WHERE ID = ?";
        $stmt_delete = $conexion->prepare($sql_delete);
        $stmt_delete->bind_param("i", $idManga);
        $stmt_delete->execute();

        // Elimina el manga de la tabla nombres_mangas
        $sql_delete_nombres = "DELETE FROM `nombres_mangas` WHERE ID_Manga = ?";
        $stmt_delete_nombres = $conexion->prepare($sql_delete_nombres);
        $stmt_delete_nombres->bind_param("i", $idManga);
        $stmt_delete_nombres->execute();


        // Verificar si hay resultados
        if (mysqli_num_rows($resultado_diferencias) > 0) {

            try {
                // Preparar la consulta de inserción
                $insertQuery = "INSERT INTO diferencias_pendientes (ID_Pendientes, Diferencia, Fecha, Dia) VALUES (?, ?, ?, ?)";

                // Preparar la declaración
                $stmt = $conexion->prepare($insertQuery);

                // Recorrer los resultados y ejecutar la inserción
                while ($fila = mysqli_fetch_assoc($resultado_diferencias)) {
                    $columna1 = $fila['Diferencia'];
                    $columna2 = $fila['Fecha'];
                    $columna3 = $fila['Dia'];

                    // Vincular los parámetros y ejecutar la consulta para cada fila
                    $stmt->bind_param("ssss", $iden, $columna1, $columna2, $columna3);
                    $stmt->execute();
                }

                // Confirmar la transacción
                $conexion->commit();
                echo "Inserción completada correctamente.";
            } catch (Exception $e) {
                // En caso de error, hacer rollback de la transacción
                $conexion->rollback();
                echo "Error: " . $e->getMessage();
            }


            // Elimina el manga de la tabla diferencias
            $sql_delete_diferencias = "DELETE FROM `diferencias` WHERE ID_Manga = ?";
            $stmt_delete_diferencias = $conexion->prepare($sql_delete_diferencias);
            $stmt_delete_diferencias->bind_param("i", $idManga);
            $stmt_delete_diferencias->execute();
        } else {
            echo "No se encontraron resultados en diferencias.";
        }

        //Hace una actualizacion general de las cantidad de diferencias con el ID Manga
        $update_cantidad = ("UPDATE pendientes_manga SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM diferencias_pendientes WHERE pendientes_manga.ID = diferencias_pendientes.ID_Pendientes);");
        $result_cantidad = mysqli_query($conexion, $update_cantidad);

        $sql = "DELETE FROM `tachiyomi` WHERE ID = ?";
        $stmt_delete_tachiyomi = $conexion->prepare($sql);
        $stmt_delete_tachiyomi->bind_param("i", $idRegistros);
        $stmt_delete_tachiyomi->execute();


        $alertTitle = '¡Manga Eliminado!';
        $alertText = 'Eliminando ' . $nombre . ' de ' . ucfirst($tabla) . '  y Mangas e insertando en Pendientes';
        $alertType = 'success';
        $redireccion = "window.location='$link'";

        alerta($alertTitle, $alertText, $alertType, $redireccion);
        die();
    } else {
        $alertTitle = '¡ID Manga no Ingresado!';
        $alertText = 'No se detecto ID Manga, favor intentarlo denuevo';
        $alertType = 'error';
        $redireccion = "window.location='$link'";

        alerta($alertTitle, $alertText, $alertType, $redireccion);
        die();
    }
}
