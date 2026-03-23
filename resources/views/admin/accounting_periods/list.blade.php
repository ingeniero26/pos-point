@extends('layouts.app')

@section('title', 'Gestión de Períodos Contables')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0">Gestión de Períodos Contables</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.accounting-periods.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Período
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label for="companyFilter" class="form-label">Empresa</label>
                    <select id="companyFilter" class="form-select">
                        <option value="">Todas las empresas</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" 
                                @if($company->id == $companyId) selected @endif>
                                {{ $company->company_name ?? $company->trade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="statusFilter" class="form-label">Estado</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="open">Abierto</option>
                        <option value="closed">Cerrado</option>
                        <option value="locked">Bloqueado</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-secondary w-100" onclick="applyFilters()">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <p class="h2 text-primary">{{ $statistics['total'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Abiertos</h5>
                    <p class="h2 text-success">{{ $statistics['open'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Cerrados</h5>
                    <p class="h2 text-warning">{{ $statistics['closed'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Bloqueados</h5>
                    <p class="h2 text-danger">{{ $statistics['locked'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de períodos -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Período</th>
                        <th>Empresa</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Estado</th>
                        <th>Avance</th>
                        <th>Cerrado por</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="periodsTableBody">
                    @forelse($periods as $period)
                        <tr>
                            <td>
                                <strong>{{ $period->getFormattedPeriodName() }}</strong>
                            </td>
                            <td>{{ $period->company->company_name ?? $period->company->trade_name }}</td>
                            <td>{{ $period->start_date->format('d/m/Y') }}</td>
                            <td>{{ $period->end_date->format('d/m/Y') }}</td>
                            <td>
                                @if($period->isOpen())
                                    <span class="badge bg-success">Abierto</span>
                                @elseif($period->isClosed())
                                    <span class="badge bg-warning">Cerrado</span>
                                @elseif($period->isLocked())
                                    <span class="badge bg-danger">Bloqueado</span>
                                @endif
                            </td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar" 
                                        style="width: {{ $period->getCompletedPercentage() }}%"
                                        aria-valuenow="{{ $period->getCompletedPercentage() }}" 
                                        aria-valuemin="0" aria-valuemax="100">
                                        {{ $period->getCompletedPercentage() }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($period->closedBy)
                                    {{ $period->closedBy->name }}
                                    <br>
                                    <small class="text-muted">{{ $period->closed_at->format('d/m/Y H:i') }}</small>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.accounting_periods.show', $period->id) }}">
                                                <i class="fas fa-eye"></i> Ver detalles
                                            </a>
                                        </li>
                                        @if($period->isOpen())
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.accounting_periods.edit', $period->id) }}">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="closePeriod({{ $period->id }})">
                                                    <i class="fas fa-lock"></i> Cerrar
                                                </a>
                                            </li>
                                        @elseif($period->isClosed())
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="lockPeriod({{ $period->id }})">
                                                    <i class="fas fa-lock-open"></i> Bloquear
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="reopenPeriod({{ $period->id }})">
                                                    <i class="fas fa-unlock"></i> Reabrir
                                                </a>
                                            </li>
                                        @elseif($period->isLocked())
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="unlockPeriod({{ $period->id }})">
                                                    <i class="fas fa-lock-open"></i> Desbloquear
                                                </a>
                                            </li>
                                        @endif
                                        @if($period->isOpen())
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="deletePeriod({{ $period->id }})">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No hay períodos contables registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($periods instanceof \Illuminate\Pagination\Paginator)
            <div class="card-footer">
                {{ $periods->links() }}
            </div>
        @endif
    </div>

    <!-- Modal crear período rápido -->
    <div class="modal fade" id="quickCreateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Períodos del Año</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="yearInput" class="form-label">Año</label>
                        <input type="number" class="form-control" id="yearInput" 
                               value="{{ now()->year }}" min="2000" max="2099">
                    </div>
                    <p class="text-muted">Se crearán los 12 meses del año seleccionado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="createYearPeriods()">
                        Crear
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function applyFilters() {
    const companyId = document.getElementById('companyFilter').value;
    const status = document.getElementById('statusFilter').value;
    
    let url = '{{ route("admin.accounting_periods.list") }}';
    const params = new URLSearchParams();
    
    if (companyId) params.append('company_id', companyId);
    if (status) params.append('status', status);
    
    if (params.toString()) {
        url += '?' + params.toString();
    }
    
    window.location.href = url;
}

function closePeriod(id) {
    if (confirm('¿Está seguro de cerrar este período? Una vez cerrado, no podrá registrar más movimientos.')) {
        fetch(`/admin/accounting_periods/${id}/close`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function lockPeriod(id) {
    if (confirm('¿Está seguro de bloquear este período? No podrá ser modificado.')) {
        fetch(`/admin/accounting_periods/${id}/lock`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function unlockPeriod(id) {
    if (confirm('¿Está seguro de desbloquear este período?')) {
        fetch(`/admin/accounting_periods/${id}/unlock`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function reopenPeriod(id) {
    if (confirm('¿Está seguro de reabrir este período?')) {
        fetch(`/admin/accounting_periods/${id}/reopen`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function deletePeriod(id) {
    if (confirm('¿Está seguro de eliminar este período? Esta acción no se puede deshacer.')) {
        fetch(`/admin/accounting_periods/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function createYearPeriods() {
    const year = document.getElementById('yearInput').value;
    const companyId = document.getElementById('companyFilter').value || '{{ auth()->user()->company_id ?? 1 }}';
    
    fetch('/admin/accounting_periods/create-year', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            company_id: companyId,
            year: year
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}
</script>
@endpush
@endsection
