@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Detalles del Cliente') }}</h5>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Volver
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 text-center mb-3">
                            <div class="avatar avatar-xl">
                                <span class="avatar-initial rounded bg-label-primary">{{ substr($client->razon_social, 0, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">RUT Empresa</th>
                                    <td>{{ $client->rut_empresa }}</td>
                                </tr>
                                <tr>
                                    <th>Razón Social</th>
                                    <td>{{ $client->razon_social }}</td>
                                </tr>
                                <tr>
                                    <th>Rubro</th>
                                    <td>{{ $client->rubro }}</td>
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <td>{{ $client->direccion }}</td>
                                </tr>
                                <tr>
                                    <th>Teléfono</th>
                                    <td>{{ $client->telefono }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre de Contacto</th>
                                    <td>{{ $client->nombre_contacto }}</td>
                                </tr>
                                <tr>
                                    <th>Email de Contacto</th>
                                    <td>{{ $client->email_contacto }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de Registro</th>
                                    <td>{{ $client->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Última Actualización</th>
                                    <td>{{ $client->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i> Editar Cliente
                        </a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este cliente? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-trash me-1"></i> Eliminar Cliente
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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
        font-size: 1.5rem;
    }
    
    .bg-label-primary {
        background-color: rgba(115, 103, 240, 0.15) !important;
        color: #7367f0 !important;
    }
</style>
@endsection 