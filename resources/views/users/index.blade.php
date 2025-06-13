@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Listado de Usuarios') }}</h5>
                    <button type="button" class="btn btn-primary" id="create-user-btn" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class="ti ti-plus"></i> Nuevo Usuario
                    </button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>RUT</th>
                                    <th>NOMBRE</th>
                                    <th>APELLIDO</th>
                                    <th>EMAIL</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->rut }}</td>
                                    <td>{{ $user->nombre }}</td>
                                    <td>{{ $user->apellido }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="d-flex gap-3">
                                            <a href="javascript:void(0);" class="view-user text-body"
                                                    data-id="{{ $user->id }}"
                                                    data-rut="{{ $user->rut }}"
                                                    data-nombre="{{ $user->nombre }}"
                                                    data-apellido="{{ $user->apellido }}"
                                                    data-email="{{ $user->email }}">
                                                <i class="ti ti-eye text-secondary fs-4"></i>
                                            </a>
                                            
                                            <a href="javascript:void(0);" class="edit-user-btn text-body"
                                                    data-id="{{ $user->id }}"
                                                    data-rut="{{ $user->rut }}"
                                                    data-nombre="{{ $user->nombre }}"
                                                    data-apellido="{{ $user->apellido }}"
                                                    data-email="{{ str_replace('@ventasfix.cl', '', $user->email) }}">
                                                <i class="ti ti-edit text-secondary fs-4"></i>
                                            </a>
                                            
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 m-0 border-0 text-body" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                    <i class="ti ti-trash text-secondary fs-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del usuario -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">ID:</label>
                    <p id="modal-id"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">RUT:</label>
                    <p id="modal-rut"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre:</label>
                    <p id="modal-nombre"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Apellido:</label>
                    <p id="modal-apellido"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <p id="modal-email"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear usuario -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createUserForm" action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rut" class="form-label">RUT</label>
                        <input type="text" class="form-control" id="rut" name="rut" required>
                        <div class="invalid-feedback" id="rut-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <div class="invalid-feedback" id="nombre-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                        <div class="invalid-feedback" id="apellido-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Username</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="email" name="email" required>
                            <span class="input-group-text">@ventasfix.cl</span>
                        </div>
                        <small class="form-text text-muted">El email completo será username@ventasfix.cl</small>
                        <div class="invalid-feedback" id="email-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback" id="password-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        <div class="invalid-feedback" id="password-confirmation-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_rut" class="form-label">RUT</label>
                        <input type="text" class="form-control" id="edit_rut" name="rut" required>
                        <div class="invalid-feedback" id="edit-rut-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        <div class="invalid-feedback" id="edit-nombre-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="edit_apellido" name="apellido" required>
                        <div class="invalid-feedback" id="edit-apellido-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Username</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="edit_email" name="email" required>
                            <span class="input-group-text">@ventasfix.cl</span>
                        </div>
                        <small class="form-text text-muted">El email completo será username@ventasfix.cl</small>
                        <div class="invalid-feedback" id="edit-email-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Nueva Contraseña (Dejar en blanco para mantener la actual)</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                        <div class="invalid-feedback" id="edit-password-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation">
                        <div class="invalid-feedback" id="edit-password-confirmation-error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal para ver usuario
        const viewButtons = document.querySelectorAll('.view-user');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const rut = this.getAttribute('data-rut');
                const nombre = this.getAttribute('data-nombre');
                const apellido = this.getAttribute('data-apellido');
                const email = this.getAttribute('data-email');
                
                document.getElementById('modal-id').textContent = id;
                document.getElementById('modal-rut').textContent = rut;
                document.getElementById('modal-nombre').textContent = nombre;
                document.getElementById('modal-apellido').textContent = apellido;
                document.getElementById('modal-email').textContent = email;
                
                const userModal = new bootstrap.Modal(document.getElementById('userModal'));
                userModal.show();
            });
        });
        
        // Modal para editar usuario
        const editButtons = document.querySelectorAll('.edit-user-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const rut = this.getAttribute('data-rut');
                const nombre = this.getAttribute('data-nombre');
                const apellido = this.getAttribute('data-apellido');
                const email = this.getAttribute('data-email');
                
                // Actualizar la acción del formulario
                document.getElementById('editUserForm').action = `/users/${id}`;
                
                // Llenar el formulario con los datos del usuario
                document.getElementById('edit_rut').value = rut;
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_apellido').value = apellido;
                document.getElementById('edit_email').value = email;
                
                // Limpiar campos de contraseña
                document.getElementById('edit_password').value = '';
                document.getElementById('edit_password_confirmation').value = '';
                
                // Mostrar el modal
                const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                editUserModal.show();
            });
        });

        // Validación de formulario de creación
        const createUserForm = document.getElementById('createUserForm');
        createUserForm.addEventListener('submit', function(event) {
            // Verificar si la contraseña y confirmación coinciden
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            if (password !== passwordConfirmation) {
                event.preventDefault();
                document.getElementById('password_confirmation').classList.add('is-invalid');
                document.getElementById('password-confirmation-error').textContent = 'Las contraseñas no coinciden';
                return false;
            }
            
            // Validar formato de email (no debe contener @)
            const email = document.getElementById('email').value;
            if (email.includes('@')) {
                event.preventDefault();
                document.getElementById('email').classList.add('is-invalid');
                document.getElementById('email-error').textContent = 'No incluya el símbolo @ en el nombre de usuario, ya se agrega automáticamente';
                return false;
            }
            
            // Validar formato de RUT
            const rut = document.getElementById('rut').value;
            if (!validarRUT(rut)) {
                event.preventDefault();
                document.getElementById('rut').classList.add('is-invalid');
                document.getElementById('rut-error').textContent = 'El formato del RUT no es válido';
                return false;
            }
            
            return true;
        });
        
        // Validación de formulario de edición
        const editUserForm = document.getElementById('editUserForm');
        editUserForm.addEventListener('submit', function(event) {
            // Verificar si la contraseña y confirmación coinciden (solo si se ingresó contraseña)
            const password = document.getElementById('edit_password').value;
            const passwordConfirmation = document.getElementById('edit_password_confirmation').value;
            
            if (password && password !== passwordConfirmation) {
                event.preventDefault();
                document.getElementById('edit_password_confirmation').classList.add('is-invalid');
                document.getElementById('edit-password-confirmation-error').textContent = 'Las contraseñas no coinciden';
                return false;
            }
            
            // Validar formato de email (no debe contener @)
            const email = document.getElementById('edit_email').value;
            if (email.includes('@')) {
                event.preventDefault();
                document.getElementById('edit_email').classList.add('is-invalid');
                document.getElementById('edit-email-error').textContent = 'No incluya el símbolo @ en el nombre de usuario, ya se agrega automáticamente';
                return false;
            }
            
            // Validar formato de RUT
            const rut = document.getElementById('edit_rut').value;
            if (!validarRUT(rut)) {
                event.preventDefault();
                document.getElementById('edit_rut').classList.add('is-invalid');
                document.getElementById('edit-rut-error').textContent = 'El formato del RUT no es válido';
                return false;
            }
            
            return true;
        });
        
        // Función para validar formato de RUT chileno
        function validarRUT(rut) {
            // Implementar si se necesita una validación específica
            // Por ahora solo verificamos que no esté vacío
            return rut.trim().length > 0;
        }
        
        // Limpiar validaciones al cambiar inputs en formulario de creación
        const createInputs = createUserForm.querySelectorAll('input');
        createInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
        
        // Limpiar validaciones al cambiar inputs en formulario de edición
        const editInputs = editUserForm.querySelectorAll('input');
        editInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    });
</script>
@endsection 