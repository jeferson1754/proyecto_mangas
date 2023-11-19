<!DOCTYPE html>
<html>
<head>
    <title>Gráfico</title>
    <!-- Incluir la librería Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.css">
</head>

<body>
   
<?php
$hora_actual = date('H:i:s');
require 'bd.php';

if (isset($_GET['variable'])) {
  $variable = urldecode($_GET['variable']);
  //echo "La variable recibida es: " . $variable;
}
    $consulta1 = "SELECT * FROM `$tabla` where ID='$variable'";
    $resultado1 = mysqli_query($conexion, $consulta1);
    //echo $consulta1;

   while ($fila1 = mysqli_fetch_assoc($resultado1)) {
            $titulo = $fila1['Nombre'];
            $enlace = $fila1['Link'];
            $verif  = $fila1['verificado'];
    }
 ?>
  <a href="<?php echo $enlace ?>" title="<?php echo $titulo ?>" target="_blanck"><h1 style="font-family:Segoe UI;font-weight: 600;"> <?php echo $titulo; ?></h1></a>
    <!-- Crear un lienzo para el gráfico -->
<style>
    .grafico{
        width: 800px;
        height: 400px;
        border: 5px solid black;
        margin: 0 auto;
    }

    table {
        width: 100% !important;
        background-color: white !important;
        text-align: left;
        border-collapse: collapse;
    }

    .bottom-right {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 150px;
        height: 130px;
        background-color: #f1f1f1;
        padding: 10px;
        text-align:center;
    }

        .todo {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            --input-focus: #2d8cf0;
            --input-out-of-focus: #ccc;
            --bg-color: #fff;
            --bg-color-alt: #666;
            --main-color: #323232;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .container input {
            position: absolute;
            opacity: 0;
        }

        .checkmark {
            width: 40px;
            height: 40px;
            position: relative;
            top: 0;
            left:25px;
            border: 2px solid var(--main-color);
            border-radius: 5px;
            box-shadow: 4px 4px var(--main-color);
            background-color: var(--input-out-of-focus);
            transition: all 0.3s;
        }


        .container input:checked~.checkmark {
            background-color: var(--input-focus);
        }


        .checkmark:after {
            content: "";
            width: 10px;
            height: 25px;
            position: absolute;
            top: 2px;
            left: 12px;
            display: none;
            border: solid var(--bg-color);
            border-width: 0 2.5px 2.5px 0;
            transform: rotate(45deg);
        }

        .container input:checked~.checkmark:after {
            display: block;

        }



        .text {
            margin-left: 8px;
            margin-right: 18px;
            color: var(--main-color);
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
        color: black;
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
        
        .grafico{
        width: 100%;
        height: 100%;
        border: white;
        margin: 0 auto;
        }
        


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
            max-width: 100%;
            margin: auto;
        }

    }
</style>

    <div class="grafico">
    <canvas id="myChart" ></canvas>
    </div>
    <?php //echo $variable ?>
     <div class="tabla" style="width:50%; margin: 0 auto;">
        <table id="example" class="display" style="borderColor:black;">
            <thead>
                <tr>
                    <th style="text-align: center;">Fecha</th>
                    <th style="text-align: center;">Diferencia</th>
                    <th style="text-align: center; width:120px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = "SELECT * FROM `$tabla7` where $fila9='$variable' ORDER BY `$tabla7`.`Fecha` DESC";

                $result = mysqli_query($conexion, $sql1);
                //echo $sql1;

                while ($mostrar = mysqli_fetch_array($result)) {
                     $id=$mostrar['ID'];
                ?>
                    <tr>
                        <td class="normal"><?php echo $mostrar['Fecha'] ?></td>
                        <td class="normal"><?php echo $mostrar['Diferencia'] ?></td>

                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-dif<?php echo $id; ?>">
                                 <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dif<?php echo $id; ?>">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>

                    <?php include('Modal-Diferencias.php'); ?>
                    <?php include('Modal-EditDiferencias.php'); ?>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>



     <div class="bottom-right">
        Verificado:
        <?php 
    
        if($verif=="SI"){
            ?>
        <form action="verif.php" method="GET">
            <div class="todo">
       
            <label class="container">
                <input type="checkbox" name="checkbox" checked value='SI'>
               
                <div class="checkmark"></div>
                <!--
                <span class="text">Etiqueta IP</span>
                -->
            </label>
                <input type="hidden" name="id_manga" value="<?php echo $variable ?>" >
                <input type="hidden" name="nombre" value="<?php echo $titulo ?>" >
                <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $variable ?>" >
            
            </div>
            <button type="submit" class="btn btn-info" name="verif" >
             Guardar
            </button>
        </form>
            <?php 
        }else{

            ?>
            <form action="verif.php" method="GET">
            <div class="todo">
       
            <label class="container">
                <input type="checkbox" name="checkbox" value='SI'>
               
                <div class="checkmark"></div>
                <!--
                <span class="text">Etiqueta IP</span>
                -->
            </label>
                <input type="hidden" name="id_manga" value="<?php echo $variable ?>" >
                <input type="hidden" name="nombre" value="<?php echo $titulo ?>" >
                <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $variable  ?>">
            
            </div>
            <button type="submit" class="btn btn-info" name="verif" >
             Guardar
            </button>
            </form>
            <?php 
        }
        
        ?>
        
        
        
    </div>



        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="./js/popper.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>

 <?php
        // Consulta SQL para obtener los datos del gráfico
        $consulta = "SELECT Fecha, Diferencia FROM `$tabla7` where $fila9='$variable' ORDER BY `$tabla7`.`Fecha` DESC";
        $resultado = mysqli_query($conexion, $consulta);

        //echo $consulta;

        // Arrays para almacenar los datos del gráfico
        $labels = array();
        $data = array();

        // Obtener los datos de la consulta y almacenarlos en los arrays
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $labels[] = $fila['Fecha'];
            $data[] = $fila['Diferencia'];
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
    ?>

    <script>
        // Obtener los datos del gráfico desde variables PHP
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($data); ?>;

        // Configurar los datos del gráfico
        var datos = {
            labels: labels,
            datasets: [{
                label: 'Diferencia',
                data: data,
                backgroundColor: 'orange', // Color de fondo de las barras
                borderColor: 'black', // Color del borde de las barras
                borderWidth: 1 // Ancho del borde de las barras
            }]
        };

        // Configuración del gráfico
        var opciones = {
            width: 100,
            height: 40
                
        };

        // Obtener el lienzo del gráfico y crear el gráfico de barras
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: datos,
            options: opciones
        });
    </script>
</body>
</html>