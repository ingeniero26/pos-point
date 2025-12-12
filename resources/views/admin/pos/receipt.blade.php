<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Venta #{{ $sale->invoice_no }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 10px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .receipt-container {
            max-width: 320px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .receipt-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }
        
        .receipt {
            padding: 20px;
            background: #ffffff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px dashed #e2e8f0;
            position: relative;
        }
        
        .logo {
            max-width: 80px;
            height: auto;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .company-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #1a202c;
            letter-spacing: -0.5px;
        }
        
        .company-details {
            font-size: 10px;
            color: #718096;
            line-height: 1.6;
            margin-bottom: 0;
        }
        
        .receipt-title {
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 16px;
            margin: 15px -5px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .info-section {
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 3px solid #667eea;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
            font-size: 10px;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #4a5568;
            min-width: 80px;
        }
        
        .info-value {
            color: #2d3748;
            font-weight: 500;
            text-align: right;
            flex: 1;
        }
        
        .items-section {
            margin: 15px 0;
        }
        
        .items {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .items thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .items th {
            padding: 10px 8px;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .items tbody tr:hover {
            background-color: #f8fafc;
        }
        
        .items tbody tr:last-child td {
            border-bottom: none;
        }
        
        .item-name {
            width: 45%;
            font-weight: 500;
            color: #2d3748;
        }
        
        .item-quantity {
            width: 15%;
            text-align: center;
            font-weight: 600;
            color: #667eea;
        }
        
        .item-price, .item-total {
            width: 20%;
            text-align: right;
            font-weight: 500;
            color: #2d3748;
        }
        
        .item-tax {
            font-size: 8px;
            color: #718096;
            font-style: italic;
            padding: 4px 8px !important;
            background: #f8fafc;
        }
        
        .no-items {
            text-align: center;
            padding: 20px;
            color: #718096;
            font-style: italic;
        }
        
        .totals {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px dashed #e2e8f0;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            font-size: 11px;
        }
        
        .total-row:last-child {
            margin-bottom: 0;
        }
        
        .total-label {
            font-weight: 500;
            color: #4a5568;
        }
        
        .total-value {
            font-weight: 600;
            color: #2d3748;
        }
        
        .grand-total {
            font-weight: 700;
            font-size: 16px;
            color: #1a202c;
            border-top: 2px solid #667eea;
            padding-top: 10px;
            margin-top: 10px;
            background: white;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .tax-summary {
            margin: 10px 0;
            padding: 8px;
            background: white;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        
        .tax-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 10px;
            color: #718096;
        }
        
        .tax-row:last-child {
            margin-bottom: 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #e2e8f0;
            font-size: 9px;
            color: #718096;
        }
        
        .footer p {
            margin: 5px 0;
            line-height: 1.4;
        }
        
        .footer .thank-you {
            font-weight: 600;
            color: #667eea;
            font-size: 11px;
        }
        
        .qr-section {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 6px;
        }
        
        .timestamp {
            font-size: 8px;
            color: #a0aec0;
            margin-top: 10px;
            text-align: center;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .receipt-container {
                box-shadow: none;
                border-radius: 0;
                max-width: 80mm;
            }
            
            .receipt {
                padding: 10px;
            }
            
            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
        
        @media (max-width: 480px) {
            .receipt-container {
                margin: 10px;
                max-width: calc(100% - 20px);
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt">
            <div class="header">
                @if($sale->company && $sale->company->logo)
                    <img src="{{ asset('storage/' . $sale->company->logo) }}" alt="Logo" class="logo">
                @endif
                <div class="company-name">{{ $sale->company->name ?? 'Empresa' }}</div>
                <div class="company-details">
                    @if($sale->company->identification_number)
                        <strong>NIT:</strong> {{ $sale->company->identification_number }}<br>
                    @endif
                    @if($sale->company->address)
                        <strong>Dirección:</strong> {{ $sale->company->address }}<br>
                    @endif
                    @if($sale->company->phone)
                        <strong>Teléfono:</strong> {{ $sale->company->phone }}
                    @endif
                </div>
            </div>

            <div class="receipt-title">Recibo #{{ $sale->invoice_no }}</div>

            <div class="info-section">
                <div class="info-row">
                    <span class="info-label">📅 Fecha:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($sale->date_of_issue)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">👤 Cliente:</span>
                    <span class="info-value">{{ $sale->customers->name ?? 'Cliente General' }}</span>
                </div>
                @if($sale->customers && $sale->customers->identification_number)
                <div class="info-row">
                    <span class="info-label">🆔 ID:</span>
                    <span class="info-value">{{ $sale->customers->identification_number }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">👨‍💼 Vendedor:</span>
                    <span class="info-value">{{ $sale->users->name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">💳 Pago:</span>
                    <span class="info-value">{{ $sale->payment_method->name ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="items-section">
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
                            $taxSummary[$taxRate] += $item->tax_amount ?? 0;
                        @endphp
                        <tr>
                            <td class="item-name">{{ $item->item->product_name ?? 'Producto' }}</td>
                            <td class="item-quantity">{{ number_format($item->quantity) }}</td>
                            <td class="item-price">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="item-total">${{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @if($item->tax_amount > 0)
                        <tr>
                            <td colspan="4" class="item-tax">
                                💰 IVA {{ $taxRate }}%: ${{ number_format($item->tax_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="no-items">
                                📦 No hay productos en esta venta
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="totals">
                <div class="total-row">
                    <span class="total-label">💵 Subtotal:</span>
                    <span class="total-value">${{ number_format($sale->total_subtotal ?? 0, 0, ',', '.') }}</span>
                </div>
                
                @if($taxSummary && count($taxSummary) > 0)
                <div class="tax-summary">
                    @foreach($taxSummary as $rate => $amount)
                    @if($amount > 0)
                    <div class="tax-row">
                        <span>🏛️ IVA {{ $rate }}%:</span>
                        <span>${{ number_format($amount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif

                @if($sale->total_discount > 0)
                <div class="total-row">
                    <span class="total-label">🎯 Descuento:</span>
                    <span class="total-value">-${{ number_format($sale->total_discount, 0, ',', '.') }}</span>
                </div>
                @endif
                
                <div class="total-row grand-total">
                    <span>💰 TOTAL A PAGAR:</span>
                    <span>${{ number_format($sale->total_sale ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($sale->observations)
            <div class="info-section">
                <div class="info-row">
                    <span class="info-label">📝 Observaciones:</span>
                </div>
                <div style="margin-top: 5px; font-size: 10px; color: #4a5568;">
                    {{ $sale->observations }}
                </div>
            </div>
            @endif

            <div class="footer">
                <p class="thank-you">🎉 ¡Gracias por su compra!</p>
                <p>Este documento no es una factura oficial.</p>
                <p>Conserve este recibo para cualquier reclamo.</p>
                
                <div class="timestamp">
                    🕒 Generado el {{ now()->format('d/m/Y H:i:s') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>