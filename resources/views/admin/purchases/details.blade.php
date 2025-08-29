@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detalles de Factura de Compra</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{url('admin/purchase/list')}}">Facturas de Compras</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Detalles de Factura
                        </li>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Factura #{{ $purchase->invoice_no }}</h4>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('admin/purchase/list') }}" class="btn btn-secondary float-end ms-2">
                                        <i class="fas fa-arrow-left"></i> Volver
                                    </a>
                                    {{-- <button class="btn btn-primary float-end" onclick="window.print()">
                                        <i class="fas fa-print"></i> Imprimir
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Información de la Factura</h5>
                                    <p><strong>Número de Factura:</strong> {{ $purchase->invoice_no }}</p>
                                    <p><strong>Fecha de Emisión:</strong> {{ $purchase->date_of_issue }}</p>
                                    <p><strong>Fecha de Vencimiento:</strong> {{ $purchase->date_of_due }}</p>
                                    <p><strong>Estado:</strong> {{ $purchase->state_type->description }}</p>
                                    <p><strong>Forma de Pago:</strong> {{ $purchase->payment_types->payment_type }}</p>
                                    <p><strong>Método de Pago:</strong> {{ $purchase->payment_method->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Información del Proveedor</h5>
                                    <p><strong>Proveedor:</strong> {{ $purchase->suppliers->company_name }}</p>
                                    <p><strong>RUC/NIT:</strong> {{ $purchase->suppliers->identification_number }}</p>
                                    <p><strong>Dirección:</strong> {{ $purchase->suppliers->address }}</p>
                                    <p><strong>Teléfono:</strong> {{ $purchase->suppliers->phone }}</p>
                                    <p><strong>Email:</strong> {{ $purchase->suppliers->email }}</p>
                                </div>
                            </div>

                            @if(isset($accountsPayable))
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="alert {{ $accountsPayable->balance <= 0 ? 'alert-success' : 'alert-warning' }}">
                                        <h5>Estado de Cuenta</h5>
                                        <p><strong>Estado:</strong> {{ $accountsPayable->account_states->name }}</p>
                                        <p><strong>Monto Total:</strong> {{ number_format($accountsPayable->total_amount, 2) }}</p>
                                        <p><strong>Saldo Pendiente:</strong> {{ number_format($accountsPayable->balance, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Detalle de Productos</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Descuento %</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($purchase->purchase_items as $item)
                                                <tr>
                                                    <td>{{ $item->item->product_name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->cost_price, 2) }}</td>
                                                    <td>{{ $item->discount_percent }}%</td>
                                                    <td>{{ number_format($item->quantity * $item->cost_price * (1 - $item->discount_percent/100), 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6 offset-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Subtotal:</th>
                                            <td class="text-end">{{ number_format($purchase->total_subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>IVA:</th>
                                            <td class="text-end">{{ number_format($purchase->total_tax, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Descuento:</th>
                                            <td class="text-end">{{ number_format($purchase->total_discount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td class="text-end"><strong>{{ number_format($purchase->total_purchase, 2) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($purchase->observations)
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Observaciones</h5>
                                    <div class="p-3 bg-light">
                                        {{ $purchase->observations }}
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