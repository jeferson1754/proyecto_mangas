<!--ventana para Update--->
<div class="modal fade" id="resta<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          ¿Realmente deseas restaurar a ?
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


      <form method="POST" action="recib_Restaurar.php">
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="name" value="<?php echo $mostrar[$fila1]; ?>">
        <input type="hidden" name="id_manga" value="<?php echo $mostrar[$fila14]; ?>">

        <div class="modal-body div1" id="cont_modal">

          <h1 class="modal-title">
            <?php echo $mostrar[$fila1]; ?>
          </h1>
          <h2 class="modal-title">
            <?php echo $mostrar[$fila8]; ?>
          </h2>
          <h2 class="modal-title">
            <?php echo $mostrar[$fila6]; ?>
          </h2>
          <h2 class="modal-title">
            Modulo:<?php echo $mostrar[$fila16]; ?>
          </h2>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Restaurar</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->