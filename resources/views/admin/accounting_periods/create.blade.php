@extends('layouts.app')

@section('title', 'Crear Período Contable')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Crear Período Contable</h1>
                <a href="{{ route('admin.accounting_periods.list') }}" class="btn btn-secondary">
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
                    <form id="createPeriodForm" method="POST" action="{{ route('admin.accounting_periods.store') }}">
                        @csrf

                        <!-- Empresa -->
                        <div class="mb-3">
                            <label for="company_id" class="form-label">Empresa <span class="text-danger">*</span></label>
                            <select class="form-select" id="company_id" name="company_id" required>
                                <option value="">Seleccione una empresa</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" 
                                        @if($company->id == $companyId) selected @endif>
                                        {{ $company->company_name ?? $company->trade_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Año -->
                        <div class="mb-3">
                            <label for="year" class="form-label">Año <span class="text-danger">*</span></label>
                            <select class="form-select" id="year" name="year" required onchange="updateDates()">
                                <option value="">Seleccione un año</option>
                                @foreach($years as $y)
                                    <option value="{{ $y }}" @if($y == $currentYear) selected @endif>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mes -->
                        <div class="mb-3">
                            <label for="month" class="form-label">Mes <span class="text-danger">*</span></label>
                            <select class="form-select" id="month" name="month" required onchange="updateDates()">
                                <option value="">Seleccione un mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>

                        <!-- Nombre del Período -->
                        <div class="mb-3">
                            <label for="period_name" class="form-label">Nombre del Período</label>
                            <input type="text" class="form-control" id="period_name" name="period_name" 
                                   placeholder="Ej: Enero 2024">
                            <small class="text-muted">Si no especifica, se usará el nombre del mes y año</small>
                        </div>

                        <!-- Fecha de Inicio -->
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>

                        <!-- Fecha de Fin -->
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Fecha de Fin <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>

                        <!-- Notas -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notas</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" 
                                      placeholder="Notas adicionales del período..."></textarea>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.accounting_periods.list') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Crear Período
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Información útil -->
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="alert alert-info">
                <h5 class="alert-heading">
                    <i class="fas fa-info-circle"></i> Información
                </h5>
                <ul class="mb-0">
                    <li>Un período contable es un intervalo de tiempo en el cual se registran las operaciones contables.</li>
                    <li>Por lo general, un período es de un mes de duración.</li>
                    <li>Las fechas se establecen automáticamente según el mes y año seleccionado.</li>
                    <li>Puede personalizar las fechas según sus necesidades.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateDates() {
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;

    if (!year || !month) {
        return;
    }

    const monthValue = parseInt(month);
    const yearValue = parseInt(year);

    // Establecer fecha de inicio (primer día del mes)
    const startDate = new Date(yearValue, monthValue - 1, 1);
    document.getElementById('start_date').value = startDate.toISOString().split('T')[0];

    // Establecer fecha de fin (último día del mes)
    const endDate = new Date(yearValue, monthValue, 0);
    document.getElementById('end_date').value = endDate.toISOString().split('T')[0];

    // Actualizar nombre del período si está vacío
    const monthNames = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    const periodNameInput = document.getElementById('period_name');
    if (!periodNameInput.value) {
        periodNameInput.value = monthNames[monthValue] + ' ' + yearValue;
    }
}

document.getElementById('createPeriodForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = {
        company_id: document.getElementById('company_id').value,
        year: document.getElementById('year').value,
        month: document.getElementById('month').value,
        period_name: document.getElementById('period_name').value || null,
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
        notes: document.getElementById('notes').value || null,
    };

    fetch('{{ route("admin.accounting_periods.store") }}', {
        method: 'POST',
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
        alert('Ocurrió un error al crear el período');
    });
});
</script>
@endpush
@endsection
