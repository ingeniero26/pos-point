<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta por Cobrar - {{ $accountReceivable->invoice_no }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
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
        }
        .header {
            padding: 20px 0;
            border-bottom: 2px solid #f0f0f0;
        }
        .logo {
            max-height: 80px;
            max-width: 200px;
        }
        .company-info {
            float: left;
            width: 60%;
        }
        .document-info {
            float: right;
            width: 35%;
            text-align: right;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
            text-align: center;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin: 15px 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-section {
            margin: 15px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        .total-row {
            margin: 5px 0;
        }
        .total-label {
            font-weight: bold;
            display: inline-block;
            width: 200px;
            text-align: right;
            margin-right: 10px;
        }
        .total-value {
            display: inline-block;
            width: 100px;
            text-align: right;
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
            background-color: #f39c12;
            color: white;
        }
        .status-paid {
            background-color: #27ae60;
            color: white;
        }
        .status-partial {
            background-color: #3498db;
            color: white;
        }
        .status-overdue {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header clearfix">
            <div class="company-info">
                @if($company->logo)
                    <img src="{{ public_path('uploads/company/' . $company->logo) }}" alt="Logo" class="logo">
                @endif
                <h2>{{ $company->name }}</h2>
                <p>{{ $company->address }}<br>
                {{ $company->city }}, {{ $company->state }}<br>
                NIT: {{ $company->nit }}<br>
                Tel: {{ $company->phone }}</p>
            </div>
            <div class="document-info">
                <h3>CUENTA POR COBRAR</h3>
                <p><strong>No. Factura:</strong> {{ $accountReceivable->invoice_no }}</p>
                <p><strong>Fecha Emisión:</strong> {{ $issueDate }}</p>
                <p><strong>Fecha Vencimiento:</strong> {{ $dueDate }}</p>
                
                @php
                    $status = '';
                    $statusClass = '';
                    
                    if($remainingBalance <= 0) {
                        $status = 'PAGADO';
                        $statusClass = 'status-paid';
                    } elseif($remainingBalance < $accountReceivable->total_amount) {
                        $status = 'PAGO PARCIAL';
                        $statusClass = 'status-partial';
                    } elseif(strtotime($accountReceivable->due_date) < strtotime('today')) {
                        $status = 'VENCIDO';
                        $statusClass = 'status-overdue';
                    } else {
                        $status = 'PENDIENTE';
                        $statusClass = 'status-pending';
                    }
                @endphp
                
                <p><strong>Estado:</strong> <span class="status-badge {{ $statusClass }}">{{ $status }}</span></p>
            </div>
        </div>
        
        <div class="title">Estado de Cuenta</div>
        
        <div class="subtitle">Información del Cliente</div>
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Cliente:</span> {{ $accountReceivable->customers->name }}
            </div>
            <div class="info-row">
                <span class="info-label">Identificación:</span> {{ $accountReceivable->customers->identification_number }}
            </div>
            <div class="info-row">
                <span class="info-label">Dirección:</span> {{ $accountReceivable->customers->address }}
            </div>
            <div class="info-row">
                <span class="info-label">Teléfono:</span> {{ $accountReceivable->customers->phone }}
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span> {{ $accountReceivable->customers->email }}
            </div>
        </div>
        
        <div class="subtitle">Resumen de la Factura</div>
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Total Factura:</span> ${{ number_format($accountReceivable->total_amount, 2, ',', '.') }}
            </div>
            <div class="info-row">
                <span class="info-label">Total Pagado:</span> ${{ number_format($totalPaid, 2, ',', '.') }}
            </div>
            <div class="info-row">
                <span class="info-label">Saldo Pendiente:</span> ${{ number_format($remainingBalance, 2, ',', '.') }}
            </div>
        </div>
        
        <div class="subtitle">Historial de Pagos</div>
        @if(count($accountReceivable->payments) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Método de Pago</th>
                        <th>Referencia</th>
                        <th>Registrado por</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accountReceivable->payments as $payment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                            <td>{{ $payment->payment_method->name }}</td>
                            <td>{{ $payment->reference ?? 'N/A' }}</td>
                            <td>{{ $payment->user->name }}</td>
                            <td style="text-align: right;">${{ number_format($payment->payment_amount, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; font-style: italic;">No hay pagos registrados para esta cuenta.</p>
        @endif
        
        <div class="footer">
            <p>Este documento es un estado de cuenta y no tiene validez como factura.</p>
            <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>