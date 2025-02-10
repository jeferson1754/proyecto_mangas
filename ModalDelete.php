<!-- Modal de eliminación -->
<div class="modal fade" id="delete<?php echo $mostrar[$fila7]; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="deleteModalLabel">
          Confirmar Eliminación
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="recib_Delete.php" method="POST">
        <?php include('regreso-modal.php');  ?>
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="name" value="<?php echo $mostrar[$fila1]; ?>">

        <div class="modal-body text-center py-4">
          <div class="mb-4">
            <h4 class="fs-3 fw-bold text-dark mb-3">
              <?php echo $mostrar[$fila1]; ?>
            </h4>

            <span class="badge bg-primary bg-gradient p-2 px-3 fs-6 mb-3">
              <?php echo $mostrar[$fila8]; ?>
            </span>

            <div class="mt-2">
              <span class="badge bg-success p-2">
                <?php echo $mostrar[$fila6]; ?>
              </span>
            </div>
          </div>

          <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Selecciona una opción para continuar
          </div>
        </div>

        <div class="modal-footer flex-column border-top-0">

          <button type="submit" name="Pendientes" class="btn btn-warning btn-lg w-100 mx-0 mb-2">
            <i class="fas fa-clock me-2"></i>
            Borrar de Tachiyomi y Manga, Mover a Pendientes
          </button>

          <button type="submit" name="Finalizados" class="btn btn-danger btn-lg w-100 mx-0">
            <i class="fas fa-trash-alt me-2"></i>
            Borrar de Tachiyomi y Mangas, Mover a Finalizados
          </button>
        </div>
      </form>
    </div>
  </div>
</div>