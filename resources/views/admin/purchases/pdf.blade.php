<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Compra #{{ $purchase->invoice_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .info-value {
            flex: 1;
        }
        .col-6 {
            width: 50%;
            float: left;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .status-paid {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: red;
            font-weight: bold;
        }
        .status-partial {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($purchase->company && $purchase->company->logo)
                <img src="{{ public_path($purchase->company->logo) }}" alt="Logo" class="logo">
            @endif
            <div class="title">FACTURA DE COMPRA</div>
            <div class="subtitle">{{ $purchase->company ? $purchase->company->name : 'Empresa' }}</div>
            <div>{{ $purchase->company ? $purchase->company->address : '' }}</div>
            <div>Tel: {{ $purchase->company ? $purchase->company->phone : '' }}</div>
        </div>

        <div class="info-section clearfix">
            <div class="col-6">
                <h4>Información de la Factura</h4>
                <div><strong>Factura No:</strong> {{ $purchase->invoice_no }}</div>
                <div><strong>Fecha de Emisión:</strong> {{ date('d/m/Y', strtotime($purchase->date_of_issue)) }}</div>
                <div><strong>Fecha de Vencimiento:</strong> {{ date('d/m/Y', strtotime($purchase->date_of_due)) }}</div>
                <div><strong>Estado:</strong> {{ $purchase->state_type->description }}</div>
                <div><strong>Forma de Pago:</strong> {{ $purchase->payment_types->payment_type }}</div>
                <div><strong>Método de Pago:</strong> {{ $purchase->payment_method->name }}</div>
                <div><strong>Bodega:</strong> {{ $purchase->warehouses->warehouse_name }}</div>
            </div>
            
            <div class="col-6">
                <h4>Información del Proveedor</h4>
                <div><strong>Proveedor:</strong> {{ $purchase->suppliers->company_name }}</div>
                <div><strong>RUC/NIT:</strong> {{ $purchase->suppliers->identification_number }}</div>
                <div><strong>Dirección:</strong> {{ $purchase->suppliers->address }}</div>
                <div><strong>Teléfono:</strong> {{ $purchase->suppliers->phone }}</div>
                <div><strong>Email:</strong> {{ $purchase->suppliers->email }}</div>
            </div>
        </div>

        @if(isset($accountsPayable))
        <div class="info-section">
            <h4>Estado de Cuenta</h4>
            <div class="clearfix">
                <div class="col-6">
                    <div><strong>Estado:</strong> 
                        @if($accountsPayable->balance <= 0)
                            <span class="status-paid">PAGADO</span>
                        @elseif($accountsPayable->balance < $accountsPayable->total_amount)
                            <span class="status-partial">PAGO PARCIAL</span>
                        @else
                            <span class="status-pending">PENDIENTE</span>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div><strong>Monto Total:</strong> {{ number_format($accountsPayable->total_amount, 2) }}</div>
                    <div><strong>Saldo Pendiente:</strong> {{ number_format($accountsPayable->balance, 2) }}</div>
                </div>
            </div>
        </div>
        @endif

        <div class="info-section">
            <h4>Detalle de Productos</h4>
            <table>
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
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->cost_price, 2) }}</td>
                        <td class="text-center">{{ $item->discount_percent }}%</td>
                        <td class="text-right">{{ number_format($item->quantity * $item->cost_price * (1 - $item->discount_percent/100), 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="info-section">
            <div style="width: 50%; float: right;">
                <table>
                    <tr>
                        <th>Subtotal:</th>
                        <td class="text-right">{{ number_format($purchase->total_subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th>IVA:</th>
                        <td class="text-right">{{ number_format($purchase->total_tax, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Descuento:</th>
                        <td class="text-right">{{ number_format($purchase->total_discount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td class="text-right"><strong>{{ number_format($purchase->total_purchase, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
            <div style="clear: both;"></div>
        </div>

        @if($purchase->observations)
        <div class="info-section">
            <h4>Observaciones</h4>
            <div style="border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9;">
                {{ $purchase->observations }}
            </div>
        </div>
        @endif

        <div class="footer">
            <p>Documento generado el {{ date('d/m/Y H:i:s') }}</p>
            <p>Este documento es un comprobante de la factura de compra y no tiene validez fiscal.</p>
            <p>Generado por: {{ $purchase->users->name }}</p>
        </div>
    </div>
</body>
</html>