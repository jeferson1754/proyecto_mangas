<div class="modal fade" id="edit<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          Actualizar Información
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <form method="POST" action="recib_Update.php" id="mi-formulario">
<?php
 include('regreso-modal.php'); 
    
    // No borrar da el nombre
    $query1 = "SELECT * FROM `manga` where ID='$mostrar[$fila7]'";
    $result1 = mysqli_query($conexion, $query1);
    $row1 = mysqli_fetch_assoc($result1);




 //echo $link;
        ?>

        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
<style>
    textarea {
        width: 460px; /* Ancho fijo */
        height: auto; /* Altura automática */
    }
</style>
        <div class="modal-body" id="cont_modal">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila1 ?></label>

             <textarea name="fila1" class="form-control" rows="3" cols="50" required="true"><?php echo $row1['Nombre']; ?></textarea>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila2 ?></label>
            <input type="text" name="fila2" class="form-control" value="<?php echo $mostrar[$fila2]; ?>">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila3 ?></label>
            <input type="number" name="fila3" class="form-control" value="<?php echo $mostrar[$fila3]; ?>">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila4 ?></label>
            <input type="number" name="fila4" class="form-control" value="<?php echo $mostrar[$fila4]; ?>">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila8 ?></label>
            <select name="fila8" class="form-control" required>
              <option value="<?php echo $mostrar[$fila8]; ?>"><?php echo $mostrar[$fila8]; ?></option>
              <?php
              $query = $conexion->query("SELECT * FROM $tabla3;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila6 ?></label>
            <select name="fila6" class="form-control" required>
              <option value="<?php echo $mostrar[$fila6]; ?>"><?php echo $mostrar[$fila6]; ?></option>
              <?php
              $query = $conexion->query("SELECT * FROM $tabla2;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila1] . '">' . $valores[$fila1] . '</option>';
              }
              ?>
            </select>
          </div>
            <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $titulo1 ?></label>
            <select name="fila13" class="form-control">
                <option value="<?php echo $mostrar[$fila13]; ?>"><?php echo $mostrar[$fila13]; ?></option>
              <?php
              $query = $conexion->query("SELECT $fila8 FROM `$tabla6`;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
              }
              ?>
            </select>
            </div>
            
            <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $titulo2 ?></label>
            <input type="date" id="date1" name="fila10" class="form-control" value="<?php echo $mostrar[$fila10]; ?>">
            <!--<input type="date" id="date1" name="fila10" class="form-control" value="<?php echo $fecha_actual; ?>">-->
            <?php //echo $fecha_actual; ?>
          </div>
               
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $titulo5 ?></label>
           <input type="date" id="date2" name="fila11" class="form-control" value="<?php echo $mostrar[$fila11]; ?>">
             <!--<input type="date" id="date2" name="fila11" class="form-control" value="<?php echo $fecha_actual; ?>">-->
            <?php //echo $fecha_actual; ?>
          </div>


        </div>
        
        <div class="modal-footer">
          <button type="button" id="boton-guardar" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </div>
</form>


    </div>
  </div>
</div>

<!---fin ventana Update --->