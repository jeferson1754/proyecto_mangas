<!--ventana para Update--->
<div class="modal fade" id="dif<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          ¿Realmente desea aumentar el registro de diferencia?
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


      <form method="POST" action="recib_Delete-Dif.php">

            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="fecha" value="<?php echo $mostrar['Fecha']  ?>">
            <input type="hidden" name="dif" value="<?php echo $mostrar['Diferencia'] ?>">
            <input type="hidden" name="ID_Manga" value="<?php echo $mostrar['ID_Manga']  ?>">
            <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $mostrar['ID_Manga']  ?>">


        <div class="modal-body div1" id="cont_modal">

          <h1 class="modal-title">Fecha:</br>
            <?php echo $mostrar['Fecha'] ?> 
          </h1>
          <h2 class="modal-title">Diferencia:
            <?php echo $mostrar['Diferencia'] ?> 
          </h2>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>

    </div>
  </div>
</div>
