<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php'; // Asegúrate de incluir tu archivo de conexión a la base de datos

$dato9 = $_REQUEST['id'];

// Consulta SQL para obtener datos filtrados por $fila7
$sql = "SELECT * FROM $tabla2 WHERE $fila7='$dato9'";
$consulta = mysqli_query($conexion, $sql);

// Consulta SQL para obtener datos filtrados por $fila9
$sql1 = "SELECT * FROM $tabla WHERE $fila9='$dato9'";
$consulta1 = mysqli_query($conexion, $sql1);

while ($mostrar = mysqli_fetch_assoc($consulta)) {
    $dato1 = $mostrar[$fila1];
    $dato2 = $mostrar[$fila2];
    $dato3 = $mostrar[$fila3];
    $dato4 = $mostrar[$fila4];
    $dato5 = $mostrar[$fila5];
    $dato6 = $mostrar[$fila6];
    $dato10 = $mostrar[$fila10];
    $dato8 = $mostrar[$fila8];
    $dato11 = $mostrar[$fila11];
    $dato12 = $mostrar[$fila12];
}

echo $sql . "<br>";
echo $fila1 . "<br>";
echo $dato1 . "<br>";
echo $dato9 . "<br>";
echo $dato11 . "<br>";
echo $dato12 . "<br>";

if (mysqli_num_rows($consulta1) == 0) {


    if (mysqli_num_rows($consulta) == 0) {
        actualizarTabla($servidor, $basededatos, $usuario, $password, $tabla, $fila4, $fila3, $fila5);
        mostrarError("Registro de $dato1 No Existe en $tabla");
    } else {
        $totalRegistros = obtenerTotalRegistros($conexion, "tachiyomi");

        if ($totalRegistros >= 30) {
            mostrarError("Hay más de 30 registros en $tabla");
            actualizarTabla($servidor, $basededatos, $usuario, $password, $tabla, $fila4, $fila3, $fila5);
        } else {
            insertarEnTabla($conexion, $tabla, $fila1, $fila9, $fila2, $fila3, $fila4, $fila5, $fila6, $fila8, $fila10, $fila11, $dato1, $dato9, $dato2, $dato3, $dato4, $dato5, $dato6, $dato8, $dato10, $dato11);
            mostrarExito("Creando $dato1 en $tabla");
        }
    }
} else {
    mostrarError("Registro de $dato1 Existe en $tabla");
}

// Funciones necesarias

function mostrarError($mensaje)
{
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "' . $mensaje . '",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
               window.location.href = "index.php";
            }
         });
        </script>';
    exit(); // Importante salir después de mostrar el error
}

function mostrarExito($mensaje)
{
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "' . $mensaje . '",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php";
            }
        });
        </script>';
    exit(); // Importante salir después de mostrar el éxito
}

function insertarEnTabla($conexion, $tabla, $fila1, $fila9, $fila2, $fila3, $fila4, $fila5, $fila6, $fila8, $fila10, $fila11, $dato1, $dato9, $dato2, $dato3, $dato4, $dato5, $dato6, $dato8, $dato10, $dato11)
{
    $sql = "INSERT INTO $tabla(`$fila1`, `$fila9`, `$fila2`, `$fila3`, `$fila4`, `$fila5`, `$fila6`, `$fila8`, `$fila10`, `$fila11`) VALUES
        ('$dato1', '$dato9', '$dato2', '$dato3', '$dato4', '$dato5', '$dato6', '$dato8', '$dato10', '$dato11')";
    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        mostrarError("Error al insertar en $tabla");
    }
}

function obtenerTotalRegistros($conexion, $tabla)
{
    $sql = "SELECT COUNT(*) AS total_registros FROM $tabla";
    $consulta = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($consulta);
    return $fila['total_registros'];
}

function actualizarTabla($servidor, $basededatos, $usuario, $password, $tabla, $fila4, $fila3, $fila5)
{
    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE $tabla SET `$fila5`= (`$fila4`-`$fila3`)";
        $conn->exec($sql);
        echo $sql;
    } catch (PDOException $e) {
        $conn = null;
        echo $e;
        echo "<br>";
        echo $sql;
    }
}
