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

    if (isset($_POST['check_lista']) && is_array(value: $_POST['check_lista']) && !empty($_POST['check_lista'])) {
        $check = addslashes(implode(", ", $_POST['check_lista']));
    } else {
        // Aquí puedes manejar el caso de que no se hayan seleccionado días
        $check = 'Indefinido';  // O asignar algún valor predeterminado
    }

    try {
        // Conexión PDO con UTF-8
        $conn = new PDO("mysql:host=$servidor;dbname=$basededatos;charset=utf8mb4", $usuario, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Consulta preparada para inserción
        $sql = "INSERT INTO $tabla (`$fila1`, `$fila2`, `$fila3`, `$fila4`, `$fila6`, `$fila8`) 
                VALUES (:nombres, :link, :vistos, :totales, :dias, :estado)";

        $query = $conn->prepare($sql);
        $query->execute([
            ':nombres' => $dato1,
            ':link'    => $dato2,
            ':vistos'  => $dato3,
            ':totales' => $dato4,
            ':dias'    => $check,
            ':estado'  => $dato8,
        ]);

        // SweetAlert de éxito
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Registro agregado correctamente",
                text: "Se ha registrado ' . htmlspecialchars($dato1, ENT_QUOTES, 'UTF-8') . ' en ' . htmlspecialchars($tabla, ENT_QUOTES, 'UTF-8') . '",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.reload();
            });
        </script>';
    } catch (PDOException $e) {
        // SweetAlert de error con mensaje específico
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error al registrar",
                text: "' . addslashes($e->getMessage()) . '",
                confirmButtonText: "OK"
            });
        </script>';
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