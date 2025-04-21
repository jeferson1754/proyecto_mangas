<?php

require 'bd.php';
include '../upa.php';
$fecha_actual = date('Y-m-d');
$fecha_futura = date('Y-m-d', strtotime($fecha_actual . ' +1 day'));

$sizebtn = "sm";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/style new.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="../css/checkbox.css">
</head>


<body>
    <?php include('../menu.php');  ?>

    <div class="main-container">
        <!--- Formulario para registrar Cliente --->
        <div class="actions-panel button-group">
            <form action="" method="GET" class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-<?php echo $sizebtn ?> btn-custom btn-primary vista-celu" data-bs-toggle="modal" data-bs-target="#new">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo <?php echo ucfirst($titulo7); ?>
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
                    $query = $conexion->query("SELECT DISTINCT $fila5 FROM $tabla WHERE $fila5 > 0 ORDER BY $fila5 ASC LIMIT 5");
                    while ($valores = mysqli_fetch_array($query)) {
                        $valor = htmlspecialchars($valores[$fila5], ENT_QUOTES);
                        $selected = (isset($_GET['capitulos']) && strval($_GET['capitulos']) === strval($valor)) ? 'selected' : '';
                        echo "<option value=\"$valor\" $selected>$valor</option>";
                    }
                    ?>
                </select>

                <select class="form-select" style="max-width: 200px;" name="estado">
                    <option value="">Seleccione Estado:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT $fila8 FROM $tabla WHERE $fila5 > 0 ORDER BY $fila8 ASC");
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


        $order = "ORDER BY `$tabla`.`Hora_Cambio` DESC";
        $columnas = "*";


        $busqueda = isset($_GET['busqueda_manga']) ? mysqli_real_escape_string($conexion, $_GET['busqueda_manga']) : '';
        $listas = isset($_GET['todos']) ? mysqli_real_escape_string($conexion, $_GET['todos']) : '';
        $capitulos = isset($_GET['capitulos']) ? mysqli_real_escape_string($conexion, $_GET['capitulos']) : '';
        $estado = isset($_GET['estado']) ? mysqli_real_escape_string($conexion, $_GET['estado']) : '';


        if (isset($_GET['borrar'])) {
            $titulo = "Todos";
            $capi = "1";
            $where = "WHERE Faltantes>0 $order limit 10";
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

            $where = " WHERE $fila10 < DATE_SUB(CURDATE(), INTERVAL 36 MONTH) AND $fila5=0 ORDER BY `$tabla`.`Faltantes`ASC, `$tabla`.`Fecha_Cambio1` ASC limit 10;";
            $capi = "1";
            $titulo = "Sin Actividad Reciente";
        } else if (isset($_GET['mayor-actividad'])) {

            $where = "ORDER BY `$tabla`.Cantidad DESC, `$tabla`.`Fecha_Cambio1` DESC, `$tabla`.`Hora_Cambio` DESC limit 30";
            $capi = "1";
            $titulo = "Mayor Actividad Reciente";
        } else if (isset($_GET['tmo'])) {
            $where = "WHERE Link NOT LIKE '%https://zonatmo.com/%' AND Link != '' AND Estado != 'Finalizado' ORDER BY `$tabla`.`Faltantes` ASC limit 30";
            $capi = "1";
            $titulo = "Sin Link TMO";
        } else if (isset($_GET['anime'])) {
            $columnas = "pendientes_manga.*";
            $where = "LEFT JOIN anime ON pendientes_manga.ID_Anime = anime.id
                    WHERE pendientes_manga.Anime = 'SI' AND pendientes_manga.Faltantes > 0
                    ORDER BY 
                    CASE WHEN anime.id IS NULL THEN 1 ELSE 0 END,
                    FIELD(anime.Estado, 'Emision', 'Pausado', 'Pendiente', 'Finalizado'),
                    pendientes_manga.Faltantes ASC
                    LIMIT 10";
            $capi = "1";
            $titulo = "Tienen Anime";
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
            }

            if (!empty($capitulos)) {
                $conditions[] = " $fila5='$capitulos'";
                $titulo = "Capitulos - " . $capitulos;
            }

            $capi = "1";

            $where = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) . " $order limit 50" : "$order limit 50";
        } else {

            $titulo = "Todos";
            $capi = "1";
            $where = "ORDER BY `$tabla`.`ID` DESC limit 10";
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
            <?php echo ucfirst($titulo) ?><span class="text-secondary"><?php echo $conteo ?></span>
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
                    <tbody>
                        <?php
                        $sql1 = "SELECT $columnas FROM $tabla $where";

                        $result = mysqli_query($conexion, $sql1);
                        //echo $sql1;

                        while ($mostrar = mysqli_fetch_array($result)) {

                            $verificado = ($mostrar['verificado'] == 'SI') ? 'green' : 'red';
                            $anime = ($mostrar['Anime'] == 'SI') ? 'orange' : 'white';
                        ?>
                            <tr>
                                <td class="fw-500"><a href="<?php echo $mostrar[$fila2] ?>" title="<?php echo $mostrar[$fila13] ?>" target="_blanck" class="link" style="text-decoration: none;"><?php echo $mostrar[$fila1] ?></a></td>
                                <td class="fw-500"><?php echo $mostrar[$fila3] ?></td>
                                <td class="fw-500"><?php echo $mostrar[$fila4] ?></td>
                                <td class="fw-500"><?php echo $mostrar[$fila5] ?></td>
                                <td>
                                    <span class="status-badge 
                                    <?php
                                    if ($mostrar[$fila8] == 'Emision') {
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
                                <?php
                                echo '<td style="text-align:center;">' . $mostrar[$titulo3] . '
                                    <span title="Verificado-' . $mostrar[$ver] . '" class="color-dot ' . $verificado . '">&bull;</span>
                                    <span title="Anime-' . $mostrar['Anime'] . '" class="color-dot ' . $anime . '">&bull;</span>
                                    </td>';
                                ?>

                                <td style="text-align:center;"><?php echo $mostrar[$fila10] ?></td>


                                <td data-label="Acciones">
                                    <div class="action-buttons">
                                        <?php
                                        $variable = $mostrar[$fila7];
                                        ?>

                                        <button type="button" class="action-button btn-info">
                                            <a href="./?busqueda_manga=<?php echo urlencode($mostrar[$fila1]); ?>&todos=&capitulos=&estado=&buscar="
                                                style="color:white" target="_blanck">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </a>
                                        </button>
                                        <button type="button"
                                            class="action-button btn-success"
                                            data-toggle="modal"
                                            data-target="#aumentar<?php echo $mostrar[$fila7]; ?>"
                                            aria-label="Editar">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button"
                                            class="action-button bg-primary"
                                            data-tooltip="Editar"
                                            data-toggle="modal"
                                            data-target="#edit<?php echo $mostrar[$fila7]; ?>"
                                            aria-label="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button"
                                            class="action-button bg-danger"
                                            data-tooltip="Eliminar"
                                            data-toggle="modal"
                                            data-target="#delete<?php echo $mostrar[$fila7]; ?>"
                                            aria-label="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <button type="button" class="action-button btn-secondary">
                                            <a href="./ejemplo-barra.php?variable=<?php echo urlencode($variable); ?>" target="_blanck" style="color:white" class="chart">
                                                <i class="fas fa-chart-bar"></i>
                                            </a>
                                        </button>
                                    </div>
                                </td>


                            <?php
                            include('Modal-Aumentar.php');
                            include('ModalEditar.php');
                            include('ModalDelete.php');
                        }
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