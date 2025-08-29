<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago-Abono #{{ $payment_purchase->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #2c3e50;
            text-align: center;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 22px;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .info-box {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .info-box p {
            margin: 10px 0;
            font-size: 16px;
        }
        .info-box strong {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .highlight {
            background-color: #e6ffe6 !important;
            font-weight: bold;
        }
        .summary {
            display: flex;
            justify-content: space-around;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .summary div {
            text-align: center;
        }
        .summary strong {
            display: block;
            font-size: 17px;
            color: #2c3e50;
        }
        .summary span {
            font-size: 21px;
            color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Agrega el logo de la empresa aquí
        <img src="{{ asset('ruta/al/logo.png') }}" alt="Logo de la Empresa"> -->
        <p><strong>Empresa:</strong> {{ $payment_purchase->company->name }}</p>
        <p><strong>Nit:</strong> {{ $payment_purchase->company->identification_number }}</p>
        <p><strong>Dirección:</strong> {{ $payment_purchase->company->address }}</p>
        <p><strong>Tel:</strong> {{ $payment_purchase->company->phone }}</p>
        <p><strong>Email:</strong> {{ $payment_purchase->company->email }}</p>
    </div>

    <div class="info-box">
        <h1>Detalles del Pago #{{ $payment_purchase->id }}</h1>
        <p><strong>Factura:</strong> {{ $payment_purchase->accountsPayable->invoice_no }}</p>
        <p><strong>Proveedor:</strong> {{ $payment_purchase->accountsPayable->suppliers->company_name }}</p>
        <p><strong>Fecha:</strong> {{ $payment_purchase->payment_date }}</p>
        <p><strong>Medio de Pago:</strong> {{ $payment_purchase->paymentMethod->name }}</p>
        <p><strong>Monto:</strong> {{ number_format($payment_purchase->payment_amount, 2) }}</p>
        <p><strong>Referencia:</strong> {{ $payment_purchase->reference }}</p>
    </div>

    <h2>Historial de Pagos</h2>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Método de Pago</th>
            <th>Monto</th>
            <th>Referencia</th>
        </tr>
        @foreach ($payment_history as $payment)
            <tr class="{{ $payment->id == $payment_purchase->id ? 'highlight' : '' }}">
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->paymentMethod->name }}</td>
                <td>{{ number_format($payment->payment_amount, 2) }}</td>
                <td>{{ $payment->reference }}</td>
            </tr>
        @endforeach
    </table>

    <h2>Resumen de la Cuenta</h2>
    <div class="summary">
        <div>
            <strong>Monto Total Factura</strong>
            <span>{{ number_format($payment_purchase->accountsPayable->total_amount, 2) }}</span>
        </div>
        <div>
            <strong>Total Pagado</strong>
            <span>{{ number_format($payment_purchase->accountsPayable->total_amount - $payment_purchase->accountsPayable->balance, 2) }}</span>
        </div>
        <div>
            <strong>Saldo Pendiente</strong>
            <span>{{ number_format($payment_purchase->accountsPayable->balance, 2) }}</span>
        </div>
    </div>
</body>
</html>