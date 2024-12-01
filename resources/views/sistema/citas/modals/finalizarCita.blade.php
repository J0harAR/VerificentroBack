<div class="modal fade" id="finalizarCita-{{$cita->id}}" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAppointmentModalLabel">Eliminar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="deleteCitaForm" method="POST" action="{{ route('citas.finalizar', ['id' => $cita->id]) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>    Folio de la cita:{{$cita->folio}}</p><br>
                
                    ¿Estás seguro de que deseas finalizar esta cita? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Finalizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
