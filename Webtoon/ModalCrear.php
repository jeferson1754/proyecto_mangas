<!--ventana para Update--->
<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #563d7c !important;">
        <h6 class="modal-title" style="color: #fff; text-align: center;">
          Nuevo <?php echo ucfirst($tabla) ?>
        </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>



      <form name="form-data" action="recibCliente.php" method="POST">

        <?php include('regreso-modal.php');  ?>

        <div class="modal-body" id="cont_modal">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila1 ?></label>
            <input type="text" name="fila1" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila2 ?></label>
            <input type="text" name="fila2" class="form-control">
          </div>

          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila3 ?></label>
            <input class="form-control" id="municipio" name="fila3" oninput="actualizarValorMunicipioInm()" type="number">
          </div>


          </input>
          </input>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila4 ?></label>
            <input class="form-control" id="municipio_inm" name="fila4" type="number">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila8 ?></label>
            <select name="fila8" class="form-control" required>
              <option value="">Seleccione:</option>
              <?php
              $query = $conexion->query("SELECT * FROM estado;");
              while ($valores = mysqli_fetch_array($query)) {
                echo '<option value="' . $valores[$fila8] . '">' . $valores[$fila8] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label"><?php echo $fila6 ?></label>
            <br>
            <?php
            $query = $conexion->query("SELECT * FROM $tabla5;");
            while ($valores = mysqli_fetch_array($query)) {
            ?>


              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="<?php echo  $valores['Dia'] ?>" id="checkbox2" name="check_lista[]">
                <label class="form-check-label" for="checkbox2">
                  <?php echo  $valores['Dia'] ?>
                </label>
              </div>
            <?php
            }
            ?>
          </div>


        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="btnEnviar">
            Registrar <?php echo ucfirst($tabla) ?>
          </button>
        </div>
    </div>
    </form>

  </div>
</div>
</div>
<!---fin ventana Update --->