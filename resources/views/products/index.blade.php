@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0 d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">{{ __('Listado de Productos') }}</h5>
                    </div>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="create-product-btn" data-bs-toggle="modal" data-bs-target="#createProductModal">
                        <i class="ti ti-plus me-1"></i> Nuevo Producto
                    </button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="datatables-products table border-top">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>SKU</th>
                                    <th>Nombre</th>
                                    <th>Precio Neto</th>
                                    <th>Precio Venta</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td></td>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center product-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    @if($product->imagen)
                                                        <img src="{{ asset('storage/'.$product->imagen) }}" alt="Imagen de producto" class="rounded">
                                                    @else
                                                        <span class="avatar-initial rounded bg-label-primary">{{ substr($product->nombre, 0, 2) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="text-heading mb-0">{{ $product->nombre }}</h6>
                                                <small class="text-truncate">{{ $product->descripcion_corta }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($product->precio_neto, 0, ',', '.') }}</td>
                                    <td>${{ number_format($product->precio_venta, 0, ',', '.') }}</td>
                                    <td>
                                        @if($product->stock_actual <= $product->stock_bajo)
                                            <span class="badge bg-label-danger">{{ $product->stock_actual }}</span>
                                        @elseif($product->stock_actual >= $product->stock_alto)
                                            <span class="badge bg-label-success">{{ $product->stock_actual }}</span>
                                        @else
                                            <span class="badge bg-label-warning">{{ $product->stock_actual }}</span>
                                        @endif
                                    </td>
                                    <td>
                                                                @if($product->stock_actual <= $product->stock_minimo)
                            <span class="badge bg-label-danger"><i class="ti ti-alert-circle me-1"></i> Bajo Stock</span>
                        @else
                            <span class="badge bg-label-success"><i class="ti ti-check-circle me-1"></i> Disponible</span>
                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-icon btn-text-secondary rounded-pill btn-sm view-product" 
                                                    data-id="{{ $product->id }}" id="ver-producto-{{ $product->id }}">
                                                <i class="ti ti-eye"></i>
                                            </button>
                                            
                                            <button type="button" class="btn btn-icon btn-text-secondary rounded-pill btn-sm edit-product-btn" 
                                                    data-id="{{ $product->id }}" id="editar-producto-{{ $product->id }}">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-text-secondary rounded-pill btn-sm" 
                                                        onclick="return confirm('¿Estás seguro de eliminar este producto?')"
                                                        id="eliminar-producto-{{ $product->id }}">
                                                    <i class="ti ti-trash"></i>
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
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalles del producto -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3 mb-md-0">
                        <div id="modal-imagen-container" class="mb-3">
                            <img id="modal-imagen" src="" alt="Imagen de producto" class="img-fluid rounded" style="max-height: 200px; display: none;">
                            <div id="modal-imagen-placeholder" class="avatar avatar-xl">
                                <span class="avatar-initial rounded bg-label-primary" id="modal-iniciales"></span>
                            </div>
                        </div>
                        <span class="badge bg-label-primary" id="modal-stock"></span>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">SKU:</label>
                            <p id="modal-sku" class="mb-1"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre:</label>
                            <p id="modal-nombre" class="mb-1"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción Corta:</label>
                            <p id="modal-descripcion-corta" class="mb-1"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción Larga:</label>
                            <p id="modal-descripcion-larga" class="mb-1"></p>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Precio Neto:</label>
                                <p id="modal-precio-neto" class="mb-1"></p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Precio Venta:</label>
                                <p id="modal-precio-venta" class="mb-1"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Stock Actual:</label>
                                <p id="modal-stock-actual" class="mb-1"></p>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-bold">Stock Mínimo:</label>
                                <p id="modal-stock-minimo" class="mb-1"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear producto -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Crear Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createProductForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sku" name="sku" required>
                            <div class="invalid-feedback" id="sku-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                            <div class="invalid-feedback" id="nombre-error"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion_corta" class="form-label">Descripción Corta <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="descripcion_corta" name="descripcion_corta" required>
                        <div class="invalid-feedback" id="descripcion-corta-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion_larga" class="form-label">Descripción Larga <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="descripcion_larga" name="descripcion_larga" rows="3" required></textarea>
                        <div class="invalid-feedback" id="descripcion-larga-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                        <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                        <div class="invalid-feedback" id="imagen-error"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="precio_neto" class="form-label">Precio Neto <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio_neto" name="precio_neto" min="0" required>
                            </div>
                            <div class="invalid-feedback" id="precio-neto-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="precio_venta" class="form-label">Precio Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="precio_venta" name="precio_venta" min="0" readonly>
                            </div>
                            <small class="form-text text-muted">Se calcula automáticamente (IVA 19%)</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_actual" name="stock_actual" min="0" required>
                            <div class="invalid-feedback" id="stock-actual-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" min="0" required>
                            <div class="invalid-feedback" id="stock-minimo-error"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock_bajo" class="form-label">Nivel Stock Bajo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_bajo" name="stock_bajo" min="0" required>
                            <small class="form-text text-muted">Para mostrar en rojo</small>
                            <div class="invalid-feedback" id="stock-bajo-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock_alto" class="form-label">Nivel Stock Alto <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stock_alto" name="stock_alto" min="0" required>
                            <small class="form-text text-muted">Para mostrar en verde</small>
                            <div class="invalid-feedback" id="stock-alto-error"></div>
                        </div>
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

<!-- Modal para editar producto -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_sku" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_sku" name="sku" required>
                            <div class="invalid-feedback" id="edit-sku-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                            <div class="invalid-feedback" id="edit-nombre-error"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_descripcion_corta" class="form-label">Descripción Corta <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_descripcion_corta" name="descripcion_corta" required>
                        <div class="invalid-feedback" id="edit-descripcion-corta-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_descripcion_larga" class="form-label">Descripción Larga <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_descripcion_larga" name="descripcion_larga" rows="3" required></textarea>
                        <div class="invalid-feedback" id="edit-descripcion-larga-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="edit_imagen" name="imagen">
                        <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
                        <div id="current_image_container" class="mt-2" style="display: none;">
                            <p>Imagen actual:</p>
                            <img id="current_image" src="" alt="Imagen actual" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                        <div class="invalid-feedback" id="edit-imagen-error"></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_precio_neto" class="form-label">Precio Neto <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="edit_precio_neto" name="precio_neto" min="0" required>
                            </div>
                            <div class="invalid-feedback" id="edit-precio-neto-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_precio_venta" class="form-label">Precio Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="edit_precio_venta" name="precio_venta" min="0" readonly>
                            </div>
                            <small class="form-text text-muted">Se calcula automáticamente (IVA 19%)</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_stock_actual" name="stock_actual" min="0" required>
                            <div class="invalid-feedback" id="edit-stock-actual-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_stock_minimo" name="stock_minimo" min="0" required>
                            <div class="invalid-feedback" id="edit-stock-minimo-error"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_stock_bajo" class="form-label">Nivel Stock Bajo <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_stock_bajo" name="stock_bajo" min="0" required>
                            <small class="form-text text-muted">Para mostrar en rojo</small>
                            <div class="invalid-feedback" id="edit-stock-bajo-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_stock_alto" class="form-label">Nivel Stock Alto <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="edit_stock_alto" name="stock_alto" min="0" required>
                            <small class="form-text text-muted">Para mostrar en verde</small>
                            <div class="invalid-feedback" id="edit-stock-alto-error"></div>
                        </div>
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

<!-- Script para corregir el problema con los modales -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar primero Bootstrap si es necesario
        if (typeof bootstrap === 'undefined') {
            console.log('Cargando Bootstrap...');
            const script = document.createElement('script');
            script.src = "{{ asset('assets/vendor/js/bootstrap.bundle.min.js') }}";
            document.body.appendChild(script);
            
            script.onload = function() {
                console.log('Bootstrap cargado correctamente');
                inicializarEventos();
            };
        } else {
            console.log('Bootstrap ya está disponible');
            inicializarEventos();
        }
        
        function inicializarEventos() {
            console.log('Inicializando eventos...');
            
            // Botones de ver producto
            const viewButtons = document.querySelectorAll('.view-product');
            console.log('Botones de ver producto encontrados:', viewButtons.length);
            
            viewButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    console.log('Click en ver producto ID:', id);
                    
                    // Usar la nueva ruta específica para AJAX
                    const url = "{{ url('/products/data') }}/" + id;
                    console.log('Consultando URL:', url);
                    
                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Respuesta status:', response.status);
                        if (!response.ok) {
                            throw new Error(`Error HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Datos recibidos:', data);
                        
                        // Actualizar el modal con los datos
                        document.getElementById('modal-sku').textContent = data.sku;
                        document.getElementById('modal-nombre').textContent = data.nombre;
                        document.getElementById('modal-descripcion-corta').textContent = data.descripcion_corta;
                        document.getElementById('modal-descripcion-larga').textContent = data.descripcion_larga;
                        document.getElementById('modal-precio-neto').textContent = `$${new Intl.NumberFormat('es-CL').format(data.precio_neto)}`;
                        document.getElementById('modal-precio-venta').textContent = `$${new Intl.NumberFormat('es-CL').format(data.precio_venta)}`;
                        document.getElementById('modal-stock-actual').textContent = data.stock_actual;
                        document.getElementById('modal-stock-minimo').textContent = data.stock_minimo;
                        
                        // Configurar la imagen
                        const imagen = document.getElementById('modal-imagen');
                        const imagenPlaceholder = document.getElementById('modal-imagen-placeholder');
                        const iniciales = document.getElementById('modal-iniciales');
                        
                        if (data.imagen) {
                            imagen.src = "{{ asset('storage') }}/" + data.imagen;
                            imagen.style.display = 'block';
                            imagenPlaceholder.style.display = 'none';
                        } else {
                            imagen.style.display = 'none';
                            imagenPlaceholder.style.display = 'flex';
                            iniciales.textContent = data.nombre.substring(0, 2).toUpperCase();
                        }
                        
                        // Configurar el estado del stock
                        const stockBadge = document.getElementById('modal-stock');
                        if (data.stock_actual <= data.stock_minimo) {
                            stockBadge.className = 'badge bg-label-danger';
                            stockBadge.innerHTML = '<i class="ti ti-alert-circle me-1"></i> Bajo Stock';
                        } else {
                            stockBadge.className = 'badge bg-label-success';
                            stockBadge.innerHTML = '<i class="ti ti-check-circle me-1"></i> Disponible';
                        }
                        
                        // Mostrar el modal usando bootstrap
                        console.log('Mostrando modal...');
                        const modalElement = document.getElementById('productModal');
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error en la petición:', error);
    
                    });
                });
            });
            
            // Botones de editar producto 
            const editButtons = document.querySelectorAll('.edit-product-btn');
            console.log('Botones de editar producto encontrados:', editButtons.length);
            
            editButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    console.log('Click en editar producto ID:', id);
                    
                    // Usar la misma ruta específica para AJAX que ver-producto
                    const url = "{{ url('/products/data') }}/" + id;
                    console.log('Consultando URL para edición:', url);
                    
                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Respuesta status (edición):', response.status);
                        if (!response.ok) {
                            throw new Error(`Error HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Datos recibidos para edición:', data);
                        
                        // Configurar la acción del formulario
                        const form = document.getElementById('editProductForm');
                        form.action = "{{ url('/products') }}/" + id;
                        
                        // Llenar el formulario con los datos del producto
                        document.getElementById('edit_sku').value = data.sku;
                        document.getElementById('edit_nombre').value = data.nombre;
                        document.getElementById('edit_descripcion_corta').value = data.descripcion_corta;
                        document.getElementById('edit_descripcion_larga').value = data.descripcion_larga;
                        document.getElementById('edit_precio_neto').value = data.precio_neto;
                        document.getElementById('edit_precio_venta').value = data.precio_venta;
                        document.getElementById('edit_stock_actual').value = data.stock_actual;
                        document.getElementById('edit_stock_minimo').value = data.stock_minimo;
                        document.getElementById('edit_stock_bajo').value = data.stock_bajo;
                        document.getElementById('edit_stock_alto').value = data.stock_alto;
                        
                        // Mostrar la imagen actual si existe
                        const currentImageContainer = document.getElementById('current_image_container');
                        const currentImage = document.getElementById('current_image');
                        
                        if (data.imagen) {
                            currentImage.src = "{{ asset('storage') }}/" + data.imagen;
                            currentImageContainer.style.display = 'block';
                        } else {
                            currentImageContainer.style.display = 'none';
                        }
                        
                        // Mostrar el modal usando bootstrap
                        console.log('Mostrando modal de edición...');
                        const modalElement = document.getElementById('editProductModal');
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error en la petición de edición:', error);

                    });
                });
            });
        }
    });
