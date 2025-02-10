

<!---fin ventana Update --->

<div class="modal fade" id="caps<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="episodeUpdateModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg border-0 rounded-lg">
      <div class="modal-header bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
        <div class="d-flex align-items-center">
          <i class="fas fa-tv me-2"></i>
          <h5 class="modal-title fw-bold">Actualizar Episodios</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form method="POST" action="recib_Update-Cap.php" class="needs-validation" id="modal_caps<?php echo $mostrar[$fila7]; ?>" novalidate>
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="nombre" value="<?php echo $mostrar[$fila1]; ?>">
        <input type="hidden" name="capitulos" value="<?php echo $mostrar[$fila3]; ?>">
        <input type="hidden" name="id_manga" value="<?php echo $mostrar[$fila9]; ?>">
        <?php include('regreso-modal.php'); ?>

        <div class="modal-body p-4">
          <div class="text-center">
            <h4 class="fs-3 fw-bold text-dark mb-3"><?php echo $mostrar[$fila1]; ?></h4>
            <span class="badge bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-4 py-2 rounded-pill fs-6 mb-4">
              <?php echo $mostrar[$fila8]; ?>
            </span>

            <div class="row g-4 mt-2">
              <div class="col-6">
                <div class="card border-0 bg-light hover-shadow transition-all h-100">
                  <div class="card-body">
                    <i class="fas fa-eye text-primary mb-3 fs-4"></i>
                    <h6 class="text-muted mb-2">Episodios Vistos</h6>
                    <div class="fs-3 fw-bold text-dark"><?php echo $mostrar[$fila3]; ?></div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card border-0 bg-light hover-shadow transition-all h-100">
                  <div class="card-body">
                    <i class="fas fa-list-ol text-primary mb-3 fs-4"></i>
                    <h6 class="text-muted mb-2">Total Episodios</h6>
                    <div class="fs-3 fw-bold text-dark"><?php echo $mostrar[$fila4]; ?></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-4">
              <label class="form-label fw-bold mb-3">Actualizar Episodios Vistos</label>
              <div class="input-group">
                <input type="number"
                  id="episodesWatched<?php echo $mostrar[$fila7]; ?>"
                  name="vistos"
                  class="form-control text-center fw-bold fs-5"
                  min="1"
                  value="1"
                  max="<?php echo $mostrar[$fila5]; ?>"
                  required>
              </div>
              <div id="vistosError<?php echo $mostrar[$fila7]; ?>" class="invalid-feedback">
                Por favor ingrese un número válido de episodios
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-light fw-medium" data-dismiss="modal">
            <i class="fas fa-times me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-primary fw-medium">
            <i class="fas fa-save me-2"></i>Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');

        const formId = form.getAttribute('id').replace('modal_caps', '');
        const input = document.getElementById(`episodesWatched${formId}`);
        const errorElement = document.getElementById(`vistosError${formId}`);

        if (input && errorElement) {
          errorElement.style.display = input.validity.valid ? 'none' : 'block';
        }
      }, false);
    });
  });
</script>