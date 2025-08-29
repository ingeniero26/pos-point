@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i>
                        Plan Único de Cuentas (PUC)
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('puc-accounts.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nueva Cuenta
                        </a>
                    </div>
                </div>
                
                <!-- Filtros -->
                <div class="card-body border-bottom">
                    <form method="GET" action="{{ route('puc-accounts.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Código o nombre..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tipo de Cuenta</label>
                            <select name="account_type" class="form-control">
                                <option value="">Todos</option>
                                <option value="ASSETS" {{ request('account_type') == 'ASSETS' ? 'selected' : '' }}>Activos</option>
                                <option value="LIABILITIES" {{ request('account_type') == 'LIABILITIES' ? 'selected' : '' }}>Pasivos</option>
                                <option value="EQUITY" {{ request('account_type') == 'EQUITY' ? 'selected' : '' }}>Patrimonio</option>
                                <option value="INCOME" {{ request('account_type') == 'INCOME' ? 'selected' : '' }}>Ingresos</option>
                                <option value="EXPENSES" {{ request('account_type') == 'EXPENSES' ? 'selected' : '' }}>Gastos</option>
                                <option value="COST" {{ request('account_type') == 'COST' ? 'selected' : '' }}>Costos</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Nivel</label>
                            <select name="level" class="form-control">
                                <option value="">Todos</option>
                                <option value="1" {{ request('level') == '1' ? 'selected' : '' }}>Clase</option>
                                <option value="2" {{ request('level') == '2' ? 'selected' : '' }}>Grupo</option>
                                <option value="3" {{ request('level') == '3' ? 'selected' : '' }}>Cuenta</option>
                                <option value="4" {{ request('level') == '4' ? 'selected' : '' }}>Subcuenta</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-control">
                                <option value="">Todos</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-info me-2">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="{{ route('puc-accounts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Limpiar
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="10%">Código</th>
                                    <th width="25%">Nombre de la Cuenta</th>
                                    <th width="8%">Nivel</th>
                                    <th width="12%">Tipo</th>
                                    <th width="10%">Naturaleza</th>
                                    <th width="8%">Terceros</th>
                                    <th width="8%">C. Costo</th>
                                    <th width="8%">Movimiento</th>
                                    <th width="8%">Estado</th>
                                    <th width="13%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accounts as $account)
                                    <tr>
                                        <td>
                                            <strong class="text-dark">{{ $account->account_code }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-dark">{{ $account->account_name }}</span>
                                            @if($account->parent)
                                                <br><small class="text-secondary">
                                                    Padre: {{ $account->parent->account_code }} - {{ $account->parent->account_name }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info text-dark">
                                                {{ $account->level_name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge text-dark
                                                @if($account->account_type == 'ASSETS') badge-success
                                                @elseif($account->account_type == 'LIABILITIES') badge-warning
                                                @elseif($account->account_type == 'EQUITY') badge-primary
                                                @elseif($account->account_type == 'INCOME') badge-info
                                                @elseif($account->account_type == 'EXPENSES') badge-danger
                                                @else badge-secondary
                                                @endif">
                                                {{ $account->account_type_spanish }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge text-dark {{ $account->nature == 'DEBIT' ? 'badge-primary' : 'badge-success' }}">
                                                {{ $account->nature_spanish }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($account->third_party_handling)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($account->cost_center_handling)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($account->accept_movement)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td>
                                            @if($account->status)
                                                <span class="badge badge-success text-dark">Activo</span>
                                            @else
                                                <span class="badge badge-secondary text-dark">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('puc-accounts.show', $account) }}" 
                                                   class="btn btn-info btn-sm" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('puc-accounts.edit', $account) }}" 
                                                   class="btn btn-warning btn-sm" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('puc-accounts.toggle-status', $account) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-{{ $account->status ? 'secondary' : 'success' }} btn-sm"
                                                            title="{{ $account->status ? 'Desactivar' : 'Activar' }}">
                                                        <i class="fas fa-{{ $account->status ? 'ban' : 'check' }}"></i>
                                                    </button>
                                                </form>
                                                @if(!$account->children()->exists())
                                                    <form action="{{ route('puc-accounts.destroy', $account) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Está seguro de eliminar esta cuenta?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-4">
                                            <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                                            <p class="text-secondary">No se encontraron cuentas PUC</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($accounts->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $accounts->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection