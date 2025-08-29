@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-eye mr-2"></i>
                        Detalle de Cuenta PUC: {{ $pucAccount->account_code }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('puc-accounts.edit', $pucAccount) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('puc-accounts.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Información Principal -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Información Principal</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Código:</strong>
                                            <p class="text-primary">{{ $pucAccount->account_code }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Nombre:</strong>
                                            <p>{{ $pucAccount->account_name }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Nivel:</strong>
                                            <p>
                                                <span class="badge badge-info text-dark">
                                                    {{ $pucAccount->level }} - {{ $pucAccount->level_name }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Tipo de Cuenta:</strong>
                                            <p>
                                                <span class="badge 
                                                    @if($pucAccount->account_type == 'ASSETS') badge-success
                                                    @elseif($pucAccount->account_type == 'LIABILITIES') badge-warning
                                                    @elseif($pucAccount->account_type == 'EQUITY') badge-primary
                                                    @elseif($pucAccount->account_type == 'INCOME') badge-info
                                                    @elseif($pucAccount->account_type == 'EXPENSES') badge-danger
                                                    @else badge-secondary
                                                    @endif">
                                                    {{ $pucAccount->account_type_spanish }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Naturaleza:</strong>
                                            <p>
                                                <span class="badge {{ $pucAccount->nature == 'DEBIT' ? 'badge-primary' : 'badge-success' }}">
                                                    {{ $pucAccount->nature_spanish }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Estado:</strong>
                                            <p>
                                                @if($pucAccount->status)
                                                    <span class="badge badge-success">Activo</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactivo</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    @if($pucAccount->parent)
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Cuenta Padre:</strong>
                                                <p>
                                                    <a href="{{ route('puc-accounts.show', $pucAccount->parent) }}" class="text-decoration-none">
                                                        {{ $pucAccount->parent->account_code }} - {{ $pucAccount->parent->account_name }}
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($pucAccount->company)
                                        <div class="row">
                                            <div class="col-12">
                                                <strong>Empresa:</strong>
                                                <p>{{ $pucAccount->company->name }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Configuraciones -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Configuraciones</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Manejo de Terceros:</strong>
                                        <p>
                                            @if($pucAccount->third_party_handling)
                                                <i class="fas fa-check text-success"></i> Sí
                                            @else
                                                <i class="fas fa-times text-danger"></i> No
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Manejo de Centro de Costos:</strong>
                                        <p>
                                            @if($pucAccount->cost_center_handling)
                                                <i class="fas fa-check text-success"></i> Sí
                                            @else
                                                <i class="fas fa-times text-danger"></i> No
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Acepta Movimientos:</strong>
                                        <p>
                                            @if($pucAccount->accept_movement)
                                                <i class="fas fa-check text-success"></i> Sí
                                            @else
                                                <i class="fas fa-times text-danger"></i> No
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Auditoría -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5 class="card-title">Información de Auditoría</h5>
                                </div>
                                <div class="card-body">
                                    @if($pucAccount->creator)
                                        <div class="mb-2">
                                            <strong>Creado por:</strong>
                                            <p>{{ $pucAccount->creator->name }}</p>
                                        </div>
                                    @endif

                                    <div class="mb-2">
                                        <strong>Fecha de creación:</strong>
                                        <p>{{ $pucAccount->created_at->format('d/m/Y H:i') }}</p>
                                    </div>

                                    <div class="mb-2">
                                        <strong>Última actualización:</strong>
                                        <p>{{ $pucAccount->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subcuentas -->
                    @if($pucAccount->children->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-sitemap mr-2"></i>
                                            Subcuentas ({{ $pucAccount->children->count() }})
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Código</th>
                                                        <th>Nombre</th>
                                                        <th>Nivel</th>
                                                        <th>Tipo</th>
                                                        <th>Estado</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pucAccount->children as $child)
                                                        <tr>
                                                            <td><strong>{{ $child->account_code }}</strong></td>
                                                            <td>{{ $child->account_name }}</td>
                                                            <td>
                                                                <span class="badge badge-info">{{ $child->level_name }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-secondary">{{ $child->account_type_spanish }}</span>
                                                            </td>
                                                            <td>
                                                                @if($child->status)
                                                                    <span class="badge badge-success">Activo</span>
                                                                @else
                                                                    <span class="badge badge-secondary">Inactivo</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('puc-accounts.show', $child) }}" 
                                                                   class="btn btn-info btn-xs">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Ruta Completa -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-route mr-2"></i>
                                        Ruta Jerárquica
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            @php
                                                $path = [];
                                                $current = $pucAccount;
                                                while($current) {
                                                    array_unshift($path, $current);
                                                    $current = $current->parent;
                                                }
                                            @endphp
                                            
                                            @foreach($path as $index => $account)
                                                @if($index < count($path) - 1)
                                                    <li class="breadcrumb-item">
                                                        <a href="{{ route('puc-accounts.show', $account) }}">
                                                            {{ $account->account_code }} - {{ $account->account_name }}
                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="breadcrumb-item active" aria-current="page">
                                                        {{ $account->account_code }} - {{ $account->account_name }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    </nav>
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