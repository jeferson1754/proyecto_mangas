<?php

require 'bd.php';
include 'upa.php';
$fecha_actual = date('Y-m-d');
$fecha_futura = date('Y-m-d', strtotime($fecha_actual . ' +1 day'));

$sizebtn = "sm";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mangas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="./css/style new.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="./css/checkbox.css">
</head>


<body>
    <?php include('menu.php'); ?>

    <div class="main-container">
        <!--- Formulario para registrar Cliente --->
        <div class="actions-panel button-group">
            <form action="" method="GET" class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-<?php echo $sizebtn ?> btn-custom btn-primary vista-celu" data-bs-toggle="modal" data-bs-target="#new">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo Manga
                </button>


                <button type="button" class="btn btn-<?php echo $sizebtn ?> btn-custom btn-outline-secondary" onclick="toggleFilters()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtros
                </button>


                <button type="submit" name="linkeado" class="btn btn-<?php echo $sizebtn ?> btn-warning btn-custom vista-celu" style="text-decoration: none;">
                    <i class="fas fa-unlink"></i> Sin Link
                </button>
                <button class="btn btn-custom btn-<?php echo $sizebtn ?> btn-warning vista-celu" type="submit" name="sin-fechas">
                    <i class="fas fa-times-circle"></i> Sin Revisión
                </button>
                <button class="btn btn-custom btn-<?php echo $sizebtn ?> btn-warning vista-celu" type="submit" name="sin-actividad">
                    <i class="fas fa-pause-circle"></i> Sin Actividad
                </button>
                <button class="btn btn-custom btn-<?php echo $sizebtn ?> btn-warning" type="submit" name="tachiyomi">
                    <i class="fas fa-ban"></i> No Tachiyomi
                </button>
                <button class="btn btn-custom btn-<?php echo $sizebtn ?> btn-warning" type="submit" name="tmo">
                    <i class="fa-solid fa-triangle-exclamation"></i> No TMO
                </button>
                <button class="btn btn-custom btn-<?php echo $sizebtn ?> btn-success" type="submit" name="mayor-actividad">
                    <i class="fas fa-play-circle"></i> Mayor Actividad
                </button>
                <button class="btn btn-custom btn-<?php echo $sizebtn ?> btn-info vista-celu" type="submit" name="anime">
                    <i class="fas fa-tv"></i> Tiene Anime
                </button>


                <button class="btn btn-custom btn-<?php echo $sizebtn ?> btn-secondary" type="submit" name="borrar">
                    <i class="fas fa-eraser"></i>
                    <span>Borrar Filtros</span>
                </button>
            </form>
        </div>
        <form method="GET">
            <div class="search-filters" id="filtersContainer" style="display: none;">

                <div class="flex-grow-1 position-relative">
                    <input
                        type="text"
                        class="form-control pe-5"
                        placeholder="Buscar manga..."
                        name="busqueda_manga"
                        id="busqueda_manga"
                        value="<?= htmlspecialchars($_GET['busqueda_manga'] ?? '', ENT_QUOTES) ?>">

                    <!-- Botón personalizado para limpiar -->
                    <button type="button" class="btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y"
                        onclick="document.getElementById('busqueda_manga').value = '';"
                        style="z-index: 5;">
                        ✕
                    </button>
                </div>


                <select class="form-select" style="max-width: 200px;" name="todos">
                    <option value="">Seleccione Todos:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT $fila1 FROM $tabla2 ORDER BY $fila1 ASC");
                    while ($valores = mysqli_fetch_array($query)) {
                        $valor = htmlspecialchars($valores[$fila1], ENT_QUOTES);
                        $selected = (isset($_GET['todos']) && $_GET['todos'] === $valor) ? 'selected' : '';
                        echo "<option value=\"$valor\" $selected>$valor</option>";
                    }
                    ?>
                </select>

                <select class="form-select" style="max-width: 200px;" name="capitulos">
                    <option value="">Seleccione Capitulo:</option>
                    <?php
                    // Consulta para obtener capítulos únicos mayores a 0
                    $query = $conexion->query("SELECT DISTINCT $fila5 FROM $tabla WHERE $fila5 > 0 ORDER BY $fila5 ASC LIMIT 5");

                    while ($valores = mysqli_fetch_array($query)) {
                        // 1. Convertimos a float para limpiar ceros (26.00 -> 26, 22.30 -> 22.3)
                        $valor_limpio = (float)$valores[$fila5];

                        // 2. Escapamos para seguridad en el atributo value
                        $valor_attr = htmlspecialchars($valor_limpio, ENT_QUOTES);

                        // 3. Comparamos de forma segura para marcar la opción seleccionada
                        $selected = (isset($_GET['capitulos']) && strval($_GET['capitulos']) === strval($valor_attr)) ? 'selected' : '';

                        // 4. Imprimimos la opción
                        echo "<option value=\"$valor_attr\" $selected>$valor_attr</option>";
                    }
                    ?>
                </select>

                <select class="form-select" style="max-width: 200px;" name="estado">
                    <option value="">Seleccione Estado:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT $fila8 FROM $tabla ORDER BY $fila8 ASC");
                    while ($valores = mysqli_fetch_array($query)) {
                        $valor = htmlspecialchars($valores[$fila8], ENT_QUOTES);
                        $selected = (isset($_GET['estado']) && $_GET['estado'] === $valor) ? 'selected' : '';
                        echo "<option value=\"$valor\" $selected>$valor</option>";
                    }
                    ?>
                </select>

                <button class="btn btn-custom btn-outline-secondary" type="submit" name="buscar">
                    <b>Buscar</b>
                </button>
            </div>
        </form>

        <?php

        $order = "ORDER BY `manga`.`Faltantes`ASC,`manga`.`Hora_Cambio` DESC";
        // Limpiar parámetros GET y prevenir inyección SQL
        $columnas = "*";

        $busqueda = isset($_GET['busqueda_manga']) ? mysqli_real_escape_string($conexion, $_GET['busqueda_manga']) : '';
        $listas = isset($_GET['todos']) ? mysqli_real_escape_string($conexion, $_GET['todos']) : '';
        $capitulos = isset($_GET['capitulos']) ? mysqli_real_escape_string($conexion, $_GET['capitulos']) : '';
        $estado = isset($_GET['estado']) ? mysqli_real_escape_string($conexion, $_GET['estado']) : '';

        if (isset($_GET['borrar'])) {
            $titulo = "Todos";
            $capi = "1";
            $where = "WHERE Faltantes>0 ORDER BY `manga`.`Hora_Cambio` DESC limit 10";
            $link = "";
        } else if (isset($_GET['linkeado'])) {
            $where = "where $fila2 ='' OR $fila13='Erroneo/Inexistente' OR $fila13='Faltante' $order limit 10";
            $capi = "1";
            $titulo = "Sin Link";
        } else if (isset($_GET['sin-fechas'])) {

            $where = "where $ver='NO' $order limit 10";
            $capi = "1";
            $titulo = "Sin Revision de Cantidad";
        } else if (isset($_GET['sin-actividad'])) {

            $where = " WHERE $fila10 < DATE_SUB(CURDATE(), INTERVAL 36 MONTH) AND $fila5=0 ORDER BY `manga`.`Faltantes`ASC, `manga`.`Fecha_Cambio1` ASC;";
            $capi = "1";
            $titulo = "Sin Actividad Reciente";
        } else if (isset($_GET['mayor-actividad'])) {
            $columnas = "manga.*";
            $where = "LEFT JOIN anime ON manga.ID_Anime = anime.id WHERE anime.id IS NULL OR anime.Estado != 'Emision' ORDER BY manga.Cantidad DESC, manga.Fecha_Cambio1 DESC, manga.Hora_Cambio DESC LIMIT 30";
            $capi = "1";
            $titulo = "Mayor Actividad Reciente";
        } else if (isset($_GET['anime'])) {
            $columnas = "manga.*";
            $where = "LEFT JOIN anime ON manga.ID_Anime = anime.id
                    WHERE manga.Anime = 'SI' AND manga.Faltantes > 0
                    ORDER BY 
                    CASE WHEN anime.id IS NULL THEN 1 ELSE 0 END,
                    FIELD(anime.Estado, 'Emision', 'Pausado', 'Pendiente', 'Finalizado'),
                    manga.Faltantes ASC
                    LIMIT 10";
            $capi = "1";
            $titulo = "Tienen Anime";
        } else if (isset($_GET['tmo'])) {
            $where = "WHERE Link NOT LIKE '%https://zonatmo.com/%' AND Link != '' AND Estado != 'Finalizado' ORDER BY manga.Fecha_Cambio1 DESC, manga.Hora_Cambio DESC limit 30";
            $capi = "1";
            $titulo = "Sin Link TMO";
        } else if (isset($_GET['tachiyomi'])) {
            $where = " LEFT JOIN `tachiyomi` ON manga.ID = tachiyomi.ID_Manga WHERE tachiyomi.ID_Manga IS NULL AND manga.Faltantes > 0 $order LIMIT 10;";
            $capi = "1";
            $titulo = "Mangas Fuera de Tachiyomi";

            $columnas = " manga.ID as ID, 
            manga.Nombre as Nombre,
            manga.Link as Link, 
            manga.`Capitulos Vistos` as `Capitulos Vistos`, 
            manga.`Capitulos Totales` as `Capitulos Totales`,
            manga.`Faltantes` as `Faltantes`,
            manga.`Estado` as `Estado`,
            manga.`Lista` as `Lista`,
            manga.`Estado_Link` as `Estado_Link`,
            manga.`Fecha_Cambio1` as `Fecha_Cambio1`,
            manga.`Fecha_Cambio2` as `Fecha_Cambio2`,
            manga.`Hora_Cambio` as `Hora_Cambio`,
            manga.`Cantidad` as `Cantidad`,
            manga.`verificado` as `verificado`,
            manga.`Anime` as `Anime`
            ";
        } else if (isset($_GET['buscar'])) {

            $conditions = [];

            if (!empty($busqueda)) {
                $conditions[] = "$fila1 COLLATE utf8mb4_general_ci LIKE '%$busqueda%'";
                $titulo = "Busqueda";
            } else {
                $titulo = "Todos";
            }

            if (!empty($listas)) {
                $conditions[] = " $fila6='$listas'";
                $titulo = $listas;
            }

            if (!empty($estado)) {
                $conditions[] = " $fila8='$estado'";
                $titulo = $estado;
            } else {
                $estado = "";
            }
            if (!empty($capitulos)) {
                $conditions[] = " $fila5 = '$capitulos'";
                $titulo = "Capitulos - " . $capitulos;

                if ((int)$capitulos > 3) {
                    $capi = "2";
                } else {
                    $capi = $capitulos;
                }
            } else {
                $capi = "1";
            }




            $where = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) . " $order limit 50" : "$order limit 50";
        } else {

            $titulo = "Todos";
            $capi = "1";
            $where = "WHERE Faltantes>0 $order limit 10";
            $link = "";
        }


        // Consulta SQL para contar registros
        $sql2 = "SELECT COUNT(*) AS total_registros FROM $tabla $where";
        $result2 = mysqli_query($conexion, $sql2);

        if ($result2->num_rows > 0) {
            $row = $result2->fetch_assoc();
            $totalRegistros = $row["total_registros"];
        } else {
            $totalRegistros = 0;
        }

        $conteo = " : " . $totalRegistros;

        include('ModalCrear.php');  ?>



        <h1 class="text-center text-primary fw-bold">
            <?php echo ucfirst($titulo) . "" . $valor ?><span class="text-secondary"><?php echo $conteo ?></span>
        </h1>

        <div class="content-card">
            <div class="table-container table-responsive">
                <table id="example" class="table custom-table">
                    <thead>
                        <tr>
                            <th><?php echo $fila1 ?></th>
                            <th><?php echo $fila3 ?></th>
                            <th><?php echo $fila4 ?></th>
                            <th><?php echo $fila5 ?></th>
                            <th><?php echo $fila8 ?></th>
                            <th><?php echo $fila6 ?></th>
                            <th><?php echo $titulo3 ?></th>
                            <th><?php echo $titulo4 ?></th>
                            <th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <style>

                    </style>
                    <tbody>
                        <?php
                        $sql1 = "SELECT $columnas FROM $tabla $where";

                        $result = mysqli_query($conexion, $sql1);

                        //echo $sql1;


                        while ($mostrar = mysqli_fetch_array($result)) {
                            // 1. LÓGICA DE TACHIYOMI (Existente)
                            $query_result = mysqli_query($conexion, "SELECT * FROM tachiyomi WHERE ID_Manga = " . $mostrar['ID']);
                            $is_successful = ($query_result !== false && mysqli_num_rows($query_result) > 0);
                            $colorClass = $is_successful ? 'blue' : 'white';
                            $tachiyomi = $is_successful ? 'Tachiyomi y ' : '';

                            // 2. LÓGICA DE CONTEO REAL DE CAPÍTULOS FALTANTES
                            // Contamos registros en la tabla diferencias que sean mayores al último capítulo visto
                            $cap_visto = $mostrar[$fila3]; // Asumiendo que $fila3 es 'Capitulos Vistos'
                            $id_manga = $mostrar['ID'];

                            $query_faltantes = mysqli_query($conexion, "SELECT COUNT(*) as total FROM diferencias WHERE ID_Manga = '$id_manga' AND Numero_Capitulo > '$cap_visto'");

                            $datos_faltantes = mysqli_fetch_assoc($query_faltantes);

                            // 1. Obtenemos el conteo de registros (filas en diferencias)
                            $conteo_registros = (float)$datos_faltantes['total'];

                            // 2. Obtenemos el cálculo matemático de la tabla manga
                            $resta_matematica = (float)$mostrar[$fila5];

                            // 3. LOGICA: Se elige el valor más alto. 
                            // Esto asegura que si falta el capítulo 191.5, el sistema cuente "1" registro o "0.5" según cuál sea mayor o más preciso.
                            $faltantes_reales = ($conteo_registros >= $resta_matematica) ? $conteo_registros : $resta_matematica;

                            // 3. FORMATEO DINÁMICO DE DECIMALES (Para que 26.00 sea 26 y 22.30 sea 22.30)
                            $vista_vistos = (float)$mostrar[$fila3];
                            $vista_totales = (float)$mostrar[$fila4];
                            $vista_faltantes = (float)$faltantes_reales;

                            // 4. OTROS ESTADOS (Existente)
                            $verificado = ($mostrar['verificado'] == 'SI') ? 'green' : 'red';
                            $anime = ($mostrar['Anime'] == 'SI') ? 'orange' : 'white';
                        ?>
                            <tr>
                                <td class="fw-500">
                                    <a href="<?php echo $mostrar[$fila2] ?>" title="<?php echo $mostrar[$fila13] ?>" target="_blanck" class="link" style="text-decoration: none;">
                                        <?php echo $mostrar[$fila1] ?>
                                    </a>
                                </td>

                                <td class="fw-500"><?php echo $vista_vistos ?></td>

                                <td class="fw-500"><?php echo $vista_totales ?></td>

                                <td class="text-center align-middle">
                                    <span class="fw-500"><?php echo (float)$faltantes_reales; ?></span>
                                    <?php if (floor($faltantes_reales) != $faltantes_reales): ?>
                                        <i class="fas fa-puzzle-piece text-info ms-1"
                                            style="font-size: 0.85rem;"
                                            data-bs-toggle="tooltip"
                                            title="Este manga tiene capítulos fraccionados"></i>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="status-badge 
            <?php
                            if ($mostrar[$fila8] == 'Emision' or $mostrar[$fila8] == 'Viendo') {
                                echo 'status-en-emision';
                            } elseif ($mostrar[$fila8] == 'Finalizado') {
                                echo 'status-finalizado';
                            } elseif ($mostrar[$fila8] == 'Pendiente') {
                                echo 'status-pendiente';
                            } elseif ($mostrar[$fila8] == 'Pausado') {
                                echo 'status-pausado';
                            }
            ?>">
                                        <?php echo $mostrar[$fila8] ?>
                                    </span>
                                </td>

                                <td><?php echo $mostrar[$fila6] ?></td>

                                <td style="text-align:center;">
                                    <?php echo $mostrar[$titulo3] ?>
                                    <span title="Verificado-<?php echo $mostrar[$ver] ?>" class="color-dot <?php echo $verificado ?>">&bull;</span>
                                    <span title="Anime-<?php echo $mostrar['Anime'] ?>" class="color-dot <?php echo $anime ?>">&bull;</span>
                                    <span title="Tachiyomi-SI" class="color-dot <?php echo $colorClass ?>">&bull;</span>
                                </td>

                                <td style="text-align:center;"><?php echo $mostrar[$fila10] ?></td>

                                <td data-label="Acciones">
                                    <div class="action-buttons">
                                        <button type="button" class="action-button bg-info" data-toggle="modal" data-target="#caps<?php echo $mostrar[$fila7]; ?>">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" class="action-button btn-success" data-toggle="modal" data-target="#aumentar<?php echo $mostrar[$fila7]; ?>">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button" class="action-button bg-primary" data-toggle="modal" data-target="#edit<?php echo $mostrar[$fila7]; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="action-button bg-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $mostrar[$fila7]; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button type="button" class="action-button btn-secondary">
                                            <a href="./ejemplo-barra.php?variable=<?php echo urlencode($mostrar[$fila7]); ?>" target="_blanck" style="color:white" class="chart">
                                                <i class="fas fa-chart-bar"></i>
                                            </a>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        <?php
                            include('Modal-Caps.php');
                            include('Modal-Aumentar.php');
                            include('ModalEditar.php');
                            include('ModalDelete.php');
                        } // Fin del while
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                order: [],
                responsive: true,
                pageLength: 10,
                dom: '<"top"f>rt<"bottom"lip><"clear">'
            });
        });

        function toggleFilters() {
            const filtersContainer = document.getElementById('filtersContainer');
            filtersContainer.style.display = filtersContainer.style.display === 'none' ? 'flex' : 'none';
        }


        function actualizarValorcapitulos() {
            let vistos = document.getElementById("vistos").value;
            //Se actualiza en municipio inm
            document.getElementById("total").value = vistos;
        }


        var botonActualizar = document.getElementById('cambiar-fecha');
        var fechaInput1 = document.getElementById('date1');
        var fechaInput2 = document.getElementById('date2');

        botonActualizar.addEventListener('click', function(event) {
            event.preventDefault();
            var fechaActual = new Date();
            var dia = ('0' + fechaActual.getDate()).slice(-2);
            var mes = ('0' + (fechaActual.getMonth() + 1)).slice(-2);
            var anio = fechaActual.getFullYear();
            fechaInput1.value = anio + '-' + mes + '-' + dia;
            fechaInput2.value = anio + '-' + mes + '-' + dia;
        });
    </script>
</body>

</html>