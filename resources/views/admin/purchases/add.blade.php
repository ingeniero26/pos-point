@extends('layouts.app')
@section('style')
<style>
     .total-purchase-label {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 2rem;
            font-weight: 400;
            line-height: 1.5;
            color: #020e13;
            background-color: #f8f9fa; /* Fondo gris claro */
            border: 1px solid #ced4da; /* Borde gris */
            border-radius: 0.25rem; /* Bordes redondeados */
            text-align: center; /* Alinear texto a la derecha */
        }
</style>
@endsection
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Factura de Compras</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Factura de Compras
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Crear Nueva Factura de Compra</h3>
                    </div>
                    <div class="card-body">
                        <form action="" action="{{route('admin.purchase.store')}}" method="POST" id="purchaseForm">
                            @csrf
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for=""><b>Tipo Comprobante</b></label>
                                        <select name="voucher_type_id" id="voucher_type_id" class="form-select">
                                            
                                             @foreach($documentTypes as $documentType)
                                                <option value="{{ $documentType->id }}"
                                                     {{ $documentType->name == 'Factura de Compra' ? 'selected' : '' }}>
                                                    {{ $documentType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for=""><b>Tercero</b> </label>
                                    <div class="input-group mb-2">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#personModal">
                                            <i class="fas fa-search-plus"></i> Buscar Proveedor
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card border-info mb-3">
                                        <div class="card-header bg-info text-white">
                                            <strong>Información del Proveedor</strong>
                                        </div>
                                        <div id="supplier-info-container" style="display: none;">
                                            <div class="card-body">
                                                <div class="row" >
                                                    <div class="col-md-1">
                                                        <label for="supplier_id"><b>ID</b></label>
                                                        <input type="text" class="form-control" id="supplier_id" name="supplier_id" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="supplier_name"><b>Nombre</b></label>
                                                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="supplier_last_name"><b>Apellido</b></label>
                                                        <input type="text" class="form-control" id="supplier_last_name" name="supplier_last_name" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="supplier_last_name"><b>Empresa</b></label>
                                                        <input type="text" class="form-control" id="company_name" 
                                                        name="company_name" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="supplier_last_name"><b>Documento</b></label>
                                                        <input type="text" class="form-control" id="supplier_document" 
                                                        name="supplier_document" readonly>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="cash_register_id" class="form-label">Caja Registradora *</label>
                                        <select class="form-select" id="cash_register_id" name="cash_register_id" required>
                                            <option value="">Seleccione...</option>
                                            @foreach($cashRegisters as $register)
                                                @if($register->hasOpenSession())
                                                    <option value="{{ $register->id }}">{{ $register->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            

                            
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for=""><b>Bodega</b></label>
                                        <select class="form-select" id="warehouse_id" name="warehouse_id">
                                             <option value="">Seleccione...</option>
                                             @foreach($warehouses as $warehouse)
                                                 <option value="{{$warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                             @endforeach
                                        </select>
                                    </div>
                                </div>
                              
                                <div class="col-md-6">
                                    <label for="">No Factura Proveedor</label>
                                    <input type="text" class="form-control" id="invoice_no" name="invoice_no" required>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><b>Estado Factura</b></label>
                                    
                                    <select class="form-select" id="state_type_id" name="state_type_id">
                                        @foreach($stateTypes as $status)
                                            <option value="{{$status->id}}">{{$status->description}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Forma de Pago</label>
                                    <select class="form-select" id="payment_form_id" name="payment_form_id">
                                        @foreach($formPayments as $paymentForm)
                                            <option value="{{$paymentForm->id}}">{{$paymentForm->payment_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Fecha Emisión</label>
                                    <input type="date" class="form-control"
                                     id="date_of_issue" name="date_of_issue" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Fecha Vencimiento</label>
                                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}" id="date_of_due"
                                     name="date_of_due" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Serie</label>
                                     <input type="text" class="form-control" id="series" name="series" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Número de Serie</label>
                                     <input type="text" class="form-control" 
                                     id="number" name="number" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Moneda</label>
                                     <select class="form-select" id="currency_id" name="currency_id">
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
                                <div class="col-md-3">
                                    <label for="">Medio de Pago</label>
                                     <select class="form-select" id="payment_method_id" name="payment_method_id">
                                        @foreach($paymentMethods as $paymentMethod)
                                        <option value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">Observaciones</label>
                                        <textarea class="form-control" id="observations" name="observations" rows="3"></textarea>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <h3 class="text-center">Detalle del Items</h3>
                                <!--Bbuscar producto para agregar a tabla temporal su impuesto-->
                               <div class="row">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Agregar Producto</h3>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <label for="">Cantidad</label>
                                                <input type="number" class="form-control" value="1"
                                                  id="quantity" name="quantity" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Precio Compra</label>
                                                <input type="number" class="form-control"
                                                  id="cost_price" name="cost_price" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for=""><b>Buscar Producto</b></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="search_barcode" 
                                                    placeholder="Ingrese nombre del producto">
                                                </div>
                                            </div>
                                             <div class="col-md-5">
                                                <div class="form-group">
                                                    <button type="button" 
                                                    class="btn btn-info mt-4"  data-bs-toggle="modal" data-bs-target="#itemModal"><i class="fas fa-search"></i></button>
                                                    <a href="{{url('admin/items/list')}}" type="button" class="btn btn-success mt-4"><i class="fas fa-plus"></i></a>
                                                </div>
                                             </div>
                                        </div>
                                        <div class="row mt-2">
                                            <table class="table table-sm table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Codigo</th>
                                                        <th>Nombre</th>
                                                        <th>Cantidad</th>
                                                        <th>Costo</th>
                                                        <th>Descuento(%)</th>
                                                        <th>Iva(%)</th>
                                                        <th>Sub Total</th>
                                                        <th>Descuento</th>
                                                        <th>Impuesto</th>
                                                         <th>Total</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                 <tbody id="item_table_body">
                                                    <?php $cont = 1?>
                                                     <!-- Cuerpo de la tabla aquí -->
                                                     @foreach ($tmp_purchase as  $value)
                                                     <?php 
                                                      $discount_percent = $value->discount_percent ?? 0;
                                                        $quantity = $value->quantity?? 0;
                                                        $cost_price = $value->cost_price ?? 0;
                                                        $subtotal = $value->quantity * $value->cost_price;
                                                        $discount_amount = $subtotal * ($discount_percent / 100);
                                                        $subtotal_after_discount = $subtotal - $discount_amount;
                                                        $tax_amount = $subtotal_after_discount * ($value->items->tax->rate ?? 0) / 100;
                                                        $total = $subtotal_after_discount + $tax_amount;                                                    

                                                     ?>
                                                       <tr>
                                                        <td>{{$cont++}}</td>
                                                        <td>{{$value->items->barcode}}</td>
                                                        <td>{{$value->items->product_name}}</td>
                                                        {{-- <td>{{$value->quantity}}</td> --}}
                                                        <td>
                                                            <input type="number" min="1"  
                                                            class="form-control form-control-sm  quantity-input" 
                                                                data-id="{{$value->id}}" value="{{$quantity}}" style="width: 70px;">
                                                         </td>
                                                        <td>
                                                            <input type="number" min="0"  
                                                            class="form-control form-control-sm cost_price-input" 
                                                                data-id="{{$value->id}}" value="{{$cost_price}}" style="width: 70px;">
                                                         </td>
                                                         {{-- <td>{{ '$ ' . number_format($value->cost_price, 2, ',', '.') }}</td> --}}
                                                       
                                                        <td>
                                                           <input type="number" min="0" max="100" class="form-control form-control-sm discount-input" 
                                                               data-id="{{$value->id}}" value="{{$discount_percent}}" style="width: 70px;">
                                                        </td>
                                                        <td>
                                                           @if($value->items->tax)
                                                               {{$value->items->tax->rate}}%
                                                           @else
                                                               0%
                                                           @endif
                                                        </td>
                                                        <td>{{ '$ ' . number_format($subtotal_after_discount, 2, ',', '.') }}</td>
                                                        <td>{{ '$ ' . number_format($discount_amount, 2, ',', '.') }}</td>
                                                        <td>{{ '$ ' . number_format($tax_amount, 2, ',', '.') }}</td>
                                                        <td>{{ '$ ' . number_format($total, 2, ',', '.') }}</td>
                                                        <td>
                                                               <button type="button" class="btn btn-danger btn-sm delete-item-btn" 
                                                                    data-id="{{$value->id}}"><i class="fas fa-trash"></i>
                                                                </button>
                                                        </td>
                                                    </tr>
                                                         
                                                     @endforeach
                                                 </tbody>
                                                 <tfoot>
                                                    <tr>
                                                        <?php 
                                                        $total_quantity = 0;
                                                        $total_subtotal = 0;
                                                        $total_discount = 0;
                                                        $total_tax = 0;
                                                        $total_purchase = 0;
                                                        
                                                        foreach($tmp_purchase as $value) {
                                                            $discount_percent = $value->discount_percent ?? 0;
                                                            $subtotal = $value->quantity * $value->cost_price;
                                                            $discount_amount = $subtotal * ($discount_percent / 100);
                                                            $subtotal_after_discount = $subtotal - $discount_amount;
                                                            $tax_amount = $subtotal_after_discount * ($value->items->tax->rate ?? 0) / 100;
                                                            $total = $subtotal_after_discount + $tax_amount;
                                                            
                                                            $total_quantity += $value->quantity;
                                                            $total_subtotal += $subtotal_after_discount;
                                                            $total_discount += $discount_amount;
                                                            $total_tax += $tax_amount;
                                                            $total_purchase += $total;
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3" style="text-align: right">
                                                           <b>Totales:</b> 
                                                        </td>
                                                        <td><b>{{ $total_quantity }}</b></td>
                                                        <td colspan="3"></td>
                                                        <td><b>{{ '$ ' . number_format($total_subtotal, 2, ',', '.') }}</b></td>
                                                        <td><b>{{ '$ ' . number_format($total_discount, 2, ',', '.') }}</b></td>
                                                        <td><b>{{ '$ ' . number_format($total_tax, 2, ',', '.') }}</b></td>
                                                        <td><b>{{ '$ ' . number_format($total_purchase, 2, ',', '.') }}</b></td>
                                                        <td></td>
                                                    </tr>
                                                    </tr>
                                                 </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                   
                                </div>
                               </div>
                               <!--total final en el formulario -->
                               <div class="row">
                                <div class="col-md-2 float-left">
                                    <label for="total_subtotal">Subtotal Compra:</label>
                                    <input type="text" class="total-purchase-label"  name="total_subtotal"
                                    value="{{ number_format($total_subtotal, 2) }}" id="total_subtotal" readonly>
                                   
                                </div>
                                <div class="col-md-2 float-left">
                                    <label for="total_subtotal">Descuento:</label>
                                    <input type="text" class="total-purchase-label" name="total_discount"
                                     value="{{ number_format($total_discount, 2) }}" id="total_discount" readonly>

                                </div>
                                <div class="col-md-2 float-left">
                                    <label for="total_subtotal">Impuesto:</label>
                                    <input type="text" class="total-purchase-label" value="{{ number_format($total_tax, 2) }}"
                                     id="total_tax" name="total_tax" readonly>

                                </div>
                                <div class="col-md-6 float-left">
                                    <label for="total_purchase">Total :</label>
                                    <input type="text" class="total-purchase-label"
                                     value="{{ number_format($total_purchase, 2) }}" name="total_purchase" id="total_purchase" readonly>
                                   
                                </div>
                                                               
                               </div>
                                
                               <!-- Modal  item-->
                            <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Buscador de productos</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="row">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="product-table" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Acción</th>
                                                             <th>Tipo</th>
                                                            <th>Nombre</th>
                                                            <th>Cód Barra</th>
                                                            <th>Cod Interno</th>
                                                            <th>SKU</th>
                                                            <th>Referencia</th>
                                                            <th>Categoria</th>
                                                          
                                                            <th>Vence</th>
                                                            <th>Descripción</th>
                                                            <th>Marca</th>
                                                            <th>Medida</th>
                                                            <th>Precio Costo</th>
                                                            <th>Precio Venta</th>
                                                            <th>Impuesto</th>
                                                            <th>Precio + Iva</th>
                                                            <th>Estado</th>
                                                            
                                                          
                                                        </tr>
                                                    </thead>
                                                    <tbody>
            
                                                    </tbody>
                                                </table>
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
                            <!-- Modal person -->
                            <div class="modal fade" id="personModal" tabindex="-1" aria-labelledby="personModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="personModalLabel">Buscar Tercero</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                
                                            <div class="table-responsive">
                                                <table id="customer-table" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>  
                                                            <th>Acción</th>
                                                            <th>Tipo Persona</th>                                               
                                                             <th>Tipo Documento</th>
                                                             <th>Número</th>  
                                                             <th>Empresa</th>                                              
                                                            <th>Tercero</th>
                                                            <th>Régimen</th>   
                                                            <th>Obligación</th>  
                                                            
                                                             <th>Teléfono</th>
                                                             <th>Correo Electrónico</th>
                                                            <th>Estado</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
            
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                                
                               
                               
                            </div>         
                        </form>
                        <div class="row">
                            <div class="col-md-8 mt-2">
                                <div class="float-end">
                                    <button type="button" class="btn btn-primary" id="saveBtn">Guardar</button>
                                </div>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="float-end">
                                    <button type="submit" class="btn btn-success" id="printBtn">Guardar y Enviar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
<script>

// pasar el item del modal al input
$(document).on('click', '.select-item', function() {
    let id = $(this).data('id');
    let barcode = $(this).data('barcode');
    $('#search_barcode').val(barcode);
    $('#itemModal').modal('hide');
    //poner focus input de buscar item
    $('#search_barcode').focus();
    // $('#itemModal').on('hidden.bs.modal',function(){
    //     $('#search_barcode').focus();
    // });

});

// pasar el tercero
$(document).on('click', '.select-person', function() {
    let id = $(this).data('id');
    let name = $(this).data('name');
    let last_name = $(this).data('last_name');
    let company_name = $(this).data('company_name');


    $('#supplier_id').val(id);
    $('#supplier_name').val(name);
    $('#supplier_last_name').val(last_name);
    $('#company_name').val(company_name);

    $('#supplier_document').val($(this).data('identification_number'));
    $('#supplier-info-container').show();

    $('#personModal').modal('hide');
    //poner focus input de buscar item
  //  $('#search_barcode').focus();
    // $('#itemModal').on('hidden.bs.modal',function(){
    //     $('#search_barcode').focus();
    // });

});

    // eliminar
    $('.delete-item-btn').click(function(){
        let id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{url('admin/purchase/create/tmp')}}/"+id,
                    type: 'POST',
                    data: {
                        _token: '{{csrf_token()}}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if(response.success) {
                            // Refresh the page to show updated calculations
                            Swal.fire({
                                title: 'Éxito',
                                text: 'Producto eliminado con éxito',
                                icon:'success',
                                confirmButtonText: 'Aceptar'
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message || 'Error al eliminar el producto',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al eliminar el producto: ', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al eliminar el producto',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            }
        });
    });
    // Add this to your existing scripts
    $(document).on('change', '.discount-input', function() {
        let id = $(this).data('id');
        let discountPercent = $(this).val();
        
        // Validate discount is between 0-100
        if (discountPercent < 0) {
            $(this).val(0);
            discountPercent = 0;
        } else if (discountPercent > 100) {
            $(this).val(100);
            discountPercent = 100;
        }
        
        // Send AJAX request to update the discount
        $.ajax({
            url: "{{route('admin.purchase.update_discount')}}",
            method: 'POST',
            data: {
                _token: '{{csrf_token()}}',
                id: id,
                discount_percent: discountPercent
            },
            success: function(response) {
                if(response.success) {
                    // Refresh the page to show updated calculations
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Descuento actualizado con éxito',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'Error al actualizar el descuento',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar el descuento: ', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar el descuento',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
    // cambiar el precio de compra dinamicamente y actualizar valores 
    //cost_price-input
    $(document).on('change', '.cost_price-input', function() {
        let id = $(this).data('id');
        let costPrice = $(this).val();
        
        // Validar  q el precio sea mayor a cero
        if (costPrice < 0) {
            $(this).val(0);
            costPrice = 0;
        }       
           
        // Send AJAX request to update the discount
        $.ajax({
            url: "{{route('admin.purchase.update_cost_price')}}",
            method: 'POST',
            data: {
                _token: '{{csrf_token()}}',
                id: id,
                cost_price: costPrice
            },
            success: function(response) {
                if(response.success) {
                    // Refresh the page to show updated calculations
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Costo actualizado con éxito',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'Error al actualizar el precio',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar el descuento: ', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar el descuento',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });

    // cambiar la cantidad dinamicamente
    $(document).on('change', '.quantity-input', function() {
        let id = $(this).data('id');
        let Quantity = $(this).val();
        
        // Validar  q el precio sea mayor a cero
        if (Quantity < 0) {
            $(this).val(0);
            Quantity = 0;
        }       
           
        // Send AJAX request to update the discount
        $.ajax({
            url: "{{route('admin.purchase.update_quantity')}}",
            method: 'POST',
            data: {
                _token: '{{csrf_token()}}',
                id: id,
                quantity: Quantity
            },
            success: function(response) {
                if(response.success) {
                    // Refresh the page to show updated calculations
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Cantidad actualizado con éxito',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'Error al actualizar  la cantidad',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar el el registro: ', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar el registro',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
</script>
<script>
    // captura el cursor 
    $('#search_barcode').focus();

    $('#purchaseForm').on('keypress', function(e){
        if(e.keyCode===13) {
            e.preventDefault();
            
        }
    });

     $(document).ready(function(){
        fechtProduct();
        fechtCustomers();
     });
     $('#payment_method_id').on('change', function() {
            const isPaymentCash = $(this).val() == '1';
            $('#cash_register_id').prop('required', isPaymentCash);
            $('#cash_register_id').closest('.col-md-3').toggle(isPaymentCash);
        });
        
     function fechtCustomers() {
        let typeContact = $('#filterTypeContact').val();
        let status = $('#filterStatus').val();
        let startDate = $('#startDate').val(); 
        let endDate = $('#endDate').val();
    
        $.ajax({
        url: "{{route('person.fetch')}}",
        type: 'GET',
        data: {
       
            status: status,
            
        },
        success: function(response){
            let tableBody = '';
            $.each(response, function(index, customer){
                let createdAt = dayjs(customer.created_at).format('DD/MM/YYYY h:mm A');
                let updatedAt = dayjs(customer.updated_at).format('DD/MM/YYYY h:mm A');
                let statusText = customer.status == 1 ? 'Inactivo' : 'Activo';
              
                let toggleStatusText = customer.status == 1 ? 'Activar' : 'Desactivar';
                let toggleIcon = customer.status == 1 ? 'fa-toggle-on' : 'fa-toggle-off';

                tableBody += `<tr>
                                <td>${index + 1}</td>
                                 <td>
                                            <button type="button" class="btn btn-success select-person" data-id="${customer.id}" 
                                            data-name="${customer.name}"
                                             data-last_name="${customer.last_name}"
                                             data-company_name="${customer.company_name}"
                                             data-identification_number="${customer.identification_number}"

                                             >Seleccionar</button></td>
                                             </td>
                                 <td>${customer.type_third ? customer.type_third.type_third : 'N/A'}</td>
                               
                                <td>${customer.identification_type ? customer.identification_type.identification_name : 'N/A'}</td>
                               
                                <td>${customer.identification_number}</td>
                                <td>${customer.company_name}</td>
                                <td>${customer.name} ${customer.last_name}</td>
                              
                                <td>${customer.type_regimen ? customer.type_regimen.regimen_name : 'N/A'}</td>
                                <td>${customer.type_liability ? customer.type_liability.liability_name : 'N/A'}</td>
                              
                                <td>${customer.phone}</td>
                                <td>${customer.email}</td>
                                <td>${statusText}</td>
                          
                             </tr>`;
            });
            $('#customer-table tbody').html(tableBody);
          
            $('#customer-table').DataTable();
        },
        error: function(xhr, status, error){
            console.error('Error al leer los contactos: ', error);
        }
            });
        }
    
    
     function fechtProduct(){
            $.ajax({
                url: "{{route('product.fetch')}}",
                type: 'GET',
                success: function(response){
                    let tableBody = '';
                    $.each(response, function(index, items){
                        let createdAt = dayjs(items.created_at).format('DD/MM/YYYY h:mm A');
                        let updatedAt = dayjs(items.updated_at).format('DD/MM/YYYY h:mm A');
                        let costPrice = formatCurrency(items.cost_price);
                        let sellingPrice = formatCurrency(items.selling_price);
                        let price_total = formatCurrency(items.price_total);
                        let statusText = items.status == 1 ? 'Inactivo' : 'Activo';
                        
                        tableBody += `<tr>
                                        <td>${index + 1}</td>
                                        <td>
                                            <button type="button" class="btn btn-success select-item" data-id="${items.id}" 
                                            data-barcode="${items.barcode}"
                                             data-name="${items.product_name}">Seleccionar</button></td>
                                             </td>
                                       
                                         <td>${ items.items_type ? items.items_type.name : 'N/A'}</td>
                                        <td>${items.product_name}</td>
                                        <td>${items.barcode}</td>
                                        <td>${items.internal_code}</td>
                                        <td>${items.sku}</td>
                                        <td>${items.reference}</td>
                                        <td>${ items.category ? items.category.category_name : 'N/A'}</td>
                                       
                                        <td>${items.expiration_date}</td>
                                        <td>${items.description}</td>
                                        <td>${ items.brand ? items.brand.brand_name : 'N/A'}</td>
                                        <td>${items.measure ? items.measure.measure_name : 'N/A'}</td>
                                        <td>${costPrice}</td>
                                        <td>${sellingPrice}</td>
                                        <td>${items.tax ? items.tax.tax_name : 'N/A'}</td>
                                        <td>${price_total}</td>
                                        <td>${statusText}</td>
                                    
                                     
                                     </tr>`;
                    });
                    $('#product-table tbody').html(tableBody);
                   
                    $('#product-table').DataTable();
                },
                error: function(xhr, status, error){
                    console.error('Error al leer los productos: ', error);
                }
            });
        }

        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
        }
</script>
<script>
    $('#search_barcode').on('keyup', function(e){
        if(e.which===13) {
            var barcode = $(this).val();
        var quantity = $('#quantity').val();
        var cost_price =$('#cost_price').val();
        if(barcode.length >0 ){
            $.ajax({
                url: "{{route('admin.purchase.tmp_purchase')}}",
                method: 'POST',
                data:{
                    _token: '{{csrf_token()}}',
                    barcode: barcode,
                    quantity: quantity,
                    cost_price: cost_price
                },
                success: function(response){
                    if(response.success) {
                        // mostrar con swalrte
                        Swal.fire({
                            title: 'Producto añadido',
                            text: response.message,
                            icon:'success',
                            confirmButtonText: 'Aceptar'
                        });
                        location.reload();
                       
                    }else{
                        // mostrar con sweetalert
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function(xhr, status, error){
                    console.error('Error al buscar el producto: ', error);
                }
            });
        }
        }
    });
</script>

<script>
    // enviar fomulario para la base de datos
 $('#saveBtn').click(function(e){
    if (!validateForm()) {
            return false;
        }
        Swal.fire({
            title: 'Procesando',
            text: 'Guardando la factura de compra...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Submit the form via AJAX
        $.ajax({
            url: "{{route('admin.purchase.store')}}",
            type: 'POST',
            data: $('#purchaseForm').serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Factura de compra guardada correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{route('admin.purchase.list')}}";
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'Error al guardar la factura de compra',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al guardar la factura: ', error);
                
                // Handle validation errors
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = 'Se encontraron los siguientes errores:<br>';
                    
                    for (let field in errors) {
                        errorMessage += `- ${errors[field][0]}<br>`;
                    }
                    
                    Swal.fire({
                        title: 'Error de validación',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al guardar la factura de compra',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
 });
 function validateForm() {
    let isValid = true;
        let errorMessage = '';
        
        // Check if supplier is selected
        if (!$('#supplier_id').val()) {
            errorMessage += '- Debe seleccionar un proveedor<br>';
            isValid = false;
        }
        
        // Check if warehouse is selected
        if (!$('#warehouse_id').val()) {
            errorMessage += '- Debe seleccionar una bodega<br>';
            isValid = false;
        }
        
        // Check if invoice number is provided
        if (!$('#invoice_no').val()) {
            errorMessage += '- Debe ingresar el número de factura<br>';
            isValid = false;
        }
        // Check if payment method is selected
        if (!$('#payment_method_id').val()) {
            errorMessage += '- Debe seleccionar un método de pago<br>';
            isValid = false;
        }

        // Check if payment method is cash and cash register is selected
        if ($('#payment_method_id').val() == '1' && !$('#cash_register_id').val()) {
            errorMessage += '- Debe seleccionar una caja registradora para el pago en efectivo<br>';
            isValid = false;
        }
        
        // Check if there are items in the purchase
        if ($('#item_table_body tr').length === 0) {
            errorMessage += '- Debe agregar al menos un producto a la factura<br>';
            isValid = false;
        }
        
        // Display error message if validation fails
        if (!isValid) {
            Swal.fire({
                title: 'Error de validación',
                html: 'Por favor corrija los siguientes errores:<br>' + errorMessage,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
        
        return isValid;
 }

</script>

@endsection