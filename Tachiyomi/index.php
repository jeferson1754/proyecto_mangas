<?php

require 'bd.php';
$fecha_actual = date('Y-m-d');
$fecha_futura = date('Y-m-d', strtotime($fecha_actual . ' +1 day'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tachiyomi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/style new.css?v=<?php echo time(); ?>">

</head>


<body>

    <?php include('../menu.php'); ?>

    <div class="main-container">
        <!--- Formulario para registrar Cliente --->
        <div class="actions-panel button-group">
            <!--- Formulario para registrar Cliente --->
            <form action="" method="GET" class="d-flex gap-2 flex-wrap">

                <button type="button" class="btn btn-primary btn-custom" onclick="window.location.href = './ModalCrear.php'">

                    <i class="fas fa-plus"></i> Nuevo Tachiyomi

                </button>


                <button type="button" class="btn btn-info btn-custom" onclick="toggleFilter('typeFilter')">
                    <i class="fas fa-filter"></i> Filtrar
                </button>

                <button type="button" class="btn btn-info btn-custom" onclick="toggleFilter('searchFilter')">
                    <i class="fas fa-search"></i> Buscar
                </button>

                <button class="btn btn-custom btn-warning" style="color:white" type="submit" name="sin-actividad">
                    <i class="fas fa-pause-circle"></i> Sin Actividad
                </button>

                <button class="btn btn-info btn-custom" type="button" onclick="vistos()" name="marcar-vistos">
                    <i class="far fa-check-square"></i>
                    Marcar Vistos
                </button>

                <button class="btn btn-custom btn-secondary" type="submit" name="borrar">
                    <i class="fas fa-eraser"></i>
                    <span>Borrar Filtros</span>
                </button>

            </form>
        </div>
        <div class="filter-section" id="typeFilter" style="display:none;">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-4">
                    <select name="listas" class="form-select" style="max-width: 100% !important;">
                        <option value="">Seleccione Todos:</option>
                        <?php
                        $query = $conexion->query("SELECT DISTINCT t.Lista FROM tachiyomi t INNER JOIN lista o ON t.Lista = o.Nombre ORDER BY o.ID ASC;");
                        while ($valores = mysqli_fetch_array($query)) {
                            echo '<option value="' . $valores[$fila6] . '">' . $valores[$fila6] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" type="submit" name="filtrar">
                        <i class="fas fa-check"></i> Aplicar Filtro
                    </button>
                    <button class="btn btn-secondary" type="submit" name="borrar">
                        <i class="fas fa-times"></i> Borrar
                    </button>
                </div>
                <input type="hidden" name="accion" value="Filtro">
            </form>
        </div>
        <div class="filter-section" id="searchFilter" style="display:none;">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="busqueda_tachi" placeholder="Nombre del Manga...">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" type="submit" name="buscar">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <button class="btn btn-secondary" type="submit" name="borrar">
                        <i class="fas fa-times"></i> Limpiar
                    </button>
                </div>
            </form>
        </div>
        <?php

        $order = "ORDER BY `$tabla`.`Faltantes`,`$tabla`.`Fecha_Cambio1` ASC limit 100";

        $busqueda = isset($_GET['busqueda_tachi']) ? mysqli_real_escape_string($conexion, $_GET['busqueda_tachi']) : '';
        $listas = isset($_GET['listas']) ? mysqli_real_escape_string($conexion, $_GET['listas']) : '';

        if (isset($_GET['borrar'])) {
            $where = "WHERE $fila5 > 0 $order";
            $estado = "Tachiyomi";
        } else if (isset($_GET['busqueda_tachi'])) {

            $where = "WHERE $fila1 LIKE '%$busqueda%' $order";
            $estado = "Busqueda";
        } else if (isset($_GET['filtrar'])) {

            $where = "WHERE $fila6='$listas' $order";
            $estado = "Filtro";
        } else if (isset($_GET['sin-actividad'])) {

            $where = " WHERE $fila11 < DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND $fila5=0 $order";
            $estado = "Sin Actividad Reciente";
        } else {
            $where = "WHERE $fila5 > 0 $order";
            $estado = "Tachiyomi";
        }

        ?>

        <h1 class="text-center text-primary fw-bold">
            <?php echo ucfirst($estado) ?>
        </h1>
        <div class="content-card">
            <div class="table-container table-responsive">
                <table id="example" class="table custom-table">
                    <thead>
                        <tr>
                            <th><?php echo $fila7 ?></th>
                            <th><?php echo $fila1 ?></th>
                            <th><?php echo $fila3 ?></th>
                            <th><?php echo $fila4 ?></th>
                            <th><?php echo $fila5 ?></th>
                            <th><?php echo $fila6 ?></th>
                            <th><?php echo $titulo4 ?></th>

                            <th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql1 = "SELECT * FROM $tabla $where";

                        $result = mysqli_query($conexion, $sql1);
                        //echo $sql1;
                        while ($mostrar = mysqli_fetch_array($result)) {
                            $name2 = $mostrar[$fila1];
                        ?>
                            <tr>
                                <td class="fw-500"><?php echo $mostrar[$fila7] ?></td>
                                <td><a href="<?php echo $mostrar[$fila2] ?>" title="<?php echo $mostrar[$fila10] ?>" target="_blanck" style="text-decoration: none;"><?php echo $mostrar[$fila1] ?></a></td>
                                <td class="fw-500"><?php echo $mostrar[$fila3] ?></td>
                                <td class="fw-500"><?php echo $mostrar[$fila4] ?></td>
                                <td class="fw-500"><?php echo $mostrar[$fila5] ?></td>
                                <td><?php echo $mostrar[$fila6] ?></td>
                                <td><?php echo $mostrar[$fila11] ?></td>
                                <td data-label="Acciones">
                                    <div class="action-buttons">
                                        <button type="button"
                                            class="action-button bg-info"
                                            data-toggle="modal"
                                            data-target="#caps<?php echo $mostrar[$fila7]; ?>"
                                            aria-label="Aprobar">
                                            <i class="fa fa-eye"></i>
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
                                    </div>
                                </td>
                            </tr>
                            <?php include('ModalEditar.php'); ?>
                            <?php include('Modal-Aumentar.php'); ?>
                            <?php include('Modal-Caps.php'); ?>
                            <?php include('ModalDelete.php'); ?>
                        <?php
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

        function toggleFilter(filterId) {
            const filter = document.getElementById(filterId);
            filter.style.display = filter.style.display === 'none' ? 'block' : 'none';
        }


        function vistos() {
            Swal.fire({
                icon: 'info',
                title: 'Consulta!',
                text: '¿Desea marcar como vistos todos los mangas que tengan 3 capitulos o menos?',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: "SI",
                cancelButtonText: "NO"

            }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire({
                        title: 'Mensaje importante',
                        text: 'Serás redirigido en 3 segundos...',
                        icon: 'warning',
                        showConfirmButton: false, // Oculta los botones
                        timer: 3000, // Tiempo en milisegundos (5 segundos en este caso)
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        },
                        onClose: () => {
                            // Redirige a otra página después de que termine el temporizador
                            window.location.href = 'marcar.php';
                        }
                    });

                    // Redirige a otra página después de 5 segundos incluso si el usuario no cierra la alerta
                    setTimeout(() => {
                        window.location.href = 'marcar.php';
                    }, 5000);
                    //window.location = "vistos.php";
                }
            })


        }
    </script>
</body>

</html>