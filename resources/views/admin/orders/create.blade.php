@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Nuevo Pedido</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item active">Nuevo Pedido</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content-body">
        <div class="container-fluid">
            <form id="orderForm" method="POST" action="{{ route('admin.orders.store') }}">
                @csrf
                <div class="row">
                    <!-- Información del Cliente -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Información del Cliente</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="person_id" class="form-label">Cliente *</label>
                                            <div class="input-group">
                                                <select class="form-select select2" id="person_id" name="person_id" required>
                                                    <option value="">Buscar cliente...</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}">
                                                            {{ $customer->name }} - {{ $customer->identification_number }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" id="newCustomerBtn">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Pedido -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Información del Pedido</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="issue_date" class="form-label">Fecha de Emisión *</label>
                                            <input type="date" class="form-control" id="issue_date" name="issue_date" 
                                                   value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="delivery_date" class="form-label">Fecha de Entrega *</label>
                                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="currency_id" class="form-label">Moneda *</label>
                                            <select class="form-select" id="currency_id" name="currency_id" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency->id }}" {{ $currency->id == 170 ? 'selected' : '' }}>
                                                        {{ $currency->currency_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="payment_form_id" class="form-label">Forma de Pago *</label>
                                            <select class="form-select" id="payment_form_id" name="payment_form_id" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($paymentForms as $form)
                                                    <option value="{{ $form->id }}" {{ $form->payment_type == 'Contado' ? 'selected' : '' }}>
                                                        {{ $form->payment_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="delivery_address" class="form-label">Dirección de Entrega</label>
                                            <textarea class="form-control" id="delivery_address" name="delivery_address" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Productos -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h5 class="mb-0">Productos</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="product_search" 
                                                   placeholder="Buscar producto por nombre o código...">
                                            <button class="btn btn-outline-primary" type="button" id="searchProductBtn">
                                                <i class="fas fa-search"></i> Buscar
                                            </button>
                                            <button class="btn btn-outline-success" type="button" id="scanBarcodeBtn">
                                                <i class="fas fa-barcode"></i> Escanear
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="products_table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 5%">Acción</th>
                                                <th style="width: 10%">Código</th>
                                                <th style="width: 25%">Descripción</th>
                                                <th style="width: 8%">Cantidad</th>
                                                <th style="width: 10%">Precio Unit.</th>
                                                <th style="width: 8%">Descuento %</th>
                                                <th style="width: 10%">Monto Desc.</th>
                                                <th style="width: 9%">IVA</th>
                                                <th style="width: 15%">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="empty_row">
                                                <td colspan="9" class="text-center">No hay productos agregados</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-end">Subtotal:</td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="total_subtotal" name="subtotal" value="0.00" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-end">Descuento:</td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="total_discount" name="discount" value="0.00" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-end">IVA:</td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="total_tax" name="vat" value="0.00" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-end"><strong>TOTAL:</strong></td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control form-control-lg bg-light fw-bold" 
                                                           id="total_sale" name="total" value="0.00" readonly>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="saveBtn">
                                            <i class="fas fa-save"></i> Guardar Pedido
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Modal para buscar productos -->
<div class="modal fade" id="productSearchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" id="modal_product_search" 
                                   placeholder="Buscar producto por nombre o código...">
                            <button class="btn btn-primary" type="button" id="modal_searchProductBtn">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="products_search_table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los productos se cargarán dinámicamente -->
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

<!-- Template para fila de producto -->
<template id="product_row_template">
    <tr class="product-row">
        <td>
            <button type="button" class="btn btn-sm btn-danger remove-product">
                <i class="fas fa-trash"></i>
            </button>
        </td>
        <td>
            <input type="hidden" name="items[][item_id]" class="product-id">
            <span class="product-code"></span>
        </td>
        <td>
            <span class="product-name"></span>
        </td>
        <td>
            <input type="number" name="items[][quantity]" class="form-control quantity" min="1" value="1">
        </td>
        <td>
            <input type="number" name="items[][unit_price]" class="form-control price" step="0.01" min="0">
        </td>
        <td>
            <input type="number" name="items[][discount]" class="form-control discount" min="0" max="100" step="0.01" value="0">
        </td>
        <td>
            <input type="text" name="items[][discount_amount]" class="form-control discount-amount" readonly>
        </td>
        <td>
            <input type="hidden" name="items[][vat_rate]" class="tax-rate">
            <span class="tax-rate-display"></span>
        </td>
        <td>
            <input type="text" name="items[][subtotal]" class="form-control subtotal" readonly>
        </td>
    </tr>
</template>

@endsection

@section('script')
<script>
$(document).ready(function() {
    // Inicializar Select2
    $('.select2').select2({
        width: '100%'
    });
    
    // Buscar productos
    $('#searchProductBtn').on('click', function() {
        let searchTerm = $('#product_search').val();
        searchProducts(searchTerm);
    });
    
    // Buscar productos al presionar Enter
    $('#product_search').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            let searchTerm = $(this).val();
            searchProducts(searchTerm);
        }
    });
    
    function searchProducts(searchTerm) {
        if (!searchTerm || (searchTerm.length < 3 && isNaN(searchTerm))) {
            $('#productSearchModal').modal('show');
            return;
        }

        $('#product_search').prop('disabled', true).addClass('loading');

        $.ajax({
            url: "{{ url('admin/orders/search-items') }}",
            type: 'GET',
            data: { term: searchTerm },
            dataType: 'json',
            success: function(response) {
                $('#product_search').prop('disabled', false).removeClass('loading');

                if (Array.isArray(response)) {
                    if (response.length === 1) {
                        addProductToTable(response[0]);
                        $('#product_search').val('');
                    } else if (response.length > 1) {
                        populateProductSearchTable(response);
                        $('#productSearchModal').modal('show');
                    } else {
                        alert('No se encontraron productos con ese término de búsqueda.');
                    }
                } else {
                    console.error('Respuesta inesperada del servidor:', response);
                    alert('Error al buscar productos. Contacte al administrador.');
                }
            },
            error: function(xhr, status, error) {
                $('#product_search').prop('disabled', false).removeClass('loading');
                console.error('Error en la búsqueda:', status, error);
                alert('Error al buscar productos. Por favor, inténtelo de nuevo.');
            }
        });
    }
    
    // Llenar tabla de búsqueda de productos
    function populateProductSearchTable(products) {
        let tbody = $('#products_search_table tbody');
        tbody.empty();
        
        if (products.length === 0) {
            tbody.append('<tr><td colspan="5" class="text-center">No se encontraron productos</td></tr>');
            return;
        }
        
        $.each(products, function(index, product) {
            let row = `
                <tr>
                    <td>${product.code || ''}</td>
                    <td>${product.name || ''}</td>
                    <td>${parseFloat(product.sale_price || product.price || 0).toFixed(2)}</td>
                    <td>${product.stock || 0}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success add-product-btn" 
                            data-id="${product.id}" 
                            data-code="${product.code || ''}" 
                            data-name="${product.name || ''}" 
                            data-price="${product.sale_price || product.price || 0}" 
                            data-tax="${product.tax_rate || 0}">
                            <i class="fas fa-plus"></i> Agregar
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }
    
    // Agregar producto desde el modal
    $(document).on('click', '.add-product-btn', function() {
        let product = {
            id: $(this).data('id'),
            code: $(this).data('code'),
            name: $(this).data('name'),
            price: $(this).data('price'),
            tax_rate: $(this).data('tax')
        };
        
        addProductToTable(product);
        $('#productSearchModal').modal('hide');
        $('#modal_product_search').val('');
    });
    
    // Agregar producto a la tabla
    function addProductToTable(product) {
        // Verificar si el producto ya está en la tabla
        let existingRow = null;
        $('.product-id').each(function() {
            if ($(this).val() == product.id) {
                existingRow = $(this).closest('tr');
                return false;
            }
        });
        
        if (existingRow) {
            // Si el producto ya existe, incrementar cantidad
            let quantityInput = existingRow.find('.quantity');
            let currentQuantity = parseInt(quantityInput.val());
            quantityInput.val(currentQuantity + 1);
            
            // Recalcular subtotal
            calculateRowTotal(existingRow);
        } else {
            // Si es un nuevo producto, agregar fila
            let template = document.getElementById('product_row_template');
            let clone = document.importNode(template.content, true);
            let row = $(clone).find('tr');
            
            // Llenar datos del producto
            row.find('.product-id').val(product.id);
            row.find('.product-code').text(product.code || '');
            row.find('.product-name').text(product.name || '');
            
            // Establecer precio
            let priceInput = row.find('.price');
            priceInput.val(parseFloat(product.price || 0).toFixed(2));
            
            // Establecer tasa de impuesto
            let taxRate = parseFloat(product.tax_rate || 0);
            row.find('.tax-rate').val(taxRate);
            row.find('.tax-rate-display').text(taxRate + '%');
            
            // Calcular subtotal inicial
            calculateRowTotal(row);
            
            // Eliminar fila vacía si existe
            $('#empty_row').remove();
            
            // Agregar fila a la tabla
            $('#products_table tbody').append(row);
        }
        
        // Recalcular totales
        calculateTotals();
        
        // Limpiar el campo de búsqueda y enfocarlo
        $('#product_search').val('').focus();
    }
    
    // Calcular total de fila
    function calculateRowTotal(row) {
        let quantity = parseInt($(row).find('.quantity').val() || 0);
        let price = parseFloat($(row).find('.price').val() || 0);
        let discount = parseFloat($(row).find('.discount').val() || 0);
        let taxRate = parseFloat($(row).find('.tax-rate').val() || 0);
        
        // Calcular subtotal antes del descuento
        let subtotalBeforeDiscount = quantity * price;
        
        // Calcular monto de descuento
        let discountAmount = (subtotalBeforeDiscount * discount) / 100;
        
        // Calcular subtotal después del descuento
        let subtotalAfterDiscount = subtotalBeforeDiscount - discountAmount;
        
        // Calcular IVA sobre el subtotal después del descuento
        let taxAmount = (subtotalAfterDiscount * taxRate) / 100;
        
        // Actualizar campos
        $(row).find('.discount-amount').val(discountAmount.toFixed(2));
        $(row).find('.subtotal').val(subtotalAfterDiscount.toFixed(2));
        
        // Actualizar campo oculto de IVA
        if ($(row).find('.tax-amount').length === 0) {
            $(row).append('<input type="hidden" name="items[][vat_value]" class="tax-amount">');
        }
        $(row).find('.tax-amount').val(taxAmount.toFixed(2));
        
        return {
            subtotal: subtotalAfterDiscount,
            tax: taxAmount,
            discount: discountAmount
        };
    }
    
    // Calcular totales generales
    function calculateTotals() {
        let totalSubtotal = 0;
        let totalDiscount = 0;
        let totalTax = 0;
        let totalSale = 0;
        
        $('.product-row').each(function() {
            let row = $(this);
            let quantity = parseInt(row.find('.quantity').val() || 0);
            let price = parseFloat(row.find('.price').val() || 0);
            let discount = parseFloat(row.find('.discount').val() || 0);
            let taxRate = parseFloat(row.find('.tax-rate').val() || 0);
            
            // Calcular subtotal antes del descuento
            let rowSubtotalBeforeDiscount = quantity * price;
            
            // Calcular monto de descuento
            let rowDiscountAmount = (rowSubtotalBeforeDiscount * discount) / 100;
            
            // Calcular subtotal después del descuento
            let rowSubtotalAfterDiscount = rowSubtotalBeforeDiscount - rowDiscountAmount;
            
            // Calcular IVA sobre el subtotal después del descuento
            let rowTax = (rowSubtotalAfterDiscount * taxRate) / 100;
            
            totalSubtotal += rowSubtotalBeforeDiscount;
            totalDiscount += rowDiscountAmount;
            totalTax += rowTax;
            totalSale += rowSubtotalAfterDiscount + rowTax;
        });
        
        // Actualizar totales en la interfaz
        $('#total_subtotal').val(totalSubtotal.toFixed(2));
        $('#total_discount').val(totalDiscount.toFixed(2));
        $('#total_tax').val(totalTax.toFixed(2));
        $('#total_sale').val(totalSale.toFixed(2));
    }
    
    // Actualizar totales al cambiar cantidad, precio o descuento
    $(document).on('input', '.quantity, .price, .discount', function() {
        calculateRowTotal($(this).closest('tr'));
        calculateTotals();
    });
    
    // Eliminar producto
    $(document).on('click', '.remove-product', function() {
        let row = $(this).closest('tr');
        row.remove();
        
        if ($('#products_table tbody tr').length === 0) {
            $('#products_table tbody').append('<tr id="empty_row"><td colspan="9" class="text-center">No hay productos agregados</td></tr>');
        }
        
        calculateTotals();
    });
    
    // Validar formulario antes de enviar
    $('#orderForm').on('submit', function(e) {
        e.preventDefault();
        
        // Verificar si hay productos
        if ($('.product-row').length === 0) {
            alert('Debe agregar al menos un producto al pedido');
            return false;
        }
        
        // Verificar campos obligatorios
        let requiredFields = ['person_id', 'issue_date', 'delivery_date', 'currency_id', 'payment_form_id'];
        let isValid = true;
        
        requiredFields.forEach(function(field) {
            if (!$('#' + field).val()) {
                isValid = false;
                $('#' + field).addClass('is-invalid');
            } else {
                $('#' + field).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Por favor complete todos los campos obligatorios');
            return false;
        }
        
        // Si todo está bien, enviar el formulario
        this.submit();
    });
});
</script>
@endsection 