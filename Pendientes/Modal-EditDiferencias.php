<!-- Modal para editar diferencia -->
<div class="modal fade" id="edit-dif<?php echo $id; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $id; ?>" aria-hidden="true">
  <style>
    .custom-modal .modal-content {
      border: none;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .custom-modal .modal-header {
      background-color: #f8fafc;
      border-bottom: 1px solid #edf2f7;
      border-radius: 12px 12px 0 0;
      padding: 1.5rem;
    }

    .custom-modal .modal-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: #2d3748;
    }

    .custom-modal .close {
      background: #f1f5f9;
      border-radius: 50%;
      padding: 0.5rem;
      margin: -0.5rem;
      opacity: 1;
      transition: all 0.2s ease;
    }

    .custom-modal .close:hover {
      background: #e2e8f0;
      transform: rotate(90deg);
    }

    .custom-modal .modal-body {
      padding: 2rem 1.5rem;
    }

    .custom-modal .form-group {
      margin-bottom: 1.5rem;
    }

    .custom-modal .form-label {
      font-weight: 500;
      color: #4a5568;
      margin-bottom: 0.5rem;
      display: block;
    }

    .custom-modal .form-control {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 0.75rem;
      font-size: 0.95rem;
      transition: all 0.2s ease;
    }

    .custom-modal .form-control:focus {
      border-color: #4a90e2;
      box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    .custom-modal .form-control:disabled {
      background-color: #f8fafc;
      cursor: not-allowed;
    }

    .custom-modal .modal-footer {
      background-color: #f8fafc;
      border-top: 1px solid #edf2f7;
      border-radius: 0 0 12px 12px;
      padding: 1.25rem 1.5rem;
    }

    .custom-modal .btn {
      padding: 0.6rem 1.5rem;
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .custom-modal .btn-secondary {
      background-color: #f1f5f9;
      border: 1px solid #e2e8f0;
      color: #64748b;
    }

    .custom-modal .btn-secondary:hover {
      background-color: #e2e8f0;
    }

    .custom-modal .btn-primary {
      background-color: #4a90e2;
      border: none;
    }

    .custom-modal .btn-primary:hover {
      background-color: #357abd;
      transform: translateY(-1px);
    }

    /* Animación del modal */
    .modal.fade .modal-dialog {
      transform: scale(0.95);
      transition: transform 0.2s ease-out;
    }

    .modal.show .modal-dialog {
      transform: scale(1);
    }
  </style>

  <div class="modal-dialog modal-dialog-centered custom-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar registro de diferencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <form method="POST" action="recib_Edit-Dif.php">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="hidden" name="ID_Manga" value="<?php echo $variable  ?>">
        <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $variable ?>">

        <div class="modal-body">
          <div class="form-group">
            <label class="form-label" for="fecha_actual">
              <i class="far fa-calendar-alt me-2"></i>
              Fecha de Registro
            </label>
            <input type="datetime-local"
              id="fecha_actual"
              name="fecha_actual"
              class="form-control"
              value="<?php echo $mostrar['Fecha']; ?>">
          </div>

          <?php
          $sql3 = "SELECT MIN(ID) AS ID_Menor FROM `$tabla7` WHERE $fila9 = '$variable'";
          $result3 = mysqli_query($conexion, $sql3);
          $row3 = mysqli_fetch_assoc($result3);
          $ID_Menor = $row3['ID_Menor'];

          $sql4 = "SELECT Fecha FROM `$tabla7` WHERE ID < '$id' AND $fila9 = '$variable' ORDER BY ID DESC LIMIT 1";
          $result2 = mysqli_query($conexion, $sql4);
          $row2 = mysqli_fetch_assoc($result2);
          $fecha_anterior = $row2['Fecha'] ?? null;
          ?>

          <div class="form-group mb-0">
            <label class="form-label" for="fecha_antigua">
              <i class="far fa-clock me-2"></i>
              Fecha del Anterior Registro
            </label>
            <?php if ($id > $ID_Menor): ?>
              <input type="datetime-local"
                disabled
                class="form-control"
                value="<?php echo $fecha_anterior; ?>">
              <input type="hidden"
                id="fecha_antigua"
                name="fecha_antigua"
                value="<?php echo $fecha_anterior; ?>">
            <?php else: ?>
              <input type="date"
                id="fecha_antigua"
                name="fecha_antigua"
                class="form-control"
                min="2000-01-01T00:00:01">
            <?php endif; ?>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Guardar cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>