@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0 d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">{{ __('Listado de Clientes') }}</h5>
                    </div>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="create-client-btn" data-bs-toggle="modal" data-bs-target="#createClientModal">
                        <i class="fas fa-plus me-1"></i> Nuevo Cliente
                    </button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="datatables-clients table border-top">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>RUT</th>
                                    <th>Razón Social</th>
                                    <th>Rubro</th>
                                    <th>Contacto</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                <tr>
                                    <td></td>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->rut_empresa }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center client-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    <span class="avatar-initial rounded bg-label-primary">{{ substr($client->razon_social, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="text-heading mb-0">{{ $client->razon_social }}</h6>
                                                <small class="text-truncate">{{ $client->direccion }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $client->rubro }}</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span>{{ $client->nombre_contacto }}</span>
                                            <small class="text-truncate">{{ $client->email_contacto }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $client->telefono }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-icon btn-text-secondary rounded-pill btn-sm view-client" 
                                                    data-id="{{ $client->id }}"
                                                    data-rut="{{ $client->rut_empresa }}"
                                                    data-razon="{{ $client->razon_social }}"
                                                    data-rubro="{{ $client->rubro }}"
                                                    data-telefono="{{ $client->telefono }}"
                                                    data-direccion="{{ $client->direccion }}"
                                                    data-contacto="{{ $client->nombre_contacto }}"
                                                    data-email="{{ $client->email_contacto }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <button type="button" class="btn btn-icon btn-text-secondary rounded-pill btn-sm edit-client-btn" 
                                                    data-id="{{ $client->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-text-secondary rounded-pill btn-sm" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                                    <i class="fas fa-trash"></i>
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
                        {{ $clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del cliente -->
<div class="modal fade" id="clientModal" tabindex="-1" aria-labelledby="clientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientModalLabel">Detalles del Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12 text-center mb-3">
                        <div class="avatar avatar-xl">
                            <span class="avatar-initial rounded bg-label-primary" id="modal-iniciales"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">RUT Empresa:</label>
                    <p id="modal-rut" class="mb-1"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Razón Social:</label>
                    <p id="modal-razon" class="mb-1"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Rubro:</label>
                    <p id="modal-rubro" class="mb-1"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Dirección:</label>
                    <p id="modal-direccion" class="mb-1"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Teléfono:</label>
                    <p id="modal-telefono" class="mb-1"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Contacto:</label>
                    <p id="modal-contacto" class="mb-1"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <p id="modal-email" class="mb-1"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear cliente -->
<div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClientModalLabel">Crear Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createClientForm" action="{{ route('clients.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rut_empresa" class="form-label">RUT Empresa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rut_empresa" name="rut_empresa" required>
                        <div class="invalid-feedback" id="rut-empresa-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="razon_social" class="form-label">Razón Social <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social" required>
                        <div class="invalid-feedback" id="razon-social-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="rubro" class="form-label">Rubro <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rubro" name="rubro" required>
                        <div class="invalid-feedback" id="rubro-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                        <div class="invalid-feedback" id="direccion-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                        <div class="invalid-feedback" id="telefono-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nombre_contacto" class="form-label">Nombre de Contacto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" required>
                        <div class="invalid-feedback" id="nombre-contacto-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email_contacto" class="form-label">Email de Contacto <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email_contacto" name="email_contacto" required>
                        <div class="invalid-feedback" id="email-contacto-error"></div>
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
@endsection

@section('styles')
<style>
    .avatar {
        position: relative;
        width: 2.375rem;
        height: 2.375rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
    }
    
    .avatar.avatar-sm {
        width: 1.75rem;
        height: 1.75rem;
    }
    
    .avatar.avatar-xl {
        width: 6rem;
        height: 6rem;
    }
    
    .avatar-initial {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    .bg-label-primary {
        background-color: rgba(115, 103, 240, 0.15) !important;
        color: #7367f0 !important;
    }
    
    .btn-text-secondary {
        color: #6c757d;
        background-color: transparent;
    }
    
    .rounded-pill {
        border-radius: 50rem !important;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal para ver cliente
        const viewButtons = document.querySelectorAll('.view-client');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const rut = this.getAttribute('data-rut');
                const razon = this.getAttribute('data-razon');
                const rubro = this.getAttribute('data-rubro');
                const telefono = this.getAttribute('data-telefono');
                const direccion = this.getAttribute('data-direccion');
                const contacto = this.getAttribute('data-contacto');
                const email = this.getAttribute('data-email');
                
                document.getElementById('modal-rut').textContent = rut;
                document.getElementById('modal-razon').textContent = razon;
                document.getElementById('modal-rubro').textContent = rubro;
                document.getElementById('modal-direccion').textContent = direccion;
                document.getElementById('modal-telefono').textContent = telefono;
                document.getElementById('modal-contacto').textContent = contacto;
                document.getElementById('modal-email').textContent = email;
                document.getElementById('modal-iniciales').textContent = razon.substring(0, 2).toUpperCase();
                
                const clientModal = new bootstrap.Modal(document.getElementById('clientModal'));
                clientModal.show();
            });
        });
        
        // Modal para editar cliente
        const editButtons = document.querySelectorAll('.edit-client-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                window.location.href = "{{ url('/clients') }}/" + id + "/edit";
            });
        });
        
        // Validar formulario de creación
        const createClientForm = document.getElementById('createClientForm');
        if (createClientForm) {
            createClientForm.addEventListener('submit', function(event) {
                // Limpiar mensajes de error previos
                const invalidFields = createClientForm.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));
                
                // Validar campos obligatorios
                let hasErrors = false;
                
                const rut = document.getElementById('rut_empresa').value.trim();
                if (!rut) {
                    document.getElementById('rut_empresa').classList.add('is-invalid');
                    document.getElementById('rut-empresa-error').textContent = 'El RUT es obligatorio';
                    hasErrors = true;
                }
                
                const razon = document.getElementById('razon_social').value.trim();
                if (!razon) {
                    document.getElementById('razon_social').classList.add('is-invalid');
                    document.getElementById('razon-social-error').textContent = 'La razón social es obligatoria';
                    hasErrors = true;
                }
                
                const rubro = document.getElementById('rubro').value.trim();
                if (!rubro) {
                    document.getElementById('rubro').classList.add('is-invalid');
                    document.getElementById('rubro-error').textContent = 'El rubro es obligatorio';
                    hasErrors = true;
                }
                
                const direccion = document.getElementById('direccion').value.trim();
                if (!direccion) {
                    document.getElementById('direccion').classList.add('is-invalid');
                    document.getElementById('direccion-error').textContent = 'La dirección es obligatoria';
                    hasErrors = true;
                }
                
                const telefono = document.getElementById('telefono').value.trim();
                if (!telefono) {
                    document.getElementById('telefono').classList.add('is-invalid');
                    document.getElementById('telefono-error').textContent = 'El teléfono es obligatorio';
                    hasErrors = true;
                }
                
                const nombreContacto = document.getElementById('nombre_contacto').value.trim();
                if (!nombreContacto) {
                    document.getElementById('nombre_contacto').classList.add('is-invalid');
                    document.getElementById('nombre-contacto-error').textContent = 'El nombre de contacto es obligatorio';
                    hasErrors = true;
                }
                
                const emailContacto = document.getElementById('email_contacto').value.trim();
                if (!emailContacto) {
                    document.getElementById('email_contacto').classList.add('is-invalid');
                    document.getElementById('email-contacto-error').textContent = 'El email de contacto es obligatorio';
                    hasErrors = true;
                } else if (!validateEmail(emailContacto)) {
                    document.getElementById('email_contacto').classList.add('is-invalid');
                    document.getElementById('email-contacto-error').textContent = 'El formato del email no es válido';
                    hasErrors = true;
                }
                
                if (hasErrors) {
                    event.preventDefault();
                    return false;
                }
                
                return true;
            });
            
            // Limpiar validaciones al cambiar inputs
            const createInputs = createClientForm.querySelectorAll('input');
            createInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                });
            });
        }
        
        // Función para validar email
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
</script>
@endsection 