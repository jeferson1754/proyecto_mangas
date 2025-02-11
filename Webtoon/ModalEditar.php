<div class="modal fade" id="edit<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0 shadow-lg rounded-lg">
      <div class="modal-header bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <h5 class="modal-title d-flex align-items-center fw-bold">
          <i class="fas fa-edit me-2"></i>Actualizar Webtoon
        </h5>
        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="recib_Update.php">
        <?php include('regreso-modal.php');  ?>
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">

        <div class="modal-body p-4">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila1 ?></label>
            <input type="text" name="fila1" class="form-control" value="<?php echo $mostrar[$fila1]; ?>" required="true">
          </div>
          <div class="row g-3">
            <!-- Autor -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila2 ?></label>
                <input type="text" name="fila2" class="form-control" value="<?php echo $mostrar[$fila2]; ?>">
              </div>
            </div>

            <!-- Estado Link -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $titulo1 ?></label>
                <select name="fila13" class="form-select" required>
                  <?php
                  $query = "SELECT $fila8 FROM `$tabla6`;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (empty($mostrar[$fila13])) {
                    echo "<option value=''>Selecciona un Estado Link</option>";
                  }

                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado[$fila8]}' " .
                        ($estado[$fila8] === $mostrar[$fila13] ? 'selected' : '') .
                        ">{$estado[$fila8]}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <!-- Capítulos -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila3 ?></label>
                <input type="number" name="fila3" class="form-control" value="<?php echo $mostrar[$fila3]; ?>">
              </div>
            </div>

            <!-- Total -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila4 ?></label>
                <input type="number" name="fila4" class="form-control" value="<?php echo $mostrar[$fila4]; ?>">
              </div>
            </div>

            <!-- Estado -->
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila8 ?></label>
                <select name="fila8" class="form-select" required>
                  <?php
                  $query = "SELECT * FROM estado;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (empty($mostrar[$fila8])) {
                    echo "<option value=''>Selecciona un estado</option>";
                  }

                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado['Estado']}' " .
                        ($estado['Estado'] === $mostrar[$fila8] ? 'selected' : '') .
                        ">{$estado['Estado']}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>


          <?php
          // La variable que contiene los días seleccionados
          $seleccionados = $mostrar[$fila6];

          // Convertir la cadena en un arreglo de días
          $seleccionadosArray = explode(", ", $seleccionados);

          // Los días de la semana para los checkboxes

          ?>

            <div class="form-group">
              <label class="form-label fw-bold"><?php echo $fila6 ?></label>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->