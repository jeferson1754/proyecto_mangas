<!--ventana para Update--->
<div class="modal fade" id="edit-dif<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          ¿Realmente desea editar el registro de diferencia?
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <style>
        .div1 {
          text-align: center;
        }
      </style>


      <form method="POST" action="recib_Edit-Dif.php">

        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="hidden" name="ID_Manga" value="<?php echo $mostrar['ID_Manga']  ?>">
        <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $mostrar['ID_Manga']  ?>">

        <div class="modal-body div1" id="cont_modal">

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Fecha de Registro</label>
            <input type="datetime-local" id="fecha_actual" name="fecha_actual" class="form-control" value="<?php echo $mostrar['Fecha']; ?>">

            <?php //echo $fecha_actual; 
            ?>
          </div>

          <?php
          $sql3 = "SELECT ID FROM `diferencias` where ID_Manga = '$variable' ORDER BY `diferencias`.`ID` ASC LIMIT 1";
          //echo $sql3;
          //echo "<br>";

          $result3 = mysqli_query($conexion, $sql3);
          while ($mostrar = mysqli_fetch_array($result3)) {
            $ID_Menor = $mostrar[$fila7];
          }

          $sql2 = "SELECT * FROM `diferencias` where ID < '$id' AND ID_Manga = '$variable' ORDER BY `diferencias`.`ID` DESC LIMIT 1";
          $result2 = mysqli_query($conexion, $sql2);
          //echo $sql2;

          while ($mostrar = mysqli_fetch_array($result2)) {
            $fecha_anterior = $mostrar[$titulo4];
          }

          if ($id > $ID_Menor) {
          ?>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Fecha de Anterior Registro</label>
              <input type="datetime" disabled="disabled" class="form-control" value="<?php echo $fecha_anterior ?>">

            </div>
            <input type="hidden" id="fecha_antigua" name="fecha_antigua" value="<?php echo $fecha_anterior ?>">
          <?php
          } else {
          ?>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Fecha de Anterior Registro</label>
              <input type="date" id="fecha_antigua" name="fecha_antigua" class="form-control" min="01-01-2000 00:00:01">
            </div>
          <?php
          }

          ?>



        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Editar</button>
        </div>
      </form>

    </div>
  </div>
</div>