<?php

require 'bd.php';
$fecha_actual = date('Y-m-d');
$fecha_futura = date('Y-m-d', strtotime($fecha_actual . ' +1 day'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css?<?php echo time(); ?>">
    <title><?php echo ucfirst($tabla) ?>
    </title>
</head>
<script>
    function filtrarTabla4() {
        document.getElementById("estado").submit();
    }
</script>

<body>

    <?php include('../menu.php'); ?>
    <div class="col-sm">
        <!--- Formulario para registrar Cliente --->
        <form action="" method="GET">
            <button type="button" class="btn btn-info mostrar" data-toggle="modal" data-target="#new">
                Nuevo <?php echo ucfirst($tabla); ?>
            </button>
            <button type="button" class="btn btn-info mostrar" onclick="myFunction2()">
                Busqueda
            </button>
            <button type="button" class="btn btn-info ocultar" onclick="myFunction()">
                Filtrar por Lista
            </button>

            <button class="btn btn-outline-info ocultar" type="submit" name="sin-actividad"> Sin Actividad </button>
            <button class="btn btn-outline-info mostrar" type="button" onclick="vistos()" name="marcar-vistos"> Marcar Vistos </button>
        </form>
        <div class="class-control" id="myDIV" style="display:none;">
            <form id="estado" action="" method="GET">
                <select name="estado" class="form-control" style="width:auto;" onchange="filtrarTabla4()">
                    <option value="">Seleccione Todos:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT t.Lista FROM tachiyomi t INNER JOIN lista o ON t.Lista = o.Nombre ORDER BY o.ID ASC;");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores[$fila6] . '">' . $valores[$fila6] . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="accion" value="Filtro1">
                <br>
            </form>
        </div>
        <div class="class-control" id="myDIV2" style="display:none;">
            <form action="" method="GET">
                <input class="form-control" type="text" name="busqueda_tachi" style="width:auto;">

                <button class="btn btn-outline-info" type="submit" name="buscar"> <b>Buscar </b> </button>
                <button class="btn btn-outline-info" type="submit" name="borrar"> <b>Borrar </b> </button>
            </form>
        </div>
        <?php

        $where = "WHERE $fila5 > 0 ORDER BY `tachiyomi`.`Faltantes` ASC limit 100";

        if (isset($_GET['borrar'])) {
            $busqueda = "";
            $where = "WHERE $fila5 > 0 ORDER BY `tachiyomi`.`Faltantes` ASC limit 100";
            $estado = "Tachiyomi";
        } else if (isset($_GET['buscar'])) {
            if (isset($_GET['busqueda_tachi'])) {
                $busqueda   = $_REQUEST['busqueda_tachi'];
                $where = "WHERE $fila1 LIKE '%$busqueda%' ORDER BY `tachiyomi`.`Faltantes` ASC limit 100";
            }
            $estado = "Busqueda";
        } else if (isset($_GET['estado'])) {

            $estado   = $_REQUEST['estado'];
            if (!empty($estado)) {

                $where = "WHERE $fila5 > 0 ORDER BY `tachiyomi`.`Faltantes` ASC limit 100";
            }

            $where = "WHERE $fila6='$estado' ORDER BY `tachiyomi`.`Faltantes` ASC limit 100";
            $accion1 = $_REQUEST['accion'];
        } else if (isset($_GET['sin-actividad'])) {
            $estado = "Sin Actividad Reciente";
            $where = " WHERE $fila11 < DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND $fila5=0 ORDER BY `$tabla`.`Faltantes`,`$tabla`.`Fecha_Cambio1` ASC limit 100";
        } else {
            $estado = "Tachiyomi";
        }

        ?>

        <?php include('ModalCrear.php');  ?>

    </div>
    <h1><?php echo $estado ?></h1>

    <div class="main-container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th class="normal"><?php echo $fila7 ?></th>
                    <th style="max-width:310px;"><?php echo $fila1 ?></th>
                    <th class="normal"><?php echo $fila3 ?></th>
                    <th class="normal"><?php echo $fila4 ?></th>
                    <th class="normal"><?php echo $fila5 ?></th>
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
                        <td class="normal"><?php echo $mostrar[$fila7] ?></td>
                        <td><a href="<?php echo $mostrar[$fila2] ?>" title="<?php echo $mostrar[$fila10] ?>" target="_blanck"><?php echo $mostrar[$fila1] ?></a></td>
                        <td class="normal"><?php echo $mostrar[$fila3] ?></td>
                        <td class="normal"><?php echo $mostrar[$fila4] ?></td>
                        <td class="normal"><?php echo $mostrar[$fila5] ?></td>
                        <td><?php echo $mostrar[$fila6] ?></td>
                        <td><?php echo $mostrar[$fila11] ?></td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#caps<?php echo $mostrar[$fila7]; ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#aumentar<?php echo $mostrar[$fila7]; ?>">
                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit<?php echo $mostrar[$fila7]; ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $mostrar[$fila7]; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
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
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                        order: [],
                        language: {
                            processing: "Tratamiento en curso...",
                            search: "Buscar:",
                            lengthMenu: "Filtro de _MENU_ <?php echo ucfirst($tabla) ?>",
                            info: "Mostrando <?php echo $tabla ?> del _START_ al _END_ de un total de _TOTAL_ <?php echo $tabla ?>",
                            infoEmpty: "No existen registros",
                            infoFiltered: "(filtrado de _MAX_ <?php echo $tabla ?> en total)",
                            infoPostFix: "",
                            loadingRecords: "Cargando elementos...",
                            zeroRecords: "No se encontraron los datos de tu busqueda..",
                            emptyTable: "No hay ningun registro en la tabla",
                            paginate: {
                                first: "Primero",
                                previous: "Anterior",
                                next: "Siguiente",
                                last: "Ultimo"
                            },
                            aria: {
                                sortAscending: ": Active para odernar en modo ascendente",
                                sortDescending: ": Active para ordenar en modo descendente  ",
                            }
                        }


                    }


                );

            });

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

            /*
            Swal.fire({
                title: 'Mensaje importante',
                text: 'Serás redirigido en 5 segundos...',
                icon: 'warning',
                showConfirmButton: false, // Oculta los botones
                timer: 5000, // Tiempo en milisegundos (5 segundos en este caso)
                timerProgressBar: true,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
                onClose: () => {
                    // Redirige a otra página después de que termine el temporizador
                    window.location.href = 'otra_pagina.html';
                }
            });

            // Redirige a otra página después de 5 segundos incluso si el usuario no cierra la alerta
            setTimeout(() => {
                window.location.href = 'otra_pagina.html';
            }, 5000);
            */

            function myFunction2() {
                var x = document.getElementById("myDIV2");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }

            function myFunction() {
                var x = document.getElementById("myDIV");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }

            function actualizarValorMunicipioInm() {
                let municipio = document.getElementById("municipio").value;
                //Se actualiza en municipio inm
                document.getElementById("municipio_inm").value = municipio;
            }
            $('#select-backed-zelect').zelect()
        </script>
</body>

</html>