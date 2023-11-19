<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$idRegistros      = $_REQUEST['id'];
$fecha_nueva      = $_REQUEST['fecha_antigua'];
$fecha_vieja      = $_REQUEST['fecha_actual'];
$ID_Manga         = $_REQUEST['id_manga'];
$link             = $_REQUEST['link'];

$fecha1 = new DateTime($_REQUEST['fecha_antigua']); // Primera fecha
$fecha2 = new DateTime($_REQUEST['fecha_actual']); // Segunda fecha (fecha actual)

// Establecer la hora a 0:00:00
$fecha1->setTime(0, 0, 0);
$fecha2->setTime(0, 0, 0);

// Formatear las fechas sin la hora
$fecha1Formateada = $fecha1->format('Y-m-d');
$fecha2Formateada = $fecha2->format('Y-m-d');

// Calcular la diferencia en días
$diferencia = strtotime($fecha2Formateada) - strtotime($fecha1Formateada);
$dias = floor($diferencia / (60 * 60 * 24));

// Mostrar la diferencia en días
echo "La diferencia en días entre $fecha1Formateada y $fecha2Formateada es: $dias días.";

//Hacer la resta de dias
$fechaInicio = new DateTime($fecha2Formateada);
$fechaFin = new DateTime($fecha1Formateada);
$diferencia2 = $fechaInicio->diff($fechaFin);
echo "<br>";

$dias2 = $diferencia2->days;
echo "Dias :".$dias2;
echo "<br>";


echo $idRegistros;
echo "<br>";
echo $fecha_nueva;
echo "<br>";
echo $fecha_vieja;
echo "<br>";
echo $link;
echo "<br>";
echo "Fecha Nuevo Capitulo : ".$fecha1Formateada;
echo "<br>";
echo "Fecha Ultimo Capitulo : ".$fecha2Formateada;
echo "<br>";
echo "Diferencia".$dias;
echo "<br>";

if($fecha_nueva=="00-00-0000 00:00:00" OR $fecha_nueva==""){

    echo "Fecha 0";
    echo '<script>
        Swal.fire({
        icon: "error",  
        title: "Error en la Fecha de la ' . $tabla7 . '",
        text: "La Fecha no es valida",
        confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';

}else if($dias=="0"){

    echo "Diferencias 0";
    echo '<script>
        Swal.fire({
        icon: "error",  
        title: "Error en los dias de las ' . $tabla7 . '",
        text: "La diferencia minima deberia ser 1",
        confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';

}else{

    try {
        $sql = "UPDATE `$tabla7` SET $fila12='$dias2',$titulo4='$fecha_vieja' WHERE $fila7='$idRegistros';";
        $resultado = mysqli_query($conexion, $sql);
        echo $sql;
    } catch (PDOException $e) {
        echo $e;
        echo "<br>";
        echo $sql;
    }

    echo '<script>
        Swal.fire({
        icon: "success",
        title: "Actualizando registro de ' . $fecha2Formateada . ' en ' . $tabla7 . '",
        confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
    </script>';

}


