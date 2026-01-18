<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Surtido</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-end { text-align: right; }
        .total-row { background-color: #eee; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>ESTANCO POS - REPORTE DE SURTIDO</h2>
        <p>Fecha de generación: {{ date('d/m/Y H:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Costo Unit.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalInversion = 0; @endphp
            @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->created_at->format('d/m/Y') }}</td>
                <td>{{ $purchase->supplier ?? 'N/A' }}</td>
                <td>{{ $purchase->product->name }}</td>
                <td>{{ $purchase->quantity }}</td>
                <td class="text-end">${{ number_format($purchase->cost_price, 0) }}</td>
                <td class="text-end">${{ number_format($purchase->total_amount, 0) }}</td>
            </tr>
            @php $totalInversion += $purchase->total_amount; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-end">INVERSIÓN TOTAL:</td>
                <td class="text-end">${{ number_format($totalInversion, 0) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
