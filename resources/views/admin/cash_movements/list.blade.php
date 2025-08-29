@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h3 class="mb-0">Movimientos de Caja</h3>
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
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle" id="cashMovementsTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha/Hora</th>
                                <th>Caja</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Documento Ref.</th>
                                <th>Tercero</th>
                                <th>Ingreso</th>
                                <th>Egreso</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_ingresos = 0;
                            $total_otros_ingresos = 0;
                            $total_egresos = 0;
                        @endphp
                            @forelse($movements as $movement)
                                @php
                                    if ($movement->amount > 0) {
                                        $total_ingresos += $movement->amount;
                                    } elseif ($movement->amount < 0) {
                                        $total_egresos += abs($movement->amount);
                                    }
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($movement->transaction_time)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $movement->cashRegisterSession->cashRegister->name ?? '-' }}</td>
                                    <td>{{ $movement->movementType->name ?? '-' }}</td>
                                    <td>{{ $movement->description }}</td>
                                    <td>
                                        @if($movement->reference_document_type)
                                            {{ $movement->reference_document_type }}
                                            @if($movement->reference_document_number)
                                                #{{ $movement->reference_document_number }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($movement->third_party_name)
                                            {{ $movement->third_party_name }}
                                            @if($movement->third_party_document_number)
                                                ({{ $movement->third_party_document_type }} {{ $movement->third_party_document_number }})
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end text-success">
                                        @if($movement->amount > 0)
                                            ${{ number_format($movement->amount, 2) }}
                                        @endif
                                    </td>
                                    <td class="text-end text-danger">
                                        @if($movement->amount < 0)
                                            ${{ number_format(abs($movement->amount), 2) }}
                                        @endif
                                    </td>
                                    <td>{{ $movement->user->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay movimientos registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot></tfoot>
                            <tr>
                                <th colspan="6" class="text-end">Totales:</th>
                                <th class="text-end text-success">${{ number_format($total_ingresos, 2) }}</th>
                                <th class="text-end text-danger">${{ number_format($total_egresos, 2) }}</th>
                                <th></th>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
$(function() {
    $('#cashMovementsTable').DataTable({
        order: [[0, 'desc']],
        language: {
           url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        }
    });
});
</script>
@endsection