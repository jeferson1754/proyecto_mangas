<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calificaciones de Animes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

</head>
<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #34495e;
        --accent-color: #16a34a;
        --text-color: #2c3e50;
        --background-color: #ecf0f1;
    }

    body {
        background-color: var(--background-color);
        color: var(--text-color);
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        padding-bottom: 2rem;
    }

    .page-header {
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 1.5rem 0;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .page-header h1 {
        font-size: 1.75rem;
    }

    .page-header .lead {
        font-size: 1rem;
        padding: 0 1rem;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.5rem;
        }

        .page-header .lead {
            font-size: 0.9rem;
        }
    }

    .controls-section,
    .rating-box {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .rating-box {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .rating-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .anime-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        padding: 0.5rem;
    }

    @media (min-width: 576px) {
        .anime-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }
    }

    .rating-box .imagen,
    .no-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .imagen {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .no-image {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f3f3f3;
        padding: 20px;
        border-radius: 8px;
    }

    @media (min-width: 576px) {

        .rating-box .imagen,
        .no-image {
            height: 300px;
        }
    }

    .rating-box header {
        padding: 0.75rem;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-color);
        min-height: 3rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (min-width: 576px) {
        .rating-box header {
            padding: 1rem;
            font-size: 1.1rem;
            min-height: 3.6rem;
        }
    }

    .stars {
        padding: 0.5rem;
        display: flex;
        gap: 0.2rem;
        justify-content: center;
    }

    .fa-star {
        color: #ddd;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .fa-star.active {
        color: #ffd700;
    }

    @media (min-width: 576px) {
        .stars {
            gap: 0.3rem;
        }

        .fa-star {
            font-size: 1.2rem;
        }
    }

    .rating-text {
        padding: 0.5rem;
        text-align: center;
        font-weight: 500;
        color: var(--primary-color);
        border-top: 1px solid #eee;
        margin-top: auto;
        font-size: 0.9rem;
    }

    @media (min-width: 576px) {
        .rating-text {
            padding: 0.5rem 1rem 1rem;
            font-size: 1rem;
        }
    }

    .product-rating-value {
        color: var(--accent-color);
        font-weight: 600;
    }

    .search-box {
        max-width: 100%;
        margin: 0 auto 1rem;
        padding: 0 1rem;
    }

    .search-box input {
        border: 2px solid var(--primary-color);
        border-radius: 25px;
        padding: 0.6rem 1rem;
        font-size: 1rem;
        width: 100%;
        transition: box-shadow 0.3s ease;
    }

    .search-box input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.2);
    }

    @media (min-width: 576px) {
        .search-box {
            max-width: 500px;
        }

        .search-box input {
            padding: 0.8rem 1.5rem;
            font-size: 1.1rem;
        }
    }

    .filters {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
        padding: 0 1rem;
    }

    .filter-select {
        padding: 0.5rem;
        border: 2px solid var(--primary-color);
        border-radius: 5px;
        background: white;
        color: var(--primary-color);
        font-weight: 500;
        cursor: pointer;
        font-size: 0.9rem;
    }

    @media (min-width: 576px) {
        .filter-select {
            padding: 0.5rem 1rem;
            font-size: 1rem;
        }
    }

    .container {
        padding: 0.5rem;
    }

    @media (min-width: 576px) {
        .container {
            padding: 1rem;
        }
    }

    .no-image {
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 2rem;
    }

    @media (min-width: 576px) {
        .no-image {
            font-size: 3rem;
        }
    }

    .seasons-container {
        padding: 10px;
        background-color: #f1f1f1;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .season-item {
        padding: 5px 0;
        font-size: 0.9rem;
        color: #333;
    }

    .season-item:not(:last-child) {
        border-bottom: 1px solid #ddd;
    }

    .episode-count {
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }
</style>

