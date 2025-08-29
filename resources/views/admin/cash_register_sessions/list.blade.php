{{-- filepath: resources/views/admin/cash_register_sessions/list.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h3 class="mb-0">Aperturas y Cierres de Caja</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Movimientos de Caja</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
         <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAperturaCaja">
            <i class="fas fa-door-open"></i> Abrir Caja
        </button>
    </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div id="alert-area" class="container-fluid mb-3"></div>
                <table class="table table-striped table-bordered align-middle" id="cashRegisterSessionsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Caja</th>
                            <th>Usuario</th>
                            <th>Saldo Inicial</th>
                            <th>Saldo Esperado</th>
                            <th>Saldo Real</th>
                            <th>Diferencia</th>
                            <th>Ventas Efectivo</th>
                            <th>Otros Ingresos</th>
                            <th>Egresos</th>
                            <th>Apertura</th>
                            <th>Cierre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $session)
                            <tr>
                                <td>{{ $session->id }}</td>
                                <td>{{ $session->cashRegister->name ?? '-' }}</td>
                                <td>{{ $session->user->name ?? '-' }}</td>
                                <td class="text-end">${{ number_format($session->opening_balance, 2) }}</td>
                                <td class="text-end">${{ number_format($session->expected_closing_balance, 2) }}</td>
                                <td class="text-end">${{ number_format($session->current_balance, 2) }}</td>
                                <td class="text-end 
                                    @if($session->difference > 0) text-success 
                                    @elseif($session->difference < 0) text-danger 
                                    @endif">
                                    ${{ number_format($session->difference, 2) }}
                                </td>
                                <td class="text-end">${{ number_format($session->total_cash_sales, 2) }}</td>
                                <td class="text-end">${{ number_format($session->total_other_cash_inflows, 2) }}</td>
                                <td class="text-end">${{ number_format($session->total_cash_outflows, 2) }}</td>
                                <td>{{ $session->opened_at ? \Carbon\Carbon::parse($session->opened_at)->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $session->closed_at ? \Carbon\Carbon::parse($session->closed_at)->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    @if($session->status == 'Open')
                                        <span class="badge bg-success">Abierta</span>
                                    @elseif($session->status == 'Closed')
                                        <span class="badge bg-secondary">Cerrada</span>
                                    @elseif($session->status == 'Conciliated')
                                        <span class="badge bg-info text-dark">Conciliada</span>
                                    @else
                                        <span class="badge bg-light text-dark">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.cash_register_session.show', $session->id) }}" class="btn btn-sm btn-primary" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($session->status == 'Open')
                                    <button class="btn btn-warning btn-close-session" onclick="prepararCierreCaja({{ $session->id }}, {{ $session->current_balance }})">
                                        <i class="fas fa-lock"></i> Cerrar Caja
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">No hay sesiones de caja registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Apertura de Caja -->
<div class="modal fade" id="modalAperturaCaja" tabindex="-1" aria-labelledby="modalAperturaCajaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formAperturaCaja" class="modal-content">
            @csrf
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalAperturaCajaLabel"><i class="fas fa-door-open"></i> Apertura de Caja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="cash_register_id" class="form-label">Caja</label>
                    <select name="cash_register_id" id="cash_register_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        @foreach($cashRegisters as $register)
                            <option value="{{ $register->id }}">{{ $register->name }}</option>
                        @endforeach
                    </select>
                </div>
                


                <div class="mb-3">
                    <label for="opening_balance" class="form-label">Saldo Inicial</label>
                    <input type="number" step="0.01" min="0" name="opening_balance" id="opening_balance" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="observations_opening" class="form-label">Observaciones</label>
                    <textarea name="observations_opening" id="observations_opening" class="form-control" rows="2"></textarea>
                </div>
                <input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-door-open"></i> Abrir Caja</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Cierre de Caja -->
<div class="modal fade" id="modalCierreCaja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formCierreCaja" class="modal-content">
            @csrf
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-lock"></i> Cierre de Caja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="actual_closing_balance" class="form-label">Saldo Final Real</label>
                    <input type="number" step="0.01" min="0" name="actual_closing_balance" id="actual_closing_balance" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="observations_closing" class="form-label">Observaciones</label>
                    <textarea name="observations_closing" id="observations_closing" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-lock"></i> Cerrar Caja</button>
            </div>
        </form>
    </div>
</div>
</main>
@endsection
@section('script')
<script type="text/javascript">
// Definir la función en el ámbito global
function prepararCierreCaja(sessionId, currentBalance) {
    $('#formCierreCaja').attr('action', "{{ url('/admin/cash_register_session/close') }}/" + sessionId);
    $('#actual_closing_balance').val(currentBalance);
    $('#modalCierreCaja').modal('show');
}

$(function() {
    // Enviar formulario de apertura por AJAX
    $('#formAperturaCaja').on('submit', function(e) {
    e.preventDefault();
    let $form = $(this);
    let $submitBtn = $form.find('button[type="submit"]');
    
    $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Procesando...');
    
    $.ajax({
        url: "{{ url('admin/cash_register_session/open') }}",
        method: "POST",
        data: $form.serialize(),
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                $('#modalAperturaCaja').modal('hide');
                setTimeout(() => location.reload(), 1200);
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function(xhr) {
            let msg = 'Error en la solicitud';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            } else if (xhr.statusText) {
                msg = xhr.statusText;
            }
            showAlert('danger', msg);
        },
        complete: function() {
            $submitBtn.prop('disabled', false).html('<i class="fas fa-door-open"></i> Abrir Caja');
        }
    });
});

 

    // Manejar el envío del formulario de cierre
    $('#formCierreCaja').on('submit', function(e) {
        e.preventDefault();
        let $form = $(this);
        let $submitBtn = $form.find('button[type="submit"]');
        
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Procesando...');
        
        $.ajax({
            url: $form.attr('action'),
            method: "POST",
            data: $form.serialize(),
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    $('#modalCierreCaja').modal('hide');
                    setTimeout(() => location.reload(), 1200);
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function(xhr) {
                let msg = 'Error en la solicitud';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.statusText) {
                    msg = xhr.statusText;
                }
                showAlert('danger', msg);
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html('<i class="fas fa-lock"></i> Cerrar Caja');
            }
        });
    });

    function showAlert(type, message) {
        $('#alert-area').html(
            `<div class="alert alert-${type} alert-dismissible fade show mt-2" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>`
        );
    }
});
</script>
@endsection