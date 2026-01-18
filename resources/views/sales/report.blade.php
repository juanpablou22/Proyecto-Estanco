<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas - Estanco POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            /* Aplicamos el fondo con una capa de oscuridad del 80% */
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                              url('/images/fondo registro ventas.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        h2 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        /* Tarjetas con efecto cristal */
        .card {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-radius: 15px !important;
            border: none !important;
        }

        /* Caja de venta total resaltada */
        .total-box {
            background: rgba(0, 0, 0, 0.4) !important;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .table-dark {
            background-color: #212529 !important;
        }

        .form-label {
            color: #495057 !important;
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">

        <div class="d-flex justify-content-between align-items-center mb-4 text-white">
            <div class="d-flex gap-3 align-items-center">
                <a href="{{ route('tables.index') }}" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left"></i> Volver a Mesas
                </a>
                <h2 class="mb-0 fw-bold">Historial de Ventas</h2>
                <a href="{{ route('sales.pdf', ['fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]) }}" class="btn btn-danger shadow-sm fw-bold">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
            </div>

            <div class="total-box p-3 rounded shadow text-end">
                <small class="text-uppercase opacity-75 fw-semibold">Venta Total en Periodo:</small>
                <h3 class="mb-0 text-warning fw-bold">$ {{ number_format($totalGeneral, 0) }}</h3>
            </div>
        </div>

        <div class="card border-0 shadow-lg mb-4">
            <div class="card-body p-4">
                <form action="{{ route('sales.report') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small"><i class="bi bi-calendar-event"></i> Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ $fecha_inicio }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small"><i class="bi bi-calendar-check"></i> Fecha Fin</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ $fecha_fin }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                            <i class="bi bi-filter"></i> FILTRAR
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('sales.report') }}" class="btn btn-dark w-100 fw-bold shadow-sm">
                            <i class="bi bi-arrow-counterclockwise"></i> VER HOY
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-calculator"></i> Cuadre de Caja (Resumen por Método)</h5>
                    </div>
                    <div class="card-body">
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

        <div class="card shadow-lg border-0 overflow-hidden">
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
                            <td><span class="badge bg-secondary px-3">{{ $sale->table_name }}</span></td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
