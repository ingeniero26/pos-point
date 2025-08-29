<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cotización {{ $quotation->number }}</title>
    <style>
        @font-face {
            font-family: 'Roboto';
            src: url('{{ asset('fonts/Roboto-Regular.ttf') }}') format('truetype');
            font-weight: normal;
        }
        @font-face {
            font-family: 'Roboto';
            src: url('{{ asset('fonts/Roboto-Bold.ttf') }}') format('truetype');
            font-weight: bold;
        }
        body {
            font-family: 'Roboto', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #2c3e50;
            margin: 0;
            padding: 40px;
            background-color: #fff;
        }
        .header {
            padding: 25px 0;
            border-bottom: 3px solid #3498db;
            margin-bottom: 35px;
            position: relative;
        }
        .company-info {
            float: left;
            width: 60%;
            font-size: 12px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        .company-info h2 {
            font-size: 20px;
            color: #3498db;
            margin: 0 0 15px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .document-info {
            float: right;
            width: 35%;
            text-align: right;
            font-size: 12px;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 8px;
            border: 2px solid #3498db;
        }
        .document-info h1 {
            font-size: 26px;
            color: #3498db;
            margin: 0 0 15px 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .document-info h3 {
            font-size: 18px;
            color: #2c3e50;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        .clear {
            clear: both;
            margin-bottom: 30px;
        }
        .customer-info {
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 35px;
            border: 2px solid #3498db;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .customer-info h3 {
            color: #3498db;
            margin: 0 0 20px 0;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
        }
        .customer-info p {
            margin: 8px 0;
            color: #2c3e50;
            font-size: 12px;
        }
        .customer-info strong {
            color: #34495e;
            font-weight: bold;
            min-width: 120px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            font-size: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        table th {
            background-color: #3498db;
            color: #ffffff;
            font-weight: bold;
            padding: 14px;
            border: 1px solid #2980b9;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }
        table td {
            padding: 12px;
            border: 1px solid #e9ecef;
            background-color: #ffffff;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            width: 45%;
            float: right;
            margin-top: 30px;
            font-size: 12px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .totals table {
            width: 100%;
            background-color: #ffffff;
            border-radius: 6px;
            overflow: hidden;
        }
        .totals th {
            text-align: left;
            color: #34495e;
            font-weight: bold;
            padding: 12px;
            border: 1px solid #e9ecef;
            background-color: #f8f9fa;
            width: 60%;
        }
        .totals td {
            text-align: right;
            padding: 12px;
            border: 1px solid #e9ecef;
            color: #2c3e50;
            font-weight: bold;
        }
        .totals tr:last-child th {
            color: #2c3e50;
            font-size: 14px;
        }
        .totals tr:last-child td {
            color: #2c3e50;
            font-size: 14px;
        }
        .terms {
            margin-top: 35px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .terms h4 {
            color: #2c3e50;
            margin: 0 0 15px 0;
            font-size: 12px;
        }
        .terms p {
            margin: 5px 0;
            font-size: 10px;
        }
        .signature {
            margin-top: 60px;
            padding: 30px;
            border-top: 2px dashed #3498db;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .signature h4 {
            margin: 0 0 15px 0;
            font-size: 14px;
            color: #3498db;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .signature-line {
            width: 200px;
            margin: 20px auto 10px;
            border-bottom: 2px solid #3498db;
        }
        .signature-name {
            font-size: 12px;
            color: #34495e;
            margin-top: 10px;
            font-weight: bold;
        }
        .footer {
            position: relative;
            margin-top: 60px;
            padding: 25px 0;
            border-top: 3px solid #3498db;
            font-size: 10px;
            color: #7f8c8d;
            page-break-inside: avoid;
            text-align: center;
        }
        @page {
            margin: 0;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <h2>{{ $quotation->company->name ?? 'Empresa' }}</h2>
            <p>{{ $quotation->company->address ?? '' }}</p>
            <p>{{ $quotation->company->phone ?? '' }} | {{ $quotation->company->email ?? '' }}</p>
            <p>NIT: {{ $quotation->company->identification_number ?? '' }}</p>
        </div>
        <div class="document-info">
            <h1>COTIZACIÓN</h1>
            <h3>{{ $quotation->number }}</h3>
            <p>Fecha de Emisión: {{ date('d/m/Y', strtotime($quotation->date_of_issue)) }}</p>
            <p>Fecha de Vencimiento: {{ date('d/m/Y', strtotime($quotation->date_of_expiration)) }}</p>
            <p>Validez: {{ $quotation->validity_days }} días</p>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="customer-info">
        <h3>Información del Cliente</h3>
        <p><strong>Nombre:</strong> {{ $quotation->customer->name ?? 'N/A' }}</p>
        <p><strong>Identificación:</strong> {{ $quotation->customer->identification_number ?? 'N/A' }}</p>
        <p><strong>Dirección:</strong> {{ $quotation->customer->address ?? 'N/A' }}</p>
        <p><strong>Teléfono:</strong> {{ $quotation->customer->phone ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $quotation->customer->email ?? 'N/A' }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Ítem</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Descuento</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->quotation_items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->item->name ?? 'N/A' }}</td>
                <td>{{ number_format($item->quantity, 2) }}</td>
                <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-right">{{ number_format($item->discount, 2) }}</td>
                <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                <td class="text-right">{{ number_format($item->total_tax, 2) }}</td>
                <td class="text-right">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <th>Subtotal:</th>
                <td>{{ number_format($quotation->subtotal, 2) }}</td>
            </tr>
            <tr>
                <th>Descuento:</th>
                <td>{{ number_format($quotation->total_discount, 2) }}</td>
            </tr>
            <tr>
                <th>IVA:</th>
                <td>{{ number_format($quotation->total_tax, 2) }}</td>
            </tr>
            <tr>
                <th>Total:</th>
                <td>{{ number_format($quotation->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="clear"></div>

    <div class="terms">
        <h4>Términos y Condiciones</h4>
        <p>{{ $quotation->notes ?? 'No se han especificado términos y condiciones.' }}</p>
        <p>Forma de Pago: {{ $quotation->paymentForm->name ?? 'N/A' }}</p>
        <p>Método de Pago: {{ $quotation->payment_method->name ?? 'N/A' }}</p>
    </div>

    <div class="signature">
        <h4>{{ $quotation->user->name ?? 'Usuario' }}</h4>
        <p>Vendedor</p>
    </div>

    <div class="footer">
        <p>Documento generado el {{ date('d/m/Y H:i:s') }}</p>
        <p>{{ $quotation->company->name ?? 'Empresa' }} - Todos los derechos reservados</p>
    </div>

</body>
</html>