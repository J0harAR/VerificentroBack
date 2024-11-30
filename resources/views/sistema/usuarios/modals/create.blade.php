<!-- Modal para crear nuevo usuario -->
<div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" aria-labelledby="nuevoUsuarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="nuevoUsuarioModalLabel"><i class="bx bx-user-plus"></i> Alta de Usuarios
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('usuarios.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" required class="form-control">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="form-group">
                <label for="confirm-password">Confirmar Password</label>
                <input type="password" name="confirm-password" required class="form-control">
                @error('confirm-password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="form-group">
                <label for="roles">Roles</label>
                <div>
                    @foreach($roles as $role)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role }}" id="role-{{ $role }}" 
                            {{ in_array($role, old('roles', $userRoles ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-{{ $role }}"> 
                                {{ $role }}
                            </label>
                        </div>
                    @endforeach
                    @if ($errors->has('roles'))
                        <div class="mt-1">
                            <small class="text-danger">Seleccione uno o más roles para poder guardar el usuario.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-success fw-semibold me-2">Guardar</button>
        <button type="button" class="btn btn-outline-secondary fw-semibold" data-bs-dismiss="modal">Cancelar</button>
    </div>
</form>
               
            </div>
        </div>
    </div>
</div>