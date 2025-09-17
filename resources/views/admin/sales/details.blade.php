@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detalle de Factura</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/sales')}}">Facturas de Ventas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Detalle de Factura #{{ $sale->invoice_no ?? ($sale->series.'-'.$sale->number) }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="app-content-body">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-invoice me-2"></i>Factura #{{ $sale->invoice_no ?? ($sale->series.'-'.$sale->number) }}
                                    </h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.sales.list') }}" class="btn btn-sm btn-light">
                                            <i class="fas fa-arrow-left me-1"></i>Volver
                                        </a>
                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-building me-2"></i>Información de la Empresa</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex mb-3">
                                                @if($sale->company && $sale->company->logo)
                                                <div class="me-3">
                                                    <img src="{{ asset($sale->company->logo) }}" alt="{{ $sale->company->name }}" 
                                                 class="brand-image opacity-75 shadow"> 
                                                </div>
                                                @endif
                                                <div>
                                                    <h5 class="mb-1">{{ $sale->company->company_name ?? 'N/A' }}</h5>
                                                    <p class="mb-0 text-muted">NIT: {{ $sale->company->identification_number ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>{{ $sale->company->address ?? 'N/A' }}</p>
                                            <p class="mb-1"><i class="fas fa-phone me-2 text-secondary"></i>{{ $sale->company->phone ?? 'N/A' }}</p>
                                            <p class="mb-0"><i class="fas fa-envelope me-2 text-secondary"></i>{{ $sale->company->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-user me-2"></i>Información del Cliente</h6>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="mb-1">{{ $sale->customers->name ?? 'N/A' }}</h5>
                                            <p class="mb-1"><strong>Identificación:</strong> {{ $sale->customers->identification_number ?? 'N/A' }}</p>
                                            <p class="mb-1"><strong>Dirección:</strong> {{ $sale->customers->address ?? 'N/A' }}</p>
                                            <p class="mb-1"><strong>Teléfono:</strong> {{ $sale->customers->phone ?? 'N/A' }}</p>
                                            <p class="mb-0"><strong>Email:</strong> {{ $sale->customers->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detalles de la Factura</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Fecha de Emisión</p>
                                                    <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($sale->date_of_issue)->format('d/m/Y') }}</p>
                                                </div>
                                                @if($sale->date_of_due)
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Fecha de Vencimiento</p>
                                                    <p class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($sale->date_of_due)->format('d/m/Y') }}</p>
                                                </div>
                                                @endif
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Forma de Pago</p>
                                                    <p class="mb-0 fw-bold">{{ $sale->paymentTypes->payment_type ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Método de Pago</p>
                                                    <p class="mb-0 fw-bold">{{ $sale->payment_method->name ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Estado</p>
                                                    @php
                                                        $statusClass = '';
                                                        switch(intval($sale->state_type_id)) {
                                                            case 1: $statusClass = 'bg-secondary'; break; // Borrador
                                                            case 2: $statusClass = 'bg-info'; break;      // Pendiente
                                                            case 3: $statusClass = 'bg-danger'; break;    // Anulada
                                                            case 4: $statusClass = 'bg-success'; break;   // Pagada
                                                            case 5: $statusClass = 'bg-warning'; break;   // Parcial
                                                            default: $statusClass = 'bg-secondary';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $statusClass }} px-3 py-2">
                                                        {{ $sale->stateTypes->description ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Registrado por</p>
                                                    <p class="mb-0 fw-bold">{{ $sale->users->name ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Almacén</p>
                                                    <p class="mb-0 fw-bold">{{ $sale->warehouses->warehouse_name ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Moneda</p>
                                                    <p class="mb-0 fw-bold">{{ $sale->currencies->currency_name ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Productos</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover mb-0">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Producto</th>
                                                            <th class="text-end">Cantidad</th>
                                                            <th class="text-end">Precio Unitario</th>
                                                            <th class="text-end">Descuento</th>
                                                            <th class="text-end">Subtotal</th>
                                                            <th class="text-end">IVA %</th>
                                                            <th class="text-end">IVA</th>
                                                            <th class="text-end">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($sale->invoiceItems && $sale->invoiceItems->count() > 0)
                                                            @foreach($sale->invoiceItems as $index => $detail)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        @if($detail->item && $detail->item->image)
                                                                        <img src="{{ asset('uploads/products/'.$detail->item->image) }}" 
                                                                             alt="Producto" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                                        @endif
                                                                        <div>
                                                                            <p class="mb-0 fw-bold">{{ $detail->item->product_name ?? 'N/A' }}</p>
                                                                            <small class="text-muted">{{ $detail->item->internal_code ?? $detail->item->barcode ?? 'N/A' }}</small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">{{ number_format($detail->quantity ?? 0, 2, ',', '.') }}</td>
                                                                <td class="text-end">{{ number_format($detail->unit_price ?? 0, 2, ',', '.') }}</td>
                                                                <td class="text-end">{{ number_format($detail->discount ?? 0, 2, ',', '.') }}</td>
                                                            <td class="text-end">{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                                                            <td class="text-end">{{ $detail->item->tax->rate ?? 0 }}%</td>
                                                            <td class="text-end">{{ number_format($detail->tax_amount, 2, ',', '.') }}</td>
                                                            <td class="text-end">{{ number_format($detail->total ?? 0, 2, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="9" class="text-center text-muted py-4">
                                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                                No hay productos registrados en esta factura
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <td colspan="6" class="text-end fw-bold">Subtotal:</td>
                                                            <td></td>
                                                            <td class="text-end fw-bold">{{ number_format($sale->total_tax, 2, ',', '.') }}</td>
                                                            <td class="text-end fw-bold">{{ number_format($sale->total_sale, 2, ',', '.') }}</td>
                                                        </tr>
                                                        @if($sale->total_discount > 0)
                                                        <tr>
                                                            <td colspan="7" class="text-end fw-bold">Descuento Total:</td>
                                                            <td class="text-end fw-bold">{{ number_format($sale->total_discount, 2, ',', '.') }}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td colspan="7" class="text-end fw-bold">Total Factura:</td>
                                                            <td class="text-end fw-bold">{{ number_format($sale->total_sale, 2, ',', '.') }}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($accountsReceivable)
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Estado de Cuenta</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <p class="mb-1 text-muted">Total Factura</p>
                                                    <p class="mb-0 fw-bold">{{ number_format($accountsReceivable->total_amount, 2, ',', '.') }}</p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p class="mb-1 text-muted">Saldo Pendiente</p>
                                                    <p class="mb-0 fw-bold">{{ number_format($accountsReceivable->balance, 2, ',', '.') }}</p>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <p class="mb-1 text-muted">Estado de Pago</p>
                                                    @php
                                                        $paymentStatus = '';
                                                        $paymentStatusClass = '';
                                                        
                                                        if($accountsReceivable->balance <= 0) {
                                                            $paymentStatus = 'PAGADO';
                                                            $paymentStatusClass = 'bg-success';
                                                        } elseif($accountsReceivable->balance < $accountsReceivable->total_amount) {
                                                            $paymentStatus = 'PAGO PARCIAL';
                                                            $paymentStatusClass = 'bg-info';
                                                        } elseif(strtotime($accountsReceivable->date_of_due) < strtotime('today')) {
                                                            $paymentStatus = 'VENCIDO';
                                                            $paymentStatusClass = 'bg-danger';
                                                        } else {
                                                            $paymentStatus = 'PENDIENTE';
                                                            $paymentStatusClass = 'bg-warning';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $paymentStatusClass }} px-3 py-2">{{ $paymentStatus }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3">
                                                <a href="{{ route('admin.accounts_receivable.list') }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-list me-1"></i>Ver en Cuentas por Cobrar
                                                </a>
                                                @if($accountsReceivable->balance > 0)
                                                <button type="button" class="btn btn-sm btn-success register-payment" 
                                                        data-id="{{ $accountsReceivable->id }}"
                                                        data-balance="{{ $accountsReceivable->balance }}">
                                                    <i class="fas fa-money-bill-wave me-1"></i>Registrar Pago
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($sale->observations)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Observaciones</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $sale->observations }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>Creado: {{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i:s') }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>Actualizado: {{ \Carbon\Carbon::parse($sale->updated_at)->format('d/m/Y H:i:s') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal para registrar pago (si es necesario) -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="paymentModalLabel"><i class="fas fa-money-bill-wave me-2"></i>Registrar Pago</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="paymentForm" action="{{ route('admin.payment_receivables.payment') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="account_receivable_id" id="account_receivable_id">
                    
                    <div class="mb-3">
                        <label for="payment_amount" class="form-label">Monto a Pagar</label>
                        <input type="number" class="form-control" id="payment_amount" name="payment_amount" step="0.01" required>
                        <div class="form-text">Saldo pendiente: <span id="pending_balance"></span></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Fecha de Pago</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_method_id" class="form-label">Método de Pago</label>
                        <select class="form-select" id="payment_method_id" name="payment_method_id" required>
                            @foreach(\App\Models\PaymentMethodModel::where('is_delete', 0)->get() as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reference" class="form-label">Referencia (opcional)</label>
                        <input type="text" class="form-control" id="reference" name="reference">
                        <div class="form-text">Número de transacción, cheque, etc.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Pago</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Manejar impresión de PDF
        $(document).on('click', '.print-pdf', function() {
            var saleId = $(this).data('id');
            
            if (!saleId) {
                console.error('ID de la venta no encontrado');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo identificar la venta'
                });
                return;
            }
            
            // Usar la ruta correcta para generar el PDF
            var url = "{{ route('admin.sales.pdf', ['id' => ':id']) }}".replace(':id', saleId);
            window.open(url, '_blank');
        });
        
        // Manejar registro de pago
        $(document).on('click', '.register-payment', function() {
            var accountReceivableId = $(this).data('id');
            var balance = $(this).data('balance');
            
            $('#account_receivable_id').val(accountReceivableId);
            $('#payment_amount').val(balance).attr('max', balance);
            $('#pending_balance').text(new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(balance));
            
            $('#paymentModal').modal('show');
        });
        
        // Validar monto de pago
        $('#payment_amount').on('input', function() {
            var balance = parseFloat($(this).attr('max'));
            var payment = parseFloat($(this).val()) || 0;
            
            if (payment > balance) {
                $(this).addClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
                $(this).after('<div class="invalid-feedback">El monto no puede ser mayor al saldo pendiente</div>');
            } else {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            }
        });
    });
</script>
@endsection