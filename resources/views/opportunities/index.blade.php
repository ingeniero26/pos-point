@extends('layouts.app')

@section('title', 'Oportunidades')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Gestión de Oportunidades</h3>
                    <div class="btn-group">
                        <a href="{{ route('opportunities.kanban') }}" class="btn btn-info">
                            <i class="fas fa-columns"></i> Vista Kanban
                        </a>
                        <a href="{{ route('opportunities.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nueva Oportunidad
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <form method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Buscar</label>
                                    <input type="text" class="form-control" name="search" 
                                           value="{{ request('search') }}" placeholder="Nombre, contacto, email...">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Etapa</label>
                                    <select class="form-select" name="stage_id">
                                        <option value="">Todas las etapas</option>
                                        @foreach($stages as $stage)
                                            <option value="{{ $stage->id }}" 
                                                {{ request('stage_id') == $stage->id ? 'selected' : '' }}>
                                                {{ $stage->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Responsable</label>
                                    <select class="form-select" name="responsible_user_id">
                                        <option value="">Todos</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                {{ request('responsible_user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Estado</label>
                                    <select class="form-select" name="status">
                                        <option value="">Todos</option>
                                        <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Abiertas</option>
                                        <option value="Won" {{ request('status') == 'Won' ? 'selected' : '' }}>Ganadas</option>
                                        <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Perdidas</option>
                                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                    <a href="{{ route('opportunities.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Limpiar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Contacto</th>
                                    <th>Etapa</th>
                                    <th>Valor Estimado</th>
                                    <th>Probabilidad</th>
                                    <th>Fecha Cierre</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($opportunities as $opportunity)
                                    <tr class="{{ $opportunity->is_overdue ? 'table-warning' : '' }}">
                                        <td>
                                            <div>
                                                <strong>{{ $opportunity->name }}</strong>
                                                @if($opportunity->is_overdue)
                                                    <span class="badge bg-warning ms-1">
                                                        <i class="fas fa-exclamation-triangle"></i> Vencida
                                                    </span>
                                                @endif
                                            </div>
                                            @if($opportunity->description)
                                                <small class="text-muted">{{ Str::limit($opportunity->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $opportunity->contact_name }}</strong>
                                                @if($opportunity->third)
                                                    <br><small class="text-muted">{{ $opportunity->third->name }}</small>
                                                @endif
                                            </div>
                                            @if($opportunity->contact_email)
                                                <small class="text-muted d-block">{{ $opportunity->contact_email }}</small>
                                            @endif
                                            @if($opportunity->contact_phone)
                                                <small class="text-muted d-block">{{ $opportunity->contact_phone }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($opportunity->stage)
                                                <span class="badge" style="background-color: {{ $opportunity->stage->colour ?? '#6c757d' }}">
                                                    {{ $opportunity->stage->name }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Sin etapa</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $opportunity->estimated_value_formatted }}</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 8px;">
                                                    <div class="progress-bar" 
                                                         role="progressbar" 
                                                         style="width: {{ $opportunity->probability }}%"
                                                         aria-valuenow="{{ $opportunity->probability }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small>{{ $opportunity->probability_formatted }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($opportunity->estimated_closing_date)
                                                <div>
                                                    {{ $opportunity->estimated_closing_date->format('d/m/Y') }}
                                                    @if($opportunity->days_to_close !== null)
                                                        <br><small class="text-muted">
                                                            @if($opportunity->days_to_close > 0)
                                                                {{ $opportunity->days_to_close }} días restantes
                                                            @elseif($opportunity->days_to_close == 0)
                                                                Hoy
                                                            @else
                                                                {{ abs($opportunity->days_to_close) }} días vencida
                                                            @endif
                                                        </small>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">No definida</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($opportunity->responsibleUser)
                                                <span class="badge bg-info">{{ $opportunity->responsibleUser->name }}</span>
                                            @else
                                                <span class="text-muted">Sin asignar</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($opportunity->status)
                                                @case('won')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-trophy"></i> {{ $opportunity->status_label }}
                                                    </span>
                                                    @break
                                                @case('lost')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times"></i> {{ $opportunity->status_label }}
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-clock"></i> {{ $opportunity->status_label }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('opportunities.show', $opportunity) }}" 
                                                   class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('opportunities.edit', $opportunity) }}" 
                                                   class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Eliminar" 
                                                        onclick="confirmDelete({{ $opportunity->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-handshake fa-3x mb-3"></i>
                                                <p>No hay oportunidades registradas</p>
                                                <a href="{{ route('opportunities.create') }}" class="btn btn-primary">
                                                    Crear primera oportunidad
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($opportunities->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $opportunities->appends(request()->query())->links() }}
                        </div>
                    @endif
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
@endsection

@push('scripts')
<script>
function confirmDelete(opportunityId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/opportunities/${opportunityId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush