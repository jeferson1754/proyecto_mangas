<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Ejemplo de datalist con PHP y SQL</title>
</head>

<body>
    <form action="/" method="post">
        <label for="manga">Manga</label>
        <input type="text" id="manga" list="mangas">
        <datalist id="mangas">
            <?php

            // Conexión a la base de datos
            $db = new PDO("mysql:host=localhost;dbname=manga", "root", "");

            // Ejecución de la consulta SQL
            $mangas = $db->query("SELECT ID, Nombre FROM `manga` ORDER BY `manga`.`Nombre` ASC");

            // Recorrido del array de mangas
            foreach ($mangas as $manga) {
                // Creación de la opción
                echo "<option value='" . $manga['ID'] . "'>" . $manga['Nombre'] . "</option>";
            }

            ?>
        </datalist>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>