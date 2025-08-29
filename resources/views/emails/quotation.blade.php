<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cotización</title>
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
        .details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .details p {
            margin: 5px 0;
        }
        .message {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Cotización {{ $emailData['quotationNumber'] }}</h2>
        </div>
        
        <div class="message">
            <p>{{ $emailData['message'] }}</p>
        </div>
        
        <div class="details">
            <p><strong>Número de Cotización:</strong> {{ $emailData['quotationNumber'] }}</p>
            <p><strong>Fecha de Emisión:</strong> {{ $emailData['issueDate'] }}</p>
            <p><strong>Fecha de Vencimiento:</strong> {{ $emailData['expirationDate'] }}</p>
            <p><strong>Total:</strong> ${{ $emailData['total'] }}</p>
        </div>
        
        <p>Adjunto encontrará el documento PDF con todos los detalles de la cotización.</p>
        
        <p>Saludos cordiales,</p>
        <p>{{ $emailData['userName'] }}</p>
        <p>{{ $emailData['companyName'] }}</p>
        
        <div class="footer">
            <p>Este es un correo electrónico automático, por favor no responda a este mensaje.</p>
        </div>
    </div>
</body>
</html>