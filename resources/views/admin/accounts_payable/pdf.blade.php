<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta por Pagar #{{ $account_payable->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
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
            {{-- @if($account_payable->company && $account_payable->company->logo)
                <img src="{{ public_path($account_payable->company->logo) }}" alt="Logo" class="logo">
            @endif --}}
            <div class="title">CUENTA POR PAGAR</div>
            <div class="subtitle">{{ $account_payable->company ? $account_payable->company->name : 'Empresa'  }}</div>
            <div>{{ $account_payable->company ? $account_payable->company->identification_number : '' }}</div>
            <div>{{ $account_payable->company ? $account_payable->company->address : '' }}</div>
            <div>Tel: {{ $account_payable->company ? $account_payable->company->phone : '' }}</div>
        </div>

        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Factura No:</div>
                <div class="info-value">{{ $account_payable->invoice_no }}</div>
                <div class="info-label">Estado:</div>
                <div class="info-value">
                    @if($account_payable->balance <= 0)
                        <span class="status-paid">PAGADO</span>
                    @elseif($account_payable->balance < $account_payable->total_amount)
                        <span class="status-partial">PAGO PARCIAL</span>
                    @else
                        <span class="status-pending">PENDIENTE</span>
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Proveedor:</div>
                <div class="info-value">{{ $account_payable->suppliers->company_name }}</div>
                <div class="info-label">Fecha de Emisión:</div>
                <div class="info-value">{{ date('d/m/Y', strtotime($account_payable->date_of_issue)) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">RUC/NIT:{{$account_payable->suppliers->identification_number}}</div>
                <div class="info-value">{{ $account_payable->suppliers->tax_id }}</div>
                <div class="info-label">Fecha de Vencimiento:</div>
                <div class="info-value">{{ date('d/m/Y', strtotime($account_payable->date_of_due)) }}</div>
            </div>
        </div>

        <div class="info-section">
            <div class="subtitle">Resumen de la Cuenta</div>
            <table>
                <tr>
                    <th>Monto Total</th>
                    <th>Pagos Realizados</th>
                    <th>Saldo Pendiente</th>
                </tr>
                <tr>
                    <td class="text-right">{{ number_format($account_payable->total_amount, 2) }}</td>
                    <td class="text-right">{{ number_format($account_payable->total_amount - $account_payable->balance, 2) }}</td>
                    <td class="text-right">{{ number_format($account_payable->balance, 2) }}</td>
                </tr>
            </table>
        </div>

        @if(isset($account_payable->payments) && count($account_payable->payments) > 0)
            <div class="info-section">
                <div class="subtitle">Historial de Pagos</div>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Método de Pago</th>
                            <th>Referencia</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($account_payable->payments as $payment)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($payment->payment_date)) }}</td>
                                <td>{{ $payment->paymentMethod ? $payment->paymentMethod->name : 'N/A' }}</td>
                                <td>{{ $payment->reference ?: 'N/A' }}</td>
                                <td class="text-right">{{ number_format($payment->payment_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="footer">
            <p>Documento generado el {{ date('d/m/Y H:i:s') }}</p>
            <p>Este documento es un comprobante de la cuenta por pagar y no tiene validez fiscal.</p>
        </div>
    </div>
</body>
</html>