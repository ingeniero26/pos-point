<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Venta #{{ $sale->invoice_no }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        .receipt {
            width: 80mm;
            margin: 0 auto;
            padding: 5mm;
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 5mm;
            border-bottom: 2px dashed #000;
            padding-bottom: 5mm;
        }
        .logo {
            max-width: 60mm;
            height: auto;
            margin-bottom: 2mm;
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 1mm;
            color: #000;
        }
        .company-details {
            font-size: 10px;
            margin-bottom: 3mm;
            color: #666;
        }
        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            border-top: 2px dashed #000;
            border-bottom: 2px dashed #000;
            padding: 2mm 0;
            margin: 3mm 0;
            color: #000;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
            font-size: 11px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin: 3mm 0;
            font-size: 11px;
        }
        .items th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding-bottom: 1mm;
            font-weight: bold;
            color: #000;
        }
        .items td {
            padding: 1mm 0;
            border-bottom: 1px dotted #ccc;
        }
        .item-name {
            width: 40%;
        }
        .item-quantity {
            width: 15%;
            text-align: center;
        }
        .item-price {
            width: 20%;
            text-align: right;
        }
        .item-total {
            width: 25%;
            text-align: right;
        }
        .item-tax {
            font-size: 9px;
            color: #666;
            text-align: right;
        }
        .totals {
            margin-top: 3mm;
            border-top: 2px dashed #000;
            padding-top: 3mm;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
            font-size: 11px;
        }
        .total-label {
            font-weight: bold;
            color: #666;
        }
        .grand-total {
            font-weight: bold;
            font-size: 14px;
            color: #000;
            border-top: 1px solid #000;
            padding-top: 1mm;
            margin-top: 1mm;
        }
        .footer {
            text-align: center;
            margin-top: 5mm;
            border-top: 2px dashed #000;
            padding-top: 3mm;
            font-size: 10px;
            color: #666;
        }
        .tax-summary {
            margin-top: 2mm;
            font-size: 10px;
            color: #666;
        }
        .tax-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5mm;
        }
        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }
            body {
                width: 80mm;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            @if($sale->company && $sale->company->logo)
                <img src="{{ asset('storage/' . $sale->company->logo) }}" alt="Logo" class="logo">
            @endif
            <div class="company-name">{{ $sale->company->name ?? 'Empresa' }}</div>
            <div class="company-details">
                NIT: {{ $sale->company->identification_number ?? '' }}<br>
                {{ $sale->company->address ?? '' }}<br>
                Tel: {{ $sale->company->phone ?? '' }}
            </div>
        </div>

        <div class="receipt-title">RECIBO DE VENTA #{{ $sale->invoice_no }}</div>

        <div class="info-row">
            <span class="info-label">Fecha:</span>
            <span>{{ \Carbon\Carbon::parse($sale->date_of_issue)->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Cliente:</span>
            <span>{{ $sale->customers->name ?? 'Cliente General' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Identificación:</span>
            <span>{{ $sale->customers->identification_number ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Vendedor:</span>
            <span>{{ $sale->users->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Método de Pago:</span>
            <span>{{ $sale->payment_method->name ?? 'N/A' }}</span>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th class="item-name">Producto</th>
                    <th class="item-quantity">Cant.</th>
                    <th class="item-price">Precio</th>
                    <th class="item-total">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $taxSummary = [];
                @endphp
                @if($sale->invoiceItems && count($sale->invoiceItems) > 0)
                @foreach($sale->invoiceItems as $item)
                @php
                    $taxRate = $item->tax_rate ?? 0;
                    if (!isset($taxSummary[$taxRate])) {
                        $taxSummary[$taxRate] = 0;
                    }
                    $taxSummary[$taxRate] += $item->tax_amount;
                @endphp
                <tr>
                    <td class="item-name">{{ $item->item->product_name ?? 'Producto' }}</td>
                    <td class="item-quantity">{{ $item->quantity }}</td>
                    <td class="item-price">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="item-total">${{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="item-tax">
                        IVA {{ $taxRate }}%: ${{ number_format($item->tax_amount, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="4" style="text-align: center; padding: 10px;">No hay productos en esta venta</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span class="total-label">Subtotal:</span>
                <span>${{ number_format($sale->total_subtotal, 0, ',', '.') }}</span>
            </div>
            
            <div class="tax-summary">
                @if($taxSummary && count($taxSummary) > 0)
                @foreach($taxSummary as $rate => $amount)
                <div class="tax-row">
                    <span>IVA {{ $rate }}%:</span>
                    <span>${{ number_format($amount, 0, ',', '.') }}</span>
                </div>
                @endforeach
                @endif
            </div>

            @if($sale->total_discount > 0)
            <div class="total-row">
                <span class="total-label">Descuento:</span>
                <span>${{ number_format($sale->total_discount, 0, ',', '.') }}</span>
            </div>
            @endif
            
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>${{ number_format($sale->total_sale, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <p>¡Gracias por su compra!</p>
            <p>Este documento no es una factura oficial.</p>
            <p>{{ $sale->observations ?? '' }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>