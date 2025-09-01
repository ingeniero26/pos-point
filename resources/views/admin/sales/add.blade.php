@extends('layouts.app')
  
@section('content')
<main class="app-main"> 
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Nueva Venta</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/sales/list')}}">Ventas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Nueva Venta
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content-body">
        <div class="container-fluid">
        <!-- Enviar company_id al formulario  -->
            <form id="salesForm" method="POST" action="{{ url('admin/sales/store') }}" >
                @csrf
                <div class="row">
                    <!-- Información del Documento -->
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Información del Documento</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        <label for="">Vendedor</label>
                                        <div class="mb-3">
                                            <select class="form-select" id="user_id" name="user_id" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <label for="">Estado</label>
                                        <div class="mb-3">
                                            <select class="form-select" id="state_type_id" name="state_type_id" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($stateTypes as $state)
                                                    <option value="{{ $state->id }}" {{ $state->description == 'Registrado' ? 'selected' : '' }}>
                                                        {{ $state->description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                               
                                  
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="voucher_type_id" class="form-label">Tipo de Comprobante *</label>
                                            <select class="form-select" id="voucher_type_id" name="voucher_type_id" required>
                                                <option value="">Seleccione...</option>
                                                {{-- @foreach($voucherTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach --}}
                                                @foreach($voucherTypes as $type)
                                                <option value="{{ $type->id }}"
                                                     {{ $type->name == 'Factura de Venta' ? 'selected' : '' }}>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="series" class="form-label">Serie *</label>
                                            <select class="form-select" id="series" name="series">
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="number" class="form-label">Número *</label>
                                            <input type="text" class="form-control" id="number" name="number"
                                             readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="date_of_issue" class="form-label">Fecha de Emisión *</label>
                                            <input type="date" class="form-control" id="date_of_issue" name="date_of_issue" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="payment_form_id" class="form-label">Forma de Pago *</label>
                                            <select class="form-select" id="payment_form_id" name="payment_form_id" required>
                                                <option value="">Seleccione...</option>
                                               @foreach ($formPayments as $formPayment )
                                                    <option value="{{ $formPayment->id }}" {{ $formPayment->payment_type == 'Contado'?'selected' : '' }}>
                                                        {{ $formPayment->payment_type }}</option>
                                                   
                                               @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="date_of_due" class="form-label">Fecha de Vencimiento</label>
                                            <input type="date" class="form-control" id="date_of_due" name="date_of_due">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="currency_id" class="form-label">Moneda *</label>
                                            <select class="form-select" id="currency_id" name="currency_id" required>
                                                <option value="">Seleccione...</option>
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
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="payment_method_id" class="form-label">Método de Pago *</label>
                                            <select class="form-select" id="payment_method_id" name="payment_method_id" required>
                                                <option value="">Seleccione...</option>
                                                @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}" {{ $method->name == 'Efectivo' ? 'selected' : '' }}>{{ $method->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="cash_register_id" class="form-label">Caja Registradora *</label>
                                            <select class="form-select" id="cash_register_id"
                                             name="cash_register_id" >
                                                <option value="">Seleccione...</option>
                                                @foreach($cashRegisters as $register)
                                                    @if($register->hasOpenSession())
                                                        <option value="{{ $register->id }}">{{ $register->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- si el pago es transdferencia mostrar el campo de banco -->
                                    <div class="col-md-3" id="bank_div" style="display: none;">
                                        <div class="mb-3">
                                            <label for="bank_id" class="form-label">Banco</label>
                                            <select class="form-select" id="bank_id" name="bank_id">
                                                <option value="">Seleccione...</option>
                                                @foreach($banks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="bank_div" style="display: none;">
                                        <div class="mb-3">
                                            <label for="account_type_id" class="form-label">Tipo Cuenta</label>
                                            <select class="form-select" id="account_type_id" name="account_type_id">
                                                <option value="">Seleccione...</option>
                                                @foreach($bankAccountTypes as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->account_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="bank_div" style="">
                                        <div class="mb-3">
                                            <label for="number" class="form-label">Número de Cuenta</label>
                                            <input type="text" class="form-control" id="number" name="number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información del Cliente -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Información del Cliente</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="customer_id" class="form-label">Cliente *</label>
                                            <div class="input-group">
                                                <select class="form-select select2" id="customer_id" name="customer_id" required>
                                                    <option value="">Buscar cliente...</option>
                                                    @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->identification_number }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-outline-secondary" type="button" id="newCustomerBtn">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Documento</label>
                                            <input type="text" class="form-control" id="customer_document" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="customer_phone" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Dirección</label>
                                            <input type="text" class="form-control" id="customer_address" readonly>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>

                    <!-- Información de Entrega -->
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Información de Entrega</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="warehouse_id" class="form-label">Bodega</label>
                                            <select class="form-select" id="warehouse_id" name="warehouse_id">
                                                <option value="">Seleccione...</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name  }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="delivery_status" class="form-label">Estado de Entrega</label>
                                            <select class="form-select" id="delivery_status" name="delivery_status">
                                                <option value="pending">Pendiente</option>
                                                <option value="in_transit">En Tránsito</option>
                                                <option value="delivered">Entregado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_method" class="form-label">Método de Envío</label>
                                            <input type="text" class="form-control" id="shipping_method" name="shipping_method">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="observations" class="form-label">Observaciones</label>
                                            <textarea class="form-control" id="observations" name="observations" rows="3"></textarea>
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
                                            <input type="text" class="form-control" id="product_search" placeholder="Buscar producto por nombre o código...">
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
                                                    <input type="text" class="form-control" id="total_subtotal" name="total_subtotal" value="0.00" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-end">Descuento:</td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="total_discount" name="total_discount" value="0.00" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-end">IVA:</td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" id="total_tax" name="total_tax" value="0.00" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" class="text-end"><strong>TOTAL:</strong></td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control form-control-lg bg-light fw-bold" id="total_sale" name="total_sale" value="0.00" readonly>
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
                                        <a href="{{ url('admin/sales/list') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancelar
                                        </a>
                                        {{-- <button type="button" class="btn btn-info" id="previewBtn">
                                            <i class="fas fa-eye"></i> Vista Previa
                                        </button> --}}
                                        <button type="submit" class="btn btn-primary" id="saveBtn">
                                            <i class="fas fa-save"></i> Guardar Venta
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
<div class="modal fade" id="productSearchModal" tabindex="-1" aria-labelledby="productSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productSearchModalLabel">Buscar Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" class="form-control" id="modal_product_search" placeholder="Buscar producto por nombre o código...">
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

<!-- Modal para agregar cliente -->
<div class="modal fade" id="newCustomerModal" tabindex="-1" aria-labelledby="newCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCustomerModalLabel">Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newCustomerForm">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Apellidos *</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_document_type" class="form-label">Tipo de Documento *</label>
                        <select class="form-select" id="identification_type_id" name="identification_type_id" required>
                            <option value="">Seleccione...</option>
                            @foreach($identificationTypes as $type_document)
                                <option value="{{ $type_document->id }}">{{ $type_document->identification_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="customer_document_number" class="form-label">Número de Documento *</label>
                        <input type="text" class="form-control" id="identification_number" name="identification_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone_number" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="customer_address_input" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveCustomerBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de vista previa -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Vista Previa de Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="preview_content">
                <!-- El contenido de la vista previa se cargará aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="printPreviewBtn">
                    <i class="fas fa-print"></i> Imprimir
                </button>
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
            <input type="hidden" name="product_ids[]" class="product-id">
            <span class="product-code"></span>
        </td>
        <td>
            <span class="product-name"></span>
        </td>
        <td>
            <input type="number" name="quantities[]" class="form-control quantity" min="1" value="1">
        </td>
        <td>
            <input type="number" name="prices[]" class="form-control price" step="0.01" min="0">
        </td>
        <td>
            <input type="number" name="discounts[]" class="form-control discount" min="0" max="100" step="0.01" value="0">
        </td>
        <td>
            <input type="text" name="discount_amounts[]" class="form-control discount-amount" readonly>
        </td>
        <td>
            <input type="hidden" name="tax_rates[]" class="tax-rate">
            <span class="tax-rate-display"></span>
        </td>
        <td>
            <input type="text" name="subtotals[]" class="form-control subtotal" readonly>
        </td>
    </tr>
</template>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        // Inicializar Select2
        $('.select2').select2({
            width: '100%'
        });
        
        // Ocultar campo de fecha de vencimiento inicialmente
        $('#date_of_due').closest('.mb-3').hide();
        
        // Mostrar/ocultar fecha de vencimiento según forma de pago
        $('#payment_form_id').on('change', function() {
            if ($(this).val() == '2') { // Crédito
                $('#date_of_due').closest('.mb-3').show();
                $('#date_of_due').prop('required', true);
            } else {
                $('#date_of_due').closest('.mb-3').hide();
                $('#date_of_due').prop('required', false);
            }
        });
        
        // Cargar series al cambiar tipo de comprobante
        $('#voucher_type_id').on('change', function() {
            let voucherTypeId = $(this).val();
            if (voucherTypeId) {
                $.ajax({
                    url: "{{ url('admin/sales/get-series') }}/" + voucherTypeId,
                    type: 'GET',
                    success: function(response) {
                        let options = '<option value="">Seleccione...</option>';
                        $.each(response, function(index, series) {
                            options += `<option value="${series.series}">${series.series}</option>`;
                        });
                        $('#series').html(options);
                    }
                });
            } else {
                $('#series').html('<option value="">Seleccione...</option>');
                $('#number').val('');
            }
        });
        
        // Obtener número al seleccionar serie
        $('#series').on('change', function() {
            let series = $(this).val();
            let voucherTypeId = $('#voucher_type_id').val();
            
            if (series && voucherTypeId) {
                $.ajax({
                    url: "{{ url('admin/sales/get-next-number') }}",
                    type: 'GET',
                    data: {
                        voucher_type_id: voucherTypeId,
                        series: series
                    },
                    success: function(response) {
                        $('#number').val(response.next_number);
                    }
                });
            } else {
                $('#number').val('');
            }
        });
        
        // Cargar datos del cliente al seleccionarlo
        $('#customer_id').on('change', function() {
            let customerId = $(this).val();
            
            if (customerId) {
                $.ajax({
                    url: "{{ url('admin/person/get-details') }}/" + customerId,
                    type: 'GET',
                    success: function(response) {
                        $('#customer_document').val(response.document_type + ': ' + response.identification_number);
                        $('#customer_phone').val(response.phone);
                        $('#customer_address').val(response.address);
                    }
                });
            } else {
                $('#customer_document').val('');
                $('#customer_phone').val('');
                $('#customer_address').val('');
            }
        });
        
        // Abrir modal para nuevo cliente
        $('#newCustomerBtn').on('click', function() {
            $('#newCustomerModal').modal('show');
        });
        
        // Guardar nuevo cliente
        $('#saveCustomerBtn').on('click', function() {
            let formData = {
                name: $('#name').val(),
                last_name: $('#last_name').val(),
                identification_type_id: $('#identification_type_id').val(),
                identification_number: $('#identification_number').val(),
                phone: $('#phone').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                type_third_id: 1, // Assuming 1 is for customers
                type_person_id: 1, // Default person type
                _token: "{{ csrf_token() }}"
            };
        
            $.ajax({
                url: "{{ url('admin/person/store-ajax') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Agregar el nuevo cliente al select y seleccionarlo
                        let newOption = new Option(response.person.name + ' - ' + response.person.identification_number, response.person.id, true, true);
                        $('#customer_id').append(newOption).trigger('change');
                        
                        // Llenar los campos de información del cliente
                        $('#customer_document').val(response.person.document_type + ': ' + response.person.identification_number);
                        $('#customer_phone').val(response.person.phone);
                        $('#customer_address').val(response.person.address);
                        
                        // Cerrar el modal y limpiar el formulario
                        $('#newCustomerModal').modal('hide');
                        $('#newCustomerForm')[0].reset();
                        
                        // Mostrar mensaje de éxito
                        alert('Cliente creado exitosamente');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = 'Error al crear el cliente:\n';
                    
                    for (let field in errors) {
                        errorMessage += errors[field][0] + '\n';
                    }
                    
                    alert(errorMessage);
                }
            });
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
            // Validación más robusta del término de búsqueda
            if (!searchTerm || (searchTerm.length < 3 && isNaN(searchTerm))) {
                $('#productSearchModal').modal('show');
                return;
            }

            // Mostrar indicador de carga (puedes usar un loader más visual)
            $('#product_search').prop('disabled', true).addClass('loading');

            $.ajax({
                url: "{{ url('admin/sales/search-items') }}",
                type: 'GET',
                data: { term: searchTerm },
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    // Eliminar indicador de carga
                    $('#product_search').prop('disabled', false).removeClass('loading');

                    // Asegurarse de que la respuesta sea un array
                    if (Array.isArray(response)) {
                        if (response.length === 1) {
                            // Un solo producto encontrado: agregarlo directamente
                            addProductToTable(response[0]);
                            $('#product_search').val(''); // Limpiar el campo de búsqueda
                        } else if (response.length > 1) {
                            // Múltiples productos: mostrar modal de búsqueda
                            populateProductSearchTable(response);
                            $('#productSearchModal').modal('show');
                        } else {
                            // No se encontraron productos
                            alert('No se encontraron productos con ese término de búsqueda.');
                        }
                    } else {
                        // La respuesta no es un array: error inesperado
                        console.error('Respuesta inesperada del servidor:', response);
                        alert('Error al buscar productos. Contacte al administrador.');
                    }
                },
                error: function(xhr, status, error) {
                    // Eliminar indicador de carga
                    $('#product_search').prop('disabled', false).removeClass('loading');

                    console.error('Error en la búsqueda:', status, error);
                    console.error('Response Text:', xhr.responseText);
                    console.error('Status Code:', xhr.status);

                    let errorMessage = 'Error al buscar productos. Por favor, inténtelo de nuevo.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = 'Error: ' + xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Error: La ruta de búsqueda no existe.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Error interno del servidor. Contacte al administrador.';
                    } else if (xhr.status === 401) {
                        errorMessage = 'Sesión expirada. Por favor, inicie sesión nuevamente.';
                        setTimeout(function() {
                            window.location.href = "{{ url('login') }}";
                        }, 2000);
                    }

                    alert(errorMessage);
                }
            });
        }
        // Buscar productos desde el modal
        $('#modal_searchProductBtn').on('click', function() {
            let searchTerm = $('#modal_product_search').val();
            
            if (searchTerm.length < 3 && !$.isNumeric(searchTerm)) {
                alert('Ingrese al menos 3 caracteres para buscar');
                return;
            }
            
            // Mostrar indicador de carga
            $('#modal_searchProductBtn').html('<i class="fas fa-spinner fa-spin"></i> Buscando...').attr('disabled', true);
            
            $.ajax({
                url: "{{ url('admin/items/search') }}",
                type: 'GET',
                data: {
                    term: searchTerm
                },
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    // Restaurar botón
                    $('#modal_searchProductBtn').html('<i class="fas fa-search"></i> Buscar').attr('disabled', false);
                    
                    console.log('Modal search response:', response);
                    
                    if (Array.isArray(response)) {
                        populateProductSearchTable(response);
                    } else {
                        alert('Formato de respuesta inesperado. Contacte al administrador.');
                    }
                },
                error: function(xhr, status, error) {
                    // Restaurar botón
                    $('#modal_searchProductBtn').html('<i class="fas fa-search"></i> Buscar').attr('disabled', false);
                    
                    console.error('Error en la búsqueda modal:', xhr.responseText);
                    console.error('Status:', status);
                    console.error('Error:', error);
                    
                    let errorMessage = 'Error al buscar productos. Por favor, inténtelo de nuevo.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = 'Error: ' + xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Error: La ruta de búsqueda no existe.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Error interno del servidor. Contacte al administrador.';
                    }
                    
                    alert(errorMessage);
                }
            });
        });
        $('#payment_method_id').on('change', function() {
            const isPaymentCash = $(this).val() == '1';
            $('#cash_register_id').prop('', isPaymentCash);
            $('#cash_register_id').closest('.col-md-3').toggle(isPaymentCash);
        });
        // cuando es trasferencia, mostrar el campo de cuenta bancaria
        $('#payment_method_id').on('change', function() {
            const isTransfer = $(this).val() == '8'; // Asumiendo que 3 es la opción de transferencia
            $('#bank_id').prop('', isTransfer);
            $('#bank_id').closest('.col-md-3').toggle(isTransfer);
            $('#account_type_id').prop('', isTransfer);
            $('#account_type_id').closest('.col-md-3').toggle(isTransfer);
            $('#number').prop('', isTransfer);
            $('#number').closest('.col-md-3').toggle(isTransfer);
        });
        // mostrar el tipo de cuenta cuando es transferencia
        // Inicializar Select2 para el campo de método de pago
     
        $('#payment_method_id').select2({
            width: '100%'
        });

        
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
                sale_price: $(this).data('price'),
                tax_rate: $(this).data('tax')
            };
            
            console.log('Product from modal:', product);
            addProductToTable(product);
            $('#productSearchModal').modal('hide');
            $('#modal_product_search').val('');
        });
        
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
                $('#products_table tbody').append('<tr id="empty_row"><td colspan="8" class="text-center">No hay productos agregados</td></tr>');
            }
            
            calculateTotals();
        });
        
        // Agregar producto a la tabla
        function addProductToTable(product) {
            console.log('Adding product to table:', product);
            
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
                
                // Asegurarse de que el precio se establezca correctamente
                let priceInput = row.find('.price');
                priceInput.val(parseFloat(product.sale_price || 0).toFixed(2));
                
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
                $(row).append('<input type="hidden" name="tax_amounts[]" class="tax-amount">');
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
            
            // Actualizar campos ocultos para el formulario
            $('#salesForm input[name="total_taxed"]').remove();
            $('#salesForm input[name="total_unaffected"]').remove();
            $('#salesForm input[name="total_exonerated"]').remove();
            
            $('<input>').attr({
                type: 'hidden',
                name: 'total_taxed',
                value: totalSale.toFixed(2)
            }).appendTo('#salesForm');
            
            $('<input>').attr({
                type: 'hidden',
                name: 'total_unaffected',
                value: '0.00'
            }).appendTo('#salesForm');
            
            $('<input>').attr({
                type: 'hidden',
                name: 'total_exonerated',
                value: '0.00'
            }).appendTo('#salesForm');
        }
        
        // Mejorar el manejo de eventos para el descuento
        $(document).on('input', '.discount', function() {
            let discount = parseFloat($(this).val()) || 0;
            
            // Validar el descuento
            if (discount < 0) {
                $(this).val(0);
                alert('El descuento no puede ser negativo');
            } else if (discount > 100) {
                $(this).val(100);
                alert('El descuento no puede ser mayor al 100%');
            }
            
            // Recalcular totales
            calculateRowTotal($(this).closest('tr'));
            calculateTotals();
        });
        
        // Escanear código de barras
        $('#scanBarcodeBtn').on('click', function() {
            // Aquí se implementaría la funcionalidad de escaneo de código de barras
            // Por ahora, simplemente enfocamos el campo de búsqueda
            $('#product_search').focus();
        });
        
        // Vista previa de la factura
        $('#previewBtn').on('click', function() {
            // Verificar que haya productos agregados
            if ($('#products_table tbody tr').length === 0 || $('#empty_row').length) {
                alert('Debe agregar al menos un producto para generar la vista previa');
                return;
            }
            
            // Verificar campos obligatorios
            if (!validateRequiredFields()) {
                return;
            }
            
            // Obtener datos del formulario
            let formData = $('#salesForm').serialize();
            
            $.ajax({
                url: "{{ url('admin/sales/preview') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#preview_content').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-3x"></i><p class="mt-2">Generando vista previa...</p></div>');
                    $('#previewModal').modal('show');
                },
                success: function(response) {
                    $('#preview_content').html(response);
                },
                error: function(xhr) {
                    let errorMessage = 'Error al generar la vista previa';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    $('#preview_content').html(`<div class="alert alert-danger">${errorMessage}</div>`);
                }
            });
        });
        
        // Imprimir vista previa
        $('#printPreviewBtn').on('click', function() {
            let printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Vista Previa de Factura</title>');
            printWindow.document.write('<link rel="stylesheet" href="{{ asset("css/bootstrap.min.css") }}">');
            printWindow.document.write('<style>body { font-size: 12px; } .table { font-size: 11px; }</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write($('#preview_content').html());
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            
            setTimeout(function() {
                printWindow.print();
            }, 500);
        });
        
        // Validar campos obligatorios
        function validateRequiredFields() {
            let isValid = true;
            
            // Validar campos requeridos
            $('#salesForm [required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                alert('Por favor complete todos los campos obligatorios');
            }
            
            return isValid;
        }
        
        // Validar formulario antes de enviar
        $('#salesForm').on('submit', function(e) {
            e.preventDefault();
            
            // Verificar que haya productos agregados
            if ($('#products_table tbody tr').length === 0 || $('#empty_row').length) {
                alert('Debe agregar al menos un producto para guardar la venta');
                return false;
            }
            
            // Verificar campos obligatorios
            if (!validateRequiredFields()) {
                return false;
            }
            
            // Confirmar antes de guardar
            Swal.fire({
                title: '¿Está seguro?',
                text: '¿Desea guardar esta venta?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Deshabilitar botón para evitar doble envío
                    $('#saveBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
                    
                    // Enviar formulario mediante AJAX
                    let form = this;
                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: $(form).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Mostrar mensaje de éxito
                                Swal.fire({
                                    title: '¡Éxito!',
                                    text: response.message || 'Venta guardada correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                });
                                
                                // Imprimir ticket de venta
                                printSalesTicket(response.data);
                                
                                // Redireccionar a la lista de ventas después de 2 segundos
                                setTimeout(function() {
                                    window.location.href = "{{ url('admin/sales/list') }}";
                                }, 2000);
                            } else {
                                // Restaurar botón de guardar
                                $('#saveBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Venta');
                                
                                // Mostrar mensaje de error
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message || 'Error al guardar la venta',
                                    icon: 'error',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        },
                        error: function(xhr) {
                            // Restaurar botón de guardar
                            $('#saveBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Guardar Venta');
                            
                            // Mostrar mensaje de error
                            let errorMessage = 'Error al guardar la venta';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                title: 'Error',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    });
                    
                    // Prevenir el envío normal del formulario
                    return false;
                }
            });
        });
        
        // Función para imprimir el ticket de venta
        function printSalesTicket(sale) {
            // Verificar que sale tenga datos
            console.log('Sale data for ticket:', sale);
            
            // Si no hay datos, usar los datos del formulario
            if (!sale) {
                sale = {
                    series: $('#series').val(),
                    number: $('#number').val(),
                    date_of_issue: $('#date_of_issue').val()
                };
            }
            
            // Crear una ventana para imprimir
            let printWindow = window.open('', '_blank');
            
            // Construir el contenido del ticket
            let ticketContent = `
                <html>
                <head>
                    <title>Factura #${sale.invoice_no || $('#invoice_no').val() || ''} ${sale.number || $('#number').val() || ''}</title>
                    <style>
                        body {
                            font-family: 'Arial', sans-serif;
                            font-size: 12px;
                            margin: 0;
                            padding: 10px;
                        }
                        .ticket {
                            width: 80mm;
                            margin: 0 auto;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 10px;
                        }
                        .company-name {
                            font-size: 16px;
                            font-weight: bold;
                        }
                        .info {
                            margin-bottom: 10px;
                        }
                        .info-row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 5px;
                        }
                        .items {
                            border-top: 1px dashed #000;
                            border-bottom: 1px dashed #000;
                            padding: 10px 0;
                            margin-bottom: 10px;
                        }
                        .item {
                            margin-bottom: 5px;
                        }
                        .totals {
                            text-align: right;
                        }
                        .total-row {
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 5px;
                        }
                        .footer {
                            text-align: center;
                            margin-top: 10px;
                            font-size: 10px;
                        }
                        @media print {
                            body {
                                width: 80mm;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="ticket">
                        <div class="header">
                            <div class="company-name">{{ Auth::user()->company->name ?? 'Empresa' }}</div>
                            <div>{{ Auth::user()->company->address ?? 'Dirección' }}</div>
                            <div>Tel: {{ Auth::user()->company->phone ?? 'Teléfono' }}</div>
                            <div>NIT: {{ Auth::user()->company->identification_number ?? 'NIT' }}</div>
                            <div>Consecutivo: {{ Auth::user()->company->getNextConsecutive() }}</div>
                           

                        </div>
                        
                        <div class="info">
                            <div class="info-row">
                                <span>Factura:</span>
                                <span>${sale.invoice_no || $('#invoice_no').val() || ''} ${sale.number || $('#number').val() || ''}</span>
                            </div>
                            <div class="info-row">
                                <span>Fecha:</span>
                                <span>${sale.date_of_issue || $('#date_of_issue').val() || ''}</span>
                            </div>
                            <div class="info-row">
                                <span>Cliente:</span>
                                <span>${$('#customer_id option:selected').text()}</span>
                            </div>
                            <div class="info-row">
                                <span>Documento:</span>
                                <span>${$('#customer_document').val()}</span>
                            </div>
                        </div>
                        
                        <div class="items">
                            <div style="font-weight: bold; margin-bottom: 5px;">DETALLE</div>
            `;
            
            // Agregar los productos
            $('.product-row').each(function() {
                let quantity = $(this).find('.quantity').val();
                let productName = $(this).find('.product-name').text();
                let price = $(this).find('.price').val();
                let subtotal = $(this).find('.subtotal').val();
                
                ticketContent += `
                    <div class="item">
                        <div>${quantity} x ${productName}</div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Precio: $${price}</span>
                            <span>$${subtotal}</span>
                        </div>
                    </div>
                `;
            });
            
            // Agregar los totales
            ticketContent += `
                        </div>
                        
                        <div class="totals">
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span>$${$('#total_subtotal').val()}</span>
                            </div>
                            <div class="total-row">
                                <span>Descuento:</span>
                                <span>$${$('#total_discount').val()}</span>
                            </div>
                            <div class="total-row">
                                <span>Impuesto:</span>
                                <span>$${$('#total_tax').val()}</span>
                            </div>
                            <div class="total-row" style="font-weight: bold;">
                                <span>TOTAL:</span>
                                <span>$${$('#total_sale').val()}</span>
                            </div>
                        </div>
                        
                        <div class="footer">
                            <p>Forma de pago: ${$('#payment_form_id option:selected').text()}</p>
                            <p>Método de pago: ${$('#payment_method_id option:selected').text()}</p>
                            <p>Gracias por su compra</p>
                        </div>
                    </div>
                </body>
                </html>
            `;
            
            // Escribir el contenido en la ventana de impresión
            printWindow.document.write(ticketContent);
            printWindow.document.close();
            
            // Imprimir después de que se cargue el contenido
            setTimeout(function() {
                printWindow.print();
                // Cerrar la ventana después de imprimir (opcional)
                // printWindow.close();
            }, 1000); // Aumentar el tiempo de espera para asegurar que el contenido se cargue
        }
    });
</script>
@endsection