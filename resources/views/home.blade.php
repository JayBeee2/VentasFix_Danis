@extends('layouts.app')

@section('content')
<h4 class="py-3 mb-4">¡Bienvenido {{ Auth::user()->nombre }}!</h4>

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column">
                <i class="ti ti-users ti-lg mb-3 text-primary"></i>
                <h5 class="card-title">Usuarios</h5>
                <p class="card-text flex-grow-1">Gestiona los usuarios del sistema.</p>
                <a href="{{ route('users.index') }}" class="btn btn-primary waves-effect waves-light mt-auto">
                    Ir a Usuarios
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column">
                <i class="ti ti-box ti-lg mb-3 text-success"></i>
                <h5 class="card-title">Productos</h5>
                <p class="card-text flex-grow-1">Administra el inventario de productos.</p>
                <a href="{{ route('products.index') }}" class="btn btn-success waves-effect waves-light mt-auto">
                    Ir a Productos
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column">
                <i class="ti ti-briefcase ti-lg mb-3 text-info"></i>
                <h5 class="card-title">Clientes</h5>
                <p class="card-text flex-grow-1">Gestiona la información de clientes.</p>
                <a href="{{ route('clients.index') }}" class="btn btn-info waves-effect waves-light mt-auto">
                    Ir a Clientes
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card h-100 text-center">
            <div class="card-body d-flex flex-column">
                <i class="ti ti-chart-bar ti-lg mb-3 text-warning"></i>
                <h5 class="card-title">Dashboard</h5>
                <p class="card-text flex-grow-1">Ver estadísticas y resumen del sistema.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-warning waves-effect waves-light mt-auto">
                    Ir al Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 