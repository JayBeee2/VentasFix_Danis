@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Editar Cliente') }}</h5>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Volver
                    </a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('clients.update', $client->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="rut_empresa" class="form-label">RUT Empresa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('rut_empresa') is-invalid @enderror" id="rut_empresa" name="rut_empresa" value="{{ old('rut_empresa', $client->rut_empresa) }}" required>
                            @error('rut_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="razon_social" class="form-label">Razón Social <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('razon_social') is-invalid @enderror" id="razon_social" name="razon_social" value="{{ old('razon_social', $client->razon_social) }}" required>
                            @error('razon_social')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rubro" class="form-label">Rubro <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('rubro') is-invalid @enderror" id="rubro" name="rubro" value="{{ old('rubro', $client->rubro) }}" required>
                            @error('rubro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ old('direccion', $client->direccion) }}" required>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $client->telefono) }}" required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nombre_contacto" class="form-label">Nombre de Contacto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre_contacto') is-invalid @enderror" id="nombre_contacto" name="nombre_contacto" value="{{ old('nombre_contacto', $client->nombre_contacto) }}" required>
                            @error('nombre_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email_contacto" class="form-label">Email de Contacto <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email_contacto') is-invalid @enderror" id="email_contacto" name="email_contacto" value="{{ old('email_contacto', $client->email_contacto) }}" required>
                            @error('email_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-save me-1"></i> Actualizar Cliente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            // Validar RUT Empresa
            const rutEmpresa = document.getElementById('rut_empresa');
            if (!rutEmpresa.value.trim()) {
                rutEmpresa.classList.add('is-invalid');
                isValid = false;
            }
            
            // Validar Razón Social
            const razonSocial = document.getElementById('razon_social');
            if (!razonSocial.value.trim()) {
                razonSocial.classList.add('is-invalid');
                isValid = false;
            }
            
            // Validar Rubro
            const rubro = document.getElementById('rubro');
            if (!rubro.value.trim()) {
                rubro.classList.add('is-invalid');
                isValid = false;
            }
            
            // Validar Dirección
            const direccion = document.getElementById('direccion');
            if (!direccion.value.trim()) {
                direccion.classList.add('is-invalid');
                isValid = false;
            }
            
            // Validar Teléfono
            const telefono = document.getElementById('telefono');
            if (!telefono.value.trim()) {
                telefono.classList.add('is-invalid');
                isValid = false;
            }
            
            // Validar Nombre de Contacto
            const nombreContacto = document.getElementById('nombre_contacto');
            if (!nombreContacto.value.trim()) {
                nombreContacto.classList.add('is-invalid');
                isValid = false;
            }
            
            // Validar Email de Contacto
            const emailContacto = document.getElementById('email_contacto');
            if (!emailContacto.value.trim()) {
                emailContacto.classList.add('is-invalid');
                isValid = false;
            } else if (!validateEmail(emailContacto.value)) {
                emailContacto.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
        
        // Limpiar validaciones al cambiar input
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
        
        // Función para validar email
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
</script>
@endsection 