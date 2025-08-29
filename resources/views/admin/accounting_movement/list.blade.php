@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Comprobantes Contables
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('accounting-movements.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nuevo Comprobante
                        </a>
                    </div>
                </div>
                
                <!-- Filtros -->
                <div class="card-body border-bottom">
                    <form method="GET" action="{{ route('accounting-movements.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Número, concepto o referencia..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tipo de Comprobante</label>
                            <select name="receipt_type_id" class="form-control">
                                <option value="">Todos</option>
                                @foreach($receiptTypes as $type)
                                    <option value="{{ $type->id }}" {{ request('receipt_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-control">
                                <option value="">Todos</option>
                                <option value="DRAFT" {{ request('status') == 'DRAFT' ? 'selected' : '' }}>Borrador</option>
                                <option value="CONFIRMED" {{ request('status') == 'CONFIRMED' ? 'selected' : '' }}>Confirmado</option>
                                <option value="CANCELLED" {{ request('status') == 'CANCELLED' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Fecha Desde</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Fecha Hasta</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-info me-2">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('accounting-movements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="8%">Número</th>
                                    <th width="12%">Tipo</th>
                                    <th width="10%">Fecha</th>
                                    <th width="25%">Concepto</th>
                                    <th width="12%">Total Débitos</th>
                                    <th width="12%">Total Créditos</th>
                                    <th width="8%">Estado</th>
                                    <th width="8%">Balance</th>
                                    <th width="15%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($movements as $movement)
                                    <tr>
                                        <td>
                                            <strong class="text-dark">{{ $movement->receipt_number }}</strong>
                                            @if($movement->reference)
                                                <br><small class="text-secondary">Ref: {{ $movement->reference }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $movement->receiptType->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $movement->receipt_date->format('d/m/Y') }}</span>
                                            @if($movement->due_date)
                                                <br><small class="text-secondary">Vence: {{ $movement->due_date->format('d/m/Y') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $movement->concept }}</span>
                                            @if($movement->creationUser)
                                                <br><small class="text-secondary">Por: {{ $movement->creationUser->name }}</small>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <span class="text-dark">{{ number_format($movement->total_debits, 2) }}</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="text-dark">{{ number_format($movement->total_credits, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $movement->status_color }} text-white">
                                                {{ $movement->status_spanish }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($movement->is_balanced)
                                                <i class="fas fa-check text-success" title="Balanceado"></i>
                                            @else
                                                <i class="fas fa-exclamation-triangle text-warning" 
                                                   title="Desbalanceado: {{ number_format($movement->difference, 2) }}"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('accounting-movements.show', $movement) }}" 
                                                   class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if($movement->status === 'DRAFT')
                                                    <a href="{{ route('accounting-movements.edit', $movement) }}" 
                                                       class="btn btn-warning btn-sm" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif

                                                @if($movement->canBeConfirmed())
                                                    <form action="{{ route('accounting-movements.confirm', $movement) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm" 
                                                                title="Confirmar"
                                                                onclick="return confirm('¿Confirmar este comprobante?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($movement->canBeCancelled())
                                                    <form action="{{ route('accounting-movements.cancel', $movement) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-secondary btn-sm" 
                                                                title="Cancelar"
                                                                onclick="return confirm('¿Cancelar este comprobante?')">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($movement->status === 'DRAFT')
                                                    <form action="{{ route('accounting-movements.destroy', $movement) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                title="Eliminar"
                                                                onclick="return confirm('¿Eliminar este comprobante?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                                            <p class="text-secondary">No se encontraron comprobantes contables</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($movements->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $movements->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection