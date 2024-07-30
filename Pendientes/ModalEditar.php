<div class="modal fade" id="edit<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">
          Actualizar Información
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="recib_Update.php" id="mi-formulario-<?php echo $mostrar[$fila7]; ?>">
        <?php
        include('regreso-modal.php');

        // No borrar da el nombre
        $query1 = "SELECT * FROM `$tabla` where ID='$mostrar[$fila7]'";
        $result1 = mysqli_query($conexion, $query1);
        $row1 = mysqli_fetch_assoc($result1);

        //echo $link;
        ?>

        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="cantidad" value="<?php echo $mostrar[$titulo3]; ?>">
        <style>
          textarea {
            width: 460px;
            /* Ancho fijo */
            height: auto;
            /* Altura automática */
          }
        </style>
        <div class="modal-body" id="cont_modal">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila1 ?></label>

            <textarea name="fila1" class="form-control" rows="3" cols="50" required="true"><?php echo $row1['Nombre']; ?></textarea>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila2 ?></label>
            <input type="text" name="fila2" class="form-control" value="<?php echo $mostrar[$fila2]; ?>">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila3 ?></label>
            <input type="number" name="fila3" class="form-control" value="<?php echo $mostrar[$fila3]; ?>">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila4 ?></label>
            <input type="number" name="fila4" class="form-control" value="<?php echo $mostrar[$fila4]; ?>">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila8 ?></label>
            <select name="fila8" class="form-control" required>
              <option value="<?php echo $mostrar[$fila8]; ?>"><?php echo $mostrar[$fila8]; ?></option>
              <?php
              $query = $conexion->query("SELECT * FROM $tabla3;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila6 ?></label>
            <select name="fila6" class="form-control" required>
              <option value="<?php echo $mostrar[$fila6]; ?>"><?php echo $mostrar[$fila6]; ?></option>
              <?php
              $query = $conexion->query("SELECT * FROM $tabla2;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila1] . '">' . $valores[$fila1] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $titulo1 ?></label>
            <select name="fila13" class="form-control">
              <option value="<?php echo $mostrar[$fila13]; ?>"><?php echo $mostrar[$fila13]; ?></option>
              <?php
              $query = $conexion->query("SELECT $fila8 FROM `$tabla6`;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
              }
              ?>
            </select>
          </div>

          <iframe id="iframeFechas-<?php echo $mostrar[$fila7]; ?>" src="fechas.php?variable=<?php echo urlencode($mostrar[$fila7]); ?>" width="100%" class="iframeFechas" frameborder="0"></iframe>
          <div id="error-<?php echo $mostrar[$fila7]; ?>" class="text-center" style="align-items:center;color: red;display: none;margin-bottom:20px;
    line-height: 25px;">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="error-mensaje" id="error-mensaje-<?php echo $mostrar[$fila7]; ?>">
            </span>
          </div>
          <input type="hidden" name="fila10" id="fechaActual-<?php echo $mostrar[$fila7]; ?>">
          <input type="hidden" name="fila11" id="fechaDestino-<?php echo $mostrar[$fila7]; ?>">


          <script>
            document.getElementById('mi-formulario-<?php echo $mostrar[$fila7]; ?>').addEventListener('submit', function(event) {
              var iframe = document.getElementById('iframeFechas-<?php echo $mostrar[$fila7]; ?>');
              var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

              // Obtener todos los elementos input en el iframe que contienen fechas
              var fechaInput1 = iframeDocument.querySelector('[id^="date1-"]');
              var fechaInput2 = iframeDocument.querySelector('[id^="date2-"]');


              var error = document.getElementById('error-<?php echo $mostrar[$fila7]; ?>');
              var errorMensaje = document.getElementById('error-mensaje-<?php echo $mostrar[$fila7]; ?>');

              // Verificar si las fechas son iguales
              if (fechaInput1.value === fechaInput2.value) {
                errorMensaje.textContent = 'Las fechas no pueden ser iguales.'; // Mensaje de error
                error.style.display = 'flex'; // Mostrar el mensaje de error
                event.preventDefault(); // Evitar el envío del formulario
                return;
              } else if (fechaInput1.value < fechaInput2.value) {
                errorMensaje.textContent = 'La Ultima Fecha no puede ser menor a la Penultima Fecha.'; // Mensaje de error
                error.style.display = 'flex'; // Mostrar el mensaje de error
                event.preventDefault(); // Evitar el envío del formulario
                return;
              }

              // Ocultar el mensaje de error si estaba visible
              error.style.display = 'none';

              // Pasar los valores a los inputs ocultos del formulario
              document.getElementById('fechaActual-<?php echo $mostrar[$fila7]; ?>').value = fechaInput1.value;
              document.getElementById('fechaDestino-<?php echo $mostrar[$fila7]; ?>').value = fechaInput2.value;

            });
          </script>



          <div class="form-group">
            <div class="todo">
              <label class="container">
                <?php
                $etiqueta = $mostrar['Anime'];
                if ($etiqueta == "SI") {
                  echo "<input type='checkbox' name='Anime' value='SI' checked>";
                  echo "<div class='checkmark'></div>";
                  echo "<span class='text'>Tiene Anime?</span>";
                } else {
                  echo "<input type='checkbox' name='Anime' value='SI' unchecked>";
                  echo "<div class='checkmark'></div>";
                  echo "<span class='text'>Tiene Anime?</span>";
                }
                ?>
              </label>
            </div>
          </div>


          <div class="modal-footer">
            <button type="button" id="boton-guardar" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="submit-button">Guardar Cambios</button>
          </div>
        </div>
      </form>


    </div>
  </div>
</div>


<!---fin ventana Update --->