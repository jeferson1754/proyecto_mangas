<!-- Modal -->
<div class="modal fade" id="new" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalTitle">
          Nuevo <?php echo ucfirst($tabla) ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Form -->
      <form name="form-data" action="recibCliente.php" method="POST">
        <?php include('regreso-modal.php');  ?>

        <div class="modal-body">
          <!-- Text Input Fields -->
          <div class="mb-3">
            <label for="fila1" class="form-label"><?php echo $fila1 ?></label>
            <input type="text" class="form-control" id="fila1" name="fila1" required>
          </div>

          <div class="mb-3">
            <label for="fila2" class="form-label"><?php echo $fila2 ?></label>
            <input type="text" class="form-control" id="fila2" name="fila2">
          </div>

          <!-- Number Inputs -->
          <div class="mb-3">
            <label for="municipio" class="form-label"><?php echo $fila3 ?></label>
            <input type="number" class="form-control" id="municipio" name="fila3"
              oninput="actualizarValorMunicipioInm()">
          </div>

          <div class="mb-3">
            <label for="municipio_inm" class="form-label"><?php echo $fila4 ?></label>
            <input type="number" class="form-control" id="municipio_inm" name="fila4">
          </div>

          <!-- Select Field -->
          <div class="mb-3">
            <label for="estado" class="form-label"><?php echo $fila8 ?></label>
            <select class="form-select" id="estado" name="fila8" required>
              <option value="">Seleccione:</option>
              <?php
              $query = $conexion->query("SELECT * FROM estado;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
              }
              ?>
            </select>
          </div>
       
          <!-- Checkbox Group -->
          <div class="mb-3">
            <label class="form-label d-block"><?php echo $fila6 ?></label>
            <div class="grid-container">
              <?php

              foreach ($dias as $dia) {
              ?>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="check_<?php echo $dia ?>" name="check_lista[]" value="<?php echo $dia ?>">
                  <label class="form-check-label" for="check_<?php echo $dia ?>">
                    <?php echo $dia ?>
                  </label>
                </div>
              <?php
              }
              ?>
            </div>
          </div>













        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i>Cerrar
          </button>
          <button type="submit" class="btn btn-primary" id="btnEnviar">
            <i class="bi bi-check-circle me-1"></i>Registrar <?php echo ucfirst($tabla) ?>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  // Initialize all tooltips
  document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  });

  // Función para actualizar el valor del municipio
  function actualizarValorMunicipioInm() {
    const municipio = document.getElementById('municipio');
    const municipioInm = document.getElementById('municipio_inm');
    municipioInm.value = municipio.value;
  }

  // Show success message after form submission
  document.querySelector('form').addEventListener('submit', function(e) {
    const button = document.querySelector('#btnEnviar');
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
  });
</script>