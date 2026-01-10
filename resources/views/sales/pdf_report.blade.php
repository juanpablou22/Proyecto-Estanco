<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #2c3e50; }
        .summary-box { background: #f8f9fa; padding: 15px; border: 1px solid #ddd; margin-bottom: 20px; }
        .total-main { font-size: 18px; font-weight: bold; color: #27ae60; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #2c3e50; color: white; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>REPORTE DE VENTAS - ESTANCO</h1>
        <p>Fecha de generación: {{ date('d/m/Y h:i A') }}</p>
    </div>

    <div class="summary-box">
        <strong>RESUMEN DE CAJA:</strong><br>
        @foreach($totalesPorMetodo as $metodo)
            {{ $metodo->payment_method }}: ${{ number_format($metodo->total, 0) }} <br>
        @endforeach
        <hr>
        <span class="total-main">VENTA TOTAL: ${{ number_format($totalGeneral, 0) }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Mesa</th>
                <th>Método</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $sale->table_name }}</td>
                <td>{{ $sale->payment_method }}</td>
                <td class="text-end">${{ number_format($sale->total, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
