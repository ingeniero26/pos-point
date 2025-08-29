<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Venta</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #2c3e50; text-align: center;">Factura de Venta</h1>
        
        <p>Estimado(a) {{ $sale->customers->name }},</p>
        
        <p>Adjunto encontrará la factura de venta número {{ $sale->invoice_no }} correspondiente a su compra realizada el {{ \Carbon\Carbon::parse($sale->date_of_issue)->format('d/m/Y') }}.</p>
        
        <p>Detalles de la factura:</p>
        <ul>
            <li>Número de Factura: {{ $sale->invoice_no }}</li>
            <li>Fecha: {{ \Carbon\Carbon::parse($sale->date_of_issue)->format('d/m/Y') }}</li>
            <li>Estado: {{ $sale->stateTypes->description }}</li>
            <li>Total: {{ number_format($sale->total_sale, 2, ',', '.') }} COP</li>
        </ul>
        
        <p>Si tiene alguna consulta, por favor no dude en contactarnos.</p>
        
        <p>Atentamente,</p>
        <p>{{ $sale->company->name }}</p>
    </div>
</body>
</html>
