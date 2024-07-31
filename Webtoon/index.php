<?php

require 'bd.php';
require '../upa copy.php';

$sql = ("select Date_FORMAT(DATE_SUB(NOW(),INTERVAL 5 HOUR),'%W');");

$dia      = mysqli_query($conexion, $sql);

while ($rows = mysqli_fetch_array($dia)) {

    $day = $rows[0];
    // echo $day;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css?<?php echo time(); ?>">
    <title><?php echo ucfirst($tabla) ?>
    </title>
</head>

<body>

    <?php include('../menu.php'); ?>

    <div class="col-sm">
        <!--- Formulario para registrar Cliente --->

        <form action="" method="GET">
            <button class="btn btn-outline-info mostrar" type="submit" name="enviar"> <b>HOY </b> </button>
            <button class="btn btn-outline-info mostrar" type="submit" name="borrar"> <b>Borrar </b> </button>
            <input type="hidden" name="accion" value="HOY">


            <button type="button" class="btn btn-info ocultar" data-toggle="modal" data-target="#new">
                Nuevo <?php echo ucfirst($tabla); ?>
            </button>

            <button type="button" class="btn btn-info ocultar" onclick="myFunction()">
                Filtrar
            </button>

            <button type="button" class="btn btn-info mostrar" onclick="myFunction2()">
                Busqueda
            </button>
            <button class="btn btn-outline-info ocultar" type="submit" name="link"> <b>Sin Link </b> </button>
            <button class="btn btn-outline-info mostrar" type="button" onclick="vistos()" name="marcar-vistos"> Marcar Vistos </button>
            <button type="button" class="btn btn-info  mostrar" onclick="window.location.href = './horario.php'">Horario</button>
        </form>
        <div class="class-control" id="myDIV" style="display:none;">
            <form action="" method="GET">
                <select name="estado" class="form-control" style="width:auto;">
                    <option value="">Seleccione:</option>
                    <?php
                    $query = $conexion->query("SELECT * FROM $tabla4;");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['Estado'] . '">' . $valores['Estado'] . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="accion" value="Filtro">
                <br>

                <button class="btn btn-outline-info" type="submit" name="filtrar"> <b>Filtrar </b> </button>
                <button class="btn btn-outline-info" type="submit" name="borrar"> <b>Borrar </b> </button>
            </form>
        </div>
        <div class="class-control" id="myDIV2" style="display:none;">
            <form action="" method="GET">
                <input class="form-control" type="text" name="busqueda_webtoon" style="width:auto;">

                <button class="btn btn-outline-info" type="submit" name="buscar"> <b>Buscar </b> </button>
                <button class="btn btn-outline-info" type="submit" name="borrar"> <b>Borrar </b> </button>
            </form>
        </div>

        <?php



        $busqueda = "";

        // Mapeo de días de la semana en inglés a español
        $dias_semana = array(
            "Monday" => "Lunes",
            "Tuesday" => "Martes",
            "Wednesday" => "Miércoles",
            "Thursday" => "Jueves",
            "Friday" => "Viernes",
            "Saturday" => "Sábado",
            "Sunday" => "Domingo"
        );

        // Verifica si el día está presente en el array y establece el equivalente en español
        if (array_key_exists($day, $dias_semana)) {
            $week = $dias_semana[$day];
        } else {
            // Mensaje de error si el día no se encuentra en el array
            echo "Día no válido: " . $day;
        }

        //echo $week;
        $where = "WHERE `$tabla`.`$fila6` LIKE'%" . $week . "%'AND $fila8 ='Emision' ORDER BY `$tabla`.`$fila7` DESC limit 100;";

        if (isset($_GET['enviar'])) {

            $where = "WHERE `$tabla`.`$fila6` LIKE '%" . $week . "%'";
        } else if (isset($_GET['borrar'])) {
            $busqueda = "";

            $where = "WHERE `$tabla`.`$fila5`>0;";
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
        }

        ?>

        <?php include('./ModalCrear.php');  ?>

    </div>
    <h1><?php echo ucfirst($tabla); ?>s</h1>
    <div class="main-container">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th style="max-width:310px;"><?php echo $fila1 ?></th>
                    <th class="normal"><?php echo $fila3 ?></th>
                    <th class="normal"><?php echo $fila4 ?></th>
                    <th class="normal"><?php echo $fila5 ?></th>
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
                        <td><a href="<?php echo $mostrar[$fila2] ?>" title="<?php echo $mostrar[$fila13] ?>" target="_blanck"><?php echo $mostrar[$fila1] ?></a></td>
                        <td class="normal"><?php echo $mostrar[$fila3] ?></td>
                        <td class="normal"><?php echo $mostrar[$fila4] ?></td>
                        <td class="normal"><?php echo $mostrar[$fila5] ?></td>
                        <td><?php echo $mostrar[$fila8] ?></td>
                        <td><?php echo $mostrar[$fila6] ?></td>


                        <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#caps<?php echo $mostrar[$fila7]; ?>">
                                Visto
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit<?php echo $mostrar[$fila7]; ?>">
                                Editar
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $mostrar[$fila7]; ?>">
                                Eliminar
                            </button>
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
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                        order: [
                            [3, 'asc']
                        ],
                        language: {
                            processing: "Tratamiento en curso...",
                            search: "Buscar:",
                            lengthMenu: "Filtro de _MENU_ <?php echo ucfirst($tabla) ?>",
                            info: "Mostrando <?php echo $tabla ?>s del _START_ al _END_ de un total de _TOTAL_ <?php echo $tabla ?>s",
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
                    text: '¿Desea marcar como vistos todos los webtoon del Dia <?php echo $week; ?>?',
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

            function myFunction() {
                var x = document.getElementById("myDIV");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }

            function myFunction2() {
                var x = document.getElementById("myDIV2");
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
        </script>
</body>

</html>