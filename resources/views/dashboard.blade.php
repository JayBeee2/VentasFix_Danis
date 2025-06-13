@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-header">Usuarios</div>
                                <div class="card-body">
                                    <h5 class="card-title">Total de Usuarios</h5>
                                    <p class="card-text display-4">{{ $userCount }}</p>
                                    <a href="{{ route('users.index') }}" class="btn btn-light">Ver Usuarios</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-header">Productos</div>
                                <div class="card-body">
                                    <h5 class="card-title">Total de Productos</h5>
                                    <p class="card-text display-4">{{ $productCount }}</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-light">Ver Productos</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-header">Clientes</div>
                                <div class="card-body">
                                    <h5 class="card-title">Total de Clientes</h5>
                                    <p class="card-text display-4">{{ $clientCount }}</p>
                                    <a href="{{ route('clients.index') }}" class="btn btn-light">Ver Clientes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 