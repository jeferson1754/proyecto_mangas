<!-- Modal para Incrementar Episodios -->
<div class="modal fade" id="aumentar<?php echo $mostrar[$fila7]; ?>" tabindex="-1" role="dialog" aria-labelledby="episodeIncrementModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg border-0">
      <!-- Header -->
      <div class="modal-header bg-gradient-primary border-0">
        <div class="d-flex align-items-center">
          <i class="fas fa-plus-circle text-white mr-2 fa-lg"></i>
          <h5 class="modal-title text-white font-weight-bold">Incrementar Total de Episodios</h5>
        </div>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body -->
      <form method="POST" action="recib_Update-Aumentar.php">
        <?php include('regreso-modal.php');
        $total = $mostrar[$fila4];
        $valor = $total + 1;
        ?>

        <input type="hidden" name="id" value="<?php echo $mostrar[$fila7]; ?>">
        <input type="hidden" name="nombre" value="<?php echo $mostrar[$fila1]; ?>">
        <input type="hidden" name="capitulos" value="<?php echo $mostrar[$fila3]; ?>">
        <input type="hidden" name="fecha" value="<?php echo $mostrar[$fila10]; ?>">
        <input type="hidden" name="cantidad" value="<?php echo $mostrar[$titulo3]; ?>">

        <div class="modal-body text-center px-4">
          <div class="mb-4">
            <h2 class="h3 font-weight-bold text-dark mb-2"><?php echo $mostrar[$fila1]; ?></h2>
            <span class="badge badge-primary px-3 py-2"><?php echo $mostrar[$fila8]; ?></span>
          </div>

          <div class="row justify-content-center mb-4">
            <div class="col-6">
              <div class="card border-0 bg-light">
                <div class="card-body">
                  <h6 class="text-muted mb-2">Episodios Vistos</h6>
                  <h3 class="mb-0 font-weight-bold"><?php echo $mostrar[$fila3]; ?></h3>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card border-0 bg-light">
                <div class="card-body">
                  <h6 class="text-muted mb-2">Total Episodios</h6>
                  <h3 class="mb-0 font-weight-bold"><?php echo $mostrar[$fila4]; ?></h3>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold">Nuevo Total de Episodios</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="fas fa-list-ol"></i>
                </span>
              </div>
              <input type="number"
                name="total"
                class="form-control border-left-0 text-center font-weight-bold"
                min="<?php echo $mostrar[$fila4]; ?>"
                value="<?php echo $valor; ?>"
                required>
            </div>
          </div>

          <div class="form-group mb-0">
            <label class="font-weight-bold">Fecha del Episodio</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text bg-transparent border-right-0">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
              <input type="date"
                name="fecha_cap"
                class="form-control border-left-0"
                value="<?php echo $fecha_actual; ?>"
                max="<?php echo $fecha_futura; ?>"
                required>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer border-top-0">
          <button type="button" class="btn btn-light font-weight-bold px-4" data-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary font-weight-bold px-4">
            <i class="fas fa-save mr-2"></i>Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .bg-gradient-primary {
    background: linear-gradient(to right, #4e73df, #224abe);
  }

  .modal-content {
    border-radius: 0.75rem;
  }

  .badge {
    font-size: 0.9rem;
    border-radius: 50rem;
  }

  .card {
    border-radius: 0.5rem;
    transition: transform 0.2s;
  }

  .card:hover {
    transform: translateY(-2px);
  }

  .input-group-text {
    border-radius: 0.5rem 0 0 0.5rem;
  }

  .form-control {
    border-radius: 0 0.5rem 0.5rem 0;
  }

  .btn {
    border-radius: 0.5rem;
    padding: 0.5rem 1.5rem;
  }

  .modal-header .close {
    padding: 1rem;
    margin: -1rem -1rem -1rem auto;
  }

  .close:hover {
    opacity: 0.75;
  }
</style>