<body>
    <!-- El resto del HTML permanece igual -->
    <!-- Header -->
    <header class="page-header">
        <div class="container">
            <h1 class="text-center mb-3">Calificaciones de Mangas</h1>
            <p class="text-center mb-0 lead">Sumérgete en el mundo de los mangas y descubre cuáles son los mejores calificados.</p>
        </div>
    </header>

    <!-- Controls Section -->
    <div class="container">
        <!-- Anime Grid -->
        <div class="anime-grid">
            <?php
            require '../bd.php';

            $sql = "SELECT Nombre as Anime, calificaciones_mangas.* FROM calificaciones_mangas WHERE Promedio > 0 ORDER BY Promedio DESC;";

            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
            ?>
                    <div class="rating-box">
                        <?php
                        $id_anime = $fila['ID'];
                        $images = $fila['Link_Imagen'];
                        $total_capitulos = $fila['Capitulos_Totales']; // Suponiendo que este campo existe en la base de datos

                        // Verificar si la URL de la imagen es válida y no está vacía
                        if (!empty($images) && filter_var($images, FILTER_VALIDATE_URL)) {
                            echo "<img class='imagen' src='{$images}' alt='Imagen de {$id_anime}'>";
                        } else {
                            // Si no hay imagen, mostrar una imagen por defecto
                            echo "     
                            <div class='no-image'>
                                <i class='fa-solid fa-bookmark'></i>
                                ID: {$fila['ID']}
                            </div>";
                        }
                        ?>
                        <header class="text-center">
                            <?php
                            echo mb_strimwidth($fila["Nombre"], 0, 40, "...");
                            ?>
                        </header>

                        <div class="stars product-stars">
                            <?php
                            $calificacion = $fila["Promedio"];
                            foreach (range(1, 5) as $i) {
                                echo $i <= $calificacion ? '<i class="fa-solid fa-star active"></i>' : '<i class="fa-solid fa-star"></i>';
                            }
                            ?>
                        </div>

                        <div class="rating-text product-rating">
                            Promedio: <span class="product-rating-value"><?php echo number_format($calificacion, 2); ?></span>
                        </div>

                        <div class="episode-count">
                            Total de capítulos: <strong><?php echo $total_capitulos ?: "Desconocido"; ?></strong>
                        </div>
                    </div>




            <?php
                }
            } else {
                echo '<div class="col-12 text-center">No se encontraron resultados.</div>';
            }
            ?>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Scripts permanecen igual
        document.getElementById('searchAnime').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const animeCards = document.querySelectorAll('.rating-box');

            animeCards.forEach(card => {
                const title = card.querySelector('header').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        document.querySelector('.filter-select').addEventListener('change', function(e) {
            const grid = document.querySelector('.anime-grid');
            const cards = Array.from(grid.getElementsByClassName('rating-box'));

            cards.sort((a, b) => {
                if (e.target.value === 'rating') {
                    const ratingA = parseFloat(a.querySelector('.product-rating-value').textContent);
                    const ratingB = parseFloat(b.querySelector('.product-rating-value').textContent);
                    return ratingB - ratingA;
                } else {
                    const titleA = a.querySelector('header').textContent;
                    const titleB = b.querySelector('header').textContent;
                    return titleA.localeCompare(titleB);
                }
            });

            cards.forEach(card => grid.appendChild(card));
        });

        function toggleSeasons(animeId) {
            var seasonContent = document.getElementById('seasons-' + animeId);
            var arrow = document.getElementById('arrow-' + animeId);

            // Si las temporadas están visibles, las ocultamos
            if (seasonContent.style.display === "block") {
                seasonContent.style.display = "none";
                arrow.classList.remove('fa-chevron-up'); // Quitar la flecha hacia arriba
                arrow.classList.add('fa-chevron-down'); // Mostrar flecha hacia abajo
            } else {
                seasonContent.style.display = "block";
                arrow.classList.remove('fa-chevron-down'); // Quitar la flecha hacia abajo
                arrow.classList.add('fa-chevron-up'); // Mostrar flecha hacia arriba
            }
        }
    </script>
</body>

</html>