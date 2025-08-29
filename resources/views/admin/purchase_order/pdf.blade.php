<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orden de Compra {{ $purchaseOrder->prefix }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .logo {
            max-height: 80px;
            max-width: 200px;
        }
        .company-info {
            float: right;
            text-align: right;
        }
        .document-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            color: #2c3e50;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
            color: #2c3e50;
        }
        .info-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 8px;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .total-row {
            padding: 5px 0;
        }
        .total-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .grand-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #333;
            padding-top: 5px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #ffeeba;
            color: #856404;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-received {
            background-color: #cce5ff;
            color: #004085;
        }
        .page-break {
            page-break-after: always;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="company-info">
            <h2>POS POINT</h2>
            <p>NIT: 900.123.456-7</p>
            <p>Dirección: Calle Principal #123</p>
            <p>Teléfono: (601) 123-4567</p>
            <p>Email: info@pospoint.com</p>
        </div>
        <div>
            <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        </div>
    </div>

    <div class="document-title">
        ORDEN DE COMPRA {{ $purchaseOrder->prefix }}
        <div style="float: right;">
            @php
                $statusClass = 'status-pending';
                if($purchaseOrder->status_order->id == 2) {
                    $statusClass = 'status-approved';
                } elseif($purchaseOrder->status_order->id == 3) {
                    $statusClass = 'status-cancelled';
                } elseif($purchaseOrder->status_order->id == 4) {
                    $statusClass = 'status-received';
                }
            @endphp
            <span class="status-badge {{ $statusClass }}">{{ $purchaseOrder->status_order->name }}</span>
        </div>
    </div>

    <div class="section">
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Proveedor:</span>
                <span>{{ $purchaseOrder->suppliers->company_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">NIT/Documento:</span>
                <span>{{ $purchaseOrder->suppliers->identification_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Dirección:</span>
                <span>{{ $purchaseOrder->suppliers->address }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Teléfono:</span>
                <span>{{ $purchaseOrder->suppliers->phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span>{{ $purchaseOrder->suppliers->email }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Fecha de Emisión:</span>
                <span>{{ date('d/m/Y', strtotime($purchaseOrder->date)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Entrega:</span>
                <span>{{ date('d/m/Y', strtotime($purchaseOrder->delivery_date)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Bodega:</span>
                <span>{{ $purchaseOrder->warehouses->warehouse_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Creado por:</span>
                <span>{{ $purchaseOrder->users->name }}</span>
            </div>
        </div>
    </div>

    @if($purchaseOrder->notes)
    <div class="section">
        <div class="section-title">Notas</div>
        <div class="info-box">
            {{ $purchaseOrder->notes }}
        </div>
    </div>
    @endif

    <div class="section">
        <div class="section-title">Productos</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="40%">Producto</th>
                    <th width="10%">Unidad</th>
                    <th width="10%" class="text-center">Cantidad</th>
                    <th width="15%" class="text-right">Precio</th>
                    <th width="5%" class="text-center">IVA</th>
                    <th width="15%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->purchase_order_items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->items->product_name }}</td>
                    <td>{{ $item->items->measure->measure_name }}</td>
                    <td class="text-center">{{ number_format($item->quantity, 0) }}</td>
                    <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->tax_rate }}%</td>
                    <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="clearfix">
        <div class="totals">
            <div class="total-row">
                <span class="total-label">Subtotal:</span>
                <span class="text-right">{{ number_format($purchaseOrder->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span class="total-label">IVA:</span>
                <span class="text-right">{{ number_format($purchaseOrder->tax_amount, 0, ',', '.') }}</span>
            </div>
            <div class="total-row grand-total">
                <span class="total-label">TOTAL:</span>
                <span class="text-right">{{ number_format($purchaseOrder->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div style="clear: both; margin-top: 100px;">
        <div style="float: left; width: 45%; text-align: center; border-top: 1px solid #ddd; padding-top: 10px;">
            Firma Autorizada
        </div>
        <div style="float: right; width: 45%; text-align: center; border-top: 1px solid #ddd; padding-top: 10px;">
            Firma Proveedor
        </div>
    </div>

    <div class="footer">
        <p>Documento generado el {{ date('d/m/Y H:i:s') }}</p>
        <p>Esta orden de compra está sujeta a los términos y condiciones acordados con el proveedor.</p>
    </div>
</body>
</html>