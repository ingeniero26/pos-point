<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Traslado #{{ $transfer->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Detalles del Traslado #{{ $transfer->id }}</h1>
    <p><strong>Fecha:</strong> {{ $transfer->transfer_date }}</p>
    <p><strong>Desde:</strong> {{ $transfer->warehouse->warehouse_name }}</p>
    <p><strong>Hacia:</strong> {{ $transfer->warehouse_destination->warehouse_name }}</p>
    <p><strong>Estado:</strong> {{ $transfer->statusTransfer->name }}</p>

    <h2>Detalles de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transfer->details as $detail)
                <tr>
                    <td>{{ $detail->item->product_name }}</td>
                    <td>{{ $detail->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td><strong>Total Productos Trasladados</strong></td>
                <td><strong>{{ $transfer->details->sum('quantity') }}</strong></td>
            </tr>
        </tfoot>
       
        
    </table>
</body>
</html>