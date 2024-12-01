<div class="modal fade" id="editCita-{{$cita->id}}" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAppointmentModalLabel">Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="editAppointmentForm" method="POST" action="{{route('citas.update',['id'=>$cita->id])}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="appointment_id" id="appointmentId">

                    <div class="mb-3">
                        <label for="clientName" class="form-label">Nombre del Cliente</label>
                        <input type="text" class="form-control" id="clientName" name="client_name" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="appointmentDate" class="form-label">Fecha</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="appointmentDate" 
                            data-station-id="{{ $cita->id_estacion }}" 
                            min="{{ date('Y-m-d') }}" 
                            required
                            name="fecha"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="appointmentTime" class="form-label">Hora</label>
                        <select class="form-control" id="appointmentTime" name="hora" required>
                            <option value="">Selecciona una hora</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('appointmentDate');
    const timeSelect = document.getElementById('appointmentTime');

    dateInput.addEventListener('change', function () {
        const selectedDate = dateInput.value;
        const stationId = dateInput.getAttribute('data-station-id'); // Obtener el ID de la estación dinámicamente

        // Limpiar el select de horas disponibles
        timeSelect.innerHTML = '<option value="">Cargando...</option>';

        if (selectedDate && stationId) {
            // Realiza la solicitud al endpoint
            fetch(`api/citas/${selectedDate}/horas-disponibles?centerId=${stationId}`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar el select y cargar las horas disponibles
                    timeSelect.innerHTML = '<option value="">Selecciona una hora</option>';
                    if (data.horas && data.horas.length > 0) {
                        data.horas.forEach(hora => {
                            const option = document.createElement('option');
                            option.value = hora;
                            option.textContent = hora;
                            timeSelect.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No hay horas disponibles';
                        timeSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error al obtener las horas disponibles:', error);
                    timeSelect.innerHTML = '<option value="">Error al cargar las horas</option>';
                });
        }
    });
});



</script>
