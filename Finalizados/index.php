<?php

require 'bd.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
    <title><?php echo ucfirst($titulo2) ?> </title>
</head>
<style>
    .main-container {
        max-width: 600%;
        margin: 30px 20px;

    }

    table {
        width: 100% !important;
        background-color: white !important;
        text-align: left;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;

    }

    thead {
        background-color: #5a9b8d !important;
        color: white !important;
        border-bottom: solid 5px #0F362D !important;
    }


    tr:nth-child(even) {
        background-color: #ddd !important;
    }

    tr:hover td {
        background-color: #369681 !important;
        color: white !important;
    }


    div.dataTables_wrapper div.dataTables_filter input {
        margin-right: 10px;
    }

    .flex-container {
        display: flex;
    }

    .max {
        width: 30%;

    }

    h1 {
        text-align: center;
    }

    a {
        color: black;
    }

    a:hover {
        color: white;
    }

    a:link,
    a:visited {
        text-decoration: none;

    }

    .normal {
        max-width: 50px;
        text-align: center;
    }

    @media screen and (max-width: 600px) {
        table {
            width: 100%;
        }

        thead {
            display: none;
        }

        tr:nth-of-type(2n) {
            background-color: inherit !important;
        }

        tr td:first-child {
            background: #f0f0f0 !important;
            font-weight: bold;
            font-size: 1.3em;
        }

        tr:hover td {
            background-color: #369681 !important;
            color: white !important;
        }


        tbody td {
            display: block;
            text-align: center !important;
        }


        tbody td:before {
            content: attr(data-th) !important;
            display: block;
            text-align: center !important;
        }

        .max {
            width: auto;
        }

        .normal {
            max-width: auto;
            margin: auto;
        }

    }
</style>

<body>

<?php include ('../menu.php'); ?>

    <div class="col-sm">
        <!--- Formulario para registrar Cliente --->


    </div>
    <h1><?php echo ucfirst($titulo2) ?></h1>
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
                $sql1 = "SELECT * FROM $tabla ";

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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#resta<?php echo $mostrar[$fila7]; ?>">
                                Restaurar
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $mostrar[$fila7]; ?>">
                                Eliminar
                            </button>
                        </td>
                    </tr>

                    <?php include('ModalDelete.php'); ?>
                    <?php include('ModalRestaurar.php'); ?>
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
                         "order": [] ,
                        language: {
                            processing: "Tratamiento en curso...",
                            search: "Buscar:",
                            lengthMenu: "Filtro de _MENU_ <?php echo ucfirst($tabla2) ?>",
                            info: "Mostrando <?php echo $tabla2 ?>s del _START_ al _END_ de un total de _TOTAL_ <?php echo $tabla2 ?>s",
                            infoEmpty: "No existen registros",
                            infoFiltered: "(filtrado de _MAX_ <?php echo $tabla2 ?> en total)",
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
