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
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/checkbox.css">
    <title><?php echo $titulo7; ?>
    </title>
</head>
<script>
    function filtrarTabla4() {
        document.getElementById("estado").submit();
    }
</script>

<body>
    <?php include('../menu.php');  ?>

    <div class="col-sm">
        <!--- Formulario para registrar Cliente --->
        <form action="" method="GET">
            <button type="button" class="btn btn-info " data-toggle="modal" data-target="#new">
                Nuevo <?php echo ucfirst($titulo7); ?>
            </button>
            <button type="button" class="btn btn-info " onclick="myFunction5()">
                Filtrar por Estado
            </button>
            <button type="button" class="btn btn-info" onclick="myFunction2()">
                Busqueda
            </button>



            <button class="btn btn-outline-info" type="submit" name="linkeado"> Sin Link </button>
            <button class="btn btn-outline-info" type="submit" name="sin-fechas"> Sin Revision </button>
            <button class="btn btn-outline-info" type="submit" name="sin-actividad"> Sin Actividad</button>
            <button class="btn btn-outline-info" type="submit" name="mayor-actividad"> Mayor Actividad</button>
            <button class="btn btn-outline-info" type="submit" name="anime"> Tiene Anime</button>
        </form>
        <div class="class-control" id="myDIV5" style="display:none;">
            <form id="estado" action="" method="GET">
                <select name="estado" class="form-control" style="width:auto;" onchange="filtrarTabla4()">
                    <option value="">Seleccione Estado:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT $fila8 FROM $tabla;");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="accion" value="Filtro">
            </form>
        </div>

        <div class="class-control" id="myDIV2" style="display:none;">
            <form action="" method="GET">
                <input class="form-control" type="text" name="busqueda_pendientes_manga" style="width:auto;">

                <button class="btn btn-outline-info" type="submit" name="buscar"> <b>Buscar </b> </button>
                <button class="btn btn-outline-info" type="submit" name="borrar"> <b>Borrar </b> </button>

                <input type="hidden" name="accion" value="Busqueda">
            </form>
        </div>

        <?php


        $order = "ORDER BY `$tabla`.`Fecha_Cambio1` DESC,`$tabla`.`Hora_Cambio` DESC";
        $where = "ORDER BY `$tabla`.`ID` DESC limit 100";
        $link = "";


        if (isset($_GET['borrar'])) {
            $busqueda = "";
            $accion1 = $_REQUEST['accion'];
            $where = "$order limit 10";
            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }

            $estado = "Pendientes";
            $conteo = " : " . $totalRegistros;
        } else if (isset($_GET['buscar'])) {
            if (isset($_GET['busqueda_pendientes_manga'])) {

                $busqueda   = $_REQUEST['busqueda_pendientes_manga'];
                $where = "WHERE $fila1 LIKE '%$busqueda%' ORDER BY `$tabla`.`Fecha_Cambio1` DESC limit 100";
                $accion1 = $_REQUEST['accion'];
                $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
                $result2 = mysqli_query($conexion, $sql2);
                //echo $sql2;

                if ($result2->num_rows > 0) {
                    $row = $result2->fetch_assoc();
                    $totalRegistros = $row["total_registros"];
                } else {
                    $totalRegistros = 0;
                }
                $estado = "Busqueda";
                $conteo = " : " . $totalRegistros;
            }
        } else if (isset($_GET['estado'])) {

            $estado   = $_REQUEST['estado'];
            if (!empty($estado)) {

                $where = "WHERE $fila8='$estado'ORDER BY `$tabla`.`ID` DESC limit 100";
            }
            $accion1 = $_REQUEST['accion'];
            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }

            $conteo = " : " . $totalRegistros;
        } else if (isset($_GET['linkeado'])) {

            $where = "where $fila2 ='' OR $fila13='Erroneo/Inexistente' OR $fila13='Faltante' ORDER BY `$tabla`.`ID` DESC";
            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }
            $estado = "Sin Link";
            $conteo = " : " . $totalRegistros;
        } else if (isset($_GET['sin-fechas'])) {

            $where = "where $ver='NO' ORDER BY `$tabla`.`Cantidad` DESC, `$tabla`.`Fecha_Cambio1` DESC limit 100";
            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }
            $estado = "Sin Revision de Cantidad";
            $conteo = " : " . $totalRegistros;
        } else if (isset($_GET['sin-actividad'])) {

            $where = " WHERE $fila10 < DATE_SUB(CURDATE(), INTERVAL 36 MONTH) AND Faltantes=0 ORDER BY `$tabla`.`Fecha_Cambio1` DESC limit 100";
            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }
            $estado = "Sin Actividad Reciente";
            $conteo = " : " . $totalRegistros;
        } else if (isset($_GET['mayor-actividad'])) {

            $where = "ORDER BY $tabla.Cantidad DESC, `$tabla`.`Fecha_Cambio1` DESC limit 100";
            $estado = "Mayor Actividad Reciente";
            $conteo = "";
        } else if (isset($_GET['anime'])) {
            $where = "where Anime='SI' ORDER BY `$tabla`.`Capitulos Vistos` DESC limit 100";
            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }
            $estado = "Tienen Anime";
            $conteo = " : " . $totalRegistros;
        } else {
            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }
            $estado = "Pendientes";
            $conteo = " : " . $totalRegistros;
        }


        //echo "El total de registros en la tabla '$tabla' es: " . $totalRegistros;
        ?>

        <?php include('ModalCrear.php');  ?>

    </div>
    <h1><?php echo ucfirst($estado) ?><?php echo $conteo ?></h1>
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
            <style>
                /* Estilos para el punto de color */
                .color-dot {
                    top: -15px;
                    left: 10px;
                    font-size: 20px;
                    position: relative;
                }

                /* Estilos para el punto verde */
                .color-dot.green {
                    color: green;
                }

                /* Estilos para el punto rojo */
                .color-dot.red {
                    color: red;
                }

                .color-dot.blue {
                    color: blue;
                }

                .color-dot.orange {
                    color: orange;
                }

                .color-dot.white {
                    top: 0px;
                    left: 0px;
                    font-size: 0px;
                    position: relative;
                }

                /* Punto de color en vista celular */
                @media (max-width: 767px) {
                    .color-dot {
                        font-size: 30px;
                        /* Tamaño en vista celular */
                    }
                }
            </style>
            <tbody>
                <?php
                $sql1 = "SELECT * FROM $tabla $where";

                $result = mysqli_query($conexion, $sql1);
                //echo $sql1;

                while ($mostrar = mysqli_fetch_array($result)) {

                    $verificado = ($mostrar['verificado'] == 'SI') ? 'green' : 'red';
                    $anime = ($mostrar['Anime'] == 'SI') ? 'orange' : 'white';
                ?>
                    <tr>
                        <td><a href="<?php echo $mostrar[$fila2] ?>" title="<?php echo $mostrar[$fila13] ?>" target="_blanck"><?php echo $mostrar[$fila1] ?></a></td>
                        <td class="normal"><?php echo $mostrar[$fila3] ?></td>
                        <td class="normal"><?php echo $mostrar[$fila4] ?></td>
                        <td class="normal"><?php echo $mostrar[$fila5] ?></td>
                        <td><?php echo $mostrar[$fila8] ?></td>
                        <td><?php echo $mostrar[$fila6] ?></td>

                        <?php
                        echo ''; // Punto de color
                        echo '<td style="text-align:center;">' . $mostrar[$titulo3] . '<span title="Verificado-' . $mostrar[$ver] . '" class="color-dot ' . $verificado . '">&bull;</span><span title="Anime-' . $mostrar['Anime'] . '" class="color-dot ' . $anime . '">&bull;</span></td>';
                        ?>

                        <td style="text-align:center;"><?php echo $mostrar[$fila10] ?></td>


                        <td>
                            <a href="./?busqueda_pendientes_manga=<?php echo urlencode($mostrar[$fila1]); ?>&buscar=&accion=Busqueda" target="_blanck">
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

        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                        "order": [],
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

            function myFunction3() {
                var x = document.getElementById("myDIV3");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }

            function myFunction4() {
                var x = document.getElementById("myDIV4");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }

            function myFunction5() {
                var x = document.getElementById("myDIV5");
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