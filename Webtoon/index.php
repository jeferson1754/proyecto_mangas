<?php

require 'bd.php';
require '../upa copy.php';

$sizebtn = "m";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webtoon</title>
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

        <form action="" method="GET" class="d-flex gap-2 flex-wrap">

            <button type="button" class="btn btn-<?php echo $sizebtn ?> btn-custom btn-primary vista-celu" data-bs-toggle="modal" data-bs-target="#new">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo <?php echo ucfirst($tabla); ?>
            </button>

            <button class="btn btn-custom btn-success btn-<?php echo $sizebtn ?> " type="submit" name="enviar">
                <i class="fas fa-calendar"></i>
                <span>Hoy</span>
            </button>

            <button type="button" class="btn btn-custom btn-info btn-<?php echo $sizebtn ?>" onclick="toggleFilter('myDIV')">
                <i class="fas fa-filter"></i>
                <span>Filtrar</span>
            </button>

            <button type="button" class="btn btn-info btn-custom btn-<?php echo $sizebtn ?>" onclick="toggleFilter('myDIV2')">
                <i class="fas fa-search"></i> Buscar
            </button>
            <button type="submit" name="link" class="btn btn-warning btn-custom btn-<?php echo $sizebtn ?>" style="text-decoration: none;">
                <i class="fas fa-unlink"></i> Sin Link
            </button>

            <button class="btn btn-custom btn-warning btn-<?php echo $sizebtn ?> " type="submit" name="faltantes">
                <i class="fas fa-clock"></i>
                <span>Pendientes</span>
            </button>
            <button class="btn btn-info btn-custom btn-<?php echo $sizebtn ?>" type="button" onclick="vistos()" name="marcar-vistos">
                <i class="far fa-check-square"></i>
                Marcar Vistos
            </button>

            <button type="button" class="btn btn-info mostrar btn-<?php echo $sizebtn; ?>" onclick="window.location.href = './horario.php'">
                <i class="fas fa-clock"></i> Horario
            </button>


            <button class="btn btn-custom btn-secondary btn-<?php echo $sizebtn ?> " type="submit" name="borrar">
                <i class="fas fa-eraser"></i>
                <span>Borrar Filtros</span>
            </button>
        </form>
        <div class="filter-section" id="myDIV" style="display:none;">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-4">
                    <select name="estado" class="form-control" style="max-width: 100% !important;">
                        <option value="">Seleccione:</option>
                        <?php
                        $query = $conexion->query("SELECT * FROM $tabla4;");
                        while ($valores = mysqli_fetch_array($query)) {
                            echo '<option value="' . $valores['Estado'] . '">' . $valores['Estado'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="accion" value="Filtro">
                <br>

                <div class="col-md-4">
                    <button class="btn btn-primary" type="submit" name="filtrar">
                        <i class="fas fa-check"></i> Aplicar Filtro
                    </button>
                    <button class="btn btn-secondary" type="submit" name="borrar">
                        <i class="fas fa-times"></i> Borrar
                    </button>
                </div>
            </form>
        </div>
        <div class="filter-section" id="myDIV2" style="display:none;">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="busqueda_webtoon" placeholder="Nombre del Webtoon...">
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

        include('./ModalCrear.php');

        $busqueda = "";



        if (isset($_GET['enviar'])) {

            $where = "WHERE `$tabla`.`$fila6` LIKE '%" . $day . "%'";
        } else if (isset($_GET['borrar'])) {
            $busqueda = "";
            $where = "WHERE `$tabla`.`$fila6` LIKE'%" . $day . "%'AND $fila8 ='Emision' ORDER BY `$tabla`.`$fila7` DESC limit 100;";
        } else if (isset($_GET['filtrar'])) {
            if (isset($_GET['estado'])) {
                $estado   = $_REQUEST['estado'];

                $where = "WHERE $fila8='$estado' ORDER BY `$tabla`.`$fila7` DESC  limit 100";
            }
        } else if (isset($_GET['buscar'])) {
            if (isset($_GET['busqueda_webtoon'])) {
                $busqueda   = $_REQUEST['busqueda_webtoon'];

                $where = "WHERE $fila1 LIKE '%$busqueda%' ORDER BY `$tabla`.`$fila7` DESC  limit 100";
            }
        } else if (isset($_GET['link'])) {

            $where = "WHERE $fila2='' OR $fila13='Faltante' ORDER BY `$tabla`.`$fila7` DESC  limit 100";
        } else if (isset($_GET['faltantes'])) {
            $where = "WHERE `$tabla`.`$fila5`>0 ORDER BY `$tabla`.`$fila5` ASC  limit 100";
        } else {
            $where = "WHERE `$tabla`.`$fila6` LIKE'%" . $day . "%'AND $fila8 ='Emision' ORDER BY `$tabla`.`$fila7` DESC limit 100;";
        }

        ?>


        <h1 class="text-center text-primary fw-bold">
            <?php echo ucfirst($tabla) ?>s
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


                            <th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql1 = "SELECT * FROM $tabla $where";

                        $result = mysqli_query($conexion, $sql1);
                        //echo $sql1;

                        while ($mostrar = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td class="fw-500"><a href="<?php echo $mostrar[$fila2] ?>" title="<?php echo $mostrar[$fila13] ?>" target="_blanck" style="text-decoration: none;"><?php echo $mostrar[$fila1] ?></a></td>
                                <td class="fw-500"><?php echo $mostrar[$fila3] ?></td>
                                <td class="fw-500"><?php echo $mostrar[$fila4] ?></td>
                                <td class="fw-500"><?php echo $mostrar[$fila5] ?></td>
                                <td><?php echo $mostrar[$fila8] ?></td>
                                <td><?php echo $mostrar[$fila6] ?></td>


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
            });
        });

        function vistos() {
            Swal.fire({
                icon: 'info',
                title: 'Consulta!',
                text: '¿Desea marcar como vistos todos los webtoon del Dia <?php echo $day; ?>?',
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
                            window.location.href = 'marcar_webtoon.php';
                        }
                    });

                    // Redirige a otra página después de 5 segundos incluso si el usuario no cierra la alerta
                    setTimeout(() => {
                        window.location.href = 'marcar_webtoon.php';
                    }, 5000);
                    //window.location = "vistos.php";
                }
            })


        }

        function toggleFilter(filterId) {
            const filter = document.getElementById(filterId);
            filter.style.display = filter.style.display === 'none' ? 'block' : 'none';
        }

        function actualizarValorMunicipioInm() {
            let municipio = document.getElementById("municipio").value;
            //Se actualiza en municipio inm
            document.getElementById("municipio_inm").value = municipio;
        }
    </script>
</body>

</html>