<?php

require 'bd.php';
include 'upa.php';
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
    <link rel="stylesheet" type="text/css" href="./css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="./css/checkbox.css">
    <title><?php echo ucfirst($tabla) ?>
    </title>
</head>
<script>
    function filtrarTabla() {
        document.getElementById("listas").submit();
    }

    function filtrarTabla2() {
        document.getElementById("listas_sinleer").submit();
    }

    function filtrarTabla3() {
        document.getElementById("capitulos").submit();
    }

    function filtrarTabla4() {
        document.getElementById("estado").submit();
    }
</script>



<body>
    <?php include('menu.php'); ?>

    <div class="col-sm">
        <!--- Formulario para registrar Cliente --->
        <form action="" method="GET">
            <button type="button" class="btn btn-info ocultar" data-toggle="modal" data-target="#new">
                Nuevo <?php echo ucfirst($tabla); ?>
            </button>
            <button type="button" class="btn btn-info ocultar" onclick="myFunction()">
                Filtrar Todos
            </button>
            <button type="button" class="btn btn-info ocultar" onclick="myFunction3()">
                Filtrar Sin Leer
            </button>
            <button type="button" class="btn btn-outline-info mostrar" onclick="myFunction4()">
                Filtrar Capitulos
            </button>
            <button type="button" class="btn btn-info mostrar" onclick="myFunction5()">
                Filtrar por Estado
            </button>
            <button type="button" class="btn btn-info mostrar" onclick="myFunction2()">
                Busqueda
            </button>



            <button class="btn btn-outline-info ocultar" type="submit" name="linkeado"> Sin Link </button>
            <button class="btn btn-outline-info ocultar" type="submit" name="sin-fechas"> Sin Revision </button>
            <button class="btn btn-outline-info ocultar" type="submit" name="sin-actividad"> Sin Actividad</button>
            <button class="btn btn-outline-info mostrar" type="submit" name="mayor-actividad"> Mayor Actividad</button>
            <button class="btn btn-outline-info ocultar" type="submit" name="anime"> Tiene Anime</button>
        </form>
        <div class="class-control" id="myDIV" style="display:none;">
            <form id="listas" action="" method="GET">
                <select name="todos" class="form-control" style="width:auto;" onchange="filtrarTabla()">
                    <option value="">Seleccione Todos:</option>
                    <?php
                    $query = $conexion->query("SELECT * FROM $tabla2;");

                    while ($valores = mysqli_fetch_array($query)) {
                        $selected = ($_GET['estado'] == $valores[$fila1]) ? 'selected' : '';
                        echo '<option value="' . $valores[$fila1] . '" ' . $selected . '>' . $valores[$fila1] . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="accion" value="Filtro1">
            </form>
        </div>
        <div class="class-control" id="myDIV3" style="display:none;">
            <form id="listas_sinleer" action="" method="GET">
                <select name="listas_sinleer" class="form-control" style="width:auto;" onchange="filtrarTabla2()">
                    <option value="">Seleccione Sin Leer:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT $fila6 FROM $tabla WHERE $fila5 > 0 ORDER BY `manga`.`Lista` ASC;");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores[$fila6] . '">' . $valores[$fila6] . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="accion" value="Filtro2">

            </form>
        </div>
        <div class="class-control" id="myDIV4" style="display:none;">
            <form id="capitulos" action="" method="GET">
                <select name="capitulos" class="form-control" style="width:auto;" onchange="filtrarTabla3()">
                    <option value="">Seleccione Capitulos:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT $fila5 FROM $tabla WHERE $fila5 > 0 ORDER BY `$tabla`.`$fila5` ASC LIMIT 5;");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores[$fila5] . '">' . $valores[$fila5] . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="accion" value="Filtro3">

            </form>
        </div>
        <div class="class-control" id="myDIV5" style="display:none;">
            <form id="estado" action="" method="GET">
                <select name="estado" class="form-control" style="width:auto;" onchange="filtrarTabla4()">
                    <option value="">Seleccione Estado:</option>
                    <?php
                    $query = $conexion->query("SELECT DISTINCT $fila8 FROM `$tabla` WHERE $fila5>0;");
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
                <input class="form-control" type="text" name="busqueda_manga" style="width:auto;">

                <button class="btn btn-outline-info" type="submit" name="buscar"> <b>Buscar </b> </button>
                <button class="btn btn-outline-info" type="submit" name="borrar"> <b>Borrar </b> </button>

                <input type="hidden" name="accion" value="Busqueda">
            </form>
        </div>

        <?php

        $order = "ORDER BY `manga`.`Faltantes`ASC, `manga`.`Fecha_Cambio1` DESC,`manga`.`Hora_Cambio` DESC";

        $where = "WHERE Faltantes>0 $order limit 10";
        $link = "";


        if (isset($_GET['borrar'])) {
            $busqueda = "";
            $where = "WHERE Faltantes>0 ORDER BY `manga`.`Fecha_Cambio1` DESC,`manga`.`Hora_Cambio` DESC limit 10";
            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }

            $estado = "Todos";
            $conteo = " : " . $totalRegistros;
            $capi = "1";
        } else if (isset($_GET['todos'])) {
            $estado   = $_GET['todos'];

            if (!empty($estado)) {
                $where = "WHERE $fila6='$estado' ORDER BY `manga`.`Fecha_Cambio1` DESC,`manga`.`Hora_Cambio` DESC limit 100";
            }

            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }

            $accion1 = $_REQUEST['accion'];
            $capi = "1";
            $conteo = " : " . $totalRegistros;
        } else if (isset($_GET['buscar'])) {
            if (isset($_GET['busqueda_manga'])) {


                $busqueda   = $_REQUEST['busqueda_manga'];
                $where = "WHERE $fila1 LIKE '%$busqueda%' $order limit 10";
                $accion1 = $_REQUEST['accion'];
                $capi = "1";
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
                $where = "WHERE $fila8='$estado' $order limit 10";
            }
            $accion1 = $_REQUEST['accion'];

            if ($estado == "Emision") {
                $capi = "1";
            } else {
                $capi = "2";
            }

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
        } else if (isset($_GET['listas_sinleer'])) {

            $estado   = $_REQUEST['listas_sinleer'];

            if (!empty($estado)) {
                $where = "WHERE $fila6='$estado' AND Faltantes>0 ORDER BY `manga`.`Fecha_Cambio1` DESC,`manga`.`Hora_Cambio` DESC limit 100";
            }

            $accion1 = $_REQUEST['accion'];

            $capi = "1";

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

            $where = "where $fila2 ='' OR $fila13='Erroneo/Inexistente' OR $fila13='Faltante' $order limit 10";
            $capi = "1";

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

            $where = "where $ver='NO' $order limit 10";
            $capi = "1";
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

            $where = " WHERE $fila10 < DATE_SUB(CURDATE(), INTERVAL 36 MONTH) AND $fila5=0 ORDER BY `manga`.`Faltantes`ASC, `manga`.`Fecha_Cambio1` ASC;";
            $capi = "1";

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

            $where = "ORDER BY manga.Cantidad DESC, `manga`.`Fecha_Cambio1` DESC, `manga`.`Hora_Cambio` DESC limit 30";
            $capi = "1";
            $estado = "Mayor Actividad Reciente";
            $conteo = " ";
            $totalRegistros = "30";
        } else if (isset($_GET['capitulos'])) {
            $caps   = $_REQUEST['capitulos'];
            $estado = "Capitulos: " . $caps;
            if (!empty($caps)) {
                $where = "WHERE $fila5='$caps' $order limit 10";
            }

            $sql2 = "SELECT COUNT(*) AS total_registros from $tabla $where";
            $result2 = mysqli_query($conexion, $sql2);
            //echo $sql2;

            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $totalRegistros = $row["total_registros"];
            } else {
                $totalRegistros = 0;
            }

            $accion1 = $_REQUEST['accion'];

            if ($caps <= 3) {
                $capi = $caps;
            } else {
                $capi = "2";
            }
            $conteo = "";
        } else if (isset($_GET['anime'])) {
            $where = "where Anime='SI' AND Faltantes>0 ORDER BY `manga`.`Capitulos Vistos` ASC limit 10";
            $capi = "1";
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
            $estado = "Todos";
            $conteo = " : " . $totalRegistros;
            $capi = "1";
        }


        //echo "El total de registros en la tabla 'manga' es: " . $totalRegistros;
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


                    $query_result = mysqli_query($conexion, "SELECT * FROM tachiyomi WHERE ID_Manga = " . $mostrar['ID']);
                    $is_successful = ($query_result !== false && mysqli_num_rows($query_result) > 0);

                    // Determinar la clase del punto de color según el resultado de la consulta
                    $colorClass = $is_successful ? 'blue' : 'white';

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
                        echo '<td style="text-align:center;">' . $mostrar[$titulo3] . '<span title="Verificado-' . $mostrar[$ver] . '" class="color-dot ' . $verificado . '">&bull;</span><span title="Anime-' . $mostrar['Anime'] . '" class="color-dot ' . $anime . '">&bull;</span><span title="Tachiyomi-SI"class="color-dot ' . $colorClass . '">&bull;</span></td>';
                        ?>

                        <td style="text-align:center;"><?php echo $mostrar[$fila10] ?></td>


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
                            <?php
                            $variable = $mostrar[$fila7];
                            ?>
                            <a href="./ejemplo-barra.php?variable=<?php echo urlencode($variable); ?>" target="_blanck">
                                <button type="button" class="btn btn-secondary">
                                    <i class="fa fa-bar-chart"></i>
                                </button>
                            </a>
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

        <script src="./js/popper.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                        "order": [],
                        language: {
                            processing: "Tratamiento en curso...",
                            search: "Buscar:",
                            lengthMenu: "Filtro de _MENU_ <?php echo ucfirst($tabla) ?>",
                            info: "Mostrando <?php echo $tabla ?>s del _START_ al _END_ de un total de <?php echo $totalRegistros ?>",
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

            // Verificar si la cookie "consulta_realizada" está establecida con JavaScript
            if (document.cookie.indexOf("consulta_realizada") >= 0) {
                // Si la cookie está establecida, la consulta ya se ha realizado hoy
                // Puedes agregar código adicional aquí si es necesario
            } else {
                // Si la cookie no está establecida, puedes agregar código JavaScript
                // para realizar alguna acción adicional si es necesario
            }
        </script>
</body>

</html>