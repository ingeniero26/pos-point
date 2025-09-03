<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket - Historial de Pagos</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.2;
            margin: 0;
            padding: 5px;
            width: 70mm;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }
        .company-name {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 2px;
        }
        .ticket-title {
            font-weight: bold;
            font-size: 11px;
            margin: 5px 0;
        }
        .info-section {
            margin-bottom: 8px;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }
        .info-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .info-line span:first-child {
            flex: 1;
        }
        .info-line span:last-child {
            flex: 1;
            text-align: right;
            font-weight: bold;
        }
        .payments-section {
            margin-bottom: 8px;
        }
        .payment-item {
            border-bottom: 1px dotted #ccc;
            padding: 3px 0;
            margin-bottom: 3px;
        }
        .payment-header {
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
            text-decoration: underline;
        }
        .payment-date {
            font-weight: bold;
        }
        .payment-amount {
            text-align: right;
            font-weight: bold;
        }
        .summary {
            border-top: 1px dashed #000;
            padding-top: 5px;
            margin-top: 8px;
        }
        .total-line {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .total-line span:first-child {
            flex: 1;
        }
        .total-line span:last-child {
            flex: 1;
            text-align: right;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 8px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
        .text-center { 
            text-align: center; 
        }
        .text-right { 
            text-align: right; 
        }
        .bold { 
            font-weight: bold; 
        }
        .small { 
            font-size: 8px; 
        }
        .no-payments {
            text-align: center;
            font-style: italic;
            color: #666;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $company->name ?? 'EMPRESA' }}</div>
        <div class="small">NIT: {{ $company->nit ?? 'N/A' }}</div>
        <div class="small">{{ $company->address ?? '' }}</div>
        <div class="small">Tel: {{ $company->phone ?? 'N/A' }}</div>
        <div class="ticket-title">HISTORIAL DE PAGOS</div>
    </div>
    
    <div class="info-section">
        <div class="info-line">
            <span>Cliente:</span>
            <span>{{ $accountReceivable->customers->name }}</span>
        </div>
        <div class="info-line">
            <span>Documento:</span>
            <span>{{ $accountReceivable->customers->identification_number ?? 'N/A' }}</span>
        </div>
        <div class="info-line">
            <span>Factura:</span>
            <span>{{ $accountReceivable->sales->invoice_no }}</span>
        </div>
        <div class="info-line">
            <span>Fecha Emisión:</span>
            <span>{{ \Carbon\Carbon::parse($accountReceivable->date_of_issue)->format('d/m/Y') }}</span>
        </div>
        <div class="info-line">
            <span>Fecha Impresión:</span>
            <span>{{ $currentDate }}</span>
        </div>
        <div class="info-line">
            <span>Hora:</span>
            <span>{{ $currentTime }}</span>
        </div>
    </div>
    
    <div class="payments-section">
        <div class="payment-header">PAGOS REALIZADOS</div>
        
        @if($accountReceivable->payments->count() > 0)
            @foreach($accountReceivable->payments as $index => $payment)
                <div class="payment-item">
                    <div class="info-line">
                        <span class="payment-date">#{{ $index + 1 }} - {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-line">
                        <span>Método:</span>
                        <span>{{ $payment->payment_method->name ?? 'N/A' }}</span>
                    </div>
                    <div class="info-line">
                        <span>Monto:</span>
                        <span class="payment-amount">${{ number_format($payment->payment_amount, 2, ',', '.') }}</span>
                    </div>
                    @if($payment->reference)
                        <div class="info-line">
                            <span>Referencia:</span>
                            <span class="small">{{ $payment->reference }}</span>
                        </div>
                    @endif
                    <div class="info-line">
                        <span>Usuario:</span>
                        <span class="small">{{ $payment->user->name ?? 'N/A' }}</span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-payments">
                No hay pagos registrados
            </div>
        @endif
    </div>
    
    <div class="summary">
        <div class="total-line">
            <span>TOTAL FACTURA:</span>
            <span>${{ number_format($accountReceivable->total_amount, 2, ',', '.') }}</span>
        </div>
        <div class="total-line">
            <span>TOTAL PAGADO:</span>
            <span>${{ number_format($totalPaid, 2, ',', '.') }}</span>
        </div>
        <div class="total-line">
            <span>SALDO PENDIENTE:</span>
            <span>${{ number_format($remainingBalance, 2, ',', '.') }}</span>
        </div>
    </div>
    
    <div class="footer">
        <div>Sistema de Gestión</div>
        <div class="small">Impreso: {{ $currentDate }} {{ $currentTime }}</div>
        <div class="small">*** COMPROBANTE DE PAGOS ***</div>
        @if($remainingBalance > 0)
            <div class="small">Estado: PENDIENTE DE PAGO</div>
        @else
            <div class="small">Estado: TOTALMENTE PAGADO</div>
        @endif
    </div>
</body>
</html>