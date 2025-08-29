@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nueva Venta</h3>
                </div>
                <div class="card-body">
                    <form id="saleForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <select class="form-control" name="customer_id" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Almacén</label>
                                    <select class="form-control" name="warehouse_id" required>
                                        <option value="">Seleccione un almacén</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Forma de Pago</label>
                                    <select class="form-control" name="payment_form_id" required>
                                        <option value="">Seleccione forma de pago</option>
                                        @foreach($paymentTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->payment_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Método de Pago</label>
                                    <select class="form-control" name="payment_method_id" required>
                                        <option value="">Seleccione método de pago</option>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Productos</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="productsTable">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Descuento</th>
                                                    <th>Subtotal</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-control product-select" required>
                                                            <option value="">Seleccione producto</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}" 
                                                                        data-price="{{ $product->sale_price }}"
                                                                        data-stock="{{ $product->stock }}">
                                                                    {{ $product->product_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control quantity" min="1" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control price" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control discount" value="0" min="0">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control subtotal" readonly>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-success btn-sm" id="addRow">
                                            <i class="fas fa-plus"></i> Agregar Producto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 offset-md-6">
                                <table class="table">
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td><input type="number" class="form-control" id="total_subtotal" name="total_subtotal" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>IVA:</th>
                                        <td><input type="number" class="form-control" id="total_tax" name="total_tax" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td><input type="number" class="form-control" id="total_amount" name="total_amount" readonly></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">Guardar Venta</button>
                                <a href="{{ route('user.sales.list') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Función para calcular subtotal
    function calculateSubtotal(row) {
        var quantity = parseFloat(row.find('.quantity').val()) || 0;
        var price = parseFloat(row.find('.price').val()) || 0;
        var discount = parseFloat(row.find('.discount').val()) || 0;
        var subtotal = (quantity * price) - discount;
        row.find('.subtotal').val(subtotal.toFixed(2));
        calculateTotals();
    }

    // Función para calcular totales
    function calculateTotals() {
        var subtotal = 0;
        $('.subtotal').each(function() {
            subtotal += parseFloat($(this).val()) || 0;
        });
        var tax = subtotal * 0.19; // 12% IVA
        var total = subtotal + tax;

        $('#total_subtotal').val(subtotal.toFixed(2));
        $('#total_tax').val(tax.toFixed(2));
        $('#total_amount').val(total.toFixed(2));
    }

    // Evento al cambiar producto
    $(document).on('change', '.product-select', function() {
        var row = $(this).closest('tr');
        var price = $(this).find(':selected').data('price');
        row.find('.price').val(price);
        calculateSubtotal(row);
    });

    // Evento al cambiar cantidad o descuento
    $(document).on('input', '.quantity, .discount', function() {
        var row = $(this).closest('tr');
        calculateSubtotal(row);
    });

    // Agregar nueva fila
    $('#addRow').click(function() {
        var newRow = $('#productsTable tbody tr:first').clone();
        newRow.find('input').val('');
        newRow.find('select').val('');
        $('#productsTable tbody').append(newRow);
    });

    // Eliminar fila
    $(document).on('click', '.remove-row', function() {
        if ($('#productsTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
            calculateTotals();
        }
    });

    // Enviar formulario
    $('#saleForm').submit(function(e) {
        e.preventDefault();
        
        var items = [];
        $('#productsTable tbody tr').each(function() {
            var productId = $(this).find('.product-select').val();
            if (productId) {
                items.push({
                    id: productId,
                    quantity: $(this).find('.quantity').val(),
                    price: $(this).find('.price').val(),
                    discount: $(this).find('.discount').val(),
                    subtotal: $(this).find('.subtotal').val()
                });
            }
        });

        var formData = {
            customer_id: $('select[name="customer_id"]').val(),
            warehouse_id: $('select[name="warehouse_id"]').val(),
            payment_form_id: $('select[name="payment_form_id"]').val(),
            payment_method_id: $('select[name="payment_method_id"]').val(),
            total_subtotal: $('#total_subtotal').val(),
            total_tax: $('#total_tax').val(),
            total_amount: $('#total_amount').val(),
            items: items
        };

        $.ajax({
            url: '{{ route("user.sales.store") }}',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Venta registrada exitosamente');
                    window.location.href = '{{ route("user.sales.list") }}';
                }
            },
            error: function(xhr) {
                alert('Error al registrar la venta: ' + xhr.responseJSON.message);
            }
        });
    });
});
</script>
@endpush
@endsection 