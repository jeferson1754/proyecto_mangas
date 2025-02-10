<?php
include('bd.php');

$nombre = $capv = $capt = $estado = $list = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST['buscar'])) {
    $busqueda = $conexion->real_escape_string($_POST['buscar']);
    $sql = "SELECT * FROM manga WHERE Nombre = '$busqueda'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
      $fila = $resultado->fetch_assoc();
      $iden = $fila['ID'];
      $nombre = $fila['Nombre'];
      $capv = $fila['Capitulos Vistos'];
      $capt = $fila['Capitulos Totales'];
      $estado = $fila['Estado'];
      $list = $fila['Lista'];
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Manga</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <!-- Card principal -->
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white py-3">
            <h4 class="card-title mb-0">
              <i class="fas fa-plus-circle me-2"></i>
              Nuevo <?php echo ucfirst($tabla) ?>
            </h4>
          </div>

          <!-- Formulario de búsqueda -->
          <div class="card-body border-bottom">
            <form method="POST" class="mb-0">
              <div class="form-group">
                <label for="buscar" class="form-label fw-semibold mb-2">
                  <i class="fas fa-search me-2"></i>Buscar Manga
                </label>
                <div class="input-group">
                  <input type="text"
                    name="buscar"
                    id="buscar"
                    class="form-control form-control-lg"
                    list="mangas"
                    placeholder="Escribe el nombre del manga..."
                    value="<?php echo $nombre; ?>"
                    required>
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search me-2"></i>Buscar
                  </button>
                  <datalist id="mangas">
                    <?php
                    $mangas = $conexion->query("SELECT ID, Nombre FROM `manga` ORDER BY `manga`.`Nombre` ASC");
                    foreach ($mangas as $manga) {
                      echo "<option value='" . $manga['Nombre'] . "'></option>";
                    }
                    ?>
                  </datalist>
                </div>
              </div>
            </form>
          </div>

          <!-- Formulario principal -->
          <form name="form-data" action="recibCliente.php" method="POST" class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?php echo $iden; ?>">
            <div class="card-body">
              <!-- Resultados de búsqueda -->
              <?php if (!empty($nombre)): ?>
                <div class="alert alert-info mb-4">
                  <h5 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>
                    Información encontrada
                  </h5>
                  <p class="mb-0">Manga: <?php echo $nombre; ?></p>
                  <p class="mb-0">Capítulos vistos: <?php echo $capv; ?></p>
                  <p class="mb-0">Capítulos totales: <?php echo $capt; ?></p>
                  <p class="mb-0">Estado: <?php echo $estado; ?></p>
                  <p class="mb-0">Lista: <?php echo $list; ?></p>
                </div>
              <?php endif; ?>

              <!-- Campos del formulario -->
              <div class="row g-4">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="fas fa-hashtag me-2"></i>Capítulos Vistos
                  </label>
                  <input type="number"
                    class="form-control"
                    name="fila3"
                    value="<?php echo $capv; ?>"
                    min="0">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="fas fa-hashtag me-2"></i>Capítulos Totales
                  </label>
                  <input type="number"
                    class="form-control"
                    name="fila4"
                    value="<?php echo $capt; ?>"
                    min="0">
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="fas fa-list me-2"></i>Estado
                  </label>
                  <select name="fila8" class="form-select" required>
                    <option value="">Seleccione estado</option>
                    <?php
                    $query = $conexion->query("SELECT * FROM $tabla3;");
                    while ($valores = mysqli_fetch_array($query)) {
                      $selected = ($estado == $valores[$fila8]) ? 'selected' : '';
                      echo '<option value="' . $valores[$fila8] . '" ' . $selected . '>' . $valores[$fila8] . '</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold">
                    <i class="fas fa-bookmark me-2"></i>Lista
                  </label>
                  <select name="fila6" class="form-select" required>
                    <option value="">Seleccione lista</option>
                    <?php
                    $query = $conexion->query("SELECT * FROM $tabla4;");
                    while ($valores = mysqli_fetch_array($query)) {
                      $selected = ($list == $valores[$fila1]) ? 'selected' : '';
                      echo '<option value="' . $valores[$fila1] . '" ' . $selected . '>' . $valores[$fila1] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>

            <!-- Footer con botones -->
            <div class="card-footer bg-light d-flex justify-content-end gap-2 py-3">
              <a href="index.php" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Guardar Cambios
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Script para validación -->
  <script>
    (function() {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
</body>

</html>