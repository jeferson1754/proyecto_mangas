<!-- Modal for Episode Update -->
<div class="modal fade" id="caps<?php echo $mostrar[$fila7]; ?>"
  tabindex="-1"
  role="dialog"
  aria-labelledby="episodeUpdateModal"
  aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="episodeUpdateModal">
          Actualizar Episodios Vistos
        </h5>
        <button type="button"
          class="btn-close"
          data-dismiss="modal"
          aria-label="Cerrar">
        </button>
      </div>

      <!-- Modal Body -->
      <form method="POST"
        action="recib_Update-Cap.php"
        class="needs-validation"
        id="modal_caps<?php echo $mostrar[$fila7]; ?>"
        novalidate>

        <!-- Hidden Fields -->
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="nombre" value="<?php echo $mostrar[$fila1]; ?>">
        <input type="hidden" name="capitulos" value="<?php echo $mostrar[$fila3]; ?>">

        <?php include('regreso-modal.php'); ?>

        <div class="modal-body">
          <div class="text-center mb-4">
            <h4 class="text-primary mb-3">
              <?php echo $mostrar[$fila1]; ?></h4>
            <div class="badge bg-info mb-2">
              <?php echo $mostrar[$fila8]; ?>
            </div>

            <div class="row mt-3">
              <div class="col">
                <div class="card bg-light">
                  <div class="card-body">
                    <h6>Episodios Vistos</h6>
                    <span class="h4"> <?php echo $mostrar[$fila3]; ?></span>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card bg-light">
                  <div class="card-body">
                    <h6>Total Episodios</h6>
                    <span class="h4"><?php echo $mostrar[$fila4]; ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group mt-4">
              <label for="episodesWatched" class="form-label">
                Actualizar Episodios Vistos
              </label>
              <div class="input-group">
                <input type="number"
                  id="episodesWatched<?php echo $mostrar[$fila7]; ?>"
                  name="vistos"
                  class="form-control text-center"
                  min="1"
                  value="<?php echo $capi; ?>"
                  max="<?php echo $mostrar[$fila5]; ?>"
                  required>
                <div id="vistosError<?php echo $mostrar[$fila7]; ?>" class="invalid-feedback">
                  Por favor ingrese un número válido de episodios
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button"
            class="btn btn-outline-secondary"
            data-dismiss="modal">
            Cancelar
          </button>
          <button type="submit"
            class="btn btn-primary">
            Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .modal-dialog-centered {
    display: flex;
    align-items: center;
    min-height: calc(100% - 1rem);
  }

  .badge {
    font-size: 1rem;
    padding: 0.5rem 1rem;
  }

  .form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
  }

  .card {
    transition: transform 0.2s;
  }

  .card:hover {
    transform: translateY(-2px);
  }
</style>

<script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Seleccionar todos los formularios que tienen la clase `needs-validation`
      const forms = document.querySelectorAll('.needs-validation');

      forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
          // Prevenir el envío si el formulario es inválido
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }

          // Agregar la clase 'was-validated' para aplicar los estilos
          form.classList.add('was-validated');

          // Función para manejar la validación de campos
          function validarCampo(inputId, errorId) {
            const input = document.getElementById(inputId);
            const errorMessage = document.getElementById(errorId);

            if (input && errorMessage) { // Verificar que los elementos existan
              // Mostrar u ocultar el mensaje de error según la validez del campo
              errorMessage.style.display = input.validity.valid ? "none" : "block";
            }
          }

          // Obtener el ID dinámico del formulario actual
          const formId = form.getAttribute('id').replace('modal_caps', '');

          validarCampo(`episodesWatched${formId}`, `vistosError${formId}`);
        }, false);
      });
    }, false);
  })();
</script>