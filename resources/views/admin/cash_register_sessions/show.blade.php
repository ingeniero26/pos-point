@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detalles de Sesión de Caja</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.cash_register_session.list') }}">Movimientos de Caja</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title">Información General</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Caja:</strong> {{ $session->cashRegister->name }}</p>
                        <p><strong>Usuario:</strong> {{ $session->user->name }}</p>
                        <p><strong>Estado:</strong> 
                            @if($session->status == 'Open')
                                <span class="badge bg-success">Abierta</span>
                            @elseif($session->status == 'Closed')
                                <span class="badge bg-secondary">Cerrada</span>
                            @endif
                        </p>
                        <p><strong>Apertura:</strong> {{ $session->opened_at ? \Carbon\Carbon::parse($session->opened_at)->format('d/m/Y H:i') : '-' }}</p>
                        <p><strong>Cierre:</strong> {{ $session->closed_at ? \Carbon\Carbon::parse($session->closed_at)->format('d/m/Y H:i') : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Saldo Inicial:</strong> ${{ number_format($session->opening_balance, 2) }}</p>
                        <p><strong>Saldo Actual:</strong> 
                            <span class="@if($session->current_balance >= $session->opening_balance) text-success @else text-danger @endif">
                                ${{ number_format($session->current_balance, 2) }}
                            </span>
                        </p>
                        @if($session->status == 'Closed')
                            <p><strong>Saldo Final Esperado:</strong> ${{ number_format($session->expected_closing_balance, 2) }}</p>
                            <p><strong>Saldo Final Real:</strong> ${{ number_format($session->actual_closing_balance, 2) }}</p>
                            <p><strong>Diferencia:</strong> 
                                <span class="@if($session->difference > 0) text-success @elseif($session->difference < 0) text-danger @endif">
                                    ${{ number_format($session->difference, 2) }}
                                </span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title">Movimientos de Caja</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Usuario</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $runningBalance = $session->opening_balance;
                                $totalInflows = 0;
                                $totalOutflows = 0;
                            ?>
                            @forelse($session->cashMovements as $movement)
                                <?php 
                                    $runningBalance += $movement->amount;
                                    if($movement->amount > 0) {
                                        $totalInflows += $movement->amount;
                                    } else {
                                        $totalOutflows += abs($movement->amount);
                                    }
                                ?>
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($movement->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($movement->movementType)
                                            <span class="badge {{ $movement->amount > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $movement->movementType->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $movement->description }}</td>
                                    <td>{{ $movement->user->name ?? '-' }}</td>
                                    <td class="text-end text-success">
                                        @if($movement->amount > 0)
                                            ${{ number_format($movement->amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end text-danger">
                                        @if($movement->amount < 0)
                                            ${{ number_format(abs($movement->amount), 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end"><strong>${{ number_format($runningBalance, 2) }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Sin movimientos registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="4" class="text-end">TOTALES:</td>
                                <td class="text-end text-success">${{ number_format($totalInflows, 2) }}</td>
                                <td class="text-end text-danger">${{ number_format($totalOutflows, 2) }}</td>
                                <td class="text-end">
                                    <span class="@if($runningBalance >= 0) text-success @else text-danger @endif">
                                        ${{ number_format($runningBalance, 2) }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="table-info fw-bold">
                                <td colspan="4" class="text-end">CÁLCULO:</td>
                                <td colspan="3" class="text-end">
                                    Inicial: ${{ number_format($session->opening_balance, 2) }} + 
                                    Ingresos: ${{ number_format($totalInflows, 2) }} - 
                                    Egresos: ${{ number_format($totalOutflows, 2) }} = 
                                    <span>
                                        ${{ number_format($runningBalance, 2) }}
                                    </span>
                                </td>
                            </tr>
                            @if($runningBalance != $session->current_balance)
                            <tr class="table-warning fw-bold">
                                <td colspan="7" class="text-center">
                                    ⚠️ INCONSISTENCIA: Saldo Calculado (${{ number_format($runningBalance, 2) }}) ≠ Saldo Actual en Sistema (${{ number_format($session->current_balance, 2) }})
                                    <br><small>Diferencia: ${{ number_format(abs($runningBalance - $session->current_balance), 2) }}</small>
                                </td>
                            </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title">Observaciones</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Apertura</h6>
                    <p>{{ $session->observations_opening ?: 'Sin observaciones' }}</p>
                </div>
                @if($session->status == 'Closed')
                    <div>
                        <h6>Cierre</h6>
                        <p>{{ $session->observations_closing ?: 'Sin observaciones' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection