@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mis Ventas</h3>
                    <div class="card-tools">
                        <a href="{{ route('user.sales.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nueva Venta
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->customers->name ?? 'N/A' }}</td>
                                    <td>{{ $sale->date_of_issue }}</td>
                                    <td>${{ number_format($sale->total_amount, 2) }}</td>
                                    <td>
                                        @if($sale->state_type_id == 1)
                                            <span class="badge badge-success">Activo</span>
                                        @else
                                            <span class="badge badge-danger">Anulado</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.sales.show', $sale->id) }}" class="btn btn-info btn-sm">
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
</div>
@endsection 