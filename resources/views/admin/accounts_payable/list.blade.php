@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Cuentas por Pagar</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Factura de Pagos a proveedores
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content-body">
        <div class="containier-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Listado de Facturas por Pagar</h4>
                                </div>
                              
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tb_purchases">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Vencimiento</th>
                                            <th>Proveedor</th>
                                            <th>No Factura</th>
                                            <th>Estado</th>
                                           
                                            <th>Total Factura</th>
                                            <th>Saldo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>               
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Realizar Pago</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="paymentForm">
            <input type="hidden" id="account_payable_id" name="account_payable_id">
            
            <div class="mb-3">
              <label for="supplier_name" class="form-label">Proveedor</label>
              <input type="text" class="form-control" id="supplier_name" readonly>
            </div>
            
            <div class="mb-3">
              <label for="invoice_number" class="form-label">Número de Factura</label>
              <input type="text" class="form-control" id="invoice_number" readonly>
            </div>
            
            <div class="mb-3">
              <label for="total_amount" class="form-label">Monto Total</label>
              <input type="text" class="form-control" id="total_amount" readonly>
            </div>
            
            <div class="mb-3">
              <label for="payment_amount" class="form-label">Monto a Pagar</label>
              <input type="number" class="form-control" id="payment_amount" name="payment_amount" step="0.01" required>
            </div>
            
            <div class="mb-3">
              <label for="payment_date" class="form-label">Fecha de Pago</label>
              <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{date('Y-m-d')}}" required>
            </div>
            
            <div class="mb-3">
              <label for="payment_method" class="form-label">Método de Pago</label>
              <select class="form-select" id="payment_method_id" name="payment_method_id">
                @foreach($paymentMethods as $paymentMethod)
                <option value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                @endforeach
            </select>
              
            </div>
            
            <div class="mb-3">
              <label for="reference" class="form-label">Referencia/Observaciones</label>
              <textarea class="form-control" id="reference" name="reference" rows="3"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="savePayment">Guardar Pago</button>
        </div>
      </div>
    </div>
  </div>