</script>

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
    
    .bg-label-success {
        background-color: rgba(40, 199, 111, 0.15) !important;
        color: #28c76f !important;
    }
    
    .bg-label-danger {
        background-color: rgba(234, 84, 85, 0.15) !important;
        color: #ea5455 !important;
    }
    
    .bg-label-warning {
        background-color: rgba(255, 159, 67, 0.15) !important;
        color: #ff9f43 !important;
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
    // Asegurarnos que bootstrap está disponible
    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap no está cargado correctamente');
        // Cargar bootstrap
        const script = document.createElement('script');
        script.src = '{{ asset("assets/vendor/js/bootstrap.js") }}';
        document.head.appendChild(script);
    } else {
        console.log('Bootstrap está cargado correctamente');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Modal para ver producto
        const viewButtons = document.querySelectorAll('.view-product');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                console.log('Click en ver producto ID:', id);
                
                // Hacer una petición AJAX para obtener los detalles completos
                fetch(`/products/${id}`)
                    .then(response => {
                        if (!response.ok) {
                            console.error('Error de respuesta:', response.status, response.statusText);
                            throw new Error(`No se pudo obtener la información del producto. Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Datos recibidos:', data);
                        
                        // Llenar el modal con los datos del producto
                        document.getElementById('modal-sku').textContent = data.sku;
                        document.getElementById('modal-nombre').textContent = data.nombre;
                        document.getElementById('modal-descripcion-corta').textContent = data.descripcion_corta;
                        document.getElementById('modal-descripcion-larga').textContent = data.descripcion_larga;
                        document.getElementById('modal-precio-neto').textContent = `$${new Intl.NumberFormat('es-CL').format(data.precio_neto)}`;
                        document.getElementById('modal-precio-venta').textContent = `$${new Intl.NumberFormat('es-CL').format(data.precio_venta)}`;
                        document.getElementById('modal-stock-actual').textContent = data.stock_actual;
                        document.getElementById('modal-stock-minimo').textContent = data.stock_minimo;
                        
                        // Configurar la imagen o iniciales
                        const imagenContainer = document.getElementById('modal-imagen-container');
                        const imagen = document.getElementById('modal-imagen');
                        const imagenPlaceholder = document.getElementById('modal-imagen-placeholder');
                        const iniciales = document.getElementById('modal-iniciales');
                        
                        if (data.imagen) {
                            imagen.src = `/storage/${data.imagen}`;
                            imagen.style.display = 'block';
                            imagenPlaceholder.style.display = 'none';
                        } else {
                            imagen.style.display = 'none';
                            imagenPlaceholder.style.display = 'flex';
                            iniciales.textContent = data.nombre.substring(0, 2).toUpperCase();
                        }
                        
                        // Configurar el estado del stock
                        const stockBadge = document.getElementById('modal-stock');
                        if (data.stock_actual <= data.stock_minimo) {
                            stockBadge.className = 'badge bg-label-danger';
                            stockBadge.innerHTML = '<i class="ti ti-alert-circle me-1"></i> Bajo Stock';
                        } else {
                            stockBadge.className = 'badge bg-label-success';
                            stockBadge.innerHTML = '<i class="ti ti-check-circle me-1"></i> Disponible';
                        }
                        
                        try {
                            // Mostrar el modal
                            const productModalEl = document.getElementById('productModal');
                            const productModal = new bootstrap.Modal(productModalEl);
                            productModal.show();
                            console.log('Modal mostrado');
                        } catch (error) {
                            console.error('Error al mostrar el modal:', error);
                        }
                    })
                    .catch(error => {
                        console.error('Error detallado:', error);
                    });
            });
        });
        
        // Modal para editar producto
        const editButtons = document.querySelectorAll('.edit-product-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                // Hacer una petición AJAX para obtener los datos del producto
                fetch(`/products/${id}`)
                    .then(response => {
                        if (!response.ok) {
                            console.error('Error de respuesta (edición):', response.status, response.statusText);
                            throw new Error(`No se pudo obtener la información del producto para editar. Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Configurar la acción del formulario
                        const form = document.getElementById('editProductForm');
                        form.action = `/products/${id}`;
                        
                        // Llenar el formulario con los datos del producto
                        document.getElementById('edit_sku').value = data.sku;
                        document.getElementById('edit_nombre').value = data.nombre;
                        document.getElementById('edit_descripcion_corta').value = data.descripcion_corta;
                        document.getElementById('edit_descripcion_larga').value = data.descripcion_larga;
                        document.getElementById('edit_precio_neto').value = data.precio_neto;
                        document.getElementById('edit_precio_venta').value = data.precio_venta;
                        document.getElementById('edit_stock_actual').value = data.stock_actual;
                        document.getElementById('edit_stock_minimo').value = data.stock_minimo;
                        document.getElementById('edit_stock_bajo').value = data.stock_bajo;
                        document.getElementById('edit_stock_alto').value = data.stock_alto;
                        
                        // Mostrar la imagen actual si existe
                        const currentImageContainer = document.getElementById('current_image_container');
                        const currentImage = document.getElementById('current_image');
                        
                        if (data.imagen) {
                            currentImage.src = `/storage/${data.imagen}`;
                            currentImageContainer.style.display = 'block';
                        } else {
                            currentImageContainer.style.display = 'none';
                        }
                        
                        // Mostrar el modal
                        const editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                        editProductModal.show();
                    })
                    .catch(error => {
                        console.error('Error detallado (edición):', error);
                    });
            });
        });
        
        // Calcular precio de venta automáticamente para formulario de creación
        const precioNetoInput = document.getElementById('precio_neto');
        const precioVentaInput = document.getElementById('precio_venta');
        
        if (precioNetoInput && precioVentaInput) {
            precioNetoInput.addEventListener('input', function() {
                const precioNeto = parseFloat(this.value) || 0;
                const iva = precioNeto * 0.19;
                const precioVenta = precioNeto + iva;
                precioVentaInput.value = Math.round(precioVenta);
            });
        }
        
        // Calcular precio de venta automáticamente para formulario de edición
        const editPrecioNetoInput = document.getElementById('edit_precio_neto');
        const editPrecioVentaInput = document.getElementById('edit_precio_venta');
        
        if (editPrecioNetoInput && editPrecioVentaInput) {
            editPrecioNetoInput.addEventListener('input', function() {
                const precioNeto = parseFloat(this.value) || 0;
                const iva = precioNeto * 0.19;
                const precioVenta = precioNeto + iva;
                editPrecioVentaInput.value = Math.round(precioVenta);
            });
        }
        
        // Validar formulario de creación
        const createProductForm = document.getElementById('createProductForm');
        if (createProductForm) {
            createProductForm.addEventListener('submit', function(event) {
                // Limpiar mensajes de error previos
                const invalidFields = createProductForm.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));
                
                // Validar campos obligatorios
                let hasErrors = false;
                
                const sku = document.getElementById('sku').value.trim();
                if (!sku) {
                    document.getElementById('sku').classList.add('is-invalid');
                    document.getElementById('sku-error').textContent = 'El SKU es obligatorio';
                    hasErrors = true;
                }
                
                const nombre = document.getElementById('nombre').value.trim();
                if (!nombre) {
                    document.getElementById('nombre').classList.add('is-invalid');
                    document.getElementById('nombre-error').textContent = 'El nombre es obligatorio';
                    hasErrors = true;
                }
                
                const descripcionCorta = document.getElementById('descripcion_corta').value.trim();
                if (!descripcionCorta) {
                    document.getElementById('descripcion_corta').classList.add('is-invalid');
                    document.getElementById('descripcion-corta-error').textContent = 'La descripción corta es obligatoria';
                    hasErrors = true;
                }
                
                const descripcionLarga = document.getElementById('descripcion_larga').value.trim();
                if (!descripcionLarga) {
                    document.getElementById('descripcion_larga').classList.add('is-invalid');
                    document.getElementById('descripcion-larga-error').textContent = 'La descripción larga es obligatoria';
                    hasErrors = true;
                }
                
                const precioNeto = document.getElementById('precio_neto').value;
                if (!precioNeto || parseFloat(precioNeto) <= 0) {
                    document.getElementById('precio_neto').classList.add('is-invalid');
                    document.getElementById('precio-neto-error').textContent = 'El precio neto debe ser mayor a 0';
                    hasErrors = true;
                }
                
                const stockActual = document.getElementById('stock_actual').value;
                if (!stockActual || parseInt(stockActual) < 0) {
                    document.getElementById('stock_actual').classList.add('is-invalid');
                    document.getElementById('stock-actual-error').textContent = 'El stock actual no puede ser negativo';
                    hasErrors = true;
                }
                
                if (hasErrors) {
                    event.preventDefault();
                    return false;
                }
                
                return true;
            });
            
            // Limpiar validaciones al cambiar inputs
            const createInputs = createProductForm.querySelectorAll('input, textarea');
            createInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                });
            });
        }
        
        // Validar formulario de edición
        const editProductForm = document.getElementById('editProductForm');
        if (editProductForm) {
            editProductForm.addEventListener('submit', function(event) {
                // Limpiar mensajes de error previos
                const invalidFields = editProductForm.querySelectorAll('.is-invalid');
                invalidFields.forEach(field => field.classList.remove('is-invalid'));
                
                // Validar campos obligatorios
                let hasErrors = false;
                
                const sku = document.getElementById('edit_sku').value.trim();
                if (!sku) {
                    document.getElementById('edit_sku').classList.add('is-invalid');
                    document.getElementById('edit-sku-error').textContent = 'El SKU es obligatorio';
                    hasErrors = true;
                }
                
                const nombre = document.getElementById('edit_nombre').value.trim();
                if (!nombre) {
                    document.getElementById('edit_nombre').classList.add('is-invalid');
                    document.getElementById('edit-nombre-error').textContent = 'El nombre es obligatorio';
                    hasErrors = true;
                }
                
                const descripcionCorta = document.getElementById('edit_descripcion_corta').value.trim();
                if (!descripcionCorta) {
                    document.getElementById('edit_descripcion_corta').classList.add('is-invalid');
                    document.getElementById('edit-descripcion-corta-error').textContent = 'La descripción corta es obligatoria';
                    hasErrors = true;
                }
                
                const descripcionLarga = document.getElementById('edit_descripcion_larga').value.trim();
                if (!descripcionLarga) {
                    document.getElementById('edit_descripcion_larga').classList.add('is-invalid');
                    document.getElementById('edit-descripcion-larga-error').textContent = 'La descripción larga es obligatoria';
                    hasErrors = true;
                }
                
                const precioNeto = document.getElementById('edit_precio_neto').value;
                if (!precioNeto || parseFloat(precioNeto) <= 0) {
                    document.getElementById('edit_precio_neto').classList.add('is-invalid');
                    document.getElementById('edit-precio-neto-error').textContent = 'El precio neto debe ser mayor a 0';
                    hasErrors = true;
                }
                
                const stockActual = document.getElementById('edit_stock_actual').value;
                if (!stockActual || parseInt(stockActual) < 0) {
                    document.getElementById('edit_stock_actual').classList.add('is-invalid');
                    document.getElementById('edit-stock-actual-error').textContent = 'El stock actual no puede ser negativo';
                    hasErrors = true;
                }
                
                if (hasErrors) {
                    event.preventDefault();
                    return false;
                }
                
                return true;
            });
            
            // Limpiar validaciones al cambiar inputs
            const editInputs = editProductForm.querySelectorAll('input, textarea');
            editInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                });
            });
        }
    });
</script>
@endsection 