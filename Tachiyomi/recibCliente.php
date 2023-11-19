<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$nombre      = $_REQUEST['nombre'];

$sql2      = ("SELECT * FROM $tabla2 where $fila1  LIKE '%$nombre%';");

$consulta2 = mysqli_query($conexion, $sql2);

while ($mostrar2 = mysqli_fetch_array($consulta2)) {

    $dato9 = $mostrar2[$fila7];
    echo $dato9 . "<br>";
}

$sql      = ("SELECT * FROM $tabla2 where $fila7='$dato9';");
$consulta = mysqli_query($conexion, $sql);
$sql1      = ("SELECT * FROM $tabla where $fila9='$dato9';");
$consulta1 = mysqli_query($conexion, $sql1);

echo $sql2 . "<br>";

while ($mostrar = mysqli_fetch_array($consulta)) {

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
echo $sql;
echo "<br>";
echo $fila1;
echo "<br>";
echo $dato1;
echo "<br>";
echo $dato9;
echo "<br>";
echo $dato11;
echo "<br>";
echo $dato12;
echo "<br>";
$Tabla = ucfirst($tabla2);

if (mysqli_num_rows($consulta1) == 0) {

    echo "$dato1 no existe en $tabla";
    echo "<br>";

    echo '<script>
Swal.fire({
    icon: "error",
    title: "Registro de ' . $dato1 . ' No Existe en ' . $Tabla . '",
    confirmButtonText: "OK"
}).then(function() {
    window.location = "index.php";
});
</script>';
    echo "<br>";
    if (mysqli_num_rows($consulta) == 0) {

        echo "$dato1 no existe en $tabla2";
        echo "<br>";

        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Registro de ' . $dato1 . ' No Existe en ' . $Tabla . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "index.php";
        });
        </script>';
        echo "<br>";



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
    } else {

        echo "$dato1 existe en $tabla2";

        echo "<br>";


        try {
            $sql = "INSERT INTO $tabla(`$fila1`,`$fila9`,`$fila2`, `$fila3`, `$fila4`,`$fila5`,`$fila6`,`$fila8`,`$fila10`,`$fila11`) VALUES
        ( '" . $dato1 . "','" . $dato9 . "','" . $dato2 . "','" . $dato3 . "','" . $dato4 . "','" . $dato5 . "','" . $dato6 . "','" . $dato8 . "','" . $dato10 . "','" . $dato11 . "')";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
            echo "<br>";
        } catch (PDOException $e) {
            $conn = null;
            echo $sql;
            echo "<br>";
            echo $e;
        }

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

        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Creando registro de ' . $dato1 . ' en ' . $tabla . '",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "index.php";
        });
        </script>';
    }
} else {

    echo "$dato1  existe en $tabla";
    echo "<br>";

    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Registro de ' . $dato1 . ' Existe en ' . $tabla . '",
        confirmButtonText: "OK"
    }).then(function() {
        window.location = "index.php";
    });
    </script>';
    echo "<br>";
}
