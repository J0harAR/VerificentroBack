<div class="modal fade" id="generarHorarioModal" tabindex="-1" role="dialog" aria-labelledby="generarEstacionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="generarEstacionLabel">
                    <i class="bx bx-plus"></i> Generar Nuevo Horario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="generarEstacionForm" action="{{route('horarios.store')}}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="row">

                        <div class="col-md-12 mb-3">
                                <label for="municipio" class="form-label">Dia</label>
                                <select name="dia" class="form-select" id="dia">
                                    <option value="" selected disabled>Selecciona un dia</option>
                                    @foreach ($dias as $dia)
                                        <option value="{{$dia->id}}">{{$dia->dia}}</option>
                                    @endforeach
                                    
                                </select>

                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Hora inicio</label>
                                <input type="time" name="hora_inicio" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Hora fin</label>
                                <input type="time" name="hora_fin" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
