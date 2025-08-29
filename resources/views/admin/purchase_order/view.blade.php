@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detalle de Orden de Compra</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/purchase_order/list')}}">Órdenes de Compra</a></li>
                        <li class="breadcrumb-item active">Detalle de Orden</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="app-content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Orden de Compra: {{ $purchaseOrder->prefix }}</h5>
                            {{-- <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cog"></i> Acciones
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" id="printOrder"><i class="fas fa-print"></i> Imprimir</a></li>
                                    <li><a class="dropdown-item" href="#" id="exportPdf"><i class="fas fa-file-pdf"></i> Exportar PDF</a></li>
                                    <li><a class="dropdown-item send-email-btn" href="#" id="sendEmail" data-id="{{ $purchaseOrder->id }}"><i class="fas fa-envelope"></i> Enviar por Email</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" id="editOrder"><i class="fas fa-edit"></i> Editar</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" id="cancelOrder"><i class="fas fa-times-circle"></i> Cancelar Orden</a></li>
                                </ul>
                            </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title mb-0"><i class="fas fa-building"></i> Información del Proveedor</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-1"><strong>Proveedor:</strong> {{ $purchaseOrder->suppliers->name }}</p>
                                            <p class="mb-1"><strong>NIT/Documento:</strong> {{ $purchaseOrder->suppliers->identification_number }}</p>
                                            <p class="mb-1"><strong>Teléfono:</strong> {{ $purchaseOrder->suppliers->phone }}</p>
                                            <p class="mb-1"><strong>Email:</strong> {{ $purchaseOrder->suppliers->email }}</p>
                                            <p class="mb-0"><strong>Dirección:</strong> {{ $purchaseOrder->suppliers->address }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title mb-0"><i class="fas fa-info-circle"></i> Información de la Orden</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Número de Orden:</strong> {{ $purchaseOrder->prefix }}</p>
                                                    <p class="mb-1"><strong>Fecha de Orden:</strong> {{ date('d/m/Y', strtotime($purchaseOrder->order_date)) }}</p>
                                                    <p class="mb-1"><strong>Fecha Esperada:</strong> {{ $purchaseOrder->expected_date ? date('d/m/Y', strtotime($purchaseOrder->expected_date)) : 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Estado:</strong> 
                                                        <span class="">
                                                            {{ $purchaseOrder->status_order->name }}
                                                        </span>
                                                    </p>
                                                    <p class="mb-1"><strong>Bodega:</strong> {{ $purchaseOrder->warehouses->warehouse_name }}</p>
                                                    <p class="mb-1"><strong>Creado por:</strong> {{ $purchaseOrder->users->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($purchaseOrder->notes)
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title mb-0"><i class="fas fa-sticky-note"></i> Notas</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $purchaseOrder->notes }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title mb-0"><i class="fas fa-shopping-cart"></i> Productos</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Producto</th>
                                                            <th>Unidad</th>
                                                            <th class="text-center">Cantidad</th>
                                                            <th class="text-end">Precio Unitario</th>
                                                            <th class="text-center">Impuesto</th>
                                                            <th class="text-end">Subtotal</th>
                                                            <th class="text-end">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($purchaseOrder->purchase_order_items as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->items->product_name }}</td>
                                                            <td>{{ $item->items->measure->measure_name }}</td>
                                                            <td class="text-center">{{ number_format($item->quantity, 0) }}</td>
                                                            <td class="text-end">{{ number_format($item->price, 0, ',', '.') }}</td>
                                                            <td class="text-center">{{ $item->tax_rate }}%</td>
                                                            <td class="text-end">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                                            <td class="text-end">{{ number_format($item->total, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6" class="text-end"><strong>Subtotal:</strong></td>
                                                            <td colspan="2" class="text-end">{{ number_format($purchaseOrder->subtotal, 0, ',', '.') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" class="text-end"><strong>Impuestos:</strong></td>
                                                            <td colspan="2" class="text-end">{{ number_format($purchaseOrder->tax_amount, 0, ',', '.') }}</td>
                                                        </tr>
                                                        <tr class="table-primary">
                                                            <td colspan="6" class="text-end"><strong>Total:</strong></td>
                                                            <td colspan="2" class="text-end"><strong>{{ number_format($purchaseOrder->total, 0, ',', '.') }}</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="card-title mb-0"><i class="fas fa-history"></i> Historial de la Orden</h6>
                                        </div>
                                        <div class="card-body">
                                            <ul class="timeline">
                                                <li class="timeline-item">
                                                    <span class="timeline-point timeline-point-primary">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </span>
                                                    <div class="timeline-event">
                                                        <div class="timeline-heading">
                                                            <h6 class="mb-0">Orden Creada</h6>
                                                        </div>
                                                        <div class="timeline-body">
                                                            <p class="mb-0">Orden creada por {{ $purchaseOrder->users->name }}</p>
                                                        </div>
                                                        <div class="timeline-footer">
                                                            <small class="text-muted">{{ date('d/m/Y H:i', strtotime($purchaseOrder->created_at)) }}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                <!-- Aquí se pueden agregar más eventos del historial -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url('admin/purchase_order/list')}}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            @if($purchaseOrder->status_order->id == 1) <!-- Asumiendo que 1 es el estado "Pendiente" -->
                            <button type="button" class="btn btn-success" id="approveOrder">
                                <i class="fas fa-check-circle"></i> Aprobar Orden
                            </button>
                            @endif
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
        // Imprimir orden
        $('#printOrder').click(function(e) {
            e.preventDefault();
            window.print();
        });
        
        // Exportar a PDF
        $('#exportPdf').click(function(e) {
            e.preventDefault();
            window.location.href = "{{ route('admin.purchase_order.export.pdf', ['id' => $purchaseOrder->id]) }}";
        });
        
        // Enviar por email - Remove this duplicate handler
        // $('#sendEmail').click(function(e) {
        //     console.log('Send email button clicked'); // Debug log
        //     e.preventDefault();
        //     
        //     // Ensure jQuery and SweetAlert2 are loaded
        //     if (typeof $ === 'undefined' || typeof Swal === 'undefined') {
        //         console.error('jQuery or SweetAlert2 not loaded');
        //         alert('Error: Required libraries not loaded');
        //         return;
        //     }
        //     
        //     Swal.fire({
        //         title: 'Enviar por Email',
        //         html: `
        //             <div class="mb-3">
        //                 <label for="emailTo" class="form-label">Destinatario</label>
        //                 <input type="email" class="form-control" id="emailTo" value="{{ $purchaseOrder->suppliers->email }}">
        //             </div>
        //             <div class="mb-3">
        //                 <label for="emailSubject" class="form-label">Asunto</label>
        //                 <input type="text" class="form-control" id="emailSubject" value="Orden de Compra {{ $purchaseOrder->prefix }}">
        //             </div>
        //             <div class="mb-3">
        //                 <label for="emailMessage" class="form-label">Mensaje</label>
        //                 <textarea class="form-control" id="emailMessage" rows="3">Adjunto encontrará la orden de compra {{ $purchaseOrder->prefix }}.</textarea>
        //             </div>
        //         `,
        //         showCancelButton: true,
        //         confirmButtonText: 'Enviar',
        //         cancelButtonText: 'Cancelar',
        //         preConfirm: () => {
        //             return {
        //                 to: document.getElementById('emailTo').value,
        //                 subject: document.getElementById('emailSubject').value,
        //                 message: document.getElementById('emailMessage').value
        //             }
        //         }
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             // Mostrar indicador de carga
        //             Swal.fire({
        //                 title: 'Enviando email...',
        //                 text: 'Por favor espere mientras se envía el email',
        //                 allowOutsideClick: false,
        //                 didOpen: () => {
        //                     Swal.showLoading();
        //                 }
        //             });
        //             
        //             // Enviar solicitud AJAX para enviar el email
        //             $.ajax({
        //                 url: "{{ url('admin/purchase_order/send-email') }}",
        //                 method: 'POST',
        //                 data: {
        //                     _token: "{{ csrf_token() }}",
        //                     purchase_order_id: {{ $purchaseOrder->id }},
        //                     email_to: result.value.to,
        //                     subject: result.value.subject,
        //                     message: result.value.message
        //                 },
        //                 success: function(response) {
        //                     console.log('Email sent response:', response); // Debug log
        //                     if (response.success) {
        //                         Swal.fire({
        //                             icon: 'success',
        //                             title: '¡Enviado!',
        //                             text: 'La orden de compra ha sido enviada por email correctamente.',
        //                             timer: 2000,
        //                             showConfirmButton: false
        //                         });
        //                     } else {
        //                         Swal.fire({
        //                             icon: 'error',
        //                             title: 'Error',
        //                             text: response.message || 'Ocurrió un error al enviar el email.'
        //                         });
        //                     }
        //                 },
        //                 error: function(xhr, status, error) {
        //                     console.error('Error al enviar email:', error);
        //                     console.error('Response:', xhr.responseText); // Debug log
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Error',
        //                         text: 'Ocurrió un error al enviar el email: ' + error
        //                     });
        //                 }
        //             });
        //         }
        //     });
        
        // Editar orden
        $('#editOrder').click(function(e) {
            e.preventDefault();
            window.location.href = "{{ route('admin.purchase_order.edit', ['id' => $purchaseOrder->id]) }}";
        });
        
        // Cancelar orden
        $('#cancelOrder').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción cancelará la orden de compra. No podrá revertir esto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, cancelar orden',
                cancelButtonText: 'No, mantener'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí iría la lógica para cancelar la orden
                    $.ajax({
                        url: "{{ route('admin.purchase_order.update_status', ['id' => $purchaseOrder->id]) }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: 'cancelled'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    '¡Cancelada!',
                                    'La orden de compra ha sido cancelada.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error',
                                'Ocurrió un error al cancelar la orden.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        
        // Aprobar orden
        $('#approveOrder').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Aprobar Orden',
                text: "¿Está seguro de aprobar esta orden de compra?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, aprobar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.purchase_order.update_status', ['id' => $purchaseOrder->id]) }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: 'approved'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    '¡Aprobada!',
                                    'La orden de compra ha sido aprobada.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error',
                                'Ocurrió un error al aprobar la orden.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
        
        // Recibir orden (si está aprobada)
        @if($purchaseOrder->status_order->id == 2) // Asumiendo que 2 es el estado "Aprobada"
        $('#receiveOrder').click(function(e) {
            e.preventDefault();
            window.location.href = "{{ route('admin.purchase_order.receive', ['id' => $purchaseOrder->id]) }}";
        });
        @endif
        
        // Estilo para la línea de tiempo
        $('.timeline').css({
            'border-left': '2px solid #dee2e6',
            'padding-left': '1.5rem',
            'list-style': 'none'
        });
        
        $('.timeline-item').css({
            'position': 'relative',
            'margin-bottom': '1.5rem'
        });
        
        $('.timeline-point').css({
            'position': 'absolute',
            'left': '-1.75rem',
            'top': '0.25rem',
            'width': '1rem',
            'height': '1rem',
            'border-radius': '50%',
            'display': 'flex',
            'align-items': 'center',
            'justify-content': 'center',
            'background-color': '#fff'
        });
        
        $('.timeline-point-primary').css({
            'color': '#0d6efd',
            'border': '2px solid #0d6efd'
        });
        
        $('.timeline-event').css({
            'position': 'relative',
            'padding-bottom': '1rem'
        });
    });
    // Improved email sending functionality
    $(document).on('click', '#sendEmail, .send-email-btn', function(e) {
        e.preventDefault();
        var purchaseId = $(this).data('id') || {{ $purchaseOrder->id }};
        console.log('Send email for purchase ID:', purchaseId);
        
        // Show email form directly without additional AJAX call
        Swal.fire({
            title: 'Enviar Orden de Compra por Email',
            html: `
                <div class="mb-3">
                    <label for="emailTo" class="form-label">Destinatario</label>
                    <input type="email" class="form-control" id="emailTo" value="{{ $purchaseOrder->suppliers->email }}">
                </div>
                <div class="mb-3">
                    <label for="emailSubject" class="form-label">Asunto</label>
                    <input type="text" class="form-control" id="emailSubject" value="Orden de Compra {{ $purchaseOrder->prefix }}">
                </div>
                <div class="mb-3">
                    <label for="emailMessage" class="form-label">Mensaje</label>
                    <textarea class="form-control" id="emailMessage" rows="3">Adjunto encontrará la orden de compra {{ $purchaseOrder->prefix }}.</textarea>
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
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading indicator
                Swal.fire({
                    title: 'Enviando email...',
                    text: 'Por favor espere mientras se envía el email',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Send AJAX request to send the email
                $.ajax({
                    url: "{{ url('admin/purchase_order/send-email') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        purchase_order_id: purchaseId,
                        email_to: result.value.to,
                        subject: result.value.subject,
                        message: result.value.message
                    },
                    success: function(response) {
                        console.log('Email response:', response);
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Enviado!',
                                text: 'La orden de compra ha sido enviada por email correctamente.',
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
                        console.error('Error al enviar email:', error);
                        console.error('Response text:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al enviar el email: ' + error
                        });
                    }
                });
            }
        });
    });
</script>

<style>
    @media print {
        .app-header, .app-sidebar, .app-footer, .card-header, .card-footer, .breadcrumb, .dropdown-menu, .btn-group {
            display: none !important;
        }
        
        .app-main {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        
        .table-dark th {
            background-color: #343a40 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .table-primary td {
            background-color: #cfe2ff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .badge {
            border: 1px solid #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
    
    .timeline {
        position: relative;
        padding-left: 1.5rem;
        list-style: none;
        border-left: 2px solid #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .timeline-point {
        position: absolute;
        left: -1.75rem;
        top: 0.25rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
    }
    
    .timeline-point-primary {
        color: #0d6efd;
        border: 2px solid #0d6efd;
    }
    
    .timeline-event {
        position: relative;
        padding-bottom: 1rem;
    }
</style>
@endsection