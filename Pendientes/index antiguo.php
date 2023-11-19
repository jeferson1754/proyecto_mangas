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
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title><?php echo $titulo7; ?>
    </title>
</head>

<body>


    <?php include('../menu.php');  ?>

    <div class="col-sm">
        <form action="" method="GET">
            <button type="button" class="btn btn-info " data-toggle="modal" data-target="#new">
                Nuevo <?php echo ucfirst($titulo7); ?>
            </button>
            <button type="button" class="btn btn-info " onclick="myFunction()">
                Busqueda
            </button>
            <button type="button" class="btn btn-info " onclick="myFunction2()">
                Filtrar por Estado
            </button>

            <button class="btn btn-outline-info" type="submit" name="linkeado"> Sin Link </button>
            <button class="btn btn-outline-info" type="submit" name="sin-fechas"> Sin Revision </button>
            <button class="btn btn-outline-info" type="submit" name="sin-actividad"> Sin Actividad</button>
            <button class="btn btn-outline-info" type="submit" name="mayor-actividad"> Mayor Actividad</button>
        </form>
        <div class="class-control" id="myDIV" style="display:none;">
            <form action="" method="GET">
                <input class="form-control" type="text" name="busqueda" style="width:auto;">

                <button class="btn btn-outline-info" type="submit" name="buscar"> <b>Buscar </b> </button>
                <button class="btn btn-outline-info" type="submit" name="borrar"> <b>Borrar </b> </button>

                <input type="hidden" name="accion" value="Busqueda">
            </form>
        </div>
        <div class="class-control" id="myDIV2" style="display:none;">
            <form action="" method="GET">
                <select name="estado" class="form-control" style="width:auto;">
                    <option value="">Seleccione Estado:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT $fila8 FROM $tabla;");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="accion" value="Filtro">
                <br>

                <button class="btn btn-outline-info" type="submit" name="filtrar"> <b>Filtrar </b> </button>
                <button class="btn btn-outline-info" type="submit" name="borrar"> <b>Borrar </b> </button>
            </form>
        </div>

        <?php
        $where = "ORDER BY `pendientes_manga`.`ID` DESC";
        $link = "";

        if (isset($_GET['borrar'])) {
            $estado = "Todos los Pendientes";
            $busqueda = "";
            $accion1 = $_REQUEST['accion'];
            $where = "ORDER BY `$tabla`.`ID` DESC";
        } else if (isset($_GET['buscar'])) {
            if (isset($_GET['busqueda'])) {
                $estado = "Busqueda en Pendientes";
                $busqueda   = $_REQUEST['busqueda'];
                $where = "WHERE $fila1 LIKE '%$busqueda%' ORDER BY `$tabla`.`Faltantes`,`$tabla`.`Fecha_Cambio1` DESC";
                $accion1 = $_REQUEST['accion'];
            }
        } else if (isset($_GET['filtrar'])) {
            if (isset($_GET['estado'])) {
                $estado   = $_REQUEST['estado'];
                $where = "WHERE $fila8='$estado'ORDER BY `$tabla`.`Fecha_Cambio1` DESC";
                $accion1 = $_REQUEST['accion'];
            }
        } else if (isset($_GET['linkeado'])) {
            $estado = "Sin Link";
            $where = "where $fila2 ='' OR $fila13='Erroneo/Inexistente' OR $fila13='Faltante' OR $fila13=''  ORDER BY `$tabla`.`Faltantes`,`$tabla`.`Fecha_Cambio1` DESC";
        } else if (isset($_GET['sin-fechas'])) {
            $estado = "Sin Revision en Pendientes";
            $where = "where $ver='NO' ORDER BY `$tabla`.`$titulo3` DESC,`$tabla`.`Fecha_Cambio1` DESC";
        } else if (isset($_GET['sin-actividad'])) {
            $estado = "Sin Actividad Reciente";
            $where = " WHERE $fila10 < DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND Faltantes=0 ORDER BY `$tabla`.`Faltantes`,`$tabla`.`Fecha_Cambio1` DESC";
        } else if (isset($_GET['mayor-actividad'])) {
            $estado = "Mayor Actividad Reciente";
            $where = "ORDER BY `$tabla`.`Fecha_Cambio1` DESC, $tabla.Cantidad DESC";
        } else {
            $estado = "Todos los Pendientes";
        }
        ?>


        <?php include('ModalCrear.php');  ?>
    </div>
    <h1><?php echo ucfirst($estado) ?></h1>
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
                    <th style="text-align:center;"><?php echo $titulo3 ?></th>
                    <th style="text-align:center;"><?php echo $titulo4 ?></th>


                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = "SELECT * FROM $tabla $where limit 100";

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
                        <td style="text-align:center;"><?php echo $mostrar[$titulo3] ?></td>
                        <td style="text-align:center;"><?php echo $mostrar[$fila10] ?></td>


                        <td>
                            <a href="./?busqueda=<?php echo urlencode($mostrar[$fila1]); ?>&buscar=&accion=Busqueda" target="_blanck">
                                <button type="button" class="btn btn-info">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#aumentar<?php echo $mostrar[$fila7]; ?>">
                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit<?php echo $mostrar[$fila7]; ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $mostrar[$fila7]; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <a href="./ejemplo-barra.php?variable=<?php echo urlencode($mostrar[$fila7]); ?>" target="_blanck">
                                <button type="button" class="btn btn-secondary">
                                    <i class="fa fa-bar-chart"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                    <?php include('ModalEditar.php'); ?>
                    <?php include('Modal-Aumentar.php'); ?>
                    <?php include('ModalDelete.php'); ?>
                <?php
                }
                ?>
            </tbody>
        </table>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

        <script src="./js/popper.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                        "order": [],
                        language: {
                            processing: "Tratamiento en curso...",
                            search: "Buscar:",
                            lengthMenu: "Filtro de _MENU_ <?php echo ucfirst($titulo7) ?>",
                            info: "Mostrando <?php echo $titulo7 ?> del _START_ al _END_ de un total de _TOTAL_ <?php echo $titulo7 ?>",
                            infoEmpty: "No existen registros",
                            infoFiltered: "(filtrado de _MAX_ <?php echo $titulo7 ?> en total)",
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