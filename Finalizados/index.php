<?php

require 'bd.php';

?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($titulo2) ?> </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/style new.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="../css/checkbox.css">
</head>


<body>

    <?php include('../menu.php'); ?>

    <div class="main-container">


        <h1 class="text-center text-primary fw-bold">
            <?php echo ucfirst($titulo2) ?>
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
                        $sql1 = "SELECT * FROM `finalizados_manga` ORDER BY `finalizados_manga`.`ID` DESC";

                        $result = mysqli_query($conexion, $sql1);
                        //echo $sql1;

                        while ($mostrar = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td class="fw-500"><a href="<?php echo $mostrar[$fila2] ?>" title="<?php echo $mostrar[$fila13] ?>" target="_blanck" class="link" style="text-decoration: none;"><?php echo $mostrar[$fila1] ?></a></td>
                                <td class="fw-500"><?php echo $mostrar[$fila3] ?></td>
                                <td class="fw-500"><?php echo $mostrar[$fila4] ?></td>
                                <td class="fw-500"><?php echo $mostrar[$fila5] ?></td>
                                <td class="fw-500">
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

                                <td class="fw-500"><?php echo $mostrar[$fila6] ?></td>


                                <td data-label="Acciones">
                                    <div class="action-buttons">
                                        <button type="button"
                                            class="action-button bg-primary" data-bs-toggle="modal" data-bs-target="#resta<?php echo $mostrar[$fila7]; ?>">
                                            <i class="fa-solid fa-arrow-rotate-left"></i> Restaurar
                                        </button>
                                        <button type="button"
                                            class="action-button bg-danger" data-toggle="modal" data-target="#delete<?php echo $mostrar[$fila7]; ?>">
                                            <i class="fas fa-trash"></i>Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <?php include('ModalDelete.php'); ?>
                            <?php include('ModalRestaurar.php'); ?>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script>
                    $(document).ready(function() {
                        $('#example').DataTable({
                                "order": [],
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