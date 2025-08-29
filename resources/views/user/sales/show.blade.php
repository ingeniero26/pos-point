@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de la Venta #{{ $sale->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('user.sales.list') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Información del Cliente</h5>
                            <table class="table">
                                <tr>
                                    <th>Nombre:</th>
                                    <td>{{ $sale->customers->name }}</td>
                                </tr>
                                <tr>
                                    <th>Documento:</th>
                                    <td>{{ $sale->customers->identification_number }}</td>
                                </tr>
                                <tr>
                                    <th>Dirección:</th>
                                    <td>{{ $sale->customers->address }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Información de la Venta</h5>
                            <table class="table">
                                <tr>
                                    <th>Fecha:</th>
                                    <td>{{ $sale->date_of_issue }}</td>
                                </tr>
                                <tr>
                                    <th>Forma de Pago:</th>
                                    <td>{{ $sale->paymentForm->name }}</td>
                                </tr>
                                <tr>
                                    <th>Método de Pago:</th>
                                    <td>{{ $sale->payment_method->name }}</td>
                                </tr>
                                <tr>
                                    <th>Almacén:</th>
                                    <td>{{ $sale->warehouses->name }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Productos</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sale->sales_items as $item)
                                        <tr>
                                            <td>{{ $item->item->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format($item->unit_price, 2) }}</td>
                                            <td>${{ number_format($item->discount, 2) }}</td>
                                            <td>${{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-right">Subtotal:</th>
                                            <td>${{ number_format($sale->total_subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">IVA:</th>
                                            <td>${{ number_format($sale->total_tax, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-right">Total:</th>
                                            <td>${{ number_format($sale->total_amount, 2) }}</td>
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
@endsection 