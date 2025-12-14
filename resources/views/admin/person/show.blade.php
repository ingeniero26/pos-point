@extends('layouts.app')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detalles del Tercero</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/person/list')}}">Terceros</a></li>
                        <li class="breadcrumb-item active">Detalles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Información del Tercero</h3>
                            <div class="card-tools">
                                <a href="{{ url('admin/person') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5>Información Básica</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 30%">Tipo de Tercero</th>
                                                <td>{{ $person->type_third ? $person->type_third->type_third : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tipo de Documento</th>
                                                <td>{{ $person->identification_type ? $person->identification_type->identification_name : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Número de Identificación</th>
                                                <td>{{ $person->identification_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nombre de la Empresa</th>
                                                <td>{{ $person->company_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Primer Nombre</th>
                                                <td>{{ $person->first_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Segundo Nombre</th>
                                                <td>{{ $person->second_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Primer Apellido</th>
                                                <td>{{ $person->last_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Segundo Apellido</th>
                                                <td>{{ $person->second_last_name ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5>Información Tributaria</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 30%">Tipo de Persona</th>
                                                <td>{{ $person->type_person ? $person->type_person->type_person : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tipo de Régimen</th>
                                                <td>{{ $person->type_regimen ? $person->type_regimen->regimen_name : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tipo de Obligación</th>
                                                <td>{{ $person->type_liability ? $person->type_liability->liability_name : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>CIUU</th>
                                                <td>{{ $person->ciiu_code ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Contribuyente</th>
                                                <td>{{ $person->great_taxpayer ? 'Sí' : 'No' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Autorretedor</th>
                                                <td>{{ $person->self_withholder ? 'Sí' : 'No' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Actividad ICA</th>
                                                <td>{{ $person->ica_activity ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tasa ICA</th>
                                                <td>{{ $person->ica_rate ? '$' . number_format($person->ica_rate, 0, ',', '.') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Registro Comercial</th>
                                                <td>{{ $person->commercial_registry ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Fecha Registro</th>
                                                <td>{{ $person->registration_date ? \Carbon\Carbon::parse($person->registration_date)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h5>Información de Contacto</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 15%">País</th>
                                                <td>{{ $person->countries ? $person->countries->country_name : 'N/A' }}</td>
                                                <th style="width: 15%">Departamento</th>
                                                <td>{{ $person->departments ? $person->departments->name_department : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ciudad</th>
                                                <td>{{ $person->cities ? $person->cities->city_name : 'N/A' }}</td>
                                                <th>Dirección</th>
                                                <td>{{ $person->address ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Teléfono</th>
                                                <td>{{ $person->phone ?? 'N/A' }}</td>
                                                <th>Correo Electrónico</th>
                                                <td>{{ $person->email ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @if($person->comment ?? false)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h5>Comentarios</h5>
                                        <div class="card">
                                            <div class="card-body">
                                                {{ $person->comment }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h5>Información del Sistema</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 15%">Estado</th>
                                                <td>
                                                    @if($person->status == 0)
                                                        <span class="badge bg-success">Activo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactivo</span>
                                                    @endif
                                                </td>
                                                <th style="width: 15%">Fecha de Creación</th>
                                                <td>{{ $person->created_at->format('d/m/Y H:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Última Actualización</th>
                                                <td colspan="3">{{ $person->updated_at->format('d/m/Y H:i A') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección de Compras (si es proveedor) -->
                            @if($person->type_third_id == 2 && $person->purchases && count($person->purchases) > 0)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-shopping-cart text-primary"></i> 
                                                Historial de Compras (Últimas 10)
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Número</th>
                                                            <th>Tipo</th>
                                                            <th>Estado</th>
                                                            <th>Método Pago</th>
                                                            <th>Total</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($person->purchases as $purchase)
                                                        <tr>
                                                            <td>
                                                                <small class="text-muted">
                                                                    {{ \Carbon\Carbon::parse($purchase->date_of_issue)->format('d/m/Y') }}
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <strong>{{ $purchase->purchase_no ?? 'N/A' }}</strong>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-info">
                                                                    {{ $purchase->voucher_type->voucher_name ?? 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if($purchase->state_type)
                                                                    @if($purchase->state_type->id == 1)
                                                                        <span class="badge bg-warning">{{ $purchase->state_type->state_name }}</span>
                                                                    @elseif($purchase->state_type->id == 2)
                                                                        <span class="badge bg-success">{{ $purchase->state_type->state_name }}</span>
                                                                    @else
                                                                        <span class="badge bg-danger">{{ $purchase->state_type->state_name }}</span>
                                                                    @endif
                                                                @else
                                                                    <span class="badge bg-secondary">N/A</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <small>{{ $purchase->payment_method->name ?? 'N/A' }}</small>
                                                            </td>
                                                            <td>
                                                                <strong class="text-success">
                                                                    ${{ number_format($purchase->total_purchase ?? 0, 0, ',', '.') }}
                                                                    <small class="text-muted">{{ $purchase->currencies->currency_name ?? '' }}</small>
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('admin/purchases/show/' . $purchase->id) }}" 
                                                                   class="btn btn-sm btn-outline-primary" 
                                                                   title="Ver detalles">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if(count($person->purchases) >= 10)
                                            <div class="text-center mt-3">
                                                <a href="{{ url('admin/purchases?supplier_id=' . $person->id) }}" 
                                                   class="btn btn-outline-primary">
                                                    <i class="fas fa-list"></i> Ver todas las compras
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Sección de Ventas (si es cliente) -->
                            @if($person->type_third_id == 1 && $person->sales && count($person->sales) > 0)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-receipt text-success"></i> 
                                                Historial de Ventas (Últimas 10)
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Número</th>
                                                            <th>Tipo</th>
                                                            <th>Estado</th>
                                                            <th>Método Pago</th>
                                                            <th>Total</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($person->sales as $sale)
                                                        <tr>
                                                            <td>
                                                                <small class="text-muted">
                                                                    {{ \Carbon\Carbon::parse($sale->date_of_issue)->format('d/m/Y') }}
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <strong>{{ $sale->invoice_no ?? 'N/A' }}</strong>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-info">
                                                                    {{ $sale->voucherTypes->voucher_name ?? 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if($sale->stateTypes)
                                                                    @if($sale->stateTypes->id == 1)
                                                                        <span class="badge bg-warning">{{ $sale->stateTypes->state_name }}</span>
                                                                    @elseif($sale->stateTypes->id == 2)
                                                                        <span class="badge bg-success">{{ $sale->stateTypes->state_name }}</span>
                                                                    @else
                                                                        <span class="badge bg-danger">{{ $sale->stateTypes->state_name }}</span>
                                                                    @endif
                                                                @else
                                                                    <span class="badge bg-secondary">N/A</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <small>{{ $sale->payment_method->name ?? 'N/A' }}</small>
                                                            </td>
                                                            <td>
                                                                <strong class="text-success">
                                                                    ${{ number_format($sale->total_sale ?? 0, 0, ',', '.') }}
                                                                    <small class="text-muted">{{ $sale->currencies->currency_name ?? '' }}</small>
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('admin/sales/show/' . $sale->id) }}" 
                                                                   class="btn btn-sm btn-outline-success" 
                                                                   title="Ver detalles">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if(count($person->sales) >= 10)
                                            <div class="text-center mt-3">
                                                <a href="{{ url('admin/sales?customer_id=' . $person->id) }}" 
                                                   class="btn btn-outline-success">
                                                    <i class="fas fa-list"></i> Ver todas las ventas
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Resumen de Transacciones -->
                            @if(($person->purchases && count($person->purchases) > 0) || ($person->sales && count($person->sales) > 0))
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-chart-bar text-info"></i> 
                                                Resumen de Transacciones
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @if($person->type_third_id == 2 && $person->purchases)
                                                <div class="col-md-6">
                                                    <div class="text-center">
                                                        <h4 class="text-primary">{{ count($person->purchases) }}</h4>
                                                        <p class="mb-0">Compras Registradas</p>
                                                        <small class="text-muted">Total: ${{ number_format($person->purchases->sum('total_purchase'), 0, ',', '.') }}</small>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($person->type_third_id == 1 && $person->sales)
                                                <div class="col-md-6">
                                                    <div class="text-center">
                                                        <h4 class="text-success">{{ count($person->sales) }}</h4>
                                                        <p class="mb-0">Ventas Registradas</p>
                                                        <small class="text-muted">Total: ${{ number_format($person->sales->sum('total_sale'), 0, ',', '.') }}</small>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){
    function formatCurrency(value) {
        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' }).format(value);
    }
});
</script>
@endsection
