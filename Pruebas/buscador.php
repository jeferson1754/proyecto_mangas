<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <form action="#" method="GET" class="search-form">
        <input type="search" name="query" placeholder="Buscar...">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>


    <div class="deudores">
        <?php
        require '../bd.php';

        $limit = 5;

        if (isset($_GET['query'])) {
            // Recuperar el término de búsqueda
            $query = $_GET['query'];

            // Consulta para buscar en la tabla mangas
            $sql_mangas = "SELECT * FROM manga WHERE Nombre LIKE '%$query%' ORDER BY `manga`.`ID` DESC limit $limit";
            $resultado_mangas = mysqli_query($conexion, $sql_mangas);

            // Consulta para buscar en la tabla anime
            $sql_anime = "SELECT * FROM anime WHERE Anime LIKE '%$query%' ORDER BY `anime`.`ID` DESC limit $limit";
            $resultado_anime = mysqli_query($conexion, $sql_anime);

            // Consulta para buscar en la tabla pendientes_mangas
            $sql_pendientes = "SELECT * FROM pendientes_manga WHERE Nombre LIKE '%$query%' ORDER BY `pendientes_manga`.`ID` DESC limit $limit";
            $resultado_pendientes = mysqli_query($conexion, $sql_pendientes);

            // Consulta para buscar en la tabla op
            $sql_op = "SELECT * FROM op WHERE Nombre LIKE '%$query%' ORDER BY `op`.`ID` DESC limit $limit";
            $resultado_op = mysqli_query($conexion, $sql_op);

            // Consulta para buscar en la tabla ed
            $sql_ed = "SELECT * FROM ed WHERE Nombre LIKE '%$query%' ORDER BY `ed`.`ID` DESC limit $limit";
            $resultado_ed = mysqli_query($conexion, $sql_ed);

            // Consulta para buscar en la tabla peliculas
            $sql_peliculas = "SELECT * FROM peliculas WHERE Nombre LIKE '%$query%' ORDER BY `peliculas`.`ID` DESC limit $limit";
            $resultado_peliculas = mysqli_query($conexion, $sql_peliculas);


            // Variable para controlar si se encontraron resultados en cada tabla
            $resultados_encontrados_mangas = false;
            $resultados_encontrados_anime = false;
            $resultados_encontrados_pendientes = false;

            $resultados_encontrados_op = false;
            $resultados_encontrados_ed = false;
            $resultados_encontrados_peliculas = false;

            // Mostrar los resultados de mangas
            echo "<div class='persona-container'>";
            echo "<div class='nombre-persona'> Mangas </div>";
            while ($fila = mysqli_fetch_assoc($resultado_mangas)) {
                echo "<div class='contenido'><br>";
                echo "<a href='/Manga/?busqueda_manga=".$fila['Nombre']."&buscar=&accion=Busqueda' target='_blanck'>";
                echo $fila['Nombre'] . "<br>";
                echo "</a>";
                echo "</div>";
                $resultados_encontrados_mangas = true;
            }
            if (!$resultados_encontrados_mangas) {
                echo "<div class='contenido'>";
                echo "No se encontraron resultados.<br>";
                echo "</div>";
            }
            echo "</div>";

            // Mostrar los resultados de anime
            echo "<div class='persona-container'>";
            echo "<div class='nombre-persona'> Anime<br> </div>";
            while ($fila = mysqli_fetch_assoc($resultado_anime)) {
                echo "<div class='contenido'><br>";
                echo "<a href='/Anime/?busqueda_anime=".$fila['Anime']."&buscar=' target='_blanck'>";
                echo $fila['Anime'] . "<br>";
                echo "</a>";
                echo "</div>";
                $resultados_encontrados_anime = true;
            }
            if (!$resultados_encontrados_anime) {
                echo "<div class='contenido'>";
                echo "No se encontraron resultados.<br>";
                echo "</div>";
            }
            echo "</div>";

            // Mostrar los resultados de pendientes_mangas
            echo "<div class='persona-container'>";
            echo "<div class='nombre-persona'> Pendientes Mangas<br> </div>";
            while ($fila = mysqli_fetch_assoc($resultado_pendientes)) {
                echo "<div class='contenido'><br>";
                echo "<a href='/Manga/Pendientes/?busqueda_pendientes_manga=".$fila['Nombre']."&buscar=&accion=Busqueda' target='_blanck'>";
                echo $fila['Nombre'] . "<br>";
                echo "</a>";
                echo "</div>";
                $resultados_encontrados_pendientes = true;
            }
            if (!$resultados_encontrados_pendientes) {
                echo "<div class='contenido'>";
                echo "No se encontraron resultados.<br>";
                echo "</div>";
            }
            echo "</div>";

            // Mostrar los resultados de op
            echo "<div class='persona-container'>";
            echo "<div class='nombre-persona'> Openings<br> </div>";
            while ($fila = mysqli_fetch_assoc($resultado_op)) {
                echo "<div class='contenido'><br>";
                echo "<a href='/Anime/OP/?busqueda_op=".$fila['Nombre']."&buscar=' target='_blanck'>";
                echo $fila['Nombre'] . "<br>";
                echo "</a>";
                echo "</div>";
                $resultados_encontrados_op = true;
            }
            if (!$resultados_encontrados_op) {
                echo "<div class='contenido'>";
                echo "No se encontraron resultados.<br>";
                echo "</div>";
            }
            echo "</div>";

            // Mostrar los resultados de ed
            echo "<div class='persona-container'>";
            echo "<div class='nombre-persona'> Endings<br> </div>";
            while ($fila = mysqli_fetch_assoc($resultado_ed)) {
                echo "<div class='contenido'><br>";
                echo "<a href='/Anime/ED/?busqueda_ed=".$fila['Nombre']."&buscar=' target='_blanck'>";
                echo $fila['Nombre'] . "<br>";
                echo "</a>";
                echo "</div>";
                $resultados_encontrados_ed = true;
            }
            if (!$resultados_encontrados_ed) {
                echo "<div class='contenido'>";
                echo "No se encontraron resultados.<br>";
                echo "</div>";
            }
            echo "</div>";

            // Mostrar los resultados de peliculas
            echo "<div class='persona-container'>";
            echo "<div class='nombre-persona'> Peliculas<br> </div>";
            while ($fila = mysqli_fetch_assoc($resultado_peliculas)) {
                echo "<div class='contenido'><br>";
                echo "<a href='/Anime/peliculas/' target='_blanck'>";
                echo $fila['Nombre'] . "<br>";
                echo "</a>";
                echo "</div>";
                $resultados_encontrados_peliculas = true;
            }
            if (!$resultados_encontrados_peliculas) {
                echo "<div class='contenido'>";
                echo "No se encontraron resultados.<br>";
                echo "</div>";
            }
            echo "</div>";
        }

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </div>
</body>

</html>