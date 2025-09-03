<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura de Venta #{{ $sale->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .logo {
            max-height: 80px;
            max-width: 200px;
        }
        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .invoice-number {
            font-size: 16px;
            color: #7f8c8d;
        }
        .company-details, .customer-details {
            margin-top: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .details-row {
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            width: 120px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #f9f9f9;
            border-bottom: 2px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            width: 350px;
            float: right;
            margin-top: 20px;
        }
        .total-row {
            padding: 5px 0;
        }
        .grand-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #ddd;
            padding-top: 5px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            text-align: center;
            color: #7f8c8d;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-1 { background-color: #e0e0e0; color: #333; } /* Registrado */
        .status-2 { background-color: #b3e0ff; color: #0066cc; } /* Enviado */
        .status-3 { background-color: #c8e6c9; color: #2e7d32; } /* Aceptado */
        .status-4 { background-color: #fff9c4; color: #ff8f00; } /* Observado */
        .status-5 { background-color: #ffcdd2; color: #c62828; } /* Rechazado */
        .status-6 { background-color: #d1c4e9; color: #4527a0; } /* Anulado */
        .status-7 { background-color: #f5f5f5; color: #616161; } /* Por Anular */
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        .col-6 {
            width: 50%;
            float: left;
        }
        .payment-info {
            margin-top: 30px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .notes {
            margin-top: 30px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="col-6">
            @if(isset($sale->company) && $sale->company->logo)
                <img src="{{ public_path($sale->company->logo) }}" class="logo">
            @else
                <div class="invoice-title">EMPRESA</div>
            @endif
            <div>
                @if(isset($sale->company))
                    <div><strong>{{ $sale->company->name }}</strong></div>
                    <div>{{ $sale->company->address }}</div>
                    <div>Tel: {{ $sale->company->phone }}</div>
                    <div>{{ $sale->company->email }}</div>
                    <div>NIT: {{ $sale->company->identification_number }}</div>
                    {{-- <div>Resolución DIAN: {{ $sale->company->dian_resolution }}</div>
                    <div>Fecha Inicio DIAN: {{ $sale->company->date_from }}</div>
                    <div>Fecha Fin DIAN: {{ $sale->company->date_to }}</div>
                    <div>Consecutivo: {{ $sale->company->getNextConsecutive() }}</div> --}}
                    

                @endif
            </div>
        </div>
        <div class="col-6 text-right">
            <div class="invoice-title">FACTURA DE VENTA</div>
            <div class="invoice-number">
                @if($sale->series && $sale->number)
                    {{ $sale->series }}-{{ $sale->number }}
                @else
                    #{{ $sale->id }}
                @endif
            </div>
            <div>
                <span class="status-badge status-{{ $sale->state_type_id }}">
                    {{ $sale->stateTypes ? $sale->stateTypes->description : 'N/A' }}
                </span>
            </div>
            <div>Fecha: {{ date('d/m/Y', strtotime($sale->date_of_issue)) }}</div>
            <div>Hora: {{ $sale->time_of_issue }}</div>
        </div>
    </div>

    <div class="clearfix">
        <div class="col-6 customer-details">
            <div class="section-title">CLIENTE</div>
            <div class="details-row">
                <span class="label">Nombre:</span> 
                {{ $sale->customers ? $sale->customers->name : 'N/A' }}
            </div>
            <div class="details-row">
                <span class="label">Identificación:</span> 
                @if($sale->customers && $sale->customers->identification_type)
                    {{ $sale->customers->identification_type->identification_name }}: 
                    {{ $sale->customers->identification_number }}
                @else
                    N/A
                @endif
            </div>
            <div class="details-row">
                <span class="label">Dirección:</span> 
                {{ $sale->customers ? $sale->customers->address : 'N/A' }}
            </div>
            <div class="details-row">
                <span class="label">Teléfono:</span> 
                {{ $sale->customers ? $sale->customers->phone : 'N/A' }}
            </div>
            <div class="details-row">
                <span class="label">Email:</span> 
                {{ $sale->customers ? $sale->customers->email : 'N/A' }}
            </div>
        </div>
        
        <div class="col-6 company-details">
            <div class="section-title">DETALLES DE LA VENTA</div>
            <div class="details-row">
                <span class="label">Vendedor:</span> 
                {{ $sale->users ? $sale->users->name : 'N/A' }}
            </div>
            <div class="details-row">
                <span class="label">Almacén:</span> 
                {{ $sale->warehouses ? $sale->warehouses->warehouse_name : 'N/A' }}
            </div>
            <div class="details-row">
                <span class="label">Tipo de Documento:</span> 
                {{ $sale->voucherTypes ? $sale->voucherTypes->voucher_name : 'N/A' }}
            </div>
            <div class="details-row">
                <span class="label">Forma de Pago:</span> 
                {{ $sale->paymentForm ? $sale->paymentForm->payment_type : 'N/A' }}
            </div>
            <div class="details-row">
                <span class="label">Método de Pago:</span> 
                {{ $sale->payment_method ? $sale->payment_method->name : 'N/A' }}
            </div>
            <div class="details-row">
                <span class="label">Fecha de Vencimiento:</span> 
                {{ date('d/m/Y', strtotime($sale->date_of_due)) }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">Código</th>
                <th width="40%">Producto</th>
                <th width="10%">Cantidad</th>
                <th width="15%">Precio Unit.</th>
                <th width="10%">Descuento</th>
                <th width="10%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $counter = 1; @endphp
            @foreach($sale->invoiceItems as $item)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $item->item ? ($item->item->internal_code ?? $item->item->barcode) : 'N/A' }}</td>
                    <td>{{ $item->item ? $item->item->product_name : 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->discount, 2, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix">
        <div class="col-6">
            <div class="payment-info">
                <div class="section-title">INFORMACIÓN DE PAGO</div>
                <div class="details-row">
                    <span class="label">Moneda:</span> 
                    {{ $sale->currencies ? $sale->currencies->currency_name : 'COP' }}
                </div>
                <div class="details-row">
                    <span class="label">Estado de Entrega:</span> 
                    {{ $sale->delivery_status }}
                </div>
                <div class="details-row">
                    <span class="label">Método de Envío:</span> 
                    {{ $sale->shipping_method }}
                </div>
            </div>

            @if($sale->observations)
            <div class="notes">
                <div class="section-title">OBSERVACIONES</div>
                <p>{{ $sale->observations }}</p>
            </div>
            @endif
        </div>
        
        <div class="totals">
            <div class="total-row">
                <span class="label">Subtotal:</span> 
                <span class="text-right">{{ number_format($sale->total_subtotal, 2, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span class="label">IVA:</span> 
                <span class="text-right">{{ number_format($sale->total_tax, 2, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span class="label">Descuento:</span> 
                <span class="text-right">{{ number_format($sale->total_discount, 2, ',', '.') }}</span>
            </div>
            <div class="total-row grand-total">
                <span class="label">TOTAL:</span> 
                <span class="text-right">{{ number_format($sale->total_sale, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Gracias por su compra. Este documento es una representación impresa de su factura.</p>
        <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>