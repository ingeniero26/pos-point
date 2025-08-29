<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orden de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Orden de Compra: {{ $emailData['orderPrefix'] }}</h2>
        </div>
        
        <p>Estimado proveedor,</p>
        
        <p>{{ $emailData['message'] }}</p>
        
        <p>Detalles de la orden:</p>
        <ul>
            <li><strong>Número de Orden:</strong> {{ $emailData['orderPrefix'] }}</li>
            <li><strong>Fecha de Orden:</strong> {{ $emailData['orderDate'] }}</li>
            <li><strong>Fecha Esperada:</strong> {{ $emailData['expectedDate'] }}</li>
            <li><strong>Total:</strong> {{ $emailData['total'] }}</li>
        </ul>
        
        <p>Por favor, encuentre adjunto el documento PDF con todos los detalles de la orden de compra.</p>
        
        <p>Saludos cordiales,</p>
        <p>{{ $emailData['userName'] }}</p>
        @if(!empty($emailData['companyName']))
        <p>{{ $emailData['companyName'] }}</p>
        @endif
        
        <div class="footer">
            <p>Este es un correo electrónico automático, por favor no responda a este mensaje.</p>
        </div>
    </div>
</body>
</html>