</div>

  <!-- Modal para mostrar detalles de pagos -->
  <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailsModalLabel">Detalles de Pagos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <p><strong>Proveedor:</strong> <span id="detail-supplier"></span></p>
              <p><strong>Factura No:</strong> <span id="detail-invoice"></span></p>
            </div>
            <div class="col-md-6">
              <p><strong>Monto Total:</strong> <span id="detail-total"></span></p>
              <p><strong>Saldo Pendiente:</strong> <span id="detail-balance"></span></p>
            </div>
          </div>
          
          <h6 class="mt-4 mb-3">Historial de Pagos</h6>
          <div class="table-responsive">
            <table class="table table-striped" id="payments-table">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Monto</th>
                  <th>Método de Pago</th>
                  <th>Referencia</th>
                </tr>
              </thead>
              <tbody>
                <!-- Los datos se cargarán dinámicamente -->
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
    // listar las compras
    $(document).ready(function() {
        $.ajax({
                url: '{{route('admin.accounts_payable.fetch')}}', // Ruta definida en Laravel
                method: 'GET',
                dataType: 'json',
                data: {
                    // Puedes agregar parámetros adicionales si es necesario
            },
                success: function(data) {
                    var tableBody = $('#tb_purchases tbody');
                    tableBody.empty(); // Limpiar el cuerpo de la tabla

                    $.each(data, function(index, purchase_accounts) {
                        // var details = transfer.transfer_detail.map(detail => {
                        //     return `${detail.product.product_name}: ${detail.quantity}`;
                        // }).join('<br>');

                        var row = `<tr>
                                    <td>${purchase_accounts.id}</td>
                                    <td>${purchase_accounts.date_of_issue}</td>
                                    <td>${purchase_accounts.date_of_due}</td>
                                    <td>${purchase_accounts.suppliers.company_name}</td>
                                    <td>${purchase_accounts.invoice_no}</td>
                                    <td>${purchase_accounts.account_states.name === 'Pendiente' ? 
                                            `<span class="text-danger fw-bold">${purchase_accounts.account_states.name}</span>` : 
                                            purchase_accounts.account_states.name}</td>
                                    <td>${purchase_accounts.total_amount}</td>    
                                    <td>${purchase_accounts.balance}</td>                   
                                 <td>
                                        <button class="btn btn-warning btn-sm print-pdf" 
                                                data-purchase-id="${purchase_accounts.id}">
                                            <i class="fa-solid fa-print"></i></button>
                                            <button class="btn btn-success btn-sm payment-btn" data-id="${purchase_accounts.id}" data-invoice="${purchase_accounts.invoice_no}" 
                                            data-amount="${purchase_accounts.total_amount}" data-balance="${purchase_accounts.balance}"
                                             data-supplier="${purchase_accounts.suppliers.company_name}">
                                            <i class="fa-solid fa-money-bill"></i></button>
                                        </td>
                                   
                                   </tr>`;
                        tableBody.append(row);
                        //$('.print-pdf').on('click', handlePrintPdf);
                    });
                    $('#tb_purchases').DataTable();
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', error);
                }
            });

            // clic para imprimir
            $(document).on('click', '.print-pdf', function() {
                var accountPayableId = $(this).data('purchase-id'); // Obtener el ID de la cuenta por pagar
                
                if (!accountPayableId) {
                    console.error('ID de cuenta por pagar no encontrado');
                    alert('Error: No se pudo identificar la cuenta por pagar');
                    return;
                }
                
                // Usar la ruta correcta para generar el PDF
                var url = "{{ route('admin.accounts_payable.pdf', ['id' => ':id']) }}".replace(':id', accountPayableId);
                console.log('Abriendo URL:', url); // Para depuración
                window.open(url, '_blank');
            });
            
            
        // Manejar el clic en el botón de pago
        $(document).on('click', '.payment-btn', function() {
            var id = $(this).data('id');
            var invoice = $(this).data('invoice');
            var amount = $(this).data('amount');
            var balance = $(this).data('balance');
            var supplier = $(this).data('supplier');
            
            // Llenar el formulario del modal
            $('#account_payable_id').val(id);
            $('#supplier_name').val(supplier);
            $('#invoice_number').val(invoice);
            $('#total_amount').val(amount);
            $('#payment_amount').val(balance); // Por defecto, sugerir el pago total
            
            // Mostrar el modal
            $('#paymentModal').modal('show');
        });
        
        // Manejar el envío del formulario de pago
        $('#savePayment').click(function() {
            // Validar el formulario
            if (!$('#paymentForm')[0].checkValidity()) {
                $('#paymentForm')[0].reportValidity();
                return;
            }
            
            // Obtener los datos del formulario
            var formData = {
                account_payable_id: $('#account_payable_id').val(),
                payment_amount: $('#payment_amount').val(),
                payment_date: $('#payment_date').val(),
                payment_method_id: $('#payment_method_id').val(),
                reference: $('#reference').val(),
                _token: $('meta[name="csrf-token"]').attr('content')  // Add CSRF token directly to form data
            };
            
            // Enviar los datos al servidor
            $.ajax({
                url: '{{route('admin.payment_purchases.payment')}}',
                method: 'POST',
                dataType: 'json',
                data: formData,
                // Remove headers section as we're including the token in the form data
                success: function(response) {
                    if (response.success) {
                        // Mostrar mensaje de éxito
                        alert(response.message);
                        // Cerrar el modal
                        $('#paymentModal').modal('hide');
                        // Recargar la tabla
                        location.reload();
                    } else {
                        // Mostrar mensaje de error
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al procesar el pago:', error);
                    alert('Error al procesar el pago. Por favor, inténtelo de nuevo.');
                }
            });
        });
    });

    
</script>
@endsection
  
      
