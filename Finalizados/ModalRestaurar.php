<!-- Modal mejorado -->
<div class="modal fade" id="resta<?php echo $mostrar[$fila7]; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">
          Confirmar Restauración
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="recib_Restaurar.php">
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="modulo" value="<?php echo $mostrar[$fila16]; ?>">
        <input type="hidden" name="id_manga" value="<?php echo $mostrar[$fila14]; ?>">

        <div class="modal-body">
          <div class="text-center mb-4">
            <div class="detail-title fw-bold">Nombre:</div>
            <div class="detail-value"><?php echo $mostrar[$fila1]; ?></div>

            <div class="detail-title fw-bold">Estado:</div>
            <div class="detail-value"><?php echo $mostrar[$fila8]; ?></div>

            <div class="detail-title fw-bold">Lista:</div>
            <div class="detail-value"><?php echo $mostrar[$fila6]; ?></div>

            <div class="detail-title fw-bold">Módulo:</div>
            <div class="detail-value"><?php echo $mostrar[$fila16]; ?></div>
          </div>

          <div class="alert alert-info text-center" role="alert">
            ¿Estás seguro que deseas restaurar este elemento?
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-undo-alt me-2"></i>Restaurar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>