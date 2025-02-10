<div class="modal fade" id="edit<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0 shadow-lg rounded-lg">
      <div class="modal-header bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <h5 class="modal-title d-flex align-items-center fw-bold">
          <i class="fas fa-edit me-2"></i>Actualizar Manga
        </h5>
        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
      </div>


      <form method="POST" action="recib_Update.php" id="mi-formulario">

        <?php
        include('regreso-modal.php');

        // No borrar da el nombre
        $query1 = "SELECT * FROM `$tabla` where ID='$mostrar[$fila7]'";
        $result1 = mysqli_query($conexion, $query1);
        $row1 = mysqli_fetch_assoc($result1);
        //echo $link;
        ?>

        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="id_manga" value="<?php echo $mostrar[$fila9]; ?>">


        <style>
          textarea {
            width: 100% !important;
            /* Ancho fijo */
            height: auto;
            /* Altura automática */
          }
        </style>

        <div class="modal-body" id="cont_modal">
          <div class="mb-4">
            <label class="form-label fw-bold"><?php echo $fila1 ?></label>
            <div class="input-group">
              <textarea name="fila1" id="inputarea<?php echo $mostrar[$fila7]; ?>"
                class="form-control border-end-0 rounded-start"><?php echo htmlspecialchars($mostrar[$fila1]); ?></textarea>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila2 ?></label>
                <input type="text" name="fila2" class="form-control" value="<?php echo $mostrar[$fila2]; ?>">
              </div>
            </div>

            <!-- Estado Link -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $titulo3 ?></label>
                <select name="fila10" class="form-select" required>
                  <?php
                  $query = "SELECT $fila8 FROM $tabla5;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (empty($mostrar[$fila10])) {
                    echo "<option value=''>Selecciona un Estado Link</option>";
                  }

                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado[$fila8]}' " .
                        ($estado[$fila8] === $mostrar[$fila10] ? 'selected' : '') .
                        ">{$estado[$fila8]}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila8 ?></label>
                <select name="fila8" class="form-select" required>
                  <?php
                  $query = "SELECT * FROM $tabla3;";
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
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila6 ?></label>
                <select name="fila6" class="form-select" required>
                  <?php
                  $query = "SELECT * FROM $tabla4;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (empty($mostrar[$fila6])) {
                    echo "<option value=''>Selecciona una Lista</option>";
                  }

                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado[$fila1]}' " .
                        ($estado[$fila1] === $mostrar[$fila1] ? 'selected' : '') .
                        ">{$estado[$fila1]}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer border-top">
          <button type="button" class="btn btn-light" data-dismiss="modal">
            <i class="fas fa-times me-2"></i>Cerrar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Guardar Cambios
          </button>
        </div>
    </div>
    </form>


  </div>
</div>
</div>

<!---fin ventana Update --->