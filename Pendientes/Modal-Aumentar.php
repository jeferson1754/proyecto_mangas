<!--ventana para Update--->
<div class="modal fade" id="aumentar<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          ¿Realmente desea aumentar el numero del total?
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

     
      <form method="POST" action="recib_Update-Aumentar.php">
        <?php include('regreso-modal.php');  
            $total= $mostrar[$fila4];   
            $valor = $total + 1;
        ?>
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="nombre" value="<?php echo $mostrar[$fila1]; ?>">
        <input type="hidden" name="capitulos" value="<?php echo $mostrar[$fila3]; ?>">
        <input type="hidden" name="fecha" value="<?php echo $mostrar[$fila10]; ?>">
        <input type="hidden" name="cantidad" value="<?php echo $mostrar[$titulo3]; ?>">


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
            <label for="recipient-name" class="col-form-label">N° Capitulos Totales:</label>
            <input type="number" name="total" class="form-control-number" min="<?php echo $mostrar[$fila4]; ?>" value="<?php echo $valor; ?>" required="true">
          </div>
           <div class="form-group">
            <label for="recipient-name" class="col-form-label">Fecha Actual Cap:</label>
            <input type="date" name="fecha_cap" class="form-control-date"  value="<?php echo $fecha_actual; ?>" max="<?php echo $fecha_futura; ?>" required="true">
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