@extends('layouts.app')

@section('title', 'Detalle de Etapa de Oportunidad')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detalle de Etapa de Oportunidad</h3>
                    <div class="btn-group">
                        <a href="{{ route('opportunity-stages.edit', $opportunityStage) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('opportunity-stages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5 class="text-muted mb-2">Información General</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 40%;">Nombre:</td>
                                            <td>{{ $opportunityStage->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Orden:</td>
                                            <td>
                                                <span class="badge bg-secondary fs-6">{{ $opportunityStage->order }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Compañía:</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $opportunityStage->company->company_name ?? 'N/A' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Estado:</td>
                                            <td>
                                                <span class="badge {{ $opportunityStage->status ? 'bg-success' : 'bg-danger' }} fs-6">
                                                    <i class="fas {{ $opportunityStage->status ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                    {{ $opportunityStage->status ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5 class="text-muted mb-2">Configuración</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 50%;">% de Cierre:</td>
                                            <td>
                                                <span class="badge bg-info fs-6">{{ $opportunityStage->closing_percentage_formatted }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Etapa de Cierre:</td>
                                            <td>
                                                @if($opportunityStage->is_closing_stage)
                                                    <span class="badge bg-success fs-6">
                                                        <i class="fas fa-check"></i> Sí
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary fs-6">
                                                        <i class="fas fa-times"></i> No
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Color:</td>
                                            <td>
                                                @if($opportunityStage->colour)
                                                    <div class="d-flex align-items-center">
                                                        <div class="color-preview me-2" 
                                                             style="width: 30px; height: 30px; background-color: {{ $opportunityStage->colour }}; border-radius: 5px; border: 2px solid #ddd;">
                                                        </div>
                                                        <code>{{ $opportunityStage->colour }}</code>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Sin color asignado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            @if($opportunityStage->description)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="text-muted mb-2">Descripción</h5>
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <p class="mb-0">{{ $opportunityStage->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="text-muted mb-2">Información de Auditoría</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" style="width: 30%;">Creado por:</td>
                                            <td>
                                                @if($opportunityStage->creator)
                                                    <span class="badge bg-info">{{ $opportunityStage->creator->name }}</span>
                                                @else
                                                    <span class="text-muted">Usuario no disponible</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Fecha de creación:</td>
                                            <td>
                                                <i class="fas fa-calendar-alt text-muted me-1"></i>
                                                {{ $opportunityStage->created_at->format('d/m/Y H:i:s') }}
                                                <small class="text-muted">({{ $opportunityStage->created_at->diffForHumans() }})</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Última actualización:</td>
                                            <td>
                                                <i class="fas fa-clock text-muted me-1"></i>
                                                {{ $opportunityStage->updated_at->format('d/m/Y H:i:s') }}
                                                <small class="text-muted">({{ $opportunityStage->updated_at->diffForHumans() }})</small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-chart-pie"></i> Vista Previa de Etapa
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <div class="stage-preview mb-3" 
                                         style="background-color: {{ $opportunityStage->colour ?? '#6c757d' }}; 
                                                color: white; 
                                                padding: 20px; 
                                                border-radius: 10px;
                                                box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        <h5 class="mb-2">{{ $opportunityStage->name }}</h5>
                                        <div class="progress mb-2" style="height: 8px;">
                                            <div class="progress-bar bg-white" 
                                                 role="progressbar" 
                                                 style="width: {{ $opportunityStage->closing_percentage }}%"
                                                 aria-valuenow="{{ $opportunityStage->closing_percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small>{{ $opportunityStage->closing_percentage_formatted }}</small>
                                    </div>
                                    
                                    @if($opportunityStage->is_closing_stage)
                                        <div class="alert alert-success py-2">
                                            <i class="fas fa-trophy"></i>
                                            <strong>Etapa de Cierre</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-cogs"></i> Acciones Rápidas
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('opportunity-stages.edit', $opportunityStage) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Editar Etapa
                                        </a>
                                        
                                        <form action="{{ route('opportunity-stages.toggle-status', $opportunityStage) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm w-100 {{ $opportunityStage->status ? 'btn-danger' : 'btn-success' }}">
                                                <i class="fas {{ $opportunityStage->status ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                {{ $opportunityStage->status ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                        
                                        <button type="button" 
                                                class="btn btn-danger btn-sm" 
                                                onclick="confirmDelete()">
                                            <i class="fas fa-trash"></i> Eliminar Etapa
                                        </button>
                                    </div>
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
                <p>¿Está seguro de que desea eliminar la etapa <strong>"{{ $opportunityStage->name }}"</strong>?</p>
                <p class="text-muted">Esta etapa será marcada como eliminada pero se mantendrá en el sistema para preservar la integridad de los datos.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('opportunity-stages.destroy', $opportunityStage) }}" method="POST" class="d-inline">
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
    .color-preview {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stage-preview {
        transition: transform 0.2s ease;
    }
    
    .stage-preview:hover {
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