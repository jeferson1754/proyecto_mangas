<div class="modal fade" id="caps<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="episodeUpdateModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg border-0 rounded-lg">
      <div class="modal-header bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
        <div class="d-flex align-items-center">
          <i class="fas fa-tv me-2"></i>
          <h5 class="modal-title fw-bold">Actualizar Episodios Vistos</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form method="POST" action="recib_Update-Cap.php" class="needs-validation" id="modal_caps<?php echo $mostrar[$fila7]; ?>" novalidate>
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="nombre" value="<?php echo $mostrar[$fila1]; ?>">
        <input type="hidden" name="capitulos" value="<?php echo (float)$mostrar[$fila3]; ?>">
        <?php include('regreso-modal.php');
        // Limpiamos decimales para la vista
        $vistos_view = (float)$mostrar[$fila3];
        $total_view = (float)$mostrar[$fila4];
        ?>

        <div class="modal-body p-4">
          <div class="text-center">
            <h4 class="fs-3 fw-bold text-dark mb-3"><?php echo $mostrar[$fila1]; ?></h4>
            <span class="badge bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-4 py-2 rounded-pill fs-6 mb-4">
              <?php echo $mostrar[$fila8]; ?>
            </span>

            <div class="row g-4 mt-2">
              <div class="col-6">
                <div class="card border-0 bg-light hover-shadow transition-all h-100">
                  <div class="card-body p-3">
                    <i class="fas fa-eye text-primary mb-2 fs-4"></i>
                    <h6 class="text-muted small mb-1">Actualmente Vistos</h6>
                    <div class="fs-4 fw-bold text-dark"><?php echo $vistos_view; ?></div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card border-0 bg-light hover-shadow transition-all h-100">
                  <div class="card-body p-3">
                    <i class="fas fa-list-ol text-primary mb-2 fs-4"></i>
                    <h6 class="text-muted small mb-1">Total de la Obra</h6>
                    <div class="fs-4 fw-bold text-dark"><?php echo $total_view; ?></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-4">
              <label class="form-label fw-bold mb-2">¿Cuántos has visto en total?</label>
              <div class="input-group">
                <input type="number"
                  id="episodesWatched<?php echo $mostrar[$fila7]; ?>"
                  name="vistos"
                  class="form-control text-center fw-bold fs-5"
                  step="any"
                  min="0"
                  value="<?php echo $capi; ?>"
                  max="<?php echo $total_view; ?>"
                  required>
              </div>
              <small class="text-muted d-block mt-2">Puedes ingresar decimales (ej. 191.5)</small>
              <div id="vistosError<?php echo $mostrar[$fila7]; ?>" class="invalid-feedback">
                El número no puede ser mayor al total (<?php echo $total_view; ?>)
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-light fw-medium" data-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary fw-medium px-4">
            <i class="fas fa-save me-2"></i>Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>