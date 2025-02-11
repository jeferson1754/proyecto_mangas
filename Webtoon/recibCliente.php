<!-- comentario -->
<header>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</header>

<?php
include 'bd.php';
// Validar datos entrantes desde $_REQUEST directamente
$dato1 = htmlspecialchars($_REQUEST['fila1'] ?? '', ENT_QUOTES, 'UTF-8');
$dato2 = htmlspecialchars($_REQUEST['fila2'] ?? '', ENT_QUOTES, 'UTF-8');
$dato3 = htmlspecialchars($_REQUEST['fila3'] ?? '', ENT_QUOTES, 'UTF-8');
$dato4 = htmlspecialchars($_REQUEST['fila4'] ?? '', ENT_QUOTES, 'UTF-8');
$dato8 = htmlspecialchars($_REQUEST['fila8'] ?? '', ENT_QUOTES, 'UTF-8');
$link  = filter_var($_REQUEST['link'] ?? '', FILTER_SANITIZE_URL);


$sql = "SELECT * FROM $tabla WHERE $fila1 = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $dato1);
$stmt->execute();
$resultado = $stmt->get_result();

$Tabla = ucfirst($tabla);

// Verificar si el registro existe
if ($resultado->num_rows === 0) {
    echo "$dato1 no existe en $tabla";

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dato1 = htmlentities($_POST['fila1']);
        $dato2 = htmlentities($_POST['fila2']);
        $dato3 = htmlentities($_POST['fila3']);
        $dato4 = htmlentities($_POST['fila4']);
        $dato8 = htmlentities($_POST['fila8']);

        
        if (isset($_POST['check_lista']) && is_array(value: $_POST['check_lista']) && !empty($_POST['check_lista'])) {
            $check = addslashes(implode(", ", $_POST['check_lista']));
        } else {
            // Aquí puedes manejar el caso de que no se hayan seleccionado días
            $check = 'Indefinido';  // O asignar algún valor predeterminado
        }


        $query = $conn->prepare(
            "INSERT INTO $tabla(`$fila1`, `$fila2`, `$fila3`, `$fila4`, `$fila6`, `$fila8`) 
             VALUES (:nombres, :link, :vistos, :totales, :dias, :estado)"
        );
        $query->execute([
            ':nombres' => $dato1,
            ':link'    => $dato2,
            ':vistos'  => $dato3,
            ':totales' => $dato4,
            ':dias'    => $check,
            ':estado'  => $dato8,
        ]);

        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Creando Registro de ' . $dato1 . ' en ' . $Tabla . '",
                confirmButtonText: "OK"
            }).then(() => {
                window.location = "' . $link . '"; 
            });
        </script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "$dato1 existe en $tabla";

    try {
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $updateSql = "UPDATE $tabla SET `$fila5` = (`$fila4` - `$fila3`)";
        $conn->exec($updateSql);

        echo $updateSql;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    echo '<script>
        Swal.fire({
            icon: "error",
            title: "Registro de ' . $dato1 . ' Existe en ' . $Tabla . '",
            confirmButtonText: "OK"
        }).then(() => {
            window.location = "' . $link . '"; 
        });
    </script>';
}
?>