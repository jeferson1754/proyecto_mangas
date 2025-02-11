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
      <!-- Form -->
      <form name="form-data" action="recibCliente.php" method="POST">
        <?php include('regreso-modal.php');  ?>

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

            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input class="form-control" id="municipio" name="fila3" type="number" oninput="actualizarValorMunicipioInm()" required>
                <label for="vistos"><?php echo $fila3 ?></label>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-floating mb-3">
                <input class="form-control" id="municipio_inm" name="fila4" type="number" required>
                <label for="municipio_inm"><?php echo $fila4 ?></label>
              </div>
            </div>

            <!-- Dropdowns Section -->
            <div class="col-md-12">
              <div class="form-floating mb-3">
                <select name="fila8" class="form-select" id="floatingFila8" required>
                  <option value="">Seleccione</option>
                  <?php
                  $query = $conexion->query("SELECT * FROM estado;");
                  while ($valores = mysqli_fetch_array($query)) {
                    echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
                  }
                  ?>
                </select>
                <label for="floatingFila8"><?php echo $fila8 ?></label>
              </div>
            </div>

            <!-- Checkbox Group -->
            <div class="col-md-12">
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