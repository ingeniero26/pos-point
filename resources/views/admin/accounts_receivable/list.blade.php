@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Cuentas por Cobrar</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Cuentas por Cobrar
                        </li>
                    </ol>
                </div>
            </div> 
        </div> 
    </div>
    <div class="app-content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>Listado de Facturas por Cobrar
                                    </h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="refreshTable">
                                            <i class="fas fa-sync-alt me-1"></i> Actualizar
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm" id="exportExcel">
                                            <i class="fas fa-file-excel me-1"></i> Exportar
                                        </button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="tb_purchases">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="10%">Fecha</th>
                                            <th width="10%">Vencimiento</th>
                                            <th width="20%">Cliente</th>
                                            <th width="10%">No Factura</th>
                                            <th width="10%">Estado</th>
                                            <th width="10%">Total Factura</th>
                                            <th width="10%">Saldo</th>
                                            <th width="15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> Visualizando todas las facturas pendientes por cobrar
                                        @if(isset($accountsCount))
                                            <br><small class="text-info">Registros en BD: {{ $accountsCount }}</small>
                                        @endif
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="badge bg-primary" id="totalCount">0 registros</div>
                                </div>
                            </div>
                        </div>
                    </div>               
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal para realizar pagos -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="paymentModalLabel">
                    <i class="fas fa-money-bill-wave me-2 text-success"></i>Registrar Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    <input type="hidden" id="account_receivable_id" name="account_receivable_id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Cliente</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="customer_name" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="invoice_number" class="form-label">Número de Factura</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                                <input type="text" class="form-control" id="invoice_number" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="total_amount" class="form-label">Monto Total</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" id="total_amount" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="balance" class="form-label">Saldo Pendiente</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" id="balance" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_amount" class="form-label">Monto a Pagar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="payment_amount" name="payment_amount" step="0.01" required>
                        </div>
                        <div class="form-text">El monto no puede ser mayor al saldo pendiente</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="payment_date" class="form-label">Fecha de Pago <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{date('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_method_id" class="form-label">Método de Pago <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_method_id" name="payment_method_id" required>
                                <option value="">Seleccione...</option>
                                @foreach($paymentMethods as $paymentMethod)
                                <option value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reference" class="form-label">Referencia/Observaciones</label>
                        <textarea class="form-control" id="reference" name="reference" rows="3" placeholder="Ingrese detalles adicionales del pago..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="savePayment">
                    <i class="fas fa-save me-1"></i>Guardar Pago
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar detalles de pagos -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="detailsModalLabel">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Historial de Pagos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mb-3 bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong><i class="fas fa-user me-2"></i>Cliente:</strong> <span id="detail-customer"></span></p>
                                <p class="mb-1"><strong><i class="fas fa-file-invoice me-2"></i>Factura No:</strong> <span id="detail-invoice"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong><i class="fas fa-dollar-sign me-2"></i>Monto Total:</strong> <span id="detail-total"></span></p>
                                <p class="mb-1"><strong><i class="fas fa-balance-scale me-2"></i>Saldo Pendiente:</strong> <span id="detail-balance"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h6 class="border-bottom pb-2 mb-3">
                    <i class="fas fa-history me-2"></i>Historial de Pagos
                </h6>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="payments-table">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Método de Pago</th>
                                <th>Referencia</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se cargarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printPaymentHistory">
                    <i class="fas fa-print me-1"></i>Imprimir Ticket
                </button>
                <button type="button" class="btn btn-info" id="printPaymentTicketPDF">
                    <i class="fas fa-file-pdf me-1"></i>Ticket PDF
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        var table = $('#tb_purchases').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            responsive: true,
            processing: true,
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'pdf',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimir',
                    className: 'btn btn-info btn-sm',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                }
            ]
        });
        
        // Cargar datos
        loadAccountsReceivable();
        
        // Función para cargar las cuentas por cobrar
        function loadAccountsReceivable() {
            console.log('Loading accounts receivable...');
            
            $.ajax({
                url: '{{route("admin.accounts_receivable.fetch")}}',
                method: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    console.log('Sending request to fetch accounts receivable');
                    $('#tb_purchases tbody').html('<tr><td colspan="9" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>Cargando datos...</td></tr>');
                },
                success: function(data) {
                    console.log('Received data:', data);
                    console.log('Data length:', data.length);
                    
                    // Limpiar tabla
                    table.clear().draw();
                    
                    // Verificar si hay datos
                    if (!data || data.length === 0) {
                        $('#tb_purchases tbody').html('<tr><td colspan="9" class="text-center">No hay cuentas por cobrar registradas</td></tr>');
                        $('#totalCount').text('0 registros');
                        return;
                    }
                    
                    // Actualizar contador
                    $('#totalCount').text(data.length + ' registros');
                    
                    // Agregar filas a la tabla
                    $.each(data, function(index, account) {
                        // Calcular días de vencimiento
                        var dueDate = new Date(account.date_of_due);
                        var today = new Date();
                        var diffTime = dueDate - today;
                        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        
                        // Formatear fecha de vencimiento con indicador de estado
                        var dueDateFormatted = formatDate(account.date_of_due);
                        if (diffDays < 0) {
                            dueDateFormatted = '<span class="text-danger">' + dueDateFormatted + ' <span class="badge bg-danger">Vencido</span></span>';
                        } else if (diffDays <= 5) {
                            dueDateFormatted = '<span class="text-warning">' + dueDateFormatted + ' <span class="badge bg-warning text-dark">Próximo</span></span>';
                        }
                        
                        // Formatear estado
                        var statusBadge = '';
                        if (account.account_states && account.account_states.name === 'Pendiente') {
                            statusBadge = '<span class="badge bg-danger">Pendiente</span>';
                        } else if (account.account_states && account.account_states.name === 'Parcial') {
                            statusBadge = '<span class="badge bg-warning text-dark">Parcial</span>';
                        } else if (account.account_states && account.account_states.name === 'Pagado') {
                            statusBadge = '<span class="badge bg-success">Pagado</span>';
                        } else {
                            statusBadge = '<span class="badge bg-secondary">' + (account.account_states ? account.account_states.name : 'N/A') + '</span>';
                        }
                        
                        // Calcular el balance real
                        var totalPaid = 0;
                        if (account.payments && account.payments.length > 0) {
                            totalPaid = account.payments.reduce(function(sum, payment) {
                                return sum + parseFloat(payment.payment_amount || 0);
                            }, 0);
                        }
                        var realBalance = parseFloat(account.total_amount) - totalPaid;
                        
                        // Actualizar el estado basado en el balance real
                        var realStatus = '';
                        if (realBalance <= 0) {
                            realStatus = '<span class="badge bg-success">Pagado</span>';
                        } else if (totalPaid > 0) {
                            realStatus = '<span class="badge bg-warning text-dark">Parcial</span>';
                        } else {
                            realStatus = '<span class="badge bg-danger">Pendiente</span>';
                        }
                        
                        // Agregar fila a la tabla
                        table.row.add([
                            account.id,
                            formatDate(account.date_of_issue),
                            dueDateFormatted,
                            account.customers ? account.customers.name : 'N/A',
                            account.sales ? account.sales.invoice_no : 'N/A',
                            realStatus,
                            formatCurrency(account.total_amount),
                            formatCurrency(realBalance),
                            '<div class="btn-group">' +
                                '<button class="btn btn-outline-primary btn-sm view-details" data-id="' + account.id + '" data-invoice="' + (account.sales ? account.sales.invoice_no : 'N/A') + '" data-amount="' + account.total_amount + '" data-balance="' + realBalance + '" data-customer="' + (account.customers ? account.customers.name : 'N/A') + '">' +
                                    '<i class="fas fa-eye"></i>' +
                                '</button>' +
                                '<button class="btn btn-outline-success btn-sm payment-btn" data-id="' + account.id + '" data-invoice="' + (account.sales ? account.sales.invoice_no : 'N/A') + '" data-amount="' + account.total_amount + '" data-balance="' + realBalance + '" data-customer="' + (account.customers ? account.customers.name : 'N/A') + '" ' + (realBalance <= 0 ? 'disabled' : '') + '>' +
                                    '<i class="fas fa-money-bill-wave"></i>' +
                                '</button>' +
                                '<button class="btn btn-outline-info btn-sm print-pdf" data-id="' + account.id + '">' +
                                    '<i class="fas fa-print"></i>' +
                                '</button>' +
                            '</div>'
                        ]).draw(false);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', {
                        status: status,
                        error: error,
                        responseText: xhr.responseText,
                        statusCode: xhr.status
                    });
                    
                    var errorMessage = 'No se pudieron cargar los datos. Por favor, intente nuevamente.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    $('#tb_purchases tbody').html('<tr><td colspan="9" class="text-center text-danger">Error: ' + errorMessage + '</td></tr>');
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al cargar datos',
                        text: errorMessage,
                        footer: 'Status: ' + xhr.status + ' - ' + error
                    });
                }
            });
        }
        
        // Formatear fecha
        function formatDate(dateString) {
            var date = new Date(dateString);
            return date.toLocaleDateString('es-ES');
        }
        
        // Formatear moneda
        function formatCurrency(amount) {
            return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(amount);
        }
        
        // Refrescar tabla
        $('#refreshTable').click(function() {
            loadAccountsReceivable();
        });
        
        // Exportar a Excel
        $('#exportExcel').click(function() {
            table.button('.buttons-excel').trigger();
        });
        
        // Test data button
        $('#testData').click(function() {
            $.ajax({
                url: '{{route("admin.accounts_receivable.test")}}',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('Test data:', data);
                    Swal.fire({
                        icon: 'info',
                        title: 'Datos de prueba',
                        html: '<pre style="text-align: left; max-height: 400px; overflow-y: auto;">' + JSON.stringify(data, null, 2) + '</pre>',
                        width: '80%'
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Test error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en test',
                        text: xhr.responseJSON ? xhr.responseJSON.error : error
                    });
                }
            });
        });
        
        // Test simple data button
        $('#testSimple').click(function() {
            $.ajax({
                url: '{{route("admin.accounts_receivable.simple")}}',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('Simple data:', data);
                    
                    // Clear and populate table with simple data
                    table.clear().draw();
                    
                    if (data && data.length > 0) {
                        $.each(data, function(index, account) {
                            table.row.add([
                                account.id,
                                account.date_of_issue,
                                account.date_of_due,
                                account.customers.name,
                                account.sales.invoice_no,
                                '<span class="badge bg-danger">' + account.account_states.name + '</span>',
                                '$' + parseFloat(account.total_amount).toLocaleString(),
                                '$' + parseFloat(account.balance).toLocaleString(),
                                '<button class="btn btn-sm btn-info">Ver</button>'
                            ]).draw(false);
                        });
                        
                        $('#totalCount').text(data.length + ' registros (simple)');
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Datos simples cargados',
                            text: 'Se cargaron ' + data.length + ' registros sin relaciones'
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sin datos',
                            text: 'No se encontraron registros'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Simple test error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en test simple',
                        text: xhr.responseJSON ? xhr.responseJSON.message : error
                    });
                }
            });
        });
        
        // Imprimir PDF
        $(document).on('click', '.print-pdf', function() {
            var accountReceivableId = $(this).data('id');
            
            if (!accountReceivableId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo identificar la cuenta por cobrar'
                });
                return;
            }
            
            var url = "{{ route('admin.accounts_receivable.pdf', ['id' => ':id']) }}".replace(':id', accountReceivableId);
            window.open(url, '_blank');
        });
        
        // Ver detalles de pagos
        $(document).on('click', '.view-details', function() {
            var id = $(this).data('id');
            var invoice_no = $(this).data('invoice');
            var amount = $(this).data('amount');
            var balance = $(this).data('balance');
            var customer = $(this).data('customer');
            
            // Guardar el ID para uso posterior
            $('#detailsModal').data('account-id', id);
            
            // Llenar información básica
            $('#detail-customer').text(customer);
            $('#detail-invoice').text(invoice_no);
            $('#detail-total').text(formatCurrency(amount));
            $('#detail-balance').text(formatCurrency(balance));
            
            // Cargar historial de pagos
            $.ajax({
                url: "{{ route('admin.payment_receivables.history', ['id' => ':id']) }}".replace(':id', id),
                method: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    $('#payments-table tbody').html('<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>Cargando historial...</td></tr>');
                },
                success: function(data) {
                    var tableBody = $('#payments-table tbody');
                    tableBody.empty();
                    
                    if (data.length === 0) {
                        tableBody.html('<tr><td colspan="5" class="text-center">No hay pagos registrados</td></tr>');
                    } else {
                        $.each(data, function(index, payment) {
                            var row = '<tr>' +
                                '<td>' + formatDate(payment.payment_date) + '</td>' +
                                '<td>' + formatCurrency(payment.payment_amount) + '</td>' +
                                '<td>' + (payment.payment_method ? payment.payment_method.name : 'N/A') + '</td>' +
                                '<td>' + (payment.reference || 'N/A') + '</td>' +
                                '<td>' + (payment.user ? payment.user.name : 'N/A') + '</td>' +
                            '</tr>';
                            tableBody.append(row);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener el historial:', error);
                    $('#payments-table tbody').html('<tr><td colspan="5" class="text-center text-danger">Error al cargar el historial</td></tr>');
                }
            });
            
            // Mostrar modal
            $('#detailsModal').modal('show');
        });
        
        // Manejar el clic en el botón de pago
        $(document).on('click', '.payment-btn', function() {
            var id = $(this).data('id');
            var invoice = $(this).data('invoice');
            var amount = $(this).data('amount');
            var balance = $(this).data('balance');
            var customer = $(this).data('customer');
            
            // Llenar el formulario del modal
            $('#account_receivable_id').val(id);
            $('#customer_name').val(customer);
            $('#invoice_number').val(invoice);
            $('#total_amount').val(formatCurrency(amount));
            $('#balance').val(formatCurrency(balance));
            $('#payment_amount').val(balance).attr('max', balance);
            
            // Mostrar el modal
            $('#paymentModal').modal('show');
        });
        
        // Validar monto de pago
        $('#payment_amount').on('input', function() {
            var balanceText = $('#balance').val();
            
            var cleanBalance = balanceText
                .replace(/\$/g, '')
                .replace(/\./g, '')
                .replace(/,/g, '.')
                .trim();
                
            var balance = parseFloat(cleanBalance);
            var payment = parseFloat($(this).val()) || 0;
            
            if (isNaN(balance)) {
                console.error('Invalid balance value:', balanceText, 'Cleaned to:', cleanBalance);
                balance = 0;
            }
            
            if (payment > balance) {
                $(this).addClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
                $(this).after('<div class="invalid-feedback">El monto no puede ser mayor al saldo pendiente</div>');
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });
        
        // Manejar el envío del formulario de pago
        $('#savePayment').click(function() {
            if (!$('#paymentForm')[0].checkValidity()) {
                $('#paymentForm')[0].reportValidity();
                return;
            }
            
            var balanceText = $('#balance').val();
            var cleanBalance = balanceText
                .replace(/\$/g, '')
                .replace(/\./g, '')
                .replace(/,/g, '.')
                .trim();
                
            var balance = parseFloat(cleanBalance);
            var payment = parseFloat($('#payment_amount').val());
            
            if (payment > balance) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El monto de pago no puede ser mayor al saldo pendiente'
                });
                return;
            }
            
            var formData = {
                account_receivable_id: $('#account_receivable_id').val(),
                payment_amount: $('#payment_amount').val(),
                payment_date: $('#payment_date').val(),
                payment_method_id: $('#payment_method_id').val(),
                reference: $('#reference').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            
            $.ajax({
                url: '{{route("admin.payment_receivables.payment")}}',
                method: 'POST',
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    $('#savePayment').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Procesando...');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Pago registrado!',
                            text: response.message,
                            confirmButtonText: 'Aceptar'
                        });
                        
                        $('#paymentModal').modal('hide');
                        $('#paymentForm')[0].reset();
                        loadAccountsReceivable();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Error al procesar el pago'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error de conexión. Por favor, intente nuevamente.'
                    });
                },
                complete: function() {
                    $('#savePayment').prop('disabled', false).html('<i class="fas fa-save me-1"></i>Guardar Pago');
                }
            });
        });
        
        // Imprimir ticket de historial de pagos
        $('#printPaymentHistory').click(function() {
            var accountId = $('#detailsModal').data('account-id');
            if (accountId) {
                var url = "{{ route('admin.accounts_receivable.ticket', ['id' => ':id']) }}".replace(':id', accountId);
                window.open(url, '_blank');
            }
        });
        
        // Imprimir ticket PDF
        $('#printPaymentTicketPDF').click(function() {
            var accountId = $('#detailsModal').data('account-id');
            if (accountId) {
                var url = "{{ route('admin.accounts_receivable.ticket', ['id' => ':id']) }}".replace(':id', accountId);
                window.open(url, '_blank');
            }
        });
        
        // Limpiar modal al cerrarse
        $('#paymentModal').on('hidden.bs.modal', function() {
            $('#paymentForm')[0].reset();
            $('#payment_amount').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        });
        
        // Limpiar modal de detalles al cerrarse
        $('#detailsModal').on('hidden.bs.modal', function() {
            $('#payments-table tbody').empty();
            $(this).removeData('account-id');
        });
    });
</script>
@endsection