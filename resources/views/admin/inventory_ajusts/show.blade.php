@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">
                        <i class="fas fa-eye text-primary me-2"></i>
                        Detalle del Ajuste de Inventario
                    </h3>
                    <p class="text-muted mb-0">{{ $inventoryAdjustment->adjustment_number }}</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.inventory_ajusts.list')}}">Ajustes de Inventario</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $inventoryAdjustment->adjustment_number }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content-body"></div>   <div class="container-fluid">
            <!-- Status and Actions Bar -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div>
                                        @php
                                            $statusClasses = [
                                                'draft' => 'bg-secondary',
                                                'pending' => 'bg-warning',
                                                'approved' => 'bg-success',
                                                'rejected' => 'bg-danger',
                                                'applied' => 'bg-info'
                                            ];
                                            $statusClass = $statusClasses[$inventoryAdjustment->status] ?? 'bg-light text-dark';
                                        @endphp
                                        <span class="badge {{ $statusClass }} fs-6 px-3 py-2">
                                            <i class="fas fa-circle me-1"></i>
                                            {{ ucfirst($inventoryAdjustment->status) }}
                                        </span>
                                    </div>
                                    <div class="vr"></div>
                                    <div>
                                        <small class="text-muted d-block">Total del Ajuste</small>
                                        <strong class="text-primary fs-5">
                                            ${{ number_format($inventoryAdjustment->total_value, 2, ',', '.') }}
                                        </strong>
                                    </div>
                                    <div class="vr"></div>
                                    <div>
                                        <small class="text-muted d-block">Productos</small>
                                        <strong class="fs-5">{{ $inventoryAdjustment->adjustmentDetails->count() }}</strong>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    @if($inventoryAdjustment->status === 'draft')
                                        <a href="{{ route('admin.inventory_ajusts.edit', $inventoryAdjustment->id) }}" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit me-1"></i>
                                            Editar
                                        </a>
                                        <button type="button" class="btn btn-success" id="submitForApproval">
                                            <i class="fas fa-paper-plane me-1"></i>
                                            Enviar para Aprobación
                                        </button>
                                    @endif
                                    
                                    @if($inventoryAdjustment->status === 'pending')
                                        <button type="button" class="btn btn-success" id="approveAdjustment">
                                            <i class="fas fa-check me-1"></i>
                                            Aprobar
                                        </button>
                                        <button type="button" class="btn btn-danger" id="rejectAdjustment">
                                            <i class="fas fa-times me-1"></i>
                                            Rechazar
                                        </button>
                                    @endif
                                    
                                    <button type="button" class="btn btn-info" id="printAdjustment">
                                        <i class="fas fa-print me-1"></i>
                                        Imprimir
                                    </button>
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" 
                                                data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" id="exportPdf">
                                                <i class="fas fa-file-pdf text-danger me-2"></i>Exportar PDF
                                            </a></li>
                                            <li><a class="dropdown-item" href="#" id="exportExcel">
                                                <i class="fas fa-file-excel text-success me-2"></i>Exportar Excel
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.inventory_ajusts.list') }}">
                                                <i class="fas fa-list me-2"></i>Volver al Listado
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Main Information -->
                <div class="col-lg-8">
                    <!-- General Information Card -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Información General
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="text-muted small">Número de Ajuste</label>
                                        <div class="fw-bold">{{ $inventoryAdjustment->adjustment_number }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="text-muted small">Fecha de Ajuste</label>
                                        <div class="fw-bold">
                                            <i class="fas fa-calendar text-muted me-1"></i>
                                            {{ $inventoryAdjustment->adjustment_date->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="text-muted small">Bodega</label>
                                        <div class="fw-bold">
                                            <i class="fas fa-warehouse text-muted me-1"></i>
                                            {{ $inventoryAdjustment->warehouse->warehouse_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="text-muted small">Tipo de Ajuste</label>
                                        <div class="fw-bold">
                                            <i class="fas fa-tags text-muted me-1"></i>
                                            {{ $inventoryAdjustment->adjustmentType->type_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                                @if($inventoryAdjustment->reasonAdjustment)
                                <div class="col-md-12">
                                    <div class="info-item">
                                        <label class="text-muted small">Razón del Ajuste</label>
                                        <div class="fw-bold">
                                            <i class="fas fa-comment-alt text-muted me-1"></i>
                                            {{ $inventoryAdjustment->reasonAdjustment->reason_name }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($inventoryAdjustment->comments)
                                <div class="col-12">
                                    <div class="info-item">
                                        <label class="text-muted small">Comentarios</label>
                                        <div class="bg-light p-3 rounded">
                                            {{ $inventoryAdjustment->comments }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Products Details Card -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-boxes me-2"></i>
                                Detalle de Productos ({{ $inventoryAdjustment->adjustmentDetails->count() }})
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="50">#</th>
                                            <th width="120">Código</th>
                                            <th>Producto</th>
                                            <th width="100" class="text-center">Stock Sistema</th>
                                            <th width="100" class="text-center">Stock Físico</th>
                                            <th width="100" class="text-center">Diferencia</th>
                                            <th width="120" class="text-end">Costo Unit.</th>
                                            <th width="120" class="text-end">Valor Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($inventoryAdjustment->adjustmentDetails as $index => $detail)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $detail->item->barcode ?? $detail->item->internal_code ?? $detail->item->sku ?? 'N/A' }}</strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $detail->item->product_name ?? 'Producto no encontrado' }}</strong>
                                                    @if($detail->item->description)
                                                        <br><small class="text-muted">{{ Str::limit($detail->item->description, 50) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark">
                                                    {{ number_format($detail->system_quantity, 0) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">
                                                    {{ number_format($detail->physical_quantity, 0) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $difference = $detail->physical_quantity - $detail->system_quantity;
                                                    $badgeClass = $difference > 0 ? 'bg-success' : ($difference < 0 ? 'bg-danger' : 'bg-secondary');
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $difference > 0 ? '+' : '' }}{{ number_format($difference, 0) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                ${{ number_format($detail->unit_cost, 2, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                <strong>${{ number_format($detail->total_cost, 2, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                <i class="fas fa-box-open fa-2x mb-2"></i>
                                                <br>No hay productos en este ajuste
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    @if($inventoryAdjustment->adjustmentDetails->count() > 0)
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="7" class="text-end">Total del Ajuste:</th>
                                            <th class="text-end">
                                                <span class="fs-5 text-primary">
                                                    ${{ number_format($inventoryAdjustment->total_value, 2, ',', '.') }}
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="col-lg-4">
                    <!-- Status Timeline -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-history me-2"></i>
                                Historial del Ajuste
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Ajuste Creado</h6>
                                        <p class="text-muted mb-1">
                                            Por: {{ $inventoryAdjustment->createdBy->name ?? 'Usuario desconocido' }}
                                        </p>
                                        <small class="text-muted">
                                            {{ $inventoryAdjustment->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                                
                                @if($inventoryAdjustment->status !== 'draft')
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Enviado para Aprobación</h6>
                                        <small class="text-muted">
                                            {{ $inventoryAdjustment->updated_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                                @endif
                                
                                @if(in_array($inventoryAdjustment->status, ['approved', 'rejected']) && $inventoryAdjustment->approval_date)
                                <div class="timeline-item">
                                    <div class="timeline-marker {{ $inventoryAdjustment->status === 'approved' ? 'bg-success' : 'bg-danger' }}"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">
                                            {{ $inventoryAdjustment->status === 'approved' ? 'Aprobado' : 'Rechazado' }}
                                        </h6>
                                        <p class="text-muted mb-1">
                                            Por: {{ $inventoryAdjustment->userApproval->name ?? 'Usuario desconocido' }}
                                        </p>
                                        <small class="text-muted">
                                            {{ $inventoryAdjustment->approval_date->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Support Document -->
                    @if($inventoryAdjustment->support_document)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-paperclip me-2"></i>
                                Documento de Soporte
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-file-alt fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Documento Adjunto</h6>
                                    <small class="text-muted">{{ basename($inventoryAdjustment->support_document) }}</small>
                                </div>
                                <div>
                                    <a href="{{ asset('storage/' . $inventoryAdjustment->support_document) }}" 
                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Summary Statistics -->
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>
                                Resumen Estadístico
                            </h6>
                        </div>
                        <div class="card-body">
                            @php
                                $totalIncrease = $inventoryAdjustment->adjustmentDetails->where('physical_quantity', '>', DB::raw('system_quantity'))->sum(function($detail) {
                                    return $detail->physical_quantity - $detail->system_quantity;
                                });
                                $totalDecrease = $inventoryAdjustment->adjustmentDetails->where('physical_quantity', '<', DB::raw('system_quantity'))->sum(function($detail) {
                                    return $detail->system_quantity - $detail->physical_quantity;
                                });
                                $increaseItems = $inventoryAdjustment->adjustmentDetails->where('physical_quantity', '>', DB::raw('system_quantity'))->count();
                                $decreaseItems = $inventoryAdjustment->adjustmentDetails->where('physical_quantity', '<', DB::raw('system_quantity'))->count();
                            @endphp
                            
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="border-end">
                                        <h4 class="text-success mb-1">+{{ number_format($totalIncrease, 0) }}</h4>
                                        <small class="text-muted">Unidades Agregadas</small>
                                        <br><small class="text-muted">({{ $increaseItems }} productos)</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-danger mb-1">-{{ number_format($totalDecrease, 0) }}</h4>
                                    <small class="text-muted">Unidades Reducidas</small>
                                    <br><small class="text-muted">({{ $decreaseItems }} productos)</small>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Impacto Neto:</span>
                                @php $netImpact = $totalIncrease - $totalDecrease; @endphp
                                <strong class="{{ $netImpact >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $netImpact >= 0 ? '+' : '' }}{{ number_format($netImpact, 0) }} unidades
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('styles')
<style>
    .info-item {
        margin-bottom: 1rem;
    }
    
    .info-item label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-marker {
        position: absolute;
        left: -22px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e9ecef;
    }
    
    .timeline-content h6 {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .timeline-content p {
        margin-bottom: 5px;
        font-size: 0.875rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .vr {
        width: 1px;
        height: 30px;
        background-color: #dee2e6;
    }
    
    @media (max-width: 768px) {
        .vr {
            display: none;
        }
        
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 1rem !important;
        }
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Submit for approval
        $('#submitForApproval').on('click', function() {
            Swal.fire({
                title: '¿Enviar para Aprobación?',
                text: 'El ajuste será enviado para revisión y aprobación.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateAdjustmentStatus('pending');
                }
            });
        });

        // Approve adjustment
        $('#approveAdjustment').on('click', function() {
            Swal.fire({
                title: '¿Aprobar Ajuste?',
                text: 'Esta acción aprobará el ajuste y actualizará el inventario.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, aprobar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateAdjustmentStatus('approved');
                }
            });
        });

        // Reject adjustment
        $('#rejectAdjustment').on('click', function() {
            Swal.fire({
                title: '¿Rechazar Ajuste?',
                input: 'textarea',
                inputLabel: 'Motivo del rechazo (opcional)',
                inputPlaceholder: 'Ingrese el motivo del rechazo...',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateAdjustmentStatus('rejected', result.value);
                }
            });
        });

        // Print adjustment
        $('#printAdjustment').on('click', function() {
            const adjustmentId = {{ $inventoryAdjustment->id }};
            const url = `{{ route('admin.inventory_ajusts.pdf', ':id') }}`.replace(':id', adjustmentId);
            window.open(url, '_blank');
        });

        // Export PDF
        $('#exportPdf').on('click', function() {
            const adjustmentId = {{ $inventoryAdjustment->id }};
            const url = `{{ route('admin.inventory_ajusts.export.pdf') }}?id=${adjustmentId}`;
            window.open(url, '_blank');
        });

        // Export Excel
        $('#exportExcel').on('click', function() {
            const adjustmentId = {{ $inventoryAdjustment->id }};
            const url = `{{ route('admin.inventory_ajusts.export.excel') }}?id=${adjustmentId}`;
            window.location.href = url;
        });
    });

    function updateAdjustmentStatus(status, comments = null) {
        const adjustmentId = {{ $inventoryAdjustment->id }};
        // item_id
        
        
        // Show loading
        Swal.fire({
            title: 'Procesando...',
            text: 'Actualizando estado del ajuste',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `{{ route('admin.inventory_ajusts.update_status', ':id') }}`.replace(':id', adjustmentId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status,
                comments: comments
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message || 'Estado actualizado correctamente',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Error al actualizar el estado'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating status:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar el estado del ajuste'
                });
            }
        });
    }
</script>
@endsection