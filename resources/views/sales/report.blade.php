<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - Estanco POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-3 align-items-center">
                <a href="{{ route('tables.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver a Mesas
                </a>
                <h2 class="mb-0">Historial de Ventas</h2>
                <a href="{{ route('sales.pdf') }}" class="btn btn-danger shadow-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                </a>
            </div>

            <div class="bg-dark text-white p-3 rounded shadow">
                <small class="text-uppercase opacity-75">Venta Total Acumulada:</small>
                <h3 class="mb-0 text-warning">$ {{ number_format($totalGeneral, 0) }}</h3>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 py-1"><i class="bi bi-calculator"></i> Cuadre de Caja (Resumen por Método)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            @forelse($totalesPorMetodo as $metodo)
                                <div class="col-md-3 border-end">
                                    <p class="text-muted mb-1">{{ $metodo->payment_method }}</p>
                                    <h4 class="fw-bold mb-0 text-primary">$ {{ number_format($metodo->total, 0) }}</h4>
                                </div>
                            @empty
                                <div class="col-12 text-muted">No hay datos de pago disponibles.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow border-0">
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Mesa</th>
                            <th>Método de Pago</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->created_at->format('d/m/Y h:i A') }}</td>
                            <td><span class="badge bg-secondary">{{ $sale->table_name }}</span></td>
                            <td>
                                @if($sale->payment_method == 'Efectivo')
                                    <i class="bi bi-cash text-success"></i>
                                @elseif($sale->payment_method == 'Nequi')
                                    <i class="bi bi-phone text-primary"></i>
                                @else
                                    <i class="bi bi-bank text-info"></i>
                                @endif
                                {{ $sale->payment_method }}
                            </td>
                            <td class="text-end font-monospace fw-bold text-dark">
                                $ {{ number_format($sale->total, 0) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No hay ventas registradas todavía.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
