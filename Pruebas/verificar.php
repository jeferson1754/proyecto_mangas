<?php
// Uso de estilos CSS para mensajes de error, advertencia y éxito
echo '
<style>
    .error {
        color: red;
    }
    .warning {
        color: yellow;
    }
    .success {
        color: green;
    }
    .next {
        color: darkblue;
    }
</style>
';

// Variables para contar los resultados
$totalCorrectos = 0;
$totalRedireccionados = 0;
$totalErrores = 0;

// Array para almacenar enlaces con errores y su código HTTP
$errores = [];

// Función para verificar si un enlace es válido
function verificarEnlace($url, &$totalCorrectos, &$totalRedireccionados, &$totalErrores, &$errores)
{
    // Filtrar la URL para eliminar caracteres no válidos
    $urlFiltrada = filter_var($url, FILTER_SANITIZE_URL);

    if ($urlFiltrada === false) {
        echo "<p class='warning'>Error: URL no válida. Por favor, ingresa una URL válida e intenta nuevamente.</p>";
        return;
    }

    $curl = curl_init();  // Inicializar cURL

    // Configurar cURL para seguir redireccionamientos y limitar el número máximo de redireccionamientos
    curl_setopt_array($curl, [
        CURLOPT_URL => $urlFiltrada,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_NOBODY => true,
        CURLOPT_TIMEOUT => 30,  // Tiempo de espera para evitar bloqueos
        CURLOPT_FOLLOWLOCATION => true,  // Seguir redireccionamientos
        CURLOPT_MAXREDIRS => 15,  // Limitar redireccionamientos
    ]);

    $curlResponse = curl_exec($curl);  // Ejecutar la solicitud cURL

    if ($curlResponse === false) {
        $errorMessage = curl_error($curl);  // Obtener mensaje de error cURL
        echo "<p class='error'>Error al verificar el enlace '$urlFiltrada' - $errorMessage.</p>";
        $totalErrores++;
        $errores[] = ['url' => $urlFiltrada, 'error' => $errorMessage];
        curl_close($curl);  // Cerrar cURL para liberar recursos
        return;
    }

    // Obtener el código HTTP y la URL final después de posibles redireccionamientos
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $urlEfectiva = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);

    curl_close($curl);  // Cerrar cURL para liberar recursos

    if ($httpCode === 200) {
        if ($urlEfectiva !== $urlFiltrada) {  // Si la URL final es diferente a la original
            $totalRedireccionados++;
            echo "<p class='success'>El enlace original <a class='next' href='$urlFiltrada' target='_blank'>'$urlFiltrada'</a> se redirige a <a class='next' href='$urlEfectiva' target='_blank'>'$urlEfectiva'</a> y funciona correctamente.</p>";
        } else {
            //echo "<p class='success'>El enlace <a href='$urlFiltrada' target='_blank'>'$urlFiltrada'</a>  es correcto</p>";
            $totalCorrectos++;
        }
    } else {
        $totalErrores++;
        $errores[] = ['url' => $urlFiltrada, 'httpCode' => $httpCode];
        echo "<p class='error'>Error: El enlace <a href='$urlFiltrada' target='_blank'>'$urlFiltrada'</a>  no funciona. Código HTTP: $httpCode.</p>";
    }
}

// Uso de conexiones persistentes para la base de datos, si es posible
require_once '../bd.php';  // Reemplazar con la configuración de conexión persistente si aplica

// Consulta SQL optimizada para obtener enlaces de manera más eficiente
$sql = "SELECT * FROM `op` WHERE Link != '' ORDER BY `op`.`Estado_Link` DESC LIMIT 25;";

$resultado = $conexion->query($sql);

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        verificarEnlace($fila['Link'], $totalCorrectos, $totalRedireccionados, $totalErrores, $errores);
        //verificarEnlace($fila['Link_Iframe'], $totalCorrectos, $totalRedireccionados, $totalErrores, $errores);
    }
    $resultado->free();  // Liberar recursos de la base de datos
} else {
    echo "<p class='error'>Error al obtener enlaces de la base de datos.</p>";
}

// Cerrar conexión a la base de datos
$conexion->close();

// Resultados finales
echo "<p>Total de enlaces correctos: $totalCorrectos.</p>";
echo "<p>Total de enlaces redireccionados: $totalRedireccionados.</p>";
echo "<p>Total de enlaces con errores: $totalErrores.</p>";

if ($totalErrores > 0) {
    echo "<p>Errores detallados:</p>";
    foreach ($errores as $error) {
        echo "<p>Error - ";
        if (isset($error['httpCode'])) {
            echo "Código HTTP: {$error['httpCode']}";
        } else {
            echo "{$error['error']}";
        }
        echo "</p>";
    }
}
