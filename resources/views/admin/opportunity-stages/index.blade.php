@extends('layouts.app')

@section('title', 'Etapas de Oportunidades')

@section('content')
<main class="app-main"> 

 <div class="app-content-header"> 
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Etapas de Oportunidades</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Etapas de Oportunidades
                            </li>
                        </ol>
                    </div>
                </div> 
            </div> 
        </div>
    <div class="app-content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Etapas de Oportunidades</h3>
                            <a href="{{ route('opportunity-stages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Nueva Etapa
                            </a>
                        </div>
                        
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Orden</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>% Cierre</th>
                                            <th>Color</th>
                                            <th>Etapa de Cierre</th>
                                            <th>Estado</th>
                                            <th>Compañía</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-stages">
                                        @forelse($stages as $stage)
                                            <tr data-id="{{ $stage->id }}">
                                                <td>
                                                    <span class="badge bg-secondary">{{ $stage->order }}</span>
                                                    <i class="fas fa-grip-vertical text-muted ms-2" style="cursor: move;"></i>
                                                </td>
                                                <td>
                                                    <strong>{{ $stage->name }}</strong>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ Str::limit($stage->description, 50) }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $stage->closing_percentage_formatted }}</span>
                                                </td>
                                                <td>
                                                    @if($stage->colour)
                                                        <div class="d-flex align-items-center">
                                                            <div class="color-box me-2" style="width: 20px; height: 20px; background-color: {{ $stage->colour }}; border-radius: 3px; border: 1px solid #ddd;"></div>
                                                            <small class="text-muted">{{ $stage->colour }}</small>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Sin color</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($stage->is_closing_stage)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check"></i> Sí
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            <i class="fas fa-times"></i> No
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('opportunity-stages.toggle-status', $stage) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm {{ $stage->status ? 'btn-success' : 'btn-danger' }}">
                                                            <i class="fas {{ $stage->status ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                            {{ $stage->status ? 'Activo' : 'Inactivo' }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $stage->company->company_name ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('opportunity-stages.show', $stage) }}" class="btn btn-sm btn-info" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('opportunity-stages.edit', $stage) }}" class="btn btn-sm btn-warning" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" title="Eliminar" 
                                                                onclick="confirmDelete({{ $stage->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                                        <p>No hay etapas de oportunidades registradas</p>
                                                        <a href="{{ route('opportunity-stages.create') }}" class="btn btn-primary">
                                                            Crear primera etapa
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($stages->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $stages->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar esta etapa de oportunidad?
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
@endsection

@push('styles')
<style>
    .sortable-placeholder {
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
    }
    
    .color-box {
        display: inline-block;
        vertical-align: middle;
    }
    
    #sortable-stages tr {
        cursor: move;
    }
    
    .table th {
        border-top: none;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar sortable para reordenar etapas
    const sortableElement = document.getElementById('sortable-stages');
    if (sortableElement) {
        new Sortable(sortableElement, {
            animation: 150,
            ghostClass: 'sortable-placeholder',
            onEnd: function(evt) {
                updateStageOrder();
            }
        });
    }
    
    function updateStageOrder() {
        const rows = document.querySelectorAll('#sortable-stages tr[data-id]');
        const stages = [];
        
        rows.forEach((row, index) => {
            stages.push({
                id: row.dataset.id,
                order: index + 1
            });
        });
        
        fetch('{{ route("opportunity-stages.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ stages: stages })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar los números de orden en la vista
                rows.forEach((row, index) => {
                    const orderBadge = row.querySelector('.badge.bg-secondary');
                    if (orderBadge) {
                        orderBadge.textContent = index + 1;
                    }
                });
                
                // Mostrar mensaje de éxito
                showAlert('success', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Error al actualizar el orden');
        });
    }
    
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        const container = document.querySelector('.card-body');
        container.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 3000);
    }
});

function confirmDelete(stageId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/opportunity-stages/${stageId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush