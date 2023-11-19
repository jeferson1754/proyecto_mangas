<?php

require 'bd.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">


    <title>Horario Webtoon
    </title>
</head>
<style>
    .main-container {
        max-width: 600%;
        margin: 30px 20px;
    }

    table {
        width: 100%;
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

    .auto-style3 {
        width: 96px;
        background-color: #E9BCAC;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 32px
    }

    .auto-style4 {
        text-align: center;
        width: 151px;
        font-size: 16px
    }

    .auto-style6 {
        position: relative;
        width: 100%;
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
        left: 0px;
        top: -70px;
        text-align: center;
        height: 1365px;
        padding-left: 15px;
        padding-right: 15px;
    }

    .auto-style8 {
        text-align: center;
        width: 154px;
        height: 46px;
    }

    .auto-style9 {
        width: 50px;
        height: 50px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 32px
    }

    .auto-style11 {
        text-align: center;


    }

    .esquina-superior-izquierda {
        position: absolute;
        top: 0;
        left: 0;
        margin-top: 5px;
        /* Ajusta el valor según sea necesario */
        margin-left: 10px;
        /* Ajusta el valor según sea necesario */
    }

    .auto-style12 {
        position: absolute;
        top: -7px;
        right: 14px;
        margin-top: 5px;
        /* Ajusta el valor según sea necesario */
        ;
        margin-right: 10px;
        width: 180px;
    }

    .auto-style13 {
        position: absolute;
        top: 0;
        left: 19px;
        margin-top: 5px;
        /* Ajusta el valor según sea necesario */
        ;
        margin-left: 10px;
        /* Ajusta el valor según sea necesario */
    }

    .auto-style14 {
        display: inline-block;
        margin-right: 5px;
        /* Ajusta el valor según sea necesario */
    }

    .auto-style15 {
        width: 748px;
        display: inline-block;
        margin-right: 20px;
        height: 35px;
    }

    .auto-style16 {
        height: 1257px;
    }
</style>

<body>

    <?php
    include('../menu.php');

    $num = "SELECT * FROM `num_horario` ORDER BY `num_horario`.`Num` DESC Limit 1";
    $result2     = mysqli_query($conexion, $num);

    while ($mostrar = mysqli_fetch_array($result2)) {

        $temp = $mostrar['Temporada'];
        $ano = $mostrar['Ano'];
    }

    $mayusculas = strtoupper($temp);
    ?>

    <div class="col-sm">

        <!--- Formulario para registrar Cliente --->
        <div class="auto-style12" style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 22px; font-weight: bold;"><?php echo $ano . " " . $mayusculas; ?></div>
        <div class="auto-style11"><span style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 62px; ">HORARIO DE WEBTOON</span></div>
    </div>

    <div class="main-container">

        <table>
            <thead>

            </thead>
            <?php

            $name1 = "SELECT Nombre,`Dias Emision` from `webtoon` where Estado='Emision' and `Dias Emision`='Lunes' ORDER BY LENGTH(Nombre) DESC;";
            $name2 = "SELECT Nombre,`Dias Emision` from `webtoon` where Estado='Emision' and `Dias Emision`='Martes' ORDER BY LENGTH(Nombre) DESC;";
            $name3 = "SELECT Nombre,`Dias Emision` from `webtoon` where Estado='Emision' and `Dias Emision`='Miercoles' ORDER BY LENGTH(Nombre) DESC;";
            $name4 = "SELECT Nombre,`Dias Emision` from `webtoon` where Estado='Emision' and `Dias Emision`='Jueves' ORDER BY LENGTH(Nombre) DESC;";
            $name5 = "SELECT Nombre,`Dias Emision` from `webtoon` where Estado='Emision' and `Dias Emision`='Viernes' ORDER BY LENGTH(Nombre) DESC;";
            $name6 = "SELECT Nombre,`Dias Emision` from `webtoon` where Estado='Emision' and `Dias Emision`='Sabado' ORDER BY LENGTH(Nombre) DESC;";
            $name7 = "SELECT Nombre,`Dias Emision` from `webtoon` where Estado='Emision' and `Dias Emision`='Domingo' ORDER BY LENGTH(Nombre) DESC;";

            $result1     = mysqli_query($conexion, $name1);
            $result2     = mysqli_query($conexion, $name2);
            $result3     = mysqli_query($conexion, $name3);
            $result4     = mysqli_query($conexion, $name4);
            $result5     = mysqli_query($conexion, $name5);
            $result6     = mysqli_query($conexion, $name6);
            $result7     = mysqli_query($conexion, $name7);

            $sql2 = ("SELECT COUNT(`Dias Emision`),`Dias Emision` FROM webtoon where `Dias Emision`='Lunes' and Estado='Emision';");
            $sql3 = ("SELECT COUNT(`Dias Emision`),`Dias Emision` FROM webtoon where `Dias Emision`='Martes' and Estado='Emision';");
            $sql4 = ("SELECT COUNT(`Dias Emision`),`Dias Emision` FROM webtoon where `Dias Emision`='Miercoles' and Estado='Emision';");
            $sql5 = ("SELECT COUNT(`Dias Emision`),`Dias Emision` FROM webtoon where `Dias Emision`='Jueves' and Estado='Emision';");
            $sql6 = ("SELECT COUNT(`Dias Emision`),`Dias Emision` FROM webtoon where `Dias Emision`='Viernes' and Estado='Emision';");
            $sql7 = ("SELECT COUNT(`Dias Emision`),`Dias Emision` FROM webtoon where `Dias Emision`='Sabado' and Estado='Emision';");
            $sql8 = ("SELECT COUNT(`Dias Emision`),`Dias Emision` FROM webtoon where `Dias Emision`='Domingo' and Estado='Emision';");

            $lunes      = mysqli_query($conexion, $sql2);
            $domingo    = mysqli_query($conexion, $sql3);
            $martes     = mysqli_query($conexion, $sql4);
            $miercoles  = mysqli_query($conexion, $sql5);
            $jueves     = mysqli_query($conexion, $sql6);
            $viernes    = mysqli_query($conexion, $sql7);
            $sabado     = mysqli_query($conexion, $sql8);

            $COUNT = ("SELECT COUNT(*) AS Total_Registros FROM webtoon WHERE Estado='Emisión' and `Dias Emision`!='Indefinido';");

            $total_webtoon      = mysqli_query($conexion, $COUNT);


            while ($mostrar = mysqli_fetch_array($total_webtoon)) {

                $final_webtoon = $mostrar['0'];
            }


            //echo $sql2;
            //echo $name1;

            //Lunes
            while ($mostrar = mysqli_fetch_array($result1)) {
                while ($l = mysqli_fetch_array($lunes)) {

            ?>


                    <tr>
                        <td rowspan="<?php echo $l['0'] ?>" class="auto-style3">
                            <div class="auto-style8"><?php echo $l['1'] ?>
                            </div>
                        </td>
                    <?php
                }
                    ?>
                    <td><?php echo $mostrar['Nombre'] ?></td>
                    </tr>



                    <?php

                } //Fin Lunes

                //Martes


                while ($mostrar = mysqli_fetch_array($result3)) {
                    while ($ma = mysqli_fetch_array($martes)) {
                        $colum1 = $ma[0];

                    ?>


                        <tr>
                            <td rowspan="<?php echo $ma['0'] ?>" class="auto-style9" style="background-color: #B9CDD9">
                                <div class="auto-style8"><?php echo $ma['1'] ?></div>
                            </td>
                        <?php
                    }
                        ?>
                        <td><?php echo $mostrar['Nombre'] ?></td>
                        </tr>

                    <?php
                } //Fin Martes

                    ?>


                    <?php

                    //Miercoles

                    while ($mostrar = mysqli_fetch_array($result4)) {
                        while ($mi = mysqli_fetch_array($miercoles)) {
                    ?>


                            <tr>
                                <td rowspan="<?php echo $mi['0'] ?>" class="auto-style3" style="background-color: #EBC6C8">
                                    <div class="auto-style8"><?php echo $mi['1'] ?></div>

                                </td>
                            <?php
                        }

                            ?>
                            <td><?php echo $mostrar['Nombre'] ?></td>

                            </tr>



                            <?php

                        } //Fin Miercoles

                        //Jueves
                        while ($mostrar = mysqli_fetch_array($result5)) {
                            while ($j = mysqli_fetch_array($jueves)) {
                            ?>


                                <tr>
                                    <td rowspan="<?php echo $j['0'] ?>" class="auto-style3" style="background-color: #E4B1C2">
                                        <div class="auto-style8"><?php echo $j['1'] ?></div>
                                    </td>
                                <?php
                            }
                                ?>
                                <td><?php echo $mostrar['Nombre'] ?></td>
                                </tr>



                                <?php

                            } //Fin Jueves


                            //Viernes
                            while ($mostrar = mysqli_fetch_array($result6)) {
                                while ($v = mysqli_fetch_array($viernes)) {
                                ?>


                                    <tr>
                                        <td rowspan="<?php echo $v['0'] ?>" class="auto-style3" style="background-color: #BFD5FD">
                                            <div class="auto-style8"><?php echo $v['1'] ?></div>
                                        </td>
                                    <?php
                                }
                                    ?>
                                    <td><?php echo $mostrar['Nombre'] ?></td>
                                    </tr>



                                    <?php

                                } //Fin Viernes

                                //Sabado
                                while ($mostrar = mysqli_fetch_array($result7)) {
                                    while ($s = mysqli_fetch_array($sabado)) {
                                    ?>


                                        <tr>
                                            <td rowspan="<?php echo $s['0'] ?>" class="auto-style3" style="background-color: #75E7FD">
                                                <div class="auto-style8"><?php echo $s['1'] ?></div>
                
                                            </td>
                                        <?php
                                    }
                                        ?>
                                        <td><?php echo $mostrar['Nombre'] ?></td>
                                        </tr>



                                        <?php

                                    } //Fin Sabado

                                    //Domingo
                                    while ($mostrar = mysqli_fetch_array($result2)) {
                                        while ($d = mysqli_fetch_array($domingo)) {
                                        ?>

                                            <tr>
                                                <td rowspan="<?php echo $d['0'] ?>" class="auto-style3" style="background-color: #E1FDD1">
                                                    <div class="auto-style8"><?php echo $d['1'] ?></div>
                
                                                </td>
                                            <?php
                                        }
                                            ?>
                                            <td><?php echo $mostrar['Nombre'] ?></td>
                                            </tr>

                                        <?php

                                    } //Fin Domingo

                                        ?>
        </table>
    </div>
    <div style="text-align: center;">
        <h2 class="auto-style14">Total Webtoon Semana : <?php echo $final_webtoon ?> </h2>
    </div>
    <br>
    <br>
</body>
<?php
$conexion = null;
?>

</html>