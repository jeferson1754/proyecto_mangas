<!-- Modal -->
<div class="modal fade" id="new" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalLabel">
          Nuevo <?php echo ucfirst($tabla) ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Form -->
      <form id="my-form" name="form-data" action="recibCliente.php" method="POST">
        <?php include('regreso-modal.php'); ?>

        <div class="modal-body">
          <div class="row g-3">
            <!-- Personal Information Section -->
            <div class="col-12">
              <div class="form-floating mb-3">
                <input type="text" name="fila1" class="form-control" id="floatingFila1" required>
                <label for="floatingFila1"><?php echo $fila1 ?></label>
              </div>
            </div>

            <div class="col-12">
              <div class="form-floating mb-3">
                <input type="text" name="fila2" class="form-control" id="floatingFila2">
                <label for="floatingFila2"><?php echo $fila2 ?></label>
              </div>
            </div>

            <!-- Numeric Inputs Section -->
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input class="form-control" id="vistos" name="fila3" type="number" oninput="actualizarValorcapitulos()" required>
                <label for="vistos"><?php echo $fila3 ?></label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input class="form-control" id="total" name="fila4" type="number" required>
                <label for="total"><?php echo $fila4 ?></label>
              </div>
            </div>

            <!-- Dropdowns Section -->
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <select name="fila8" class="form-select" id="floatingFila8" required>
                  <option value="Emision">Emision</option>
                  <?php
                  $query = $conexion->query("SELECT * FROM $tabla3;");
                  while ($valores = mysqli_fetch_array($query)) {
                    echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
                  }
                  ?>
                </select>
                <label for="floatingFila8"><?php echo $fila8 ?></label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating mb-3">
                <select name="fila6" class="form-select" id="floatingFila6" required>
                  <option value="Sin Lista">Sin Lista</option>
                  <?php
                  $query = $conexion->query("SELECT * FROM $tabla2;");
                  while ($valores = mysqli_fetch_array($query)) {
                    echo '<option value="' . $valores[$fila1] . '">' . $valores[$fila1] . '</option>';
                  }
                  ?>
                </select>
                <label for="floatingFila6"><?php echo $fila6 ?></label>
              </div>
            </div>

            <!-- Date Inputs Section -->
            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input type="date" id="date1" name="fila10" class="form-control" value="<?php echo $fecha_actual; ?>" required>
                <label for="date1">Fecha Ultima</label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input type="date" id="date2" name="fila11" class="form-control" value="<?php echo $fecha_actual; ?>" max="<?php echo $fecha_actual; ?>" required>
                <label for="date2">Fecha Penultima</label>
              </div>
            </div>

            <!-- Checkbox Section -->
            <div class="col-12">
              <div class="form-check form-switch" style="margin-left: 120px;">
                <input class="form-check-input" type="checkbox" name="Anime" value="SI" id="animeCheck" style="transform: scale(1.5);">
                <label class="form-check-label ms-2" for="animeCheck">¿Tiene Anime?</label>
              </div>

            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">
            Registrar <?php echo ucfirst($tabla) ?>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>