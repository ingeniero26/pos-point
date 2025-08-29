@extends('layouts.app')
  
@section('content')
<main class="app-main"> 
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Vista Previa de Venta</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/sales/list') }}">Ventas</a></li>
                        <li class="breadcrumb-item active">Vista Previa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="app-content"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Información de la Venta</h5>
                        </div>
                        <div class="card-body">
                            <!-- Vista previa de la información de venta -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Información del Cliente</h6>
                                    <p><strong>Cliente:</strong> <span id="preview_customer_name">-</span></p>
                                    <p><strong>Documento:</strong> <span id="preview_customer_document">-</span></p>
                                    <p><strong>Teléfono:</strong> <span id="preview_customer_phone">-</span></p>
                                    <p><strong>Dirección:</strong> <span id="preview_customer_address">-</span></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Información de la Venta</h6>
                                    <p><strong>Fecha:</strong> <span id="preview_date">-</span></p>
                                    <p><strong>Tipo de Comprobante:</strong> <span id="preview_voucher_type">-</span></p>
                                    <p><strong>Serie-Número:</strong> <span id="preview_voucher_number">-</span></p>
                                    <p><strong>Forma de Pago:</strong> <span id="preview_payment_form">-</span></p>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6>Productos</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="preview_products_table">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Código</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Unit.</th>
                                                    <th>Descuento</th>
                                                    <th>IVA</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="preview_empty_row">
                                                    <td colspan="7" class="text-center">No hay productos agregados</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6 offset-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Subtotal:</th>
                                            <td id="preview_subtotal">0.00</td>
                                        </tr>
                                        <tr>
                                            <th>Descuento Total:</th>
                                            <td id="preview_discount">0.00</td>
                                        </tr>
                                        <tr>
                                            <th>IVA:</th>
                                            <td id="preview_tax">0.00</td>
                                        </tr>
                                        <tr class="table-primary">
                                            <th>TOTAL:</th>
                                            <td id="preview_total">0.00</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ url('admin/sales/create') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Volver a Editar
                                    </a>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button type="button" id="confirmSaleBtn" class="btn btn-success">
                                        <i class="fas fa-check"></i> Confirmar Venta
                                    </button>
                                    <button type="button" id="printPreviewBtn" class="btn btn-info">
                                        <i class="fas fa-print"></i> Imprimir Vista Previa
                                    </button>
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Cargar datos de la venta desde localStorage
        loadSalePreview();
        
        // Confirmar venta
        $('#confirmSaleBtn').on('click', function() {
            confirmSale();
        });
        
        // Imprimir vista previa
        $('#printPreviewBtn').on('click', function() {
            window.print();
        });
        
        // Función para cargar los datos de la venta
        function loadSalePreview() {
            // Obtener datos del localStorage
            let saleData = JSON.parse(localStorage.getItem('saleData'));
            
            if (!saleData) {
                alert('No hay datos de venta para previsualizar');
                window.location.href = "{{ url('admin/sales/create') }}";
                return;
            }
            
            // Cargar información del cliente
            $('#preview_customer_name').text(saleData.customer_name || '-');
            $('#preview_customer_document').text(saleData.customer_document || '-');
            $('#preview_customer_phone').text(saleData.customer_phone || '-');
            $('#preview_customer_address').text(saleData.customer_address || '-');
            
            // Cargar información de la venta
            $('#preview_date').text(saleData.date || '-');
            $('#preview_voucher_type').text(saleData.voucher_type || '-');
            $('#preview_voucher_number').text(saleData.voucher_number || '-');
            $('#preview_payment_form').text(saleData.payment_form || '-');
            
            // Cargar productos
            if (saleData.products && saleData.products.length > 0) {
                let tbody = $('#preview_products_table tbody');
                tbody.empty();
                
                saleData.products.forEach(function(product) {
                    let row = `
                        <tr>
                            <td>${product.code || '-'}</td>
                            <td>${product.name || '-'}</td>
                            <td>${product.quantity || '0'}</td>
                            <td>${parseFloat(product.price).toFixed(2)}</td>
                            <td>${product.discount}%</td>
                            <td>${product.tax_rate}%</td>
                            <td>${parseFloat(product.subtotal).toFixed(2)}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }
            
            // Cargar totales
            $('#preview_subtotal').text(parseFloat(saleData.subtotal || 0).toFixed(2));
            $('#preview_discount').text(parseFloat(saleData.total_discount || 0).toFixed(2));
            $('#preview_tax').text(parseFloat(saleData.total_tax || 0).toFixed(2));
            $('#preview_total').text(parseFloat(saleData.total || 0).toFixed(2));
        }
        
        // Función para confirmar la venta
        function confirmSale() {
            let saleData = JSON.parse(localStorage.getItem('saleData'));
            
            if (!saleData) {
                alert('No hay datos de venta para confirmar');
                return;
            }
            
            $.ajax({
                url: "{{ url('admin/sales/store') }}",
                type: 'POST',
                data: saleData,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        alert('Venta registrada exitosamente');
                        localStorage.removeItem('saleData');
                        window.location.href = "{{ url('admin/sales/list') }}";
                    } else {
                        alert('Error al registrar la venta: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al registrar la venta';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ': ' + xhr.responseJSON.message;
                    }
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage += '\n\nDetalles:';
                        for (let field in xhr.responseJSON.errors) {
                            errorMessage += '\n- ' + xhr.responseJSON.errors[field][0];
                        }
                    }
                    
                    alert(errorMessage);
                }
            });
        }
    });
</script>
@endsection