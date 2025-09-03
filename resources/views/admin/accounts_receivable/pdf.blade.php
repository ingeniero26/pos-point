<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta por Cobrar - {{ $accountReceivable->sales->invoice_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .company-info {
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        .document-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            color: #333;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .info-value {
            flex: 1;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .table .text-right {
            text-align: right;
        }
        .table .text-center {
            text-align: center;
        }
        .totals-section {
            margin-top: 20px;
            border-top: 2px solid #007bff;
            padding-top: 15px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .total-row.final {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-pending {
            background-color: #dc3545;
            color: white;
        }
        .status-partial {
            background-color: #ffc107;
            color: #333;
        }
        .status-paid {
            background-color: #28a745;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <div class="company-name">{{ $company->name ?? 'Empresa' }}</div>
            @if($company)
                <div>{{ $company->address ?? '' }}</div>
                <div>Tel: {{ $company->phone ?? '' }} | Email: {{ $company->email ?? '' }}</div>
                <div>{{ $company->identification_type ?? '' }}: {{ $company->identification_number ?? '' }}</div>
            @endif
        </div>
        <div class="document-title">CUENTA POR COBRAR</div>
    </div>

    <!-- Account Information -->
    <div class="info-section">
        <h3>Información de la Cuenta</h3>
        <div class="info-row">
            <span class="info-label">Cliente:</span>
            <span class="info-value">{{ $accountReceivable->customers->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Identificación:</span>
            <span class="info-value">{{ $accountReceivable->customers->identification_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">No. Factura:</span>
            <span class="info-value">{{ $accountReceivable->sales->invoice_no }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha Emisión:</span>
            <span class="info-value">{{ $issueDate }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha Vencimiento:</span>
            <span class="info-value">{{ $dueDate }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Estado:</span>
            <span class="info-value">
                @if($remainingBalance <= 0)
                    <span class="status-badge status-paid">PAGADO</span>
                @elseif($totalPaid > 0)
                    <span class="status-badge status-partial">PARCIAL</span>
                @else
                    <span class="status-badge status-pending">PENDIENTE</span>
                @endif
            </span>
        </div>
    </div>

    <!-- Payment History -->
    @if($accountReceivable->payments->count() > 0)
    <div class="info-section">
        <h3>Historial de Pagos</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Método de Pago</th>
                    <th>Referencia</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accountReceivable->payments as $payment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                    <td class="text-right">${{ number_format($payment->payment_amount, 2) }}</td>
                    <td>{{ $payment->payment_method->name ?? 'N/A' }}</td>
                    <td>{{ $payment->reference ?? 'N/A' }}</td>
                    <td>{{ $payment->user->name ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Totals Section -->
    <div class="totals-section">
        <div class="total-row">
            <span>Monto Total de la Factura:</span>
            <span>${{ number_format($accountReceivable->total_amount, 2) }}</span>
        </div>
        <div class="total-row">
            <span>Total Pagado:</span>
            <span>${{ number_format($totalPaid, 2) }}</span>
        </div>
        <div class="total-row final">
            <span>Saldo Pendiente:</span>
            <span>${{ number_format($remainingBalance, 2) }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>{{ $company->name ?? 'Sistema de Gestión' }} - Cuentas por Cobrar</p>
    </div>
</body>
</html>