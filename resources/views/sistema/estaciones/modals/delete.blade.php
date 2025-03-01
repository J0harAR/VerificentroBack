<div class="modal fade" id="deleteEstacion-{{$estacion->id}}" tabindex="-1" aria-labelledby="deleteEstacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAppointmentModalLabel">Eliminar Estación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <form id="deleteCitaForm" method="POST" action="{{ route('estaciones.destroy', ['estacione' => $estacion->id]) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>    Estacion:{{$estacion->nombre}}</p><br>
                
                    ¿Estás seguro de que deseas eliminar esta cita? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
