<div class="modal fade" id="edit<?php echo $mostrar[$fila7];  ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-edit me-2"></i>Actualizar Manga
        </h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="recib_Update.php">
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="cantidad" value="<?php echo $mostrar[$titulo3]; ?>">

        <?php include('regreso-modal.php'); ?>

        <div class="modal-body">
          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label"><?php echo $fila1 ?></label>
                <!-- Textarea que se sincroniza con el input -->
                <!-- Contenedor para el textarea y el botón alineado a la derecha -->
                <div class="d-flex align-items-center mt-2">
                  <textarea id="inputarea<?php echo $mostrar[$fila7]; ?>" class="form-control me-2"
                    oninput="replicarTextoDesdeTextarea('<?php echo $mostrar[$fila7]; ?>')"><?php echo htmlspecialchars($mostrar[$fila1]); ?></textarea>

                  <!-- Botón alineado a la derecha -->
                  <button class="btn btn-secondary" type="button" onclick="mostrarDiv('<?php echo $mostrar[$fila7]; ?>')">
                    <i class="fa-solid fa-arrows-rotate"></i> Cambiar Nombre
                  </button>
                </div>


                <div id="formDiv<?php echo $mostrar[$fila7]; ?>" class="mt-3" style="display: none;">
                  <label for="inputText<?php echo $mostrar[$fila7]; ?>">Buscar sugerencias:</label>
                  <input type="text" list="suggestions<?php echo $mostrar[$fila7]; ?>" id="inputText<?php echo $mostrar[$fila7]; ?>"
                    name="inputText" class="form-control"
                    value="<?php echo htmlspecialchars($mostrar[$fila1]); ?>"
                    oninput="replicarTextoDesdeInput('<?php echo $mostrar[$fila7]; ?>')">

                  <datalist id="suggestions<?php echo $mostrar[$fila7]; ?>">
                    <?php
                    $query_list = "SELECT * FROM `nombres_mangas` WHERE ID_Manga='$mostrar[$fila7]'";
                    $result_list = mysqli_query($conexion, $query_list);
                    while ($row_list = mysqli_fetch_assoc($result_list)) {
                      echo "<option value='" . htmlspecialchars($row_list['Nombre']) . "'>";
                    }
                    ?>
                  </datalist>
                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?php echo $fila2 ?></label>
                <input type="text" name="fila2" class="form-control" value="<?php echo $mostrar[$fila2]; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?php echo $fila3 ?></label>
                <input type="number" name="fila3" class="form-control" value="<?php echo $mostrar[$fila3]; ?>">
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?php echo $fila4 ?></label>
                <input type="number" name="fila4" class="form-control" value="<?php echo $mostrar[$fila4]; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?php echo $fila8 ?></label>
                <select name="fila8" class="form-control" required>
                  <?php
                  // Consulta para obtener los estados
                  $query = "SELECT * FROM $tabla3;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  // Mostrar el estado actual seleccionado si existe
                  if (empty($mostrar[$fila8])) {
                    echo "<option value=''>Selecciona un estado</option>";
                  }

                  // Mostrar las opciones de los estados disponibles
                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado['Estado']}' " .
                        ($estado['Estado'] === $mostrar[$fila8] ? 'selected' : '') .
                        ">{$estado['Estado']}</option>";
                    }
                  } else {
                    echo "<option value=''>No hay estados disponibles</option>";
                  }
                  ?>
                </select>

              </div>
            </div>


          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?php echo $fila6 ?></label>
                <select name="fila6" class="form-control" required>
                  <?php
                  // Consulta para obtener los estados
                  $query = "SELECT * FROM $tabla2;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  // Mostrar el estado actual seleccionado si existe
                  if (empty($mostrar[$fila6])) {
                    echo "<option value=''>Selecciona una Lista</option>";
                  }

                  // Mostrar las opciones de los estados disponibles
                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado[$fila1]}' " .
                        ($estado[$fila1] === $mostrar[$fila1] ? 'selected' : '') .
                        ">{$estado[$fila1]}</option>";
                    }
                  } else {
                    echo "<option value=''>No hay listas disponibles</option>";
                  }
                  ?>
                </select>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label"><?php echo $titulo1 ?></label>
                <select name="fila13" class="form-control" required>
                  <?php
                  // Consulta para obtener los estados
                  $query = "SELECT $fila8 FROM $tabla6;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  // Mostrar el estado actual seleccionado si existe
                  if (empty($mostrar[$fila13])) {
                    echo "<option value=''>Selecciona un Estado Link</option>";
                  }

                  // Mostrar las opciones de los estados disponibles
                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado[$fila8]}' " .
                        ($estado[$fila8] === $mostrar[$fila13] ? 'selected' : '') .
                        ">{$estado[$fila8]}</option>";
                    }
                  } else {
                    echo "<option value=''>No hay Estado Link disponibles</option>";
                  }
                  ?>
                </select>

              </div>
            </div>
          </div>
          <div class="row" style="height:195px">
            <iframe id="iframeFechas-<?php echo $mostrar[$fila7]; ?>" src="fechas.php?variable=<?php echo urlencode($mostrar[$fila7]); ?>" width="100%" height="100%" class="iframeFechas" frameborder="0"></iframe>
            <div id="error-<?php echo $mostrar[$fila7]; ?>" class="text-center" style="align-items:center;color: red;display: none;margin-bottom:20px;
    line-height: 25px;">
              <i class="fa-solid fa-triangle-exclamation"></i>
              <span class="error-mensaje" id="error-mensaje-<?php echo $mostrar[$fila7]; ?>">
              </span>
            </div>
            <input type="hidden" name="fila10" id="fechaActual-<?php echo $mostrar[$fila7]; ?>">
            <input type="hidden" name="fila11" id="fechaDestino-<?php echo $mostrar[$fila7]; ?>">

          </div>

          <?php
          if ($mostrar['Anime'] == "SI") {
            $etiqueta = "checked";
          } else {
            $etiqueta = "unchecked";
          }
          ?>

          <div class="col-12">
            <div class="form-check form-switch" style="margin-left: 120px;">
              <input class="form-check-input" type="checkbox" name="Anime" value="SI" id="animeCheck" style="transform: scale(1.5);" <?php echo $etiqueta; ?>>
              <label class="form-check-label ms-2" for="animeCheck">¿Tiene Anime?</label>
            </div>
          </div>

          <div class="rating-box">
            <header>Calificación del Anime</header>
            <div class="stars">
              <?php
              $sql2 = "SELECT promedio FROM calificaciones WHERE ID_Anime=$mostrar[$fila7]";
              $result2 = $conexion->query($sql2);

              if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $calificacion = $row["promedio"];
                $texto = "Promedio:";
              } else {
                $calificacion = "";
                $texto = "Sin Calificar Aun";
              }

              for ($i = 1; $i <= 5; $i++) {
                if ($i <= $calificacion) {
                  echo '<i class="fa-solid fa-star active"></i>';
                } else {
                  echo '<i class="fa-solid fa-star"></i>';
                }
              }
              ?>
            </div>

            <div class="rating-text">
              <?php echo $texto ?> <span class="rating-value"><?php echo $calificacion ?></span>
            </div>
            <a href="./Calificaciones/editar_stars.php?id=<?php echo $mostrar[$fila7]; ?>"
              class="btn btn-secondary mt-3">
              Cambiar Calificación
            </a>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i>Cerrar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

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

  // Función para replicar el texto del textarea al input
  function replicarTextoDesdeTextarea(id) {
    var texto = document.getElementById('inputarea' + id).value;
    document.getElementById('inputText' + id).value = texto;
  }

  // Función para replicar el texto del input al textarea
  function replicarTextoDesdeInput(id) {
    var texto = document.getElementById('inputText' + id).value;
    document.getElementById('inputarea' + id).value = texto;
  }

  // Función para mostrar u ocultar el div
  function mostrarDiv(id) {
    var div = document.getElementById('formDiv' + id);
    div.style.display = div.style.display === 'none' ? 'block' : 'none';
  }
</script>