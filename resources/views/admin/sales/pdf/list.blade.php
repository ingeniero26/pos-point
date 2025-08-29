<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Listado de Ventas</h2>
        <p>Fecha de generación: {{ date('Y-m-d H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>No. Factura</th>
                <th>Estado</th>
                <th>Forma de Pago</th>
                <th>Método</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Descuento</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($sales as $sale)
                @php 
                    $total += $sale->total_sale;
                    $invoiceNumber = $sale->series && $sale->number ? 
                        "{$sale->series}-{$sale->number}" : 
                        ($sale->invoice_no ? $sale->invoice_no : 'N/A');
                @endphp
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ date('d/m/Y', strtotime($sale->date_of_issue)) }}</td>
                    <td>{{ $sale->customers ? $sale->customers->name : 'N/A' }}</td>
                    <td>{{ $invoiceNumber }}</td>
                    <td>{{ $sale->state_types ? $sale->state_types->description : 'N/A' }}</td>
                    <td>{{ $sale->payment_form ? $sale->payment_form->payment_type : 'N/A' }}</td>
                    <td>{{ $sale->payment_method ? $sale->payment_method->name : 'N/A' }}</td>
                    <td>{{ number_format($sale->total_subtotal, 2, ',', '.') }}</td>
                    <td>{{ number_format($sale->total_tax, 2, ',', '.') }}</td>
                    <td>{{ number_format($sale->total_discount, 2, ',', '.') }}</td>
                    <td>{{ number_format($sale->total_sale, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>{{ number_format($total, 2, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>Página 1 de 1</p>
    </div>
</body>
</html>