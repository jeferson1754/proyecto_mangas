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
        <input type="hidden" name="id_manga" value="<?php echo $mostrar[$fila9]; ?>">
        <input type="hidden" name="name" value="<?php echo $mostrar[$fila1]; ?>">
        <input type="hidden" name="lista" value="<?php echo $mostrar[$fila6]; ?>">

        <div class="modal-body div1" id="cont_modal">

          <h1 class="modal-title">
            <?php echo $mostrar[$fila1]; ?>
          </h1>
          <h2 class="modal-title">
            <?php echo $mostrar[$fila8]; ?>
          </h2>
          <h2 class="modal-title">
            <?php echo $mostrar[$fila6]; ?>
          </h2>
        </div>
        <div class="modal-footer" style="display: flex;justify-content: center;">
          <button type="submit" name="Tachiyomi" class="btn btn-primary">
            <i class="fa-solid fa-recycle"></i> Borrar de Tachiyomi y Dejar en Mangas</button>
          <button type="submit" name="Pendientes" class="btn btn-warning">
            <i class="fa-solid fa-delete-left"></i> Borrar de Tachiyomi y Manga, Mover a Pendientes</button>
          <button type="submit" name="Finalizados" class="btn btn-danger">
            <i class="fa-solid fa-trash"></i> Borrar de Tachiyomi y Mangas, Mover a Finalizados</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!---fin ventana Update --->