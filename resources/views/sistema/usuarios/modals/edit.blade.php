<!-- Modal de edición -->
<div class="modal fade" id="editarUsuarioModal-{{$usuario->id}}" tabindex="-1"
                                    aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title" id="editarUsuarioModalLabel"><i
                                                        class="bx bx-user-edit"></i> Editar Usuario</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-12 mb-3">
            <label for="name-{{$usuario->id}}" class="form-label fw-semibold">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" class="form-control"
                id="name-{{$usuario->id}}" required>
        </div>

        <div class="col-12 mb-3">
            <label for="email-{{$usuario->id}}" class="form-label fw-semibold">E-mail</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" class="form-control"
                id="email-{{$usuario->id}}" required>
        </div>

        <div class="col-12 mb-3">
            <label for="password-{{$usuario->id}}" class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" id="password-{{$usuario->id}}"
                placeholder="Dejar en blanco si no desea cambiar">
        </div>

        <div class="col-12 mb-3">
            <label for="confirm-password-{{$usuario->id}}" class="form-label fw-semibold">Confirmar Password</label>
            <input type="password" name="confirm-password" class="form-control" id="confirm-password-{{$usuario->id}}"
                placeholder="Dejar en blanco si no desea cambiar">
        </div>

        <div class="mb-3">
    <label class="form-label fw-semibold">Roles</label>
    <div class="d-flex flex-wrap">
        @foreach($roles as $roleId => $roleName)
            <div class="form-check me-3"> <!-- Utiliza 'me-3' para margen derecho -->
                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $roleName }}" id="role-{{ $usuario->id }}-{{ $roleId }}"
                    {{ in_array($roleId, old('roles', $usuario->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                <label class="form-check-label" for="role-{{ $usuario->id }}-{{ $roleId }}">
                    {{ $roleName }}
                </label>
            </div>
        @endforeach
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