@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye mr-2"></i>
                        Comprobante Contable: {{ $accountingMovement->receipt_number }}
                    </h3>
                    <div class="card-tools">
                        @if($accountingMovement->status === 'DRAFT')
                            <a href="{{ route('accounting-movements.edit', $accountingMovement) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        @endif
                        <a href="{{ route('accounting-movements.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
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

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Información Principal -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Información del Comprobante</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Tipo de Comprobante:</strong>
                                            <p>{{ $accountingMovement->receiptType->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Número:</strong>
                                            <p class="text-primary">{{ $accountingMovement->receipt_number }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Fecha:</strong>
                                            <p>{{ $accountingMovement->receipt_date->format('d/m/Y') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Fecha de Vencimiento:</strong>
                                            <p>{{ $accountingMovement->due_date ? $accountingMovement->due_date->format('d/m/Y') : 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <strong>Concepto:</strong>
                                            <p>{{ $accountingMovement->concept }}</p>
                                        </div>
                                    </div>

                                    @if($accountingMovement->reference)
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Referencia:</strong>
                                                <p>{{ $accountingMovement->reference }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($accountingMovement->company)
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Empresa:</strong>
                                                <p>{{ $accountingMovement->company->name }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Estado y Totales -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Estado y Totales</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Estado:</strong>
                                        <p>
                                            <span class="badge badge-{{ $accountingMovement->status_color }} text-white">
                                                {{ $accountingMovement->status_spanish }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Total Débitos:</strong>
                                        <p class="text-primary h5">{{ number_format($accountingMovement->total_debits, 2) }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Total Créditos:</strong>
                                        <p class="text-success h5">{{ number_format($accountingMovement->total_credits, 2) }}</p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Balance:</strong>
                                        <p>
                                            @if($accountingMovement->is_balanced)
                                                <span class="badge badge-success text-white">
                                                    <i class="fas fa-check"></i> Balanceado
                                                </span>
                                            @else
                                                <span class="badge badge-warning text-white">
                                                    <i class="fas fa-exclamation-triangle"></i> 
                                                    Desbalanceado ({{ number_format($accountingMovement->difference, 2) }})
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Acciones -->
                                    <div class="mt-4">
                                        @if($accountingMovement->canBeConfirmed())
                                            <form action="{{ route('accounting-movements.confirm', $accountingMovement) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm btn-block mb-2"
                                                        onclick="return confirm('¿Confirmar este comprobante?')">
                                                    <i class="fas fa-check"></i> Confirmar
                                                </button>
                                            </form>
                                        @endif

                                        @if($accountingMovement->canBeCancelled())
                                            <form action="{{ route('accounting-movements.cancel', $accountingMovement) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-secondary btn-sm btn-block mb-2"
                                                        onclick="return confirm('¿Cancelar este comprobante?')">
                                                    <i class="fas fa-ban"></i> Cancelar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Auditoría -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title">Información de Auditoría</h5>
                                </div>
                                <div class="card-body">
                                    @if($accountingMovement->creationUser)
                                        <div class="mb-2">
                                            <strong>Creado por:</strong>
                                            <p>{{ $accountingMovement->creationUser->name }}</p>
                                        </div>
                                    @endif

                                    <div class="mb-2">
                                        <strong>Fecha de creación:</strong>
                                        <p>{{ $accountingMovement->created_at->format('d/m/Y H:i') }}</p>
                                    </div>

                                    @if($accountingMovement->confirmation_date)
                                        <div class="mb-2">
                                            <strong>Confirmado por:</strong>
                                            <p>{{ $accountingMovement->confirmationUser->name ?? 'N/A' }}</p>
                                        </div>

                                        <div class="mb-2">
                                            <strong>Fecha de confirmación:</strong>
                                            <p>{{ $accountingMovement->confirmation_date->format('d/m/Y H:i') }}</p>
                                        </div>
                                    @endif

                                    <div class="mb-2">
                                        <strong>Última actualización:</strong>
                                        <p>{{ $accountingMovement->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del Comprobante -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-list mr-2"></i>
                                        Detalles del Comprobante ({{ $accountingMovement->details->count() }})
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="15%">Cuenta PUC</th>
                                                    <th width="20%">Nombre Cuenta</th>
                                                    <th width="25%">Concepto</th>
                                                    <th width="10%">Débito</th>
                                                    <th width="10%">Crédito</th>
                                                    <th width="12%">Tercero</th>
                                                    <th width="8%">Centro Costo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($accountingMovement->details as $detail)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $detail->pucAccount->account_code ?? 'N/A' }}</strong>
                                                        </td>
                                                        <td>
                                                            {{ $detail->pucAccount->account_name ?? 'N/A' }}
                                                        </td>
                                                        <td>{{ $detail->concept }}</td>
                                                        <td class="text-right">
                                                            @if($detail->debit_amount > 0)
                                                                <span class="text-primary">{{ number_format($detail->debit_amount, 2) }}</span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-right">
                                                            @if($detail->credit_amount > 0)
                                                                <span class="text-success">{{ number_format($detail->credit_amount, 2) }}</span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $detail->thirdParty->name ?? '-' }}
                                                        </td>
                                                        <td>
                                                            {{ $detail->costCenter->name ?? '-' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-info">
                                                <tr>
                                                    <th colspan="3">TOTALES</th>
                                                    <th class="text-right">{{ number_format($accountingMovement->total_debits, 2) }}</th>
                                                    <th class="text-right">{{ number_format($accountingMovement->total_credits, 2) }}</th>
                                                    <th colspan="2">
                                                        @if($accountingMovement->is_balanced)
                                                            <span class="badge badge-success text-white">Balanceado</span>
                                                        @else
                                                            <span class="badge badge-warning text-white">
                                                                Diferencia: {{ number_format($accountingMovement->difference, 2) }}
                                                            </span>
                                                        @endif
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection