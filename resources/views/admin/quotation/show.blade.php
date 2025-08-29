@extends('layouts.app')

@section('style')
<style>
    .quotation-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .quotation-number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    
    .quotation-status {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending { background-color: #ffc107; color: #000; }
    .status-approved { background-color: #28a745; color: #fff; }
    .status-rejected { background-color: #dc3545; color: #fff; }
    .status-sent { background-color: #17a2b8; color: #fff; }
    
    .info-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border-left: 4px solid #667eea;
    }
    
    .info-card h5 {
        color: #333;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    
    .info-card h5 i {
        margin-right: 0.5rem;
        color: #667eea;
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #555;
        min-width: 150px;
    }
    
    .info-value {
        color: #333;
        text-align: right;
        flex: 1;
    }
    
    .items-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .items-table .table {
        margin-bottom: 0;
    }
    
    .items-table .table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .items-table .table td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .items-table .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .totals-section {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        font-size: 1.1rem;
    }
    
    .total-row.grand-total {
        font-size: 1.3rem;
        font-weight: bold;
        color: #667eea;
        border-top: 2px solid #667eea;
        padding-top: 1rem;
        margin-top: 1rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }
    
    .action-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .action-btn i {
        margin-right: 0.5rem;
    }
    
    .btn-primary { background: #667eea; color: white; }
    .btn-primary:hover { background: #5a6fd8; transform: translateY(-2px); }
    
    .btn-success { background: #28a745; color: white; }
    .btn-success:hover { background: #218838; transform: translateY(-2px); }
    
    .btn-info { background: #17a2b8; color: white; }
    .btn-info:hover { background: #138496; transform: translateY(-2px); }
    
    .btn-warning { background: #ffc107; color: #000; }
    .btn-warning:hover { background: #e0a800; transform: translateY(-2px); }
    
    .btn-danger { background: #dc3545; color: white; }
    .btn-danger:hover { background: #c82333; transform: translateY(-2px); }
    
    .notes-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .notes-section h5 {
        color: #333;
        margin-bottom: 1rem;
    }
    
    .notes-content {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }
    
    @media (max-width: 768px) {
        .quotation-header {
            padding: 1rem;
        }
        
        .quotation-number {
            font-size: 1.5rem;
        }
        
        .info-row {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .info-value {
            text-align: left;
            margin-top: 0.25rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">
                        <i class="fas fa-file-invoice me-2"></i>Detalle de Cotización
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.quotation.list') }}">Cotizaciones</a></li>
                        <li class="breadcrumb-item active">Detalle</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content-body">
        <div class="container-fluid">
            <!-- Header de la Cotización -->
            <div class="quotation-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="quotation-number">{{ $quotation->number }}</div>
                        <p class="mb-0">
                            <i class="fas fa-calendar me-2"></i>
                            Fecha de emisión: {{ \Carbon\Carbon::parse($quotation->date_of_issue)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="quotation-status status-{{ strtolower($quotation->statusQuotation->name ?? 'pending') }}">
                            {{ $quotation->statusQuotation->name ?? 'Pendiente' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Información del Cliente -->
                <div class="col-md-6">
                    <div class="info-card">
                        <h5><i class="fas fa-user"></i>Información del Cliente</h5>
                        <div class="info-row">
                            <span class="info-label">Cliente:</span>
                            <span class="info-value">{{ $quotation->customer->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Documento:</span>
                            <span class="info-value">{{ $quotation->customer->identification_number ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Teléfono:</span>
                            <span class="info-value">{{ $quotation->customer->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $quotation->customer->email ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dirección:</span>
                            <span class="info-value">{{ $quotation->customer->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Información de la Cotización -->
                <div class="col-md-6">
                    <div class="info-card">
                        <h5><i class="fas fa-info-circle"></i>Información de la Cotización</h5>
                        <div class="info-row">
                            <span class="info-label">Bodega:</span>
                            <span class="info-value">{{ $quotation->warehouse->warehouse_name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Moneda:</span>
                            <span class="info-value">{{ $quotation->currency->currency_name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Forma de Pago:</span>
                            <span class="info-value">{{ $quotation->paymentForm->payment_type ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Método de Pago:</span>
                            <span class="info-value">{{ $quotation->payment_method->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Válida hasta:</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($quotation->date_of_expiration)->format('d/m/Y') ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Creada por:</span>
                            <span class="info-value">{{ $quotation->user->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Items -->
            <div class="items-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Precio Unit.</th>
                            <th>Descuento</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotation->quotation_items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $item->item->product_name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $item->item->barcode ?? 'Sin código' }}</small>
                            </td>
                            <td>{{ $item->item->description ?? 'Sin descripción' }}</td>
                            <td>{{ number_format($item->quantity, 2) }}</td>
                            <td>{{ $item->item->measure->measure_name ?? 'N/A' }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ number_format($item->discount, 2) }}</td>
                            <td><strong>{{ number_format($item->subtotal, 2) }}</strong></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay items en esta cotización</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Totales -->
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <div class="totals-section">
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>{{ number_format($quotation->subtotal, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span>Descuento:</span>
                            <span>{{ number_format($quotation->total_discount, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span>Impuestos:</span>
                            <span>{{ number_format($quotation->total_tax, 2) }}</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>TOTAL:</span>
                            <span>{{ number_format($quotation->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notas -->
            @if($quotation->notes)
            <div class="notes-section">
                <h5><i class="fas fa-sticky-note me-2"></i>Notas y Observaciones</h5>
                <div class="notes-content">
                    {{ $quotation->notes }}
                </div>
            </div>
            @endif

            <!-- Botones de Acción -->
            <div class="action-buttons">
                <a href="{{ route('admin.quotation.list') }}" class="action-btn btn-warning">
                    <i class="fas fa-arrow-left"></i>Volver a la Lista
                </a>
                
                <a href="{{ route('admin.quotation.pdf', $quotation->id) }}" 
                   target="_blank" class="action-btn btn-info">
                    <i class="fas fa-file-pdf"></i>Descargar PDF
                </a>
                
                @if($quotation->customer->email)
                <button type="button" class="action-btn btn-success" 
                        onclick="sendEmail({{ $quotation->id }})">
                    <i class="fas fa-envelope"></i>Enviar por Email
                </button>
                @endif
                
                @if($quotation->status_quotation_id == 7) {{-- Asumiendo que 7 es el ID de es "Pendiente" --}}
                <button type="button" class="action-btn btn-primary" 
                        onclick="approveQuotation({{ $quotation->id }})">
                    <i class="fas fa-check"></i>Aprobar Cotización
                </button>
                @endif
                
                <button type="button" class="action-btn btn-danger" 
                        onclick="deleteQuotation({{ $quotation->id }})">
                    <i class="fas fa-trash"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script type="text/javascript">
    function sendEmail(quotationId) {
        Swal.fire({
            title: 'Enviar Cotización',
            text: '¿Desea enviar la cotización por email al cliente?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, Enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar formulario para editar destinatario, asunto y mensaje
                Swal.fire({
                    title: 'Datos de envío',
                    html: `
                        <div class='mb-3'>
                            <label for='emailTo' class='form-label'>Destinatario</label>
                            <input type='email' class='form-control' id='emailTo' value='{{ $quotation->customer->email ?? '' }}'>
                        </div>
                        <div class='mb-3'>
                            <label for='emailSubject' class='form-label'>Asunto</label>
                            <input type='text' class='form-control' id='emailSubject' value='Cotización {{ $quotation->number }}'>
                        </div>
                        <div class='mb-3'>
                            <label for='emailMessage' class='form-label'>Mensaje</label>
                            <textarea class='form-control' id='emailMessage' rows='3'>Adjunto encontrará la cotización {{ $quotation->number }}.</textarea>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Enviar',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        return {
                            to: document.getElementById('emailTo').value,
                            subject: document.getElementById('emailSubject').value,
                            message: document.getElementById('emailMessage').value
                        }
                    }
                }).then((formResult) => {
                    if (formResult.isConfirmed) {
                        Swal.fire({
                            title: 'Enviando email...',
                            text: 'Por favor espere mientras se envía el email',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                        // Enviar AJAX para enviar el email
                        $.ajax({
                            url: "{{ url('admin/quotation/send-email') }}",
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                quotation_id: quotationId,
                                email_to: formResult.value.to,
                                subject: formResult.value.subject,
                                message: formResult.value.message
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Enviado!',
                                        text: 'La cotización ha sido enviada por email correctamente.',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message || 'Ocurrió un error al enviar el email.'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al enviar el email: ' + error
                                });
                            }
                        });
                    }
                });
            }
        });
    }

    function approveQuotation(quotationId) {
        Swal.fire({
            title: 'Aprobar Cotización',
            text: '¿Está seguro de que desea aprobar esta cotización?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, Aprobar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí puedes implementar la lógica para aprobar la cotización
                $.ajax({
                    url: "{{ url('admin/quotation/approve') }}/" + quotationId,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        quotation_id: quotationId
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('¡Aprobada!', 'La cotización ha sido aprobada.', 'success');
                        } else {
                            Swal.fire('Error', response.message || 'Ocurrió un error al aprobar la cotización.', 'error');
                        }
                    }
                });
            }
        });
    }

    function deleteQuotation(quotationId) {
        Swal.fire({
            title: 'Eliminar Cotización',
            text: '¿Está seguro de que desea eliminar esta cotización? Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí puedes implementar la lógica para eliminar la cotización
                $.ajax({
                    url: "{{ url('admin/quotation/destroy') }}/" + quotationId,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        quotation_id: quotationId
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('¡Eliminada!', 'La cotización ha sido eliminada.', 'success');
                        } else {
                            Swal.fire('Error', response.message || 'Ocurrió un error al eliminar la cotización.', 'error');
                        }
                    }
            
            });
        }
        });
    }
</script>
@endsection
