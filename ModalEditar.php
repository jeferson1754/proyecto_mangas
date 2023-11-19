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

      <form method="POST" action="recib_Update.php" id="mi-formulario">
        <?php
        include('regreso-modal.php');

        // No borrar da el nombre
        $query1 = "SELECT * FROM `manga` where ID='$mostrar[$fila7]'";
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

          <style>
            .inline-input {
              display: inline-block;
              width: 54%;
            }

            .inline-boton {
              display: inline-block;
              width: 45%;
            }

            .boton {
              font-family: Arial, Helvetica, sans-serif;
              font-weight: bold;
              color: white;
              background-color: #171717;
              padding: 0.6em;
              border: none;
              border-radius: .6rem;
              position: relative;
              cursor: pointer;
              overflow: hidden;
            }

            .boton span:not(:nth-child(6)) {
              position: absolute;
              left: 50%;
              top: 50%;
              transform: translate(-50%, -50%);
              height: 70px;
              width: 70px;
              background-color: #0c66ed;
              border-radius: 50%;
              transition: .6s ease;
            }

            .boton span:nth-child(6) {
              position: relative;
            }

            .boton span:nth-child(1) {
              transform: translate(-3.3em, -4em);
            }

            .boton span:nth-child(2) {
              transform: translate(-6em, 1.3em);
            }

            .boton span:nth-child(3) {
              transform: translate(-.2em, 1.8em);
            }

            .boton span:nth-child(4) {
              transform: translate(3.5em, 1.4em);
            }

            .boton span:nth-child(5) {
              transform: translate(3.5em, -3.8em);
            }

            .boton:hover span:not(:nth-child(6)) {
              transform: translate(-50%, -50%) scale(4);
              transition: 1.5s ease;
            }
          </style>

          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $titulo2 ?></label><br>
            <input type="date" id="date1-<?php echo $mostrar['ID']; ?>" name="fila10" class="inline-input form-control" value="<?php echo $mostrar[$fila10]; ?>">

            <button type="button" class="inline-boton boton cambiar-fecha" data-id="<?php echo $mostrar['ID']; ?>">
              <span class="circle1"></span>
              <span class="circle2"></span>
              <span class="circle3"></span>
              <span class="circle4"></span>
              <span class="circle5"></span>
              <span class="text">Intercambiar Fechas</span>
            </button>
          </div>

          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $titulo5 ?></label>
            <input type="date" id="date2-<?php echo $mostrar['ID']; ?>" name="fila11" class="form-control" value="<?php echo $mostrar[$fila11]; ?>" max="<?php echo $mostrar[$fila10]; ?>">
          </div>


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

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.getElementsByClassName('cambiar-fecha');
    for (var i = 0; i < buttons.length; i++) {
      buttons[i].addEventListener('click', function(event) {
        event.preventDefault();
        // Obtener el id del registro asociado al botón
        var id = this.getAttribute('data-id');

        // Obtener la fecha actual en formato "yyyy-MM-dd"
        var fechaActual = new Date();
        var dia = ('0' + fechaActual.getDate()).slice(-2);
        var mes = ('0' + (fechaActual.getMonth() + 1)).slice(-2);
        var anio = fechaActual.getFullYear();
        var fechaActualFormatted = anio + '-' + mes + '-' + dia;


        // Obtener el id del registro asociado al botón
        var id = this.getAttribute('data-id');

        // Obtener los valores actuales de "date1" y "date2" para el registro correspondiente
        var fechaInput1 = document.getElementById('date1-' + id);
        var fechaInput2 = document.getElementById('date2-' + id);

        // Intercambiar los valores de "date1" y "date2" para el registro correspondiente
        fechaInput2.value = fechaInput1.value;

      });
    }
  });
</script>

<!---fin ventana Update --->