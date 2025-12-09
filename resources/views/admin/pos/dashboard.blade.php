@extends('layouts.app')
@section('content')

@section('style')
<link href="{{ asset('assets/css/pos.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<style>
    .pos-container {
        display: flex;
        height: calc(100vh - 120px);
    }
    .product-area {
        flex: 7;
        overflow-y: auto;
        padding: 15px;
        background-color: #f5f5f5;
    }
    .cart-area {
        flex: 5;
        display: flex;
        flex-direction: column;
        border-left: 1px solid #ddd;
        background-color: #fff;
    }
    .cart-items {
        flex-grow: 1;
        overflow-y: auto;
        padding: 15px;
    }
    .cart-totals {
        padding: 15px;
        border-top: 1px solid #ddd;
        background-color: #f9f9f9;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }
    .product-card {
        position: relative;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .product-image-container {
        position: relative;
        height: 150px;
        overflow: hidden;
        background: #f8f9fa;
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
        transition: transform 0.3s ease;
        background: white;
    }
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    .product-badges {
        position: absolute;
        top: 10px;
        left: 10px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .stock-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .stock-badge.low {
        background: #dc3545;
        color: white;
    }
    .stock-badge.normal {
        background: #28a745;
        color: white;
    }
    .product-info {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .product-name {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        line-height: 1.3;
        height: 2.6em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .product-code {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .product-price {
        font-size: 1.1rem;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 5px;
    }
    .product-stock {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: auto;
    }
    .product-category {
        position: absolute;
        bottom: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 3px 8px;
        font-size: 0.75rem;
        border-radius: 3px 0 0 0;
    }
    .product-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
    }
    .action-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }
    .action-btn:hover {
        background: #f8f9fa;
        transform: scale(1.1);
    }
    .category-tabs {
        display: flex;
        overflow-x: auto;
        margin-bottom: 15px;
        padding-bottom: 5px;
    }
    .category-tab {
        padding: 8px 15px;
        background: #e9ecef;
        border-radius: 20px;
        margin-right: 10px;
        cursor: pointer;
        white-space: nowrap;
    }
    .category-tab.active {
        background: #007bff;
        color: white;
    }
    .cart-item {
        display: flex;
        border-bottom: 1px solid #eee;
        padding: 10px 0;
        margin-bottom: 10px;
    }
    .cart-item-details {
        flex-grow: 1;
        width: 100%;
    }
    .quantity-control {
        display: flex;
        align-items: center;
        margin-top: 5px;
    }
    .quantity-input {
        text-align: center;
    }
    .cart-item-actions {
        display: flex;
        align-items: center;
    }
    .quantity-control {
        display: flex;
        align-items: center;
        margin-top: 5px;
    }
    .quantity-btn {
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f0;
        border-radius: 4px;
        cursor: pointer;
    }
    .quantity-input {
        width: 40px;
        text-align: center;
        margin: 0 5px;
    }
    .payment-methods {
        display: flex;
        margin-bottom: 15px;
    }
    .payment-method {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 10px;
        cursor: pointer;
    }
    .payment-method.active {
        background: #28a745;
        color: white;
        border-color: #28a745;
    }
    .search-bar {
        margin-bottom: 15px;
    }
    .customer-info {
        margin-bottom: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 4px;
    }
    .customer-info-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .customer-extra-info {
        background: rgba(255,255,255,0.8);
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
    
    .product-card {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .product-image-container {
        position: relative;
        height: 120px;
        overflow: hidden;
        border-radius: 8px 8px 0 0;
    }
    
    .stock-badge {
        position: absolute;
        top: 5px;
        right: 5px;
    }
    
    .product-info {
        padding: 10px;
    }
    
    .product-name {
        font-size: 0.9rem;
        margin-bottom: 5px;
        height: 2.4em;
        overflow: hidden;
    }
    
    .product-price {
        font-weight: bold;
        color: #28a745;
    }
    
    .cart-header {
        border-radius: 0 0 8px 8px;
    }
    
    .cart-items {
        background: #fff;
    }
    
    .cart-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }
    
    .cart-item:hover {
        background-color: #f8f9fa;
    }
    
    .totals-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .totals-row.total {
        font-size: 1.2rem;
        font-weight: bold;
        color: #28a745;
        border-top: 2px solid #eee;
        padding-top: 10px;
        margin-top: 10px;
    }
    
    .payment-method {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        margin-right: 10px;
        margin-bottom: 10px;
        background: #f8f9fa;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .payment-method:hover {
        background: #e9ecef;
    }
    
    .payment-method.active {
        background: #28a745;
        color: white;
    }
    
    .payment-method i {
        margin-right: 5px;
    }

    .no-image-container {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #6c757d;
        padding: 20px;
    }

    .no-image-container i {
        font-size: 3rem;
        margin-bottom: 10px;
        color: #adb5bd;
    }

    .no-image-container span {
        font-size: 0.9rem;
        text-align: center;
    }
</style>
@endsection

<main class="app-main">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sistema POS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">POS</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="pos-container">
                            <!-- Product Area -->
                            <div class="product-area">
                                <div class="customer-info-section mb-4 p-3 bg-white rounded shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Información del Cliente</h5>
                                        <button class="btn btn-sm btn-primary" id="add-customer">
                                            <i class="fas fa-plus"></i> Nuevo Cliente
                                        </button>
                                    </div>
                                    <div class="customer-details">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group mb-2">
                                                    <label class="form-label">Cliente</label>
                                                    <select class="form-control select2" id="customer-select" style="width: 100%;">
                                                        <option value="">Seleccionar Cliente</option>
                                                        @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}" 
                                                                data-phone="{{ $customer->phone }}"
                                                                data-email="{{ $customer->email }}"
                                                                data-address="{{ $customer->address }}"
                                                                {{ $customer->id == 16 ? 'selected' : '' }}>
                                                            {{ $customer->name }} - {{ $customer->identification_number }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label class="form-label">Bodega</label>
                                                    <select class="form-control select2" id="warehouse-select" style="width: 100%;">
                                                        <option value="">Seleccionar Bodega</option>
                                                        @foreach($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}" {{ $warehouse->id == 1 ? 'selected' : '' }}>{{ $warehouse->warehouse_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="customer-extra-info mt-3">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <small class="text-muted">Teléfono:</small>
                                                    <p class="mb-1 customer-phone">-</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-muted">Email:</small>
                                                    <p class="mb-1 customer-email">-</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-muted">Dirección:</small>
                                                    <p class="mb-1 customer-address">-</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <small class="text-muted">Bodega:</small>
                                                    <p class="mb-1 warehouse-name">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="">Seleccione una caja</label>
                                    <select class="form-control select2" id="cash-register-select" style="width: 100%;">
                                        <option value="">Seleccionar Caja</option>
                                        @foreach($cashRegisters as $register)
                                        <option value="{{ $register->id }}">{{ $register->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="search-container mb-4">
                                    <div class="input-group">
                                        <input type="text" id="quickSearch" class="form-control" placeholder="Buscar producto por código o nombre...">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="scanBarcode">
                                                <i class="fas fa-barcode"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="searchResults" class="search-results"></div>
                                </div>

                                <div class="category-tabs mb-4">
                                    <div class="category-tab active" data-category="all">Todos</div>
                                    @foreach($categories as $category)
                                    <div class="category-tab" data-category="{{ $category->id }}">
                                        {{ $category->category_name }}
                                    </div>
                                    @endforeach
                                </div>

                                <div class="product-grid">
                                    @foreach($products as $product)
                                    <div class="product-card" 
                                         data-id="{{ $product->id }}" 
                                         data-category="{{ $product->category_id }}"
                                         data-stock-min="{{ $product->stock_min }}">
                                        <div class="product-image-container">
                                            @if($product->image)
                                                <img src="{{ asset('storage/'.$product->image) }}" 
                                                     class="product-image" alt="{{ $product->product_name }}">
                                            @else
                                                <div class="no-image-container">
                                                    <i class="fas fa-box-open"></i>
                                                    <span>Sin imagen</span>
                                                </div>
                                            @endif
                                            
                                            <div class="product-badges">
                                                @if($product->available_stock <= $product->stock_min)
                                                <span class="stock-badge low">Stock Bajo</span>
                                                @else
                                                <span class="stock-badge normal">Disponible</span>
                                                @endif
                                            </div>

                                            <div class="product-actions">
                                                <button class="action-btn" title="Ver detalles">
                                                    <i class="fas fa-info"></i>
                                                </button>
                                                <button class="action-btn add-to-cart" data-product-id="{{ $product->id }}" title="Agregar al carrito">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="product-info">
                                            <h6 class="product-name">{{ $product->product_name }}</h6>
                                            <div class="product-code">Código: {{ $product->barcode }}</div>
                                            <div class="product-price">${{ number_format($product->selling_price, 0, ',', '.') }}</div>
                                            <div class="product-stock">
                                                <i class="fas fa-box"></i> Stock: <span class="stock-amount" data-product-id="{{ $product->id }}">{{ $product->available_stock }}</span>
                                            </div>
                                            <div class="product-category">
                                                {{ $product->category->category_name ?? 'Sin categoría' }}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Cart Area -->
                            <div class="cart-area">
                                <div class="cart-header p-3 bg-white border-bottom">
                                    <h5 class="mb-0">Carrito de Venta</h5>
                                </div>
                                
                                <div class="cart-items">
                                    <div id="cart-items-container">
                                        <!-- Los items del carrito se agregarán aquí dinámicamente -->
                                    </div>
                                </div>
                                
                                <div class="cart-totals">
                                    <div class="totals-row">
                                        <span>Subtotal:</span>
                                        <span id="cart-subtotal">$0.00</span>
                                    </div>
                                    <div class="totals-row">
                                        <span>IVA:</span>
                                        <span id="cart-tax">$0.00</span>
                                    </div>
                                    <div class="totals-row">
                                        <span>Descuento:</span>
                                        <span id="cart-discount">$0.00</span>
                                    </div>
                                    <div class="totals-row total">
                                        <span>Total:</span>
                                        <span id="cart-total">$0.00</span>
                                    </div>
                                    
                                    <div class="payment-section mt-3">
                                        <h6 class="mb-3">Método de Pago</h6>
                                        <div class="payment-methods">
                                            @foreach($paymentMethods as $method)
                                            <div class="payment-method" data-id="{{ $method->id }}" {{ $method->name == 'Efectivo' ? 'class="active"' : '' }}>
                                                <i class="fas fa-{{ $method->icon ?? 'money-bill' }}"></i>
                                                {{ $method->name }}
                                            </div>
                                            @endforeach
                                        </div>
                                        
                                        <div class="payment-form mt-3">
                                            <div class="form-group">
                                                <label>Forma de Pago</label>
                                                <select class="form-control" id="payment-form">
                                                    @foreach($paymentTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->payment_type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="form-group mt-3">
                                                <label>Monto Recibido</label>
                                                <input type="number" class="form-control" id="amount-received" step="0.01">
                                            </div>
                                            
                                            <div class="form-group mt-3">
                                                <label>Cambio</label>
                                                <input type="number" class="form-control" id="change-amount" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="action-buttons mt-4">
                                            <button class="btn btn-danger btn-block mb-2" id="clear-cart">
                                                <i class="fas fa-trash"></i> Limpiar Carrito
                                            </button>
                                            <button class="btn btn-success btn-block" id="process-payment">
                                                <i class="fas fa-check"></i> Procesar Pago
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<!-- Modal para nuevo cliente -->
<div class="modal fade" id="newCustomerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="newCustomerForm">
                    <div class="form-group mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Identificación</label>
                        <input type="text" class="form-control" name="identification_number" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group mb-3">
                        <label>Dirección</label>
                        <textarea class="form-control" name="address"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveCustomer">Guardar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript">
// Configuración de toastr
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

// Configurar jQuery para incluir el token CSRF en todas las peticiones AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

$(document).ready(function() {
    // Inicializar Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        dropdownParent: $('.customer-info-section')
    });
    
    // Variables globales
    let cart = [];
    let selectedCustomer = 16; // Inicializar con el Consumidor Final
    let selectedWarehouse = 1; // Inicializar con la bodega principal
    let selectedPaymentMethod = 1; // Inicializar con el método de pago en efectivo
    
    // Hacer las funciones accesibles globalmente
    window.removeItem = function(index) {
        if (index >= 0 && index < cart.length) {
            cart.splice(index, 1);
            renderCart();
            updateCartTotals();
            toastr.success('Producto eliminado del carrito');
        }
    };

    window.updateQuantity = function(index, change) {
        if (index >= 0 && index < cart.length) {
            const newQuantity = parseInt(cart[index].quantity) + parseInt(change);
            
            if (newQuantity > 0) {
                cart[index].quantity = newQuantity;
                recalculateItemTax(cart[index]);
                renderCart();
                updateCartTotals();
            } else {
                removeItem(index);
            }
        }
    };

    // Función para renderizar el carrito
    function renderCart() {
        console.log('Renderizando carrito:', cart);
        const container = $('#cart-items-container');
        container.empty();
        
        if (cart.length === 0) {
            container.append('<div class="text-center p-3">El carrito está vacío</div>');
            return;
        }
        
        cart.forEach((item, index) => {
            container.append(`
                <div class="cart-item">
                    <div class="cart-item-details">
                        <h6 class="mb-1">${item.name}</h6>
                        <div class="d-flex justify-content-between">
                            <span>$${item.price.toFixed(2)} x ${item.quantity}</span>
                            <span>$${item.total.toFixed(2)}</span>
                        </div>
                        <div class="quantity-control">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                            <input type="number" class="quantity-input" value="${item.quantity}" 
                                   onchange="updateQuantity(${index}, this.value - ${item.quantity})">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                    </div>
                    <div class="cart-item-actions">
                        <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);
        });
    }

    // Función para actualizar totales
    function updateCartTotals() {
        const subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
        const tax = cart.reduce((sum, item) => sum + item.tax_amount, 0);
        const total = subtotal + tax;
        
        $('#cart-subtotal').text('$' + subtotal.toFixed(2));
        $('#cart-tax').text('$' + tax.toFixed(2));
        $('#cart-total').text('$' + total.toFixed(2));
        
        // Actualizar cambio
        const received = parseFloat($('#amount-received').val()) || 0;
        $('#change-amount').val((received - total).toFixed(2));
    }

    // Evento para agregar cliente
    $('#add-customer').click(function() {
        $('#newCustomerModal').modal('show');
    });
    
    // Evento para guardar nuevo cliente
    $('#saveCustomer').click(function() {
        const formData = $('#newCustomerForm').serialize();
        
        $.ajax({
            url: '{{ route("person.store") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Agregar el nuevo cliente al select
                    const option = new Option(response.customer.name + ' - ' + response.customer.identification_number, response.customer.id);
                    $('#customer-select').append(option).val(response.customer.id).trigger('change');
                    
                    // Cerrar modal y limpiar formulario
                    $('#newCustomerModal').modal('hide');
                    $('#newCustomerForm')[0].reset();
                    
                    // Mostrar mensaje de éxito
                    toastr.success('Cliente agregado exitosamente');
                }
            },
            error: function(xhr) {
                toastr.error('Error al guardar el cliente');
            }
        });
    });
    
    // Evento para seleccionar cliente
    $('#customer-select').on('change', function() {
        const option = $(this).find('option:selected');
        selectedCustomer = $(this).val();
        
        // Actualizar información del cliente
        $('.customer-phone').text(option.data('phone') || '-');
        $('.customer-email').text(option.data('email') || '-');
        $('.customer-address').text(option.data('address') || '-');
    });
    
    // Evento para seleccionar bodega
    $('#warehouse-select').on('change', function() {
        selectedWarehouse = $(this).val();
        $('.warehouse-name').text($(this).find('option:selected').text());
    });
    
    // Evento para agregar producto al carrito
    $('.add-to-cart').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const productId = $(this).data('product-id');
        console.log('Producto ID:', productId);
        
        if (!selectedWarehouse) {
            toastr.warning('Por favor seleccione una bodega');
            return;
        }
        
        // Mostrar indicador de carga
        $(this).prop('disabled', true);
        
        $.ajax({
            url: '{{ route("admin.pos.add_item") }}',
            method: 'POST',
            data: {
                item_id: productId,
                warehouse_id: selectedWarehouse,
                quantity: 1
            },
            success: function(response) {
                console.log('Respuesta:', response);
                if (response.success) {
                    // Asegurar que la cantidad sea un número
                    response.quantity = parseInt(response.quantity);
                    addToCart(response.item, response.quantity);
                    toastr.success('Producto agregado al carrito');
                } else {
                    toastr.error(response.message || 'Error al agregar el producto');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                toastr.error('Error al agregar el producto');
            },
            complete: function() {
                // Habilitar el botón nuevamente
                $('.add-to-cart').prop('disabled', false);
            }
        });
    });

    // Función para agregar al carrito
    function addToCart(item, quantity) {
        console.log('Agregando al carrito:', item, quantity);
        
        const existingItem = cart.find(i => i.id === item.id);
        
        if (existingItem) {
            // Asegurar que quantity sea un número
            quantity = parseInt(quantity);
            existingItem.quantity = parseInt(existingItem.quantity) + quantity;
            existingItem.subtotal = existingItem.price * existingItem.quantity;
            existingItem.tax_amount = existingItem.subtotal * (existingItem.tax_rate / 100);
            existingItem.total = existingItem.subtotal + existingItem.tax_amount;
        } else {
            // Asegurar que quantity sea un número
            quantity = parseInt(quantity);
            const subtotal = parseFloat(item.selling_price) * quantity;
            const tax_rate = item.tax ? parseFloat(item.tax.rate) : 0;
            const tax_amount = subtotal * (tax_rate / 100);
            
            cart.push({
                id: item.id,
                name: item.product_name,
                price: parseFloat(item.selling_price),
                quantity: quantity,
                tax_rate: tax_rate,
                tax_amount: tax_amount,
                subtotal: subtotal,
                total: subtotal + tax_amount
            });
        }
        
        renderCart();
        updateCartTotals();
    }

    // Función para recalcular el IVA de un item
    function recalculateItemTax(item) {
        item.subtotal = item.price * item.quantity;
        item.tax_amount = item.subtotal * (item.tax_rate / 100);
        item.total = item.subtotal + item.tax_amount;
    }

    // Evento para procesar pago
    $('#process-payment').click(function() {
        if (!selectedCustomer) {
            toastr.warning('Por favor seleccione un cliente');
            return;
        }
        
        if (!selectedWarehouse) {
            toastr.warning('Por favor seleccione una bodega');
            return;
        }
        
        if (!selectedPaymentMethod) {
            toastr.warning('Por favor seleccione un método de pago');
            return;
        }
        
        if (cart.length === 0) {
            toastr.warning('El carrito está vacío');
            return;
        }

        // Validar monto recibido
        const total = cart.reduce((sum, item) => sum + item.total, 0);
        const received = parseFloat($('#amount-received').val()) || 0;
        if (received < total) {
            toastr.warning('El monto recibido es menor al total');
            return;
        }
        
        const paymentData = {
            customer_id: selectedCustomer,
            warehouse_id: selectedWarehouse,
            cash_register_id: $('#cash-register-select').val(),
            payment_method_id: selectedPaymentMethod,
            payment_form_id: $('#payment-form').val(),
            items: cart,
            subtotal: cart.reduce((sum, item) => sum + item.subtotal, 0),
            tax_amount: cart.reduce((sum, item) => sum + item.tax_amount, 0),
            total: total,
            received: received,
           // Asumiendo que 1 es el ID para efectivo
            change: parseFloat($('#change-amount').val()) || 0,
            discount: parseFloat($('#cart-discount').text().replace('$', '')) || 0,
        };
        
        $.ajax({
            url: '{{ route("admin.pos.process_payment") }}',
            method: 'POST',
            data: paymentData,
            success: function(response) {
                if (response.success) {
                    // Limpiar carrito
                    cart = [];
                    renderCart();
                    updateCartTotals();
                    
                    // Limpiar campos de pago
                    $('#amount-received').val('');
                    $('#change-amount').val('');
                    
                    // Mostrar mensaje de éxito
                    toastr.success('Venta procesada exitosamente');
                    
                    // Imprimir recibo
                    window.open('{{ url("admin/pos/receipt") }}/' + response.sale_id, '_blank');

                    // Actualizar saldo de caja si es pago en efectivo
                    if (selectedPaymentMethod == 1) { // Asumiendo que 1 es el ID para efectivo
                        updateCashRegisterBalance(response.cash_register_session);
                    }
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Error al procesar el pago');
            }
        });
    });
    
    // Función para actualizar el saldo de la caja
    function updateCashRegisterBalance(session) {
        if (session && session.current_balance !== undefined) {
            // Actualizar el saldo en la interfaz si es necesario
            toastr.info('Saldo actual de caja: $' + session.current_balance.toFixed(2));
        }
    }

    // Evento para calcular cambio
    $('#amount-received').on('input', function() {
        const received = parseFloat($(this).val()) || 0;
        const total = cart.reduce((sum, item) => sum + item.total, 0);
        const change = received - total;
        
        $('#change-amount').val(change < 0 ? '0.00' : change.toFixed(2));
    });
    
    // Evento para limpiar carrito
    $('#clear-cart').click(function() {
        cart = [];
        renderCart();
        updateCartTotals();
    });
    
    // Evento para seleccionar método de pago
    $('.payment-method').click(function() {
        $('.payment-method').removeClass('active');
        $(this).addClass('active');
        selectedPaymentMethod = $(this).data('id');
    });
    
    // Evento para búsqueda rápida
    $('#quickSearch').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $('.product-card').each(function() {
            const productName = $(this).find('.product-name').text().toLowerCase();
            const productCode = $(this).find('.product-code').text().toLowerCase();
            
            if (productName.includes(searchTerm) || productCode.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Evento para filtro por categoría
    $('.category-tab').click(function() {
        $('.category-tab').removeClass('active');
        $(this).addClass('active');
        
        const category = $(this).data('category');
        
        $('.product-card').each(function() {
            if (category === 'all' || $(this).data('category') === category) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection