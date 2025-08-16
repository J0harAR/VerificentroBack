<div class="modal fade" id="generarEstacionModal" tabindex="-1" role="dialog" aria-labelledby="generarEstacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="generarEstacionLabel">
                    <i class="bx bx-plus"></i> Generar Nueva Estación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="generarEstacionForm" action="{{ route('estaciones.store') }}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <!-- Sección Datos de la Estación -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Datos de la Estación</h6>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" required value="{{ old('telefono') }}">
                            </div>

                            <div class="col-12">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Dirección</h6>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select name="estado" class="form-select" id="estado" required>
                                    <option value="" selected disabled>Selecciona un estado</option>
                                    @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="municipio" class="form-label">Municipio</label>
                                <select name="municipio" class="form-select" id="municipio" 
                                    @if(isset($estacion)) data-selected="{{ $estacion->direccion->municipio }}" @endif required>
                                    <option value="" selected disabled>Selecciona un municipio</option>
                                </select>

                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="calle" class="form-label">localidad</label>
                                <input type="text" name="localidad" class="form-control" required value="{{ old('localidad') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="calle" class="form-label">Calle</label>
                                <input type="text" name="calle" class="form-control" required value="{{ old('calle') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="colonia" class="form-label">Colonia</label>
                                <input type="text" name="colonia" class="form-control" required value="{{ old('colonia') }}">
                            </div>


                            <div class="col-md-6 mb-3">
                                <label for="numero_exterior" class="form-label">Numero exterior</label>
                                <input type="text" name="numero_exterior" class="form-control" required value="{{ old('numero_exterior') }}">
                            </div>


                            <div class="col-md-6 mb-3">
                                <label for="numero_interior" class="form-label">Numero interior</label>
                                <input type="text" name="numero_interior" class="form-control" required value="{{ old('numero_interior') }}">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="entre_calles" class="form-label">Entre calles</label>
                                <input type="text" name="entre_calles" class="form-control" required value="{{ old('entre_calles') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="colonia" class="form-label">Codigo postal</label>
                                <input type="text" name="codigo_postal" class="form-control" required value="{{ old('codigo_postal') }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="latitude">latitude</label>
                                <input type="number" step="0.00000001" name="latitude" value="{{ old('latitude') }}" class="form-control"required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="longitude">Longitude</label>
                                <input type="number" step="0.00000001" name="longitude" value="{{ old('longitude') }}" class="form-control"required>
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
