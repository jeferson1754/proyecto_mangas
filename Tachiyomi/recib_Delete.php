<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
$idRegistros = $_REQUEST['id'];
$idManga     = $_REQUEST['id_manga'];
$nombre      = $_REQUEST['name'];
$lista       = $_REQUEST['lista'];
$link        = $_REQUEST['link'];

if (isset($_POST['Tachiyomi'])) {
    if ($lista == "Sin Lista") {
        echo "Manga sin Lista <br>";
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "No se puede eliminar registro de ' . $nombre . ' en ' . $tabla . ' porque no tiene Lista",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
        </script>';
    } else {
        echo "Manga con Lista <br>";
        try {
            $sql = "DELETE FROM `$tabla` WHERE $fila7='$idRegistros';";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql . "<br>";

            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Elimando registro de ' . $nombre . ' en ' . $tabla . '",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '"; 
            });
            </script>';
        } catch (PDOException $e) {
            echo $sql . "<br>";
            echo $e;
        }
    }
} else if (isset($_POST['Pendientes'])) {

    $sql = "SELECT * FROM `$tabla2` WHERE `$fila7`='$idManga';";
    echo $sql . "<br>";
    $consulta = mysqli_query($conexion, $sql);

    $query = "SELECT * FROM `$tabla7` WHERE `$fila9`='$idManga';";
    echo $query . "<br>";
    $resultado3 = mysqli_query($conexion, $query);

    // Agranda la primera letra de la variable
    $Tabla = ucfirst($tabla);
    $Tabla2 = ucfirst($tabla2);

    if ($mostrar = mysqli_fetch_array($consulta)) {
        $dato1 = $mostrar[$fila1];
        $dato2 = $mostrar[$fila2];
        $dato3 = $mostrar[$fila3];
        $dato4 = $mostrar[$fila4];
        $dato5 = $mostrar[$fila5];
        $dato6 = $mostrar[$fila6];
        $dato8 = $mostrar[$fila8];
        $dato10 = $mostrar[$fila10];
        $dato11 = $mostrar[$fila11];
        $dato12 = $mostrar[$fila12];
    }

    $sql1 = "SELECT * FROM `$tabla8` WHERE `$fila1`='$dato1';";
    $consulta1 = mysqli_query($conexion, $sql1);
    echo $sql1 . "<br>";

    echo $dato1 . "<br>";
    echo $dato2 . "<br>";
    echo $dato3 . "<br>";
    echo $dato4 . "<br>";
    echo $dato5 . "<br>";
    echo $dato6 . "<br>";
    echo $dato8 . "<br>";
    echo $dato10 . "<br>";
    echo $dato11 . "<br>";
    echo $dato12 . "<br>";



    if (mysqli_num_rows($consulta1) == 0) {

        try {
            $sql = "INSERT INTO `$tabla8`(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila5`, `$fila6`,`$fila8`,`$fila10`,`$fila11`,`$fila12`,`$ver`) VALUES
            ('$dato1','$dato2','$dato3','$dato4','$dato5','$dato6','$dato8','$dato10','$dato11','$dato12','NO')";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql . "<br>";
        } catch (PDOException $e) {
            echo $e . "<br>";
            echo $sql . "<br>";
        }

        try {
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `$tabla8` SET `$fila5`= (`$fila4`-`$fila3`)";
            $conn->exec($sql);
            echo $sql . "<br>";
        } catch (PDOException $e) {
            $conn = null;
            echo $e . "<br>";
            echo $sql . "<br>";
        }

        $deleteQueries = [
            "DELETE FROM `$tabla` WHERE `$fila7`='$idRegistros';",
            "DELETE FROM `$tabla2` WHERE `$fila7`='$idManga';"
        ];

        foreach ($deleteQueries as $deleteQuery) {
            try {
                $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->exec($deleteQuery);
                echo $deleteQuery . "<br>";
            } catch (PDOException $e) {
                $conn = null;
                echo $e . "<br>";
                echo $deleteQuery . "<br>";
            }
        }


        // Verificar si hay resultados
        if (mysqli_num_rows($resultado3) > 0) {
            // Buscar el ID de la manga recién insertado
            $consulta1 = "SELECT * FROM `$tabla8` WHERE Nombre = '$dato1'";
            $resultado1 = mysqli_query($conexion, $consulta1);
            $fila1 = mysqli_fetch_assoc($resultado1);
            $iden = $fila1['ID'];

            // Preparar la consulta de inserción en la nueva tabla
            $insertQuery = "INSERT INTO $tabla9 ($fila15, $fila13, $titulo4) VALUES ";

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

            echo "Datos insertados correctamente en la nueva tabla.";
            echo "<br>";

            // Intentar eliminar los registros de la tabla $tabla7
            try {
                $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "DELETE FROM `$tabla7` WHERE $fila9='$idManga';";
                $conn->exec($sql);
                echo $sql;
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

        echo '<script>
            Swal.fire({
        icon: "success",
        title: "Elimando registro de ' . $nombre . ' en ' . $Tabla . ' y insertando en ' . $tabla8 . '",
        confirmButtonText: "OK"
        }).then(function() {
            window.location = "index.php";
        });
        </script>';
        echo "<br>";
        $sql2      = ("UPDATE $tabla8 SET Cantidad = ( SELECT COUNT(*) AS cantidad_productos FROM $tabla9 WHERE $tabla8.$fila7 = $tabla9.$fila15) ;");
        echo $sql2;
        $consulta = mysqli_query($conexion, $sql2);
    } else {

        try {
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM `$tabla` WHERE $fila7='$idRegistros';";
            $conn->exec($sql);
            echo $sql;
            echo "<br>";
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }

        try {
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM `$tabla2` WHERE $fila7='$idManga';";
            $conn->exec($sql);
            echo $sql;
            echo "<br>";
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }

        echo '<script>
            Swal.fire({
            icon: "success",
            title: "Elimando registro de ' . $nombre . ' en ' . $Tabla . '",
            confirmButtonText: "OK"
            }).then(function() {
                window.location = "index.php";
            });
        </script>';
    }
} else if (isset($_POST['Finalizados'])) {
    //Agranda la primera letra de la varible
    $Tabla = ucfirst($tabla);
    $Tabla2 = ucfirst($tabla2);

    $sql = ("SELECT * FROM $tabla WHERE $fila9='$idManga';");
    $sql2 = ("SELECT * FROM $tabla2 where $fila7='$idManga';");

    $consulta      = mysqli_query($conexion, $sql);
    $consulta1    = mysqli_query($conexion, $sql2);

    //Saca la ultima fecha registrada
    while ($mostrar = mysqli_fetch_array($consulta1)) {

        $dato1 = $mostrar[$fila1];
        $dato2 = $mostrar[$fila2];
        $dato3 = $mostrar[$fila3];
        $dato4 = $mostrar[$fila4];
        $dato5 = $mostrar[$fila5];
        $dato6 = $mostrar[$fila6];
        $dato8 = $mostrar[$fila8];
        $dato10 = $mostrar[$fila10];
        $dato11 = $mostrar[$fila11];
        $dato12 = $mostrar[$fila12];
        $dato15 = $mostrar[$ver];
    }

    echo $sql;
    echo "<br>";
    echo $sql2;
    echo "<br>";
    echo $dato1;
    echo "<br>";
    echo $dato2;
    echo "<br>";
    echo $dato3;
    echo "<br>";
    echo $dato4;
    echo "<br>";
    echo $dato5;
    echo "<br>";
    echo $dato6;
    echo "<br>";
    echo $dato8;
    echo "<br>";
    echo $dato10;
    echo "<br>";
    echo $dato11;
    echo "<br>";
    echo $dato12;
    echo "<br>";
    echo $dato15;
    echo "<br>";
    echo $idRegistros;
    echo "<br>";

    if ($dato5 == 0) {
        echo "El manga no tiene capitulos faltantes";
        echo "<br>";
        //Hace la actualizacion en mangas
        try {
            $sql = "INSERT INTO `$tabla6`(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila5`, `$fila6`,`$fila8`,`$fila10`,`$fila11`,`$fila12`,`$fila14`) VALUES
            ( '" . $dato1 . "','" . $dato2 . "','" . $dato3 . "','" . $dato4 . "','" . $dato5 . "','" . $dato6 . "','Finalizado','" . $dato10 . "','" . $dato11 . "','" . $dato12 . "','"               . $idManga . "')";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
            echo "<br>";
        } catch (PDOException $e) {
            echo $e;
            echo "<br>";
            echo $sql;
        }

        try {
            $sql = "DELETE FROM `$tabla` WHERE $fila7='$idRegistros';";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
            echo "<br>";
        } catch (PDOException $e) {
            echo $e;
            echo "<br>";
            echo $sql;
        }

        try {
            $sql = "DELETE FROM `$tabla2` WHERE $fila7='$idManga';";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
            echo "<br>";
        } catch (PDOException $e) {
            echo $e;
            echo "<br>";
            echo $sql;
        }

        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Eliminando ' . $nombre . ' de ' . $Tabla . ' y insertando en Finalizados",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '"; 
            });
        </script>';
    } else {
        echo "El manga tiene capitulos faltantes";
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "' . $nombre . ' Tiene capitulos faltantes ",
            confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
        });
        </script>';
    }
}




//header("location:index.php");
?>