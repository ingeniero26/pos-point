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
                        <p><strong>Saldo Actual:</strong> ${{ number_format($session->current_balance, 2) }}</p>
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
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($session->opened_at)->format('d/m/Y H:i') }}</td>
                                <td>Apertura</td>
                                <td>Saldo inicial</td>
                                <td class="text-end">${{ number_format($session->opening_balance, 2) }}</td>
                                <td class="text-end">$0.00</td>
                                <td class="text-end">${{ number_format($session->opening_balance, 2) }}</td>
                            </tr>
                            @foreach($session->cashMovements as $movement)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($movement->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $movement->type }}</td>
                                    <td>{{ $movement->description }}</td>
                                    <td class="text-end">${{ $movement->type == 'income' ? number_format($movement->amount, 2) : '0.00' }}</td>
                                    <td class="text-end">${{ $movement->type == 'expense' ? number_format($movement->amount, 2) : '0.00' }}</td>
                                    <td class="text-end">${{ number_format($movement->balance_after, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
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