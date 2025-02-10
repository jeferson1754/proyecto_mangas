<!--ventana para Update--->
<div class="modal fade" id="delete<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          ¿Realmente deseas eliminar a ?
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <style>
        .div1 {
          text-align: center;
        }
      </style>
      <form method="POST" action="recib_Delete.php">
        <?php include('regreso-modal.php');  ?>


        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="name" value="<?php echo $mostrar[$fila1]; ?>">

        <div class="modal-body div1" id="cont_modal">
          <h4 class="fs-3 fw-bold text-dark mb-3"><?php echo $mostrar[$fila1]; ?></h4>
          <span class="badge bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-4 py-2 rounded-pill fs-6 mb-4">
            <?php echo $mostrar[$fila8]; ?>
          </span>
          <br>
          <span class="badge badge-success px-3 py-2"> <?php echo $mostrar[$fila6]; ?></span>
        </div>
        <div class="modal-footer" style="display: flex;justify-content: center;">
          <button type="submit" name="Mangas" class="btn btn-warning">
            <i class="fa-solid fa-delete-left"></i> Borrar de Pendientes, Mover a Mangas</button>
          <button type="submit" name="Finalizados" class="btn btn-danger">
            <i class="fa-solid fa-trash"></i> Borrar de Pendientes, Mover a Finalizados</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->