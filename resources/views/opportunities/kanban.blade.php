@extends('layouts.app')

@section('title', 'Oportunidades - Vista Kanban')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Pipeline de Oportunidades</h3>
                    <div class="btn-group">
                        <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Vista Lista
                        </a>
                        <a href="{{ route('opportunities.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nueva Oportunidad
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="kanban-board d-flex" style="overflow-x: auto; min-height: 600px;">
                        @foreach($stages as $stage)
                            <div class="kanban-column" 
                                 data-stage-id="{{ $stage->id }}"
                                 style="min-width: 300px; max-width: 300px; margin: 15px; background-color: #f8f9fa; border-radius: 8px;">
                                
                                <!-- Encabezado de la columna -->
                                <div class="kanban-header p-3 border-bottom" 
                                     style="background-color: {{ $stage->colour ?? '#6c757d' }}; color: white; border-radius: 8px 8px 0 0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">{{ $stage->name }}</h6>
                                        <span class="badge bg-light text-dark">{{ $stage->opportunities->count() }}</span>
                                    </div>
                                    <small class="opacity-75">{{ $stage->closing_percentage }}% probabilidad</small>
                                </div>
                                
                                <!-- Contenido de la columna -->
                                <div class="kanban-content p-2" style="min-height: 500px;">
                                    @foreach($stage->opportunities as $opportunity)
                                        <div class="opportunity-card card mb-2 shadow-sm" 
                                             data-opportunity-id="{{ $opportunity->id }}"
                                             style="cursor: move; border-left: 4px solid {{ $stage->colour ?? '#6c757d' }};">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-1" style="font-size: 0.9rem;">
                                                        {{ Str::limit($opportunity->name, 30) }}
                                                    </h6>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-link text-muted p-0" 
                                                                type="button" 
                                                                data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('opportunities.show', $opportunity) }}">
                                                                    <i class="fas fa-eye"></i> Ver
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('opportunities.edit', $opportunity) }}">
                                                                    <i class="fas fa-edit"></i> Editar
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="#" 
                                                                   onclick="confirmDelete({{ $opportunity->id }})">
                                                                    <i class="fas fa-trash"></i> Eliminar
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-user"></i> {{ $opportunity->contact_name }}
                                                    </small>
                                                    @if($opportunity->third)
                                                        <small class="text-muted d-block">
                                                            <i class="fas fa-building"></i> {{ Str::limit($opportunity->third->name, 25) }}
                                                        </small>
                                                    @endif
                                                </div>
                                                
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="fw-bold text-success" style="font-size: 0.9rem;">
                                                        {{ $opportunity->estimated_value_formatted }}
                                                    </span>
                                                    <span class="badge bg-info">{{ $opportunity->probability }}%</span>
                                                </div>
                                                
                                                @if($opportunity->estimated_closing_date)
                                                    <div class="mb-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar"></i> 
                                                            {{ $opportunity->estimated_closing_date->format('d/m/Y') }}
                                                            @if($opportunity->is_overdue)
                                                                <span class="text-danger">
                                                                    <i class="fas fa-exclamation-triangle"></i> Vencida
                                                                </span>
                                                            @endif
                                                        </small>
                                                    </div>
                                                @endif
                                                
                                                @if($opportunity->responsibleUser)
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                             style="width: 24px; height: 24px; font-size: 0.7rem; color: white;">
                                                            {{ strtoupper(substr($opportunity->responsibleUser->name, 0, 2)) }}
                                                        </div>
                                                        <small class="text-muted">{{ Str::limit($opportunity->responsibleUser->name, 20) }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- Zona de drop -->
                                    <div class="drop-zone" 
                                         style="min-height: 50px; border: 2px dashed #dee2e6; border-radius: 4px; display: none;">
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <small class="text-muted">Soltar aquí</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Footer con estadísticas -->
                                <div class="kanban-footer p-2 border-top bg-light" style="border-radius: 0 0 8px 8px;">
                                    <small class="text-muted">
                                        Total: {{ $stage->opportunities->sum('estimated_value') > 0 ? '$' . number_format($stage->opportunities->sum('estimated_value'), 2) : '$0.00' }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
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
                ¿Está seguro de que desea eliminar esta oportunidad?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mover oportunidad -->
<div class="modal fade" id="moveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mover Oportunidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="moveForm">
                    <div class="mb-3">
                        <label class="form-label">Nueva Etapa</label>
                        <select class="form-select" id="new_stage_id" required>
                            @foreach($stages as $stage)
                                <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="reason_container" style="display: none;">
                        <label class="form-label">Razón de pérdida</label>
                        <textarea class="form-control" id="reason_lost" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="moveOpportunity()">Mover</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .kanban-board {
        padding: 0 15px;
    }
    
    .opportunity-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .opportunity-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
    }
    
    .opportunity-card.dragging {
        opacity: 0.5;
        transform: rotate(5deg);
    }
    
    .kanban-column.drag-over .drop-zone {
        display: block !important;
        border-color: #007bff !important;
        background-color: rgba(0, 123, 255, 0.1);
    }
    
    .kanban-content {
        max-height: 500px;
        overflow-y: auto;
    }
    
    .kanban-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .kanban-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .kanban-content::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    .kanban-content::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentOpportunityId = null;
    
    // Inicializar drag and drop para cada columna
    document.querySelectorAll('.kanban-content').forEach(function(column) {
        new Sortable(column, {
            group: 'opportunities',
            animation: 150,
            ghostClass: 'dragging',
            chosenClass: 'dragging',
            dragClass: 'dragging',
            onStart: function(evt) {
                document.querySelectorAll('.drop-zone').forEach(zone => {
                    zone.style.display = 'block';
                });
            },
            onEnd: function(evt) {
                document.querySelectorAll('.drop-zone').forEach(zone => {
                    zone.style.display = 'none';
                });
                
                // Si cambió de columna
                if (evt.from !== evt.to) {
                    const opportunityId = evt.item.dataset.opportunityId;
                    const newStageId = evt.to.closest('.kanban-column').dataset.stageId;
                    
                    currentOpportunityId = opportunityId;
                    
                    // Verificar si la nueva etapa requiere razón de pérdida
                    const stageSelect = document.getElementById('new_stage_id');
                    stageSelect.value = newStageId;
                    
                    // Simular cambio para mostrar/ocultar razón de pérdida
                    stageSelect.dispatchEvent(new Event('change'));
                    
                    const modal = new bootstrap.Modal(document.getElementById('moveModal'));
                    modal.show();
                }
            }
        });
    });
    
    // Mostrar/ocultar campo de razón de pérdida
    document.getElementById('new_stage_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const reasonContainer = document.getElementById('reason_container');
        
        // Aquí deberías verificar si la etapa es de pérdida
        // Por simplicidad, asumimos que las etapas con 0% son de pérdida
        if (selectedOption.text.toLowerCase().includes('perdido') || selectedOption.text.toLowerCase().includes('lost')) {
            reasonContainer.style.display = 'block';
            document.getElementById('reason_lost').required = true;
        } else {
            reasonContainer.style.display = 'none';
            document.getElementById('reason_lost').required = false;
        }
    });
});

function moveOpportunity() {
    if (!currentOpportunityId) return;
    
    const stageId = document.getElementById('new_stage_id').value;
    const reason = document.getElementById('reason_lost').value;
    
    fetch(`/admin/opportunities/${currentOpportunityId}/move-stage`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            stage_id: stageId,
            reason_lost: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('moveModal'));
            modal.hide();
            
            // Recargar página para actualizar vista
            location.reload();
        } else {
            alert('Error al mover la oportunidad');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al mover la oportunidad');
    });
}

function confirmDelete(opportunityId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/opportunities/${opportunityId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush