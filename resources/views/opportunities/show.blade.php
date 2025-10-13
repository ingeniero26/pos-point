@extends('layouts.app')

@section('title', 'Detalle de Oportunidad')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $opportunity->name }}</h3>
                    <div class="btn-group">
                        <a href="{{ route('opportunities.edit', $opportunity) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Información General -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle"></i> Información General
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%;">Nombre:</td>
                                                    <td>{{ $opportunity->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Compañía:</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $opportunity->company->company_name ?? 'N/A' }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Estado:</td>
                                                    <td>
                                                        @switch($opportunity->status)
                                                            @case('won')
                                                                <span class="badge bg-success fs-6">
                                                                    <i class="fas fa-trophy"></i> {{ $opportunity->status_label }}
                                                                </span>
                                                                @break
                                                            @case('lost')
                                                                <span class="badge bg-danger fs-6">
                                                                    <i class="fas fa-times"></i> {{ $opportunity->status_label }}
                                                                </span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-primary fs-6">
                                                                    <i class="fas fa-clock"></i> {{ $opportunity->status_label }}
                                                                </span>
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Etapa Actual:</td>
                                                    <td>
                                                        @if($opportunity->stage)
                                                            <span class="badge fs-6" style="background-color: {{ $opportunity->stage->colour ?? '#6c757d' }}">
                                                                {{ $opportunity->stage->name }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">Sin etapa</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%;">Valor Estimado:</td>
                                                    <td>
                                                        <span class="fs-5 fw-bold text-success">{{ $opportunity->estimated_value_formatted }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Probabilidad:</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress me-2" style="width: 100px; height: 10px;">
                                                                <div class="progress-bar" 
                                                                     role="progressbar" 
                                                                     style="width: {{ $opportunity->probability }}%"
                                                                     aria-valuenow="{{ $opportunity->probability }}" 
                                                                     aria-valuemin="0" 
                                                                     aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <span class="fw-bold">{{ $opportunity->probability_formatted }}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Responsable:</td>
                                                    <td>
                                                        @if($opportunity->responsibleUser)
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                                     style="width: 32px; height: 32px; font-size: 0.8rem; color: white;">
                                                                    {{ strtoupper(substr($opportunity->responsibleUser->name, 0, 2)) }}
                                                                </div>
                                                                <span>{{ $opportunity->responsibleUser->name }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">Sin asignar</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Fuente:</td>
                                                    <td>
                                                        @if($opportunity->source)
                                                            <span class="badge bg-info">{{ $opportunity->source->name }}</span>
                                                        @else
                                                            <span class="text-muted">No especificada</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    @if($opportunity->description)
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h6 class="fw-bold">Descripción:</h6>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p class="mb-0">{{ $opportunity->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-address-book"></i> Información de Contacto
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%;">Contacto Principal:</td>
                                                    <td>{{ $opportunity->contact_name }}</td>
                                                </tr>
                                                @if($opportunity->third)
                                                    <tr>
                                                        <td class="fw-bold">Cliente/Tercero:</td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ $opportunity->third->name }}</span>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                @if($opportunity->contact_email)
                                                    <tr>
                                                        <td class="fw-bold" style="width: 30%;">Email:</td>
                                                        <td>
                                                            <a href="mailto:{{ $opportunity->contact_email }}">
                                                                <i class="fas fa-envelope"></i> {{ $opportunity->contact_email }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if($opportunity->contact_phone)
                                                    <tr>
                                                        <td class="fw-bold">Teléfono:</td>
                                                        <td>
                                                            <a href="tel:{{ $opportunity->contact_phone }}">
                                                                <i class="fas fa-phone"></i> {{ $opportunity->contact_phone }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fechas y Seguimiento -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-calendar-alt"></i> Fechas y Seguimiento
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="fw-bold" style="width: 50%;">Fecha de Creación:</td>
                                                    <td>
                                                        <i class="fas fa-calendar-plus text-muted me-1"></i>
                                                        {{ $opportunity->created_at->format('d/m/Y H:i') }}
                                                        <br><small class="text-muted">{{ $opportunity->created_at->diffForHumans() }}</small>
                                                    </td>
                                                </tr>
                                                @if($opportunity->estimated_closing_date)
                                                    <tr>
                                                        <td class="fw-bold">Fecha Estimada de Cierre:</td>
                                                        <td>
                                                            <i class="fas fa-calendar-check text-muted me-1"></i>
                                                            {{ $opportunity->estimated_closing_date->format('d/m/Y') }}
                                                            @if($opportunity->days_to_close !== null)
                                                                <br><small class="text-muted">
                                                                    @if($opportunity->days_to_close > 0)
                                                                        {{ $opportunity->days_to_close }} días restantes
                                                                    @elseif($opportunity->days_to_close == 0)
                                                                        <span class="text-warning">Hoy</span>
                                                                    @else
                                                                        <span class="text-danger">{{ abs($opportunity->days_to_close) }} días vencida</span>
                                                                    @endif
                                                                </small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                @if($opportunity->closing_date)
                                                    <tr>
                                                        <td class="fw-bold" style="width: 40%;">Fecha de Cierre:</td>
                                                        <td>
                                                            <i class="fas fa-flag-checkered text-muted me-1"></i>
                                                            {{ $opportunity->closing_date->format('d/m/Y') }}
                                                            <br><small class="text-muted">{{ $opportunity->closing_date->diffForHumans() }}</small>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td class="fw-bold">Última Actualización:</td>
                                                    <td>
                                                        <i class="fas fa-clock text-muted me-1"></i>
                                                        {{ $opportunity->updated_at->format('d/m/Y H:i') }}
                                                        <br><small class="text-muted">{{ $opportunity->updated_at->diffForHumans() }}</small>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    @if($opportunity->reason_lost)
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h6 class="fw-bold text-danger">Razón de Pérdida:</h6>
                                                <div class="alert alert-danger">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    {{ $opportunity->reason_lost }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Resumen Visual -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-chart-pie"></i> Resumen Visual
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <div class="opportunity-preview mb-3" 
                                         style="background: linear-gradient(135deg, {{ $opportunity->stage->colour ?? '#6c757d' }}, {{ $opportunity->stage->colour ?? '#6c757d' }}aa); 
                                                color: white; 
                                                padding: 25px; 
                                                border-radius: 15px;
                                                box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                        <h5 class="mb-3">{{ $opportunity->stage->name ?? 'Sin etapa' }}</h5>
                                        <div class="mb-3">
                                            <div class="h2 mb-0">{{ $opportunity->estimated_value_formatted }}</div>
                                            <small class="opacity-75">Valor estimado</small>
                                        </div>
                                        <div class="progress mb-2" style="height: 10px; background-color: rgba(255,255,255,0.3);">
                                            <div class="progress-bar bg-white" 
                                                 role="progressbar" 
                                                 style="width: {{ $opportunity->probability }}%"
                                                 aria-valuenow="{{ $opportunity->probability }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="opacity-75">{{ $opportunity->probability_formatted }} probabilidad</small>
                                    </div>
                                    
                                    @if($opportunity->is_overdue)
                                        <div class="alert alert-warning py-2">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <strong>Oportunidad Vencida</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Acciones Rápidas -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cogs"></i> Acciones Rápidas
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('opportunities.edit', $opportunity) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar Oportunidad
                                        </a>
                                        
                                        @if($opportunity->contact_email)
                                            <a href="mailto:{{ $opportunity->contact_email }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-envelope"></i> Enviar Email
                                            </a>
                                        @endif
                                        
                                        @if($opportunity->contact_phone)
                                            <a href="tel:{{ $opportunity->contact_phone }}" 
                                               class="btn btn-success btn-sm">
                                                <i class="fas fa-phone"></i> Llamar
                                            </a>
                                        @endif
                                        
                                        <button type="button" 
                                                class="btn btn-danger btn-sm" 
                                                onclick="confirmDelete()">
                                            <i class="fas fa-trash"></i> Eliminar Oportunidad
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Información de Auditoría -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-history"></i> Auditoría
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <small class="text-muted">
                                        <strong>Creado por:</strong><br>
                                        @if($opportunity->creator)
                                            {{ $opportunity->creator->name }}
                                        @else
                                            Usuario no disponible
                                        @endif
                                        <br><br>
                                        <strong>ID:</strong> {{ $opportunity->id }}<br>
                                        <strong>Creado:</strong> {{ $opportunity->created_at->format('d/m/Y H:i:s') }}<br>
                                        <strong>Actualizado:</strong> {{ $opportunity->updated_at->format('d/m/Y H:i:s') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                </div>
                <p>¿Está seguro de que desea eliminar la oportunidad <strong>"{{ $opportunity->name }}"</strong>?</p>
                <p class="text-muted">La oportunidad será marcada como eliminada pero se mantendrá en el sistema para preservar la integridad de los datos.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('opportunities.destroy', $opportunity) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .opportunity-preview {
        transition: transform 0.2s ease;
    }
    
    .opportunity-preview:hover {
        transform: translateY(-2px);
    }
    
    .table-borderless td {
        border: none;
        padding: 0.5rem 0;
    }
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush