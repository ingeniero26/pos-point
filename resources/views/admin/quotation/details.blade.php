@extends('layouts.app')
@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Detalles de Cotización</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.quotation.list') }}">Cotizaciones</a></li>
                        <li class="breadcrumb-item active">Detalles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content-body">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información General</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Número de Cotización:</label>
                                <p class="form-control-plaintext">{{ $quotation->number }}</p>
                            </div>
                            <div class="form-group">
                                <label>Fecha de Emisión:</label>
                                <p class="form-control-plaintext">{{ $quotation->date_of_issue }}</p>
                            </div>
                            <div class="form-group">
                                <label>Fecha de Expiración:</label>
                                <p class="form-control-plaintext">{{ $quotation->date_of_expiration }}</p>
                            </div>
                            <div class="form-group">
                                <label>Estado:</label>
                                <p class="form-control-plaintext">{{ $quotation->statusQuotation->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cliente:</label>
                                <p class="form-control-plaintext">{{ $quotation->customer->name }}</p>
                            </div>
                            <div class="form-group">
                                <label>Almacén:</label>
                                <p class="form-control-plaintext">{{ $quotation->warehouse->name }}</p>
                            </div>
                            <div class="form-group">
                                <label>Moneda:</label>
                                <p class="form-control-plaintext">{{ $quotation->currency->name }}</p>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Pago:</label>
                                <p class="form-control-plaintext">{{ $quotation->paymentForm->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de Productos</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotation->quotation_items as $item)
                                <tr>
                                    <td>{{ $item->item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->item->measure->name }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ number_format($item->discount, 2) }}</td>
                                    <td>{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Totales</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Subtotal:</label>
                                <p class="form-control-plaintext">{{ number_format($quotation->subtotal, 2) }}</p>
                            </div>
                            <div class="form-group">
                                <label>Descuento Total:</label>
                                <p class="form-control-plaintext">{{ number_format($quotation->total_discount, 2) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Impuesto Total:</label>
                                <p class="form-control-plaintext">{{ number_format($quotation->total_tax, 2) }}</p>
                            </div>
                            <div class="form-group">
                                <label>Total:</label>
                                <p class="form-control-plaintext">{{ number_format($quotation->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Agregar funcionalidad para imprimir
        $('#btn-print').on('click', function() {
            window.print();
        });

        // Agregar funcionalidad para enviar por correo
        $('#btn-email').on('click', function() {
            window.location.href = '{{ route("admin.quotation.send-email", $quotation->id) }}';
        });
    });
</script>
@endsection