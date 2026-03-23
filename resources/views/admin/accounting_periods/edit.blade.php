@extends('layouts.app')

@section('title', 'Editar Período Contable')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Editar Período Contable</h1>
                <a href="{{ route('accounting-periods.list') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <form id="editPeriodForm" method="POST" action="{{ route('accounting-periods.update', $accountingPeriods->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Información General -->
                        <div class="alert alert-info mb-4">
                            <strong>Período:</strong> {{ $accountingPeriods->getFormattedPeriodName() }} 
                            <br>
                            <strong>Estado:</strong> 
                            @if($accountingPeriods->isOpen())
                                <span class="badge bg-success">Abierto</span>
                            @elseif($accountingPeriods->isClosed())
                                <span class="badge bg-warning">Cerrado</span>
                            @else
                                <span class="badge bg-danger">Bloqueado</span>
                            @endif
                        </div>

                        <!-- Empresa (solo lectura) -->
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Empresa</label>
                            <input type="text" class="form-control" id="company_name" 
                                   value="{{ $accountingPeriods->company->company_name ?? $accountingPeriods->company->trade_name }}" 
                                   readonly>
                        </div>

                        <!-- Año y Mes (solo lectura) -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="year" class="form-label">Año</label>
                                    <input type="text" class="form-control" id="year" 
                                           value="{{ $accountingPeriods->year }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="month" class="form-label">Mes</label>
                                    <input type="text" class="form-control" id="month" 
                                           value="{{ \App\Models\AccountingPeriods::getMonthName($accountingPeriods->month) }}" 
                                           readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Nombre del Período -->
                        <div class="mb-3">
                            <label for="period_name" class="form-label">Nombre del Período</label>
                            <input type="text" class="form-control" id="period_name" name="period_name" 
                                   value="{{ $accountingPeriods->period_name }}"
                                   placeholder="Ej: Enero 2024">
                        </div>

                        <!-- Fecha de Inicio -->
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ $accountingPeriods->start_date->format('Y-m-d') }}">
                        </div>

                        <!-- Fecha de Fin -->
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ $accountingPeriods->end_date->format('Y-m-d') }}">
                        </div>

                        <!-- Estadísticas -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1"><strong>Días en el período:</strong></p>
                                        <p class="h5 mb-0">{{ $accountingPeriods->getDaysCount() }} días</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-1"><strong>Completitud:</strong></p>
                                        <p class="h5 mb-0">{{ $accountingPeriods->getCompletedPercentage() }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notas -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" 
                                      placeholder="Notas adicionales del período...">{{ $accountingPeriods->notes }}</textarea>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.accounting_periods.list') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Acciones de período -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Acciones del Período</h5>
                </div>
                <div class="card-body">
                    @if($accountingPeriods->isOpen())
                        <button class="btn btn-warning" onclick="closePeriod()">
                            <i class="fas fa-lock"></i> Cerrar Período
                        </button>
                        <small class="d-block text-muted mt-2">
                            Una vez cerrado, no podrá registrar más movimientos en este período.
                        </small>
                    @elseif($accountingPeriods->isClosed())
                        <p class="mb-2">
                            <strong>Cerrado el:</strong> 
                            {{ $accountingPeriods->closed_at->format('d/m/Y H:i') }}
                            @if($accountingPeriods->closedBy)
                                <strong>por:</strong> {{ $accountingPeriods->closedBy->name }}
                            @endif
                        </p>
                        <div class="btn-group" role="group">
                            <button class="btn btn-info" onclick="lockPeriod()">
                                <i class="fas fa-lock"></i> Bloquear
                            </button>
                            <button class="btn btn-danger" onclick="reopenPeriod()">
                                <i class="fas fa-unlock"></i> Reabrir
                            </button>
                        </div>
                    @elseif($accountingPeriods->isLocked())
                        <p class="mb-2 alert alert-warning">
                            <strong>Período Bloqueado:</strong> Este período no puede ser modificado.
                        </p>
                        <button class="btn btn-secondary" onclick="unlockPeriod()">
                            <i class="fas fa-lock-open"></i> Desbloquear
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('editPeriodForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = {
        period_name: document.getElementById('period_name').value || null,
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
        notes: document.getElementById('notes').value || null,
    };

    fetch('/admin/accounting_periods/{{ $accountingPeriods->id }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = '{{ route("admin.accounting_periods.list") }}';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al actualizar el período');
    });
});

function closePeriod() {
    if (confirm('¿Está seguro de cerrar este período? Una vez cerrado, no podrá registrar más movimientos.')) {
        fetch('/admin/accounting_periods/{{ $accountingPeriods->id }}/close', {
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
        fetch('/admin/accounting_periods/{{ $accountingPeriods->id }}/lock', {
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
        fetch('/admin/accounting_periods/{{ $accountingPeriods->id }}/unlock', {
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
        fetch('/admin/accounting_periods/{{ $accountingPeriods->id }}/reopen', {
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
