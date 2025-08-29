@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Nueva Nota de Pedido</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/purchase_order/list') }}">Órdenes de Compra</a></li>
                        <li class="breadcrumb-item active">Nueva Nota</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Información de la Nota</h5>
                </div>
                <div class="card-body">
                    <form action="" id="purchaseOrderForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="supplier_id" class="form-label">Proveedor</label>
                                <select class="form-select" id="supplier_id" name="supplier_id">
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="">Bodega</label>
                                <select class="form-select" id="warehouse_id" name="warehouse_id">
                                    <option value="">Seleccione una Bodega</option>
                                    @php
                                        $defaultWarehouseId = 1; // Reemplaza 5 con el ID de la bodega por defecto
                                    @endphp

                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ $warehouse->id == $defaultWarehouseId ? 'selected' : '' }}>
                                            {{ $warehouse->warehouse_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="supplier_id" class="form-label">Estado</label>
                                <select class="form-select" id="status_order_id" name="status_order_id">
                                    <option value="">Seleccione un Estado</option>
                                   
                                    @foreach ($status_order as $status )
                                    <option value="{{ $status->id }}" {{ $status->name == 'Borrador'?'selected' : '' }}>
                                        {{ $status->name }}</option>
                                   
                               @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="order_date" class="form-label">Fecha de la Orden</label>
                                <input type="date" class="form-control" id="order_date" name="order_date">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="expected_date" class="form-label">Fecha Esperada de Entrega</label>
                                <input type="date" class="form-control" id="expected_date" name="expected_date">
                            </div>
                            <div class="col-md-4">
                                <label for="notes" class="form-label">Notas</label>
                                <textarea class="form-control" id="notes" name="notes" rows="1"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="">Moneda</label>
                                <select class="form-select" id="currency_id" name="currency_id">
                                    <option value="">Seleccione una Moneda</option>
                                    @foreach($currencies as $currency)
                                    // mostrar seleccionada el valor con id 170
                                    @if($currency->id == 170)
                                    <option selected value="{{$currency->id}}">{{$currency->currency_name}}</option>
                                    @else
                                    <option value="{{$currency->id}}">{{$currency->currency_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                        <div class="card mt-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title">Productos</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary" id="addItemBtn">
                                            <i class="fas fa-plus"></i> Agregar Producto
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="itemsTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Producto</th>
                                                <th width="120">Cantidad</th>
                                                <th width="150">Precio Unitario</th>
                                                <th width="100">Impuesto %</th>
                                                <th width="150">Subtotal</th>
                                                <th width="150">Total</th>
                                                <th width="80">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="noItemsRow">
                                                <td colspan="7" class="text-center">No hay productos agregados</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                                <td colspan="3"><span id="orderSubtotal">$0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Impuestos:</strong></td>
                                                <td colspan="3"><span id="orderTaxAmount">$0.00</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                                <td colspan="3"><span id="orderTotal">$0.00</span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12 text-end">
                                <a href="{{url('admin/purchase_order/list')}}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary" id="saveOrderBtn">
                                    <i class="fas fa-save"></i> Guardar Orden
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal para seleccionar productos -->
<div class="modal fade" id="itemSelectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="itemSearchInput" placeholder="Buscar producto...">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="itemsSelectionTable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Unidad</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Items will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        // Variables globales
        let items = [];
        let selectedItems = [];
        let itemRowCounter = 0;
        
        // Cargar productos
        function loadItems() {
            $.ajax({
                url: "{{ route('admin.purchase_orders.get_items') }}",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    items = data;
                    renderItemsTable();
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar productos:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cargar los productos'
                    });
                }
            });
        }
        
        // Renderizar tabla de productos
        function renderItemsTable() {
            const tableBody = $('#itemsSelectionTable tbody');
            tableBody.empty();
            
            $.each(items, function(index, item) {
                const row = `
                    <tr>
                        <td>${item.barcode || 'N/A'}</td>
                        <td>${item.product_name}</td>
                        <td>${item.category ? item.category.category_name : 'N/A'}</td>
                        <td>${item.measure ? item.measure.measure_name : 'N/A'}</td>
                        <td>${formatCurrency(item.cost_price)}</td>
                        <td>
                            <button class="btn btn-primary btn-sm select-item" data-item='${JSON.stringify(item)}'>
                                <i class="fas fa-plus"></i> Seleccionar
                            </button>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
            
            // Filtrar productos
            $('#itemSearchInput').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('#itemsSelectionTable tbody tr').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.indexOf(searchTerm) > -1);
                });
            });
        }
        
        // Agregar producto al hacer clic en el botón
        $(document).on('click', '.select-item', function() {
            const itemData = $(this).data('item');
            addItemToOrder(itemData);
            $('#itemSelectionModal').modal('hide');
        });
        
        // Agregar producto a la orden
        function addItemToOrder(item) {
            // Verificar si el producto ya está en la lista
            const existingItem = selectedItems.find(i => i.item_id === item.id);
            if (existingItem) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Producto ya agregado',
                    text: 'Este producto ya está en la lista. Puede modificar la cantidad si lo desea.'
                });
                return;
            }
            
            itemRowCounter++;
            const taxRate = item.tax ? item.tax.rate : 0;
            const newItem = {
                row_id: itemRowCounter,
                item_id: item.id,
                product_name: item.product_name,
                quantity: 1,
                price: item.cost_price,
                tax_rate: taxRate,
                measure: item.measure ? item.measure.measure_name : 'N/A'
            };
            
            selectedItems.push(newItem);
            renderOrderItems();
        }
        
        // Renderizar productos de la orden
        function renderOrderItems() {
            const tableBody = $('#itemsTable tbody');
            
            if (selectedItems.length === 0) {
                tableBody.html('<tr id="noItemsRow"><td colspan="7" class="text-center">No hay productos agregados</td></tr>');
                updateOrderTotals();
                return;
            }
            
            tableBody.empty();
            
            $.each(selectedItems, function(index, item) {
                const subtotal = item.quantity * item.price;
                const taxAmount = subtotal * (item.tax_rate / 100);
                const total = subtotal + taxAmount;
                
                const row = `
                    <tr data-row-id="${item.row_id}">
                        <td>${item.product_name} <small class="text-muted">(${item.measure})</small></td>
                        <td>
                            <input type="number" class="form-control item-quantity" min="1" value="${item.quantity}" 
                                data-row-id="${item.row_id}">
                        </td>
                        <td>
                            <input type="number" class="form-control item-price" min="0" step="0.01" value="${item.price}" 
                                data-row-id="${item.row_id}">
                        </td>
                        <td>
                            <input type="number" class="form-control item-tax" min="0" step="0.01" value="${item.tax_rate}" 
                                data-row-id="${item.row_id}" readonly>
                        </td>
                        <td>${formatCurrency(subtotal)}</td>
                        <td>${formatCurrency(total)}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item" data-row-id="${item.row_id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                tableBody.append(row);
            });
            
            updateOrderTotals();
        }
        
        // Actualizar totales de la orden
        function updateOrderTotals() {
            let subtotal = 0;
            let taxAmount = 0;
            
            $.each(selectedItems, function(index, item) {
                const itemSubtotal = item.quantity * item.price;
                const itemTaxAmount = itemSubtotal * (item.tax_rate / 100);
                
                subtotal += itemSubtotal;
                taxAmount += itemTaxAmount;
            });
            
            const total = subtotal + taxAmount;
            
            $('#orderSubtotal').text(formatCurrency(subtotal));
            $('#orderTaxAmount').text(formatCurrency(taxAmount));
            $('#orderTotal').text(formatCurrency(total));
        }
        
        // Formatear moneda
        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0
            }).format(value);
        }
        
        // Mostrar modal para agregar producto
        $('#addItemBtn').click(function() {
            $('#itemSelectionModal').modal('show');
        });
        
        // Eliminar producto
        $(document).on('click', '.remove-item', function() {
            const rowId = $(this).data('row-id');
            selectedItems = selectedItems.filter(item => item.row_id !== rowId);
            renderOrderItems();
        });
        
        // Actualizar cantidad
        $(document).on('change', '.item-quantity', function() {
            const rowId = $(this).data('row-id');
            const newQuantity = parseInt($(this).val());
            
            if (newQuantity < 1) {
                $(this).val(1);
                return;
            }
            
            const itemIndex = selectedItems.findIndex(item => item.row_id === rowId);
            if (itemIndex !== -1) {
                selectedItems[itemIndex].quantity = newQuantity;
                renderOrderItems();
            }
        });
        
        // Actualizar precio
        $(document).on('change', '.item-price', function() {
            const rowId = $(this).data('row-id');
            const newPrice = parseFloat($(this).val());
            
            if (newPrice < 0) {
                $(this).val(0);
                return;
            }
            
            const itemIndex = selectedItems.findIndex(item => item.row_id === rowId);
            if (itemIndex !== -1) {
                selectedItems[itemIndex].price = newPrice;
                renderOrderItems();
            }
        });
        
        // Guardar orden de compra
        $('#purchaseOrderForm').submit(function(e) {
            e.preventDefault();
            
            if (selectedItems.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe agregar al menos un producto a la orden'
                });
                return;
            }
            
            // Mostrar confirmación
            Swal.fire({
                title: '¿Está seguro?',
                text: 'Se creará una nueva orden de compra',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, crear orden',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    saveOrder();
                }
            });
        });
        
        // Guardar orden en la base de datos
        function saveOrder() {
            const formData = {
                _token: $('input[name="_token"]').val(),
                supplier_id: $('#supplier_id').val(),
                warehouse_id: $('#warehouse_id').val(),
                status_order_id: $('#status_order_id').val(),
                currency_id: $('#currency_id').val(),
                order_date: $('#order_date').val(),
                expected_date: $('#expected_date').val(),
                notes: $('#notes').val(),
                items: selectedItems.map(item => ({
                    item_id: item.item_id,
                    quantity: item.quantity,
                    price: item.price,
                    tax_rate: item.tax_rate
                }))
            };
            
            // Mostrar cargando
            Swal.fire({
                title: 'Guardando...',
                text: 'Creando orden de compra',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: "{{ route('admin.purchase_orders.store') }}",
                method: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message,
                            confirmButtonText: 'Ver Orden',
                            showCancelButton: true,
                            cancelButtonText: 'Crear Otra'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('admin.purchase_orders.view', ['id' => ':id']) }}".replace(':id', response.purchase_order_id);
                            } else {
                                // Limpiar formulario
                                $('#purchaseOrderForm')[0].reset();
                                selectedItems = [];
                                renderOrderItems();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al guardar la orden:', error);
                    
                    let errorMessage = 'Error al guardar la orden de compra';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        }
        
        // Inicializar
        loadItems();
    });
</script>
@endsection