<!--ventana para Update--->
<div class="modal fade" id="caps<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          ¿Realmente desea aumentar el numero de capitulos vistos ?
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


      <form method="POST" action="recib_Update-Cap.php">

        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="nombre" value="<?php echo $mostrar[$fila1]; ?>">
        <input type="hidden" name="capitulos" value="<?php echo $mostrar[$fila3]; ?>">
        <input type="hidden" name="id_manga" value="<?php echo $mostrar[$fila9]; ?>">
         <?php include('regreso-modal.php');  ?>


        <div class="modal-body div1" id="cont_modal">

          <h1 class="modal-title">
            <?php echo $mostrar[$fila1]; ?>
          </h1>
          <h2 class="modal-title">
            <?php echo $mostrar[$fila8]; ?>
          </h2>
          <h2 class="modal-title">
            Vistos:
            <?php echo $mostrar[$fila3]; ?>
          </h2>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">N° Capitulos Vistos:</label>
            <input type="number" name="vistos" class="form-control-number" min="1" value="<?php echo $capi; ?>" max="<?php echo $mostrar[$fila5]; ?>" required="true">
          </div>
          <h2 class="modal-title">
            Total:
            <?php echo $mostrar[$fila4]; ?>
          </h2>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!---fin ventana Update --->