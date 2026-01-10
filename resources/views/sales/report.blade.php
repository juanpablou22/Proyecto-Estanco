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
                <h2 class="mb-0 fw-bold text-dark">Historial de Ventas</h2>
                <a href="{{ route('sales.pdf', ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]) }}" class="btn btn-danger shadow-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF Filtrado
                </a>
            </div>

            <div class="bg-dark text-white p-3 rounded shadow text-end">
                <small class="text-uppercase opacity-75 fw-semibold">Venta en Periodo Seleccionado:</small>
                <h3 class="mb-0 text-warning fw-bold">$ {{ number_format($totalGeneral, 0) }}</h3>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body bg-white p-4">
                <form action="{{ route('sales.report') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small"><i class="bi bi-calendar-event"></i> Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control border-primary-subtle" value="{{ $fecha_inicio }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small"><i class="bi bi-calendar-check"></i> Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control border-primary-subtle" value="{{ $fecha_fin }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="bi bi-search"></i> Filtrar Reporte
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('sales.report') }}" class="btn btn-dark w-100 fw-bold">
                            <i class="bi bi-arrow-counterclockwise"></i> Ver Hoy
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 py-1 fw-semibold"><i class="bi bi-calculator"></i> Cuadre de Caja (Resumen por Método)</h5>
                    </div>
                    <div class="card-body bg-white">
                        <div class="row text-center">
                            @forelse($totalesPorMetodo as $metodo)
                                <div class="col-md-3 border-end">
                                    <p class="text-muted mb-1 text-uppercase x-small fw-bold">{{ $metodo->payment_method }}</p>
                                    <h4 class="fw-bold mb-0 text-primary">$ {{ number_format($metodo->total, 0) }}</h4>
                                </div>
                            @empty
                                <div class="col-12 text-muted py-2">No se encontraron ventas para este periodo.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow border-0 overflow-hidden">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3">Fecha y Hora</th>
                            <th class="py-3">Mesa</th>
                            <th class="py-3">Método de Pago</th>
                            <th class="text-end pe-4 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $sale->created_at->format('d/m/Y h:i A') }}</td>
                            <td><span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3">{{ $sale->table_name }}</span></td>
                            <td>
                                @if($sale->payment_method == 'Efectivo')
                                    <i class="bi bi-cash text-success"></i>
                                @elseif($sale->payment_method == 'Nequi')
                                    <i class="bi bi-phone text-primary"></i>
                                @else
                                    <i class="bi bi-credit-card text-info"></i>
                                @endif
                                <span class="ms-1 fw-medium text-dark">{{ $sale->payment_method }}</span>
                            </td>
                            <td class="text-end pe-4 font-monospace fw-bold text-dark fs-5">
                                $ {{ number_format($sale->total, 0) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-info-circle display-4 text-muted"></i>
                                <p class="mt-2 text-muted fw-semibold">No se registraron ventas en el periodo seleccionado.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
