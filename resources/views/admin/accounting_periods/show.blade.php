@extends('layouts.app')

@section('title', 'Detalles del Período Contable')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-10 offset-md-1">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Detalles del Período Contable</h1>
                <a href="{{ route('admin.accounting_periods.list') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Información General -->
    <div class="row mb-4">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        {{ $period->getFormattedPeriodName() }}
                        @if($period->isOpen())
                            <span class="badge bg-success">Abierto</span>
                        @elseif($period->isClosed())
                            <span class="badge bg-warning">Cerrado</span>
                        @else
                            <span class="badge bg-danger">Bloqueado</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Empresa:</strong></p>
                            <p>{{ $period->company->company_name ?? $period->company->trade_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Año/Mes:</strong></p>
                            <p>{{ $period->year }} / {{ \App\Models\AccountingPeriods::getMonthName($period->month) }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Fecha de Inicio:</strong></p>
                            <p>{{ $period->start_date->format('d/m/Y') }} a las {{ $period->start_date->format('H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fecha de Fin:</strong></p>
                            <p>{{ $period->end_date->format('d/m/Y') }} a las {{ $period->end_date->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h6 class="card-title">Total de Días</h6>
                            <h3 class="text-primary">{{ $period->getDaysCount() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h6 class="card-title">Días Restantes</h6>
                            <h3 class="text-info">{{ $period->getDaysRemaining() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h6 class="card-title">Vencido</h6>
                            <h3 class="text-danger">
                                @if($period->isExpired())
                                    Sí
                                @else
                                    No
                                @endif
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h6 class="card-title">Completitud</h6>
                            <h3 class="text-success">{{ $period->getCompletedPercentage() }}%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barra de progreso -->
    <div class="row mb-4">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Progreso del Período</h6>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-info" role="progressbar" 
                             style="width: {{ $period->getCompletedPercentage() }}%"
                             aria-valuenow="{{ $period->getCompletedPercentage() }}" 
                             aria-valuemin="0" aria-valuemax="100">
                            {{ $period->getCompletedPercentage() }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información de Cierre -->
    @if($period->isClosed() || $period->isLocked())
        <div class="row mb-4">
            <div class="col-md-10 offset-md-1">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Información de Cierre</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Fecha de Cierre:</strong></p>
                                <p>{{ $period->closed_at?->format('d/m/Y H:i:s') ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Cerrado por:</strong></p>
                                <p>{{ $period->closedBy?->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Notas -->
    @if($period->notes)
        <div class="row mb-4">
            <div class="col-md-10 offset-md-1">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Notas</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $period->notes }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Acciones -->
    <div class="row mb-4">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Acciones</h5>
                </div>
                <div class="card-body">
                    @if($period->isOpen())
                        <a href="{{ route('admin.accounting_periods.edit', $period->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar Período
                        </a>
                        <button class="btn btn-warning" onclick="closePeriod()">
                            <i class="fas fa-lock"></i> Cerrar Período
                        </button>
                        <a href="{{ route('admin.accounting_periods.list') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    @elseif($period->isClosed())
                        <button class="btn btn-info" onclick="lockPeriod()">
                            <i class="fas fa-lock"></i> Bloquear
                        </button>
                        <button class="btn btn-danger" onclick="reopenPeriod()">
                            <i class="fas fa-unlock"></i> Reabrir
                        </button>
                        <a href="{{ route('admin.accounting_periods.list') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    @elseif($period->isLocked())
                        <button class="btn btn-secondary" onclick="unlockPeriod()">
                            <i class="fas fa-lock-open"></i> Desbloquear
                        </button>
                        <a href="{{ route('admin.accounting_periods.list') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function closePeriod() {
    if (confirm('¿Está seguro de cerrar este período? Una vez cerrado, no podrá registrar más movimientos.')) {
        fetch('/admin/accounting_periods/{{ $period->id }}/close', {
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

function lockPeriod() {
    if (confirm('¿Está seguro de bloquear este período? No podrá ser modificado.')) {
        fetch('/admin/accounting_periods/{{ $period->id }}/lock', {
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

function unlockPeriod() {
    if (confirm('¿Está seguro de desbloquear este período?')) {
        fetch('/admin/accounting_periods/{{ $period->id }}/unlock', {
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

function reopenPeriod() {
    if (confirm('¿Está seguro de reabrir este período?')) {
        fetch('/admin/accounting_periods/{{ $period->id }}/reopen', {
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
</script>
@endpush
@endsection
