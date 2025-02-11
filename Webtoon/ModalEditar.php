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


      <form method="POST" action="recib_Update.php">
        <?php include('regreso-modal.php');  ?>
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">

        <div class="modal-body" id="cont_modal">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila1 ?></label>
            <input type="text" name="fila1" class="form-control" value="<?php echo $mostrar[$fila1]; ?>" required="true">
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
              $query = $conexion->query("SELECT * FROM estado;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
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

          <?php
          // La variable que contiene los días seleccionados
          $seleccionados = $mostrar[$fila6];

          // Convertir la cadena en un arreglo de días
          $seleccionadosArray = explode(", ", $seleccionados);

          // Los días de la semana para los checkboxes

          ?>

          <div class="form-group">
            <div class="form-group">
              <label for="recipient-name" class="col-form-label"><?php echo $fila6 ?></label>
              <div class="grid-container">
                <?php
                // Mostrar los checkboxes para cada día
                foreach ($dias as $dia) {
                ?>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check_<?php echo $dia ?>_<?php echo $mostrar[$fila7]; ?>" name="check_lista[]" value="<?php echo $dia ?>"
                      <?php
                      // Verificar si el día está en el arreglo de días seleccionados
                      if (in_array($dia, $seleccionadosArray)) {
                        echo 'checked';  // Marcar el checkbox si el día está en la lista de seleccionados
                      }
                      ?>>
                    <label class="form-check-label" for="check_<?php echo $dia ?>_<?php echo $mostrar[$fila7]; ?>">
                      <?php echo $dia ?>
                    </label>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>


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