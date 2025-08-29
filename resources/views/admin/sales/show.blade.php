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
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0">
                                        <i class="fas fa-file-invoice me-2"></i>Factura #{{ $sale->invoice_no ?? ($sale->series.'-'.$sale->number) }}
                                    </h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="btn-group">
                                        <a href="{{ url('admin/sales/list') }}" class="btn btn-sm btn-light">
                                            <i class="fas fa-arrow-left me-1"></i>Volver
                                        </a>
                                        <button type="button" class="btn btn-sm btn-success print-pdf" data-sale-id="{{ $sale->id }}">
                                            <i class="fas fa-print me-1"></i>Imprimir
                                        </button>
                                        <a href="{{ url('admin/sales/edit/'.$sale->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit me-1"></i>Editar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-building me-2"></i>Información de la Empresa</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex mb-3">
                                                @if($company->logo)
                                                <div class="me-3">
                                                    <img src="{{ asset('uploads/company/'.$company->logo) }}" alt="Logo" style="max-height: 60px;">
                                                </div>
                                                @endif
                                                <div>
                                                    <h5 class="mb-1">{{ $company->name }}</h5>
                                                    <p class="mb-0 text-muted">NIT: {{ $company->identification_number }}</p>
                                                </div>
                                            </div>
                                            <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i>{{ $company->address }}</p>
                                            <p class="mb-1"><i class="fas fa-phone me-2 text-secondary"></i>{{ $company->phone }}</p>
                                            <p class="mb-0"><i class="fas fa-envelope me-2 text-secondary"></i>{{ $company->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-user me-2"></i>Información del Cliente</h6>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="mb-1">{{ $sale->customers->name }}</h5>
                                            <p class="mb-1"><strong>Identificación:</strong> {{ $sale->customers->identification_number }}</p>
                                            <p class="mb-1"><strong>Dirección:</strong> {{ $sale->customers->address }}</p>
                                            <p class="mb-1"><strong>Teléfono:</strong> {{ $sale->customers->phone }}</p>
                                            <p class="mb-0"><strong>Email:</strong> {{ $sale->customers->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Detalles de la Factura</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Fecha de Emisión</p>
                                                    <p class="mb-0 fw-bold">{{ $issueDate }}</p>
                                                </div>
                                                @if($dueDate)
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Fecha de Vencimiento</p>
                                                    <p class="mb-0 fw-bold">{{ $dueDate }}</p>
                                                </div>
                                                @endif
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Forma de Pago</p>
                                                    <p class="mb-0 fw-bold">{{ $sale->payment_form->payment_type ?? 'N/A' }}</p>
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
                                                            case 1: $statusClass = 'bg-secondary'; break;
                                                            case 2: $statusClass = 'bg-info'; break;
                                                            case 3: $statusClass = 'bg-success'; break;
                                                            case 4: $statusClass = 'bg-warning'; break;
                                                            case 5: $statusClass = 'bg-danger'; break;
                                                            case 6: $statusClass = 'bg-dark'; break;
                                                            case 7: $statusClass = 'bg-light text-dark'; break;
                                                            default: $statusClass = 'bg-secondary';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $statusClass }} px-3 py-2">
                                                        {{ $sale->state_types->description ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <p class="mb-1 text-muted">Registrado por</p>
                                                    <p class="mb-0 fw-bold">{{ $sale->user->name ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card">
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
                                                            <th>Unidad</th>
                                                            <th class="text-end">Cantidad</th>
                                                            <th class="text-end">Precio Unitario</th>
                                                            <th class="text-end">Descuento</th>
                                                            <th class="text-end">Subtotal</th>
                                                            <th class="text-end">IVA</th>
                                                            <th class="text-end">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($sale->sale_details as $index => $detail)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    @if($detail->products && $detail->products->image)
                                                                    <img src="{{ asset('uploads/products/'.$detail->products->image) }}" 
                                                                         alt="Producto" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                                    @endif
                                                                    <div>
                                                                        <p class="mb-0 fw-bold">{{ $detail->products->name ?? 'N/A' }}</p>
                                                                        <small class="text-muted">{{ $detail->products->code ?? 'N/A' }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $detail->unit_types->name ?? 'N/A' }}</td>
                                                            <td class="text-end">{{ number_format($detail->quantity, 2, ',', '.') }}</td>
                                                            <td class="text-end">{{ number_format($detail->unit_price, 2, ',', '.') }}</td>
                                                            <td class="text-end">{{ number_format($detail->discount, 2, ',', '.') }}</td>
                                                            <td class="text-end">{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                                                            <td class="text-end">{{ number_format($detail->tax_amount, 2, ',', '.') }}</td>
                                                            <td class="text-end">{{ number_format($detail->total, 2, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <td colspan="6" class="text-end fw-bold">Totales:</td>
                                                            <td class="text-end fw-bold">{{ number_format($sale->total_subtotal, 2, ',', '.') }}</td>
                                                            <td class="text-end fw-bold">{{ number_format($sale->total_tax, 2, ',', '.') }}</td>
                                                            <td class="text-end fw-bold">{{ number_format($sale->total_sale, 2, ',', '.') }}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if(count($payments) > 0)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Historial de Pagos</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover mb-0">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Método de Pago</th>
                                                            <th>Referencia</th>
                                                            <th>Registrado por</th>
                                                            <th class="text-end">Monto</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($payments as $payment)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                                            <td>{{ $payment->payment_method->name ?? 'N/A' }}</td>
                                                            <td>{{ $payment->reference ?? 'N/A' }}</td>
                                                            <td>{{ $payment->user->name ?? 'N/A' }}</td>
                                                            <td class="text-end">{{ number_format($payment->payment_amount, 2, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <td colspan="4" class="text-end fw-bold">Total Pagado:</td>
                                                            <td class="text-end fw-bold">
                                                                {{ number_format($payments->sum('payment_amount'), 2, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-end fw-bold">Saldo Pendiente:</td>
                                                            <td class="text-end fw-bold">
                                                                {{ number_format($sale->total_sale - $payments->sum('payment_amount'), 2, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($sale->notes)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notas</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $sale->notes }}</p>
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
                                        <i class="fas fa-clock me-1"></i>Creado: {{ $sale->created_at->format('d/m/Y H:i:s') }}
                                    </small>
                                </div>
                                <div class="col-md-6 text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>Actualizado: {{ $sale->updated_at->format('d/m/Y H:i:s') }}
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
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Manejar impresión de PDF
        $(document).on('click', '.print-pdf', function() {
            var saleId = $(this).data('sale-id');
            
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
    });
</script>
@endsection