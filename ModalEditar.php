<div class="modal fade" id="edit<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0 shadow-lg rounded-lg">
      <div class="modal-header bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <h5 class="modal-title d-flex align-items-center fw-bold">
          <i class="fas fa-edit me-2"></i>Actualizar Manga
        </h5>
        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="recib_Update.php" id="mi-formulario-<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="cantidad" value="<?php echo $mostrar[$titulo3]; ?>">
        <?php include('regreso-modal.php'); ?>

        <div class="modal-body p-4">
          <!-- Nombre del Manga -->
          <div class="mb-4">
            <label class="form-label fw-bold"><?php echo $fila1 ?></label>
            <div class="input-group">
              <textarea name="fila1" id="inputarea<?php echo $mostrar[$fila7]; ?>"
                class="form-control border-end-0 rounded-start" required
                oninput="replicarTextoDesdeTextarea('<?php echo $mostrar[$fila7]; ?>')"><?php echo htmlspecialchars($mostrar[$fila1]); ?></textarea>
              <button class="btn btn-light border" type="button" onclick="mostrarDiv('<?php echo $mostrar[$fila7]; ?>')">
                <i class="fa-solid fa-arrows-rotate me-1"></i>Cambiar
              </button>
            </div>

            <div id="formDiv<?php echo $mostrar[$fila7]; ?>" class="mt-3 bg-light p-3 rounded-3 shadow-sm" style="display: none;">
              <label class="form-label">Buscar sugerencias:</label>
              <input type="text" list="suggestions<?php echo $mostrar[$fila7]; ?>"
                id="inputText<?php echo $mostrar[$fila7]; ?>"
                name="inputText<?php echo $mostrar[$fila7]; ?>"
                class="form-control"
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

          <!-- Info Grid -->
          <div class="row g-3">
            <!-- Autor -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila2 ?></label>
                <input type="text" name="fila2" class="form-control" value="<?php echo $mostrar[$fila2]; ?>">
              </div>
            </div>

            <!-- Estado Link -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $titulo1 ?></label>
                <select name="fila13" class="form-select" required>
                  <?php
                  $query = "SELECT $fila8 FROM $tabla6;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (empty($mostrar[$fila13])) {
                    echo "<option value=''>Selecciona un Estado Link</option>";
                  }

                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado[$fila8]}' " .
                        ($estado[$fila8] === $mostrar[$fila13] ? 'selected' : '') .
                        ">{$estado[$fila8]}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <!-- Capítulos -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila3 ?></label>
                <input type="number" name="fila3" class="form-control" value="<?php echo $mostrar[$fila3]; ?>">
              </div>
            </div>

            <!-- Total -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila4 ?></label>
                <input type="number" name="fila4" class="form-control" value="<?php echo $mostrar[$fila4]; ?>">
              </div>
            </div>

            <!-- Estado -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila8 ?></label>
                <select name="fila8" class="form-select" required>
                  <?php
                  $query = "SELECT * FROM $tabla3;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (empty($mostrar[$fila8])) {
                    echo "<option value=''>Selecciona un estado</option>";
                  }

                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado['Estado']}' " .
                        ($estado['Estado'] === $mostrar[$fila8] ? 'selected' : '') .
                        ">{$estado['Estado']}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <!-- Lista -->
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label fw-bold"><?php echo $fila6 ?></label>
                <select name="fila6" class="form-select" required>
                  <?php
                  $query = "SELECT * FROM $tabla2;";
                  $stmt = $db->prepare($query);
                  $stmt->execute();
                  $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (empty($mostrar[$fila6])) {
                    echo "<option value=''>Selecciona una Lista</option>";
                  }

                  if ($estados) {
                    foreach ($estados as $estado) {
                      echo "<option value='{$estado[$fila1]}' " .
                        ($estado[$fila1] === $mostrar[$fila6] ? 'selected' : '') .
                        ">{$estado[$fila1]}</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <!-- Fechas Frame -->
          <div class="mt-4">
            <iframe id="iframeFechas-<?php echo $mostrar[$fila7]; ?>"
              src="fechas.php?variable=<?php echo urlencode($mostrar[$fila7]); ?>"
              class="w-100 rounded"
              style="height: 200px;"
              frameborder="0">
            </iframe>

            <div id="error-<?php echo $mostrar[$fila7]; ?>"
              class="alert alert-danger align-items-center mt-2"
              style="display: none;">
              <i class="fa-solid fa-triangle-exclamation me-2"></i>
              <span id="error-mensaje-<?php echo $mostrar[$fila7]; ?>"></span>
            </div>

            <input type="hidden" name="fila10" id="fechaActual-<?php echo $mostrar[$fila7]; ?>">
            <input type="hidden" name="fila11" id="fechaDestino-<?php echo $mostrar[$fila7]; ?>">
          </div>

          <!-- Anime Switch -->
          <div class="form-check form-switch mt-4" style="margin-left: 120px;">
            <input class="form-check-input" type="checkbox" name="Anime" value="SI" id="animeCheck" style="transform: scale(1.5);"
              <?php echo ($mostrar['Anime'] == "SI") ? "checked" : ""; ?>>
            <label class="form-check-label ms-2" for="animeCheck">¿Tiene Anime?</label>
          </div>
        </div>

        <div class="modal-footer border-top">
          <button type="button" class="btn btn-light" data-dismiss="modal">
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

<style>
  .modal-content {
    border: none;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
  }

  .form-check-input:checked {
    background-color: #6366f1;
    border-color: #6366f1;
  }

  .alert-danger {
    border-left: 4px solid #dc3545;
  }

  .bg-gradient-to-r {
    background: linear-gradient(to right, #7c3aed, #4f46e5);
  }
</style>

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

  function replicarTextoDesdeTextarea(id) {
    const texto = document.getElementById(`inputarea${id}`).value;
    document.getElementById(`inputText${id}`).value = texto;
  }

  function replicarTextoDesdeInput(id) {
    const texto = document.getElementById(`inputText${id}`).value;
    document.getElementById(`inputarea${id}`).value = texto;
  }

  function mostrarDiv(id) {
    const div = document.getElementById(`formDiv${id}`);
    div.style.display = div.style.display === 'none' ? 'block' : 'none';
  }

  document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('[id^="mi-formulario-"]');
    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        const id = this.id.replace('mi-formulario-', '');
        if (!validarFormulario(id)) {
          e.preventDefault();
        }
      });
    });
  });
</script>