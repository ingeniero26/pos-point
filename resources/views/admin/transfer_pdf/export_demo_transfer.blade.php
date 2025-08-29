<!DOCTYPE html>
<html>
<head>
    <title>Traslados</title>
    <link href="https://fonts.googleapis.com/css2?family=Helvetica+Neue:wght@400;700&display=swap" rel="stylesheet">
   <style>
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: #333;
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #007bff; /* Azul más atractivo */
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px 15px;
        text-align: left;
    }
    th {
        background-color: #f8f9fa; /* Gris claro */
        font-weight: 600;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .details-table {
        width: 100%;
        border-collapse: collapse;
    }
    .details-table th, .details-table td {
        border: 1px solid #eee;
        padding: 8px 10px;
    }
    .details-table th {
        background-color: #e9ecef;
    }
</style>
</head>
<body>
    <h2>Lista de Traslados</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Almacén Origen</th>
                <th>Almacén Destino</th>
                <th>Estado</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transfers as $transfer)
                <tr>
                    <td>{{ $transfer->id }}</td>
                    <td>{{ $transfer->transfer_date }}</td>
                    <td>{{ $transfer->warehouse->warehouse_name }}</td>
                    <td>{{ $transfer->warehouse_destination->warehouse_name }}</td>
                    <td>{{ $transfer->statusTransfer->name }}</td>
                    <td>
                        <table>
                            <thead>
                                <tr>
                                    <th>Ítem</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transfer->details as $detail)
                                    <tr>
                                        <td>{{ $detail->item->product_name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>