<!--coment-->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';

$idRegistros      = $_REQUEST['id'];
$nombre           = $_REQUEST['name'];
$link             = $_REQUEST['link'];

if (isset($_POST['Finalizados'])) {
    //Agranda la primera letra de la varible
    $Tabla = ucfirst($tabla);
    $Tabla4 = ucfirst($tabla4);

    $sql = ("SELECT * FROM $tabla WHERE $fila7='$idRegistros';");
    $sql2 = ("SELECT * FROM $tabla4 where $fila9='$idRegistros';");

    $consulta1    = mysqli_query($conexion, $sql2);
    $consulta      = mysqli_query($conexion, $sql);

    //Busca el fecha de la ultima actualizacion en mangas
    $sql3 = ("SELECT * FROM $tabla where $fila7='$idRegistros';");
    $consulta2 = mysqli_query($conexion, $sql3);

    //Saca la ultima fecha registrada
    while ($mostrar = mysqli_fetch_array($consulta2)) {

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
    }

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
    echo $dato13;
    echo "<br>";
    echo $idRegistros;
    echo "<br>";

    if ($dato5 == 0) {
        echo "El manga no tiene capitulos faltantes";
        echo "<br>";
        //Hace la actualizacion en mangas
        try {
            $sql = "INSERT INTO `$tabla5`(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila5`, `$fila6`,`$fila8`,`$fila10`,`$fila11`,`$fila13`,`$fila14`,`$fila16`) VALUES
            ('" . $dato1 . "','" . $dato2 . "','" . $dato3 . "','" . $dato4 . "','" . $dato5 . "','" . $dato6 . "','Finalizado','" . $dato10 . "','" . $dato11 . "','" . $dato13 . "','"               . $idRegistros . "','manga')";
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

        if (mysqli_num_rows($consulta1) > 0) {
            echo "<br>";
            echo "Existe en $tabla4 y en $tabla";
            echo "<br>";
            //Actualiza los datos requeridos en tachiyomi

            try {
                $sql = "DELETE FROM `$tabla4` WHERE $fila9='$idRegistros';";
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
                title: "Eliminando ' . $nombre . ' de ' . $Tabla . ' y ' . $Tabla4 . '  e insertando en Finalizados",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '"; 
            });
            </script>';
        }
    } else {
        echo "El manga tiene capitulos faltantes";
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "' . $nombre . ' tiene Capitulos Faltantes ",
                confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '"; 
            }); 
        </script>';
    }
} else if (isset($_POST['Pendientes'])) {

    $sql      = ("SELECT * FROM $tabla where $fila7='$idRegistros';");
    echo $sql;
    echo "<br>";
    $consulta = mysqli_query($conexion, $sql);

    $query  = ("SELECT * FROM $tabla7 where $fila9='$idRegistros';");
    echo $query;
    echo "<br>";
    $resultado3  = mysqli_query($conexion, $query);

    //Agranda la primera letra de la varible
    $Tabla = ucfirst($tabla);
    $Tabla2 = ucfirst($tabla2);

    while ($mostrar = mysqli_fetch_array($consulta)) {

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
        $dato17 = $mostrar[$fila17];
        $verif = $mostrar[$ver];
    }

    $sql1      = ("SELECT * FROM $tabla8 where $fila1='$dato1';");
    $consulta1 = mysqli_query($conexion, $sql1);
    echo $sql1;
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
    echo $dato13;
    echo "<br>";
    echo $dato17;
    echo "<br>";
    echo $verif;
    echo "<br>";

    if (mysqli_num_rows($consulta1) == 0) {

        try {
            $sql = "INSERT INTO `$tabla8`(`$fila1`,`$fila2`,`$fila3`, `$fila4`, `$fila5`, `$fila6`,`$fila8`,`$fila10`,`$fila11`,`$fila13`,`$ver`,`$fila17`) VALUES
            ( '" . $dato1 . "','" . $dato2 . "','" . $dato3 . "','" . $dato4 . "','" . $dato5 . "','" . $dato6 . "','" . $dato8 . "','" . $dato10 . "','" . $dato11 . "','" . $dato13 . "','" . $verif . "','" . $dato17 . "')";
            $resultado = mysqli_query($conexion, $sql);
            echo $sql;
            echo "<br>";
        } catch (PDOException $e) {
            echo $e;
            echo "<br>";
            echo $sql;
        }

        try {
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE $tabla8 SET `$fila5`= (`$fila4`-`$fila3`)";
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
            $sql = "DELETE FROM `$tabla4` WHERE $fila9='$idRegistros';";
            $conn->exec($sql);
            echo $sql;
            echo "<br>";
        } catch (PDOException $e) {
            $conn = null;
            echo $e;
            echo "<br>";
            echo $sql;
        }

        // Verificar si hay resultados
        if (mysqli_num_rows($resultado3) > 0) {
            // Arreglo para almacenar los resultados
            $resultados = array();

            // Recorrer los resultados y guardarlos en el arreglo
            while ($fila = mysqli_fetch_assoc($resultado3)) {
                $resultados[] = $fila;
            }

            //Busca el id de la manga recien insertado
            $consulta1 = "SELECT * FROM `$tabla8` where Nombre='$dato1'";
            $resultado1 = mysqli_query($conexion, $consulta1);
            echo $consulta1;
            echo "<br>";

            while ($fila1 = mysqli_fetch_assoc($resultado1)) {
                $iden = $fila1['ID'];
            }

            echo "ID :" . $iden;
            echo "<br>";

            // Insertar los resultados en otra tabla
            foreach ($resultados as $fila) {
                $columna1 = $fila['Diferencia'];
                $columna2 = $fila['Fecha'];

                // Consulta SQL de inserción en la nueva tabla
                $insertQuery = "INSERT INTO $tabla9 ($fila15,$fila12,$titulo4) VALUES('$iden','$columna1', '$columna2')";

                echo $fila['Diferencia'];
                echo "<br>";
                echo $fila['Fecha'];
                echo "<br>";
                echo $insertQuery;
                echo "<br>";

                // Ejecutar la consulta de inserción
                $resultado2 = mysqli_query($conexion, $insertQuery);
            }

            echo "Datos insertados correctamente en la nueva tabla.";
            echo "<br>";

            try {
                $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "DELETE FROM `$tabla7` WHERE $fila9='$idRegistros';";
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
        title: "Elimando registro de ' . $nombre . ' en ' . $Tabla . ' y insertando en ' . $titulo7 . '",
        confirmButtonText: "OK"
        }).then(function() {
            window.location = "' . $link . '"; 
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
            $sql = "DELETE FROM `$tabla4` WHERE $fila9='$idRegistros';";
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
            title: "Elimando registro de ' . $nombre . ' en ' . $Tabla . '",
            confirmButtonText: "OK"
            }).then(function() {
                window.location = "' . $link . '"; 
            });
        </script>';
    }
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
