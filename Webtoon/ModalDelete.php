<div class="modal fade delete-modal" id="delete<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">
          Confirmar Eliminación
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <form method="POST" action="recib_Delete.php">
        <?php include('regreso-modal.php');  ?>
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="nombre" value="<?php echo $mostrar[$fila1]; ?>">

        <div class="modal-body">
          <i class="fas fa-exclamation-triangle warning-icon"></i>

          <h1 class="anime-title">
            <?php echo $mostrar[$fila1]; ?>
          </h1>
          <h2 class="anime-details">
            <?php echo $mostrar[$fila8]; ?>
          </h2>
          <h2 class="anime-details">
            <?php echo $mostrar[$fila6]; ?>
          </h2>
          <p class="mt-4 text-gray-600">
            Esta acción no se puede deshacer.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-cancel" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Cancelar
          </button>
          <button type="submit" class="btn btn-delete">
            <i class="fas fa-trash-alt"></i>
            Eliminar
          </button>
        </div>
      </form>

    </div>
  </div>
</div>