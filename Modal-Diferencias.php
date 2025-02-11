<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="dif<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <style>
    .delete-modal .modal-content {
      border: none;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .delete-modal .modal-header {
      background-color: #FEF2F2;
      border-bottom: 1px solid #FEE2E2;
      border-radius: 12px 12px 0 0;
      padding: 1.25rem 1.5rem;
    }

    .delete-modal .modal-title {
      color: #DC2626;
      font-size: 1.1rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .delete-modal .close {
      padding: 0.5rem;
      margin: -0.5rem -0.5rem -0.5rem auto;
      border-radius: 50%;
      background: #FEE2E2;
      opacity: 1;
      transition: all 0.2s ease;
      border: none;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .delete-modal .close:hover {
      background: #FCA5A5;
      transform: rotate(90deg);
    }

    .delete-modal .modal-body {
      padding: 2rem 1.5rem;
      text-align: center;
    }

    .delete-modal .info-group {
      background: #F9FAFB;
      border-radius: 8px;
      padding: 1.5rem;
      margin: 1rem 0;
    }

    .delete-modal .info-label {
      color: #6B7280;
      font-size: 0.9rem;
      margin-bottom: 0.25rem;
    }

    .delete-modal .info-value {
      color: #111827;
      font-size: 1.25rem;
      font-weight: 600;
      margin: 0;
    }

    .delete-modal .modal-footer {
      background-color: #F9FAFB;
      border-top: 1px solid #E5E7EB;
      border-radius: 0 0 12px 12px;
      padding: 1.25rem 1.5rem;
      display: flex;
      justify-content: flex-end;
      gap: 0.75rem;
    }

    .delete-modal .btn {
      padding: 0.6rem 1.25rem;
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .delete-modal .btn-cancel {
      background-color: #F3F4F6;
      border: 1px solid #E5E7EB;
      color: #4B5563;
    }

    .delete-modal .btn-cancel:hover {
      background-color: #E5E7EB;
    }

    .delete-modal .btn-delete {
      background-color: #DC2626;
      border: none;
      color: white;
    }

    .delete-modal .btn-delete:hover {
      background-color: #B91C1C;
      transform: translateY(-1px);
    }

    .delete-modal .warning-icon {
      color: #DC2626;
      font-size: 3rem;
      margin-bottom: 1rem;
    }
  </style>

  <div class="modal-dialog modal-dialog-centered delete-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle"></i>
          Confirmar eliminación
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <form method="POST" action="recib_Delete-Dif.php">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <input type="hidden" name="fecha" value="<?php echo $mostrar['Fecha'] ?>">
        <input type="hidden" name="dif" value="<?php echo $mostrar['Diferencia'] ?>">
        <input type="hidden" name="ID_Manga" value="<?php echo $variable ?>">
        <input type="hidden" name="link" value="./ejemplo-barra.php?variable=<?php echo $variable ?>">

        <div class="modal-body">
          <i class="fas fa-trash-alt warning-icon"></i>
          <p style="color: #4B5563; margin-bottom: 1.5rem;">
            ¿Está seguro que desea eliminar este registro? Esta acción no se puede deshacer.
          </p>

          <div class="info-group">
            <div style="margin-bottom: 1rem;">
              <div class="info-label">
                <i class="far fa-calendar-alt"></i> Fecha
              </div>
              <div class="info-value">
                <?php echo $mostrar['Fecha'] ?>
              </div>
            </div>

            <div>
              <div class="info-label">
                <i class="fas fa-chart-line"></i> Diferencia
              </div>
              <div class="info-value">
                <?php echo $mostrar['Diferencia'] ?>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-cancel" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Cancelar
          </button>
          <button type="submit" class="btn btn-delete">
            <i class="fas fa-trash-alt"></i>
            Eliminar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>