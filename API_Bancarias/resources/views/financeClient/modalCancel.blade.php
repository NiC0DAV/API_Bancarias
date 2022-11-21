<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="text-center">¿Estas seguro que deseas cancelar tu solicitud de credito?</h6>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <a href="{{ route('returnToStore', $dataClient) }}" class="btn btn-primary">Confirmar</a>
        </div>
      </div>
    </div>
</div>
