<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Profesional - Estanco POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            /* Un degradado más oscuro para que el texto resalte mejor */
            background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.92)),
                              url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.02) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px !important;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }

        /* --- AQUÍ ESTÁ EL TRUCO PARA QUE NO SE VEA MAL --- */
        .table {
            --bs-table-bg: transparent !important; /* Mata el fondo blanco de Bootstrap */
            --bs-table-color: #f8f9fa !important;
            --bs-table-border-color: rgba(255, 255, 255, 0.1) !important;
            margin-bottom: 0;
        }

        .table thead th {
            background: rgba(255, 193, 7, 0.1) !important; /* Un toque de oro muy suave */
            color: #ffc107 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            padding: 1.5rem 1rem;
            border: none;
        }

        .table tbody td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: transparent !important;
        }

        /* Hover sutil para no arruinar el cristal */
        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03) !important;
            color: #fff !important;
        }

        /* Estilo de los números y etiquetas */
        .stock-badge {
            font-size: 1.1rem;
            font-weight: 700;
            text-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        .status-pill {
            font-size: 0.65rem;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .total-amount {
            color: #ffc107;
            font-size: 2.2rem;
            font-weight: 800;
            text-shadow: 0 0 15px rgba(255, 193, 7, 0.3);
        }

        .btn-gold {
            background: #ffc107;
            border: none;
            color: #000;
            font-weight: 700;
            border-radius: 10px;
            transition: 0.2s;
        }

        .btn-gold:hover {
            background: #e5ac00;
            transform: scale(1.02);
            color: #000;
        }

        .btn-outline-glass {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffc107;
            border-color: #ffc107;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark mb-4 py-3" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(10px);">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ route('home') }}" class="btn btn-outline-glass btn-sm me-3">
                    <i class="bi bi-house-door-fill me-2"></i> Menu Principal
                </a>
                <span class="navbar-brand mb-0 h4 fw-bold">CONTROL DE INVENTARIO</span>
            </div>

        </div>
    </nav>

    <div class="container mb-5">
        <div class="glass-card card border-0">
            <div class="card-header bg-transparent py-4 px-4 border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 fw-bold">Existencias</h4>
                    <p class="text-white-50 mb-0 small">Control de stock y capital</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-gold px-4">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Registro
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">Producto</th>
                                <th>Precio</th>
                                <th class="text-center">Stock</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold fs-6">{{ $product->name }}</div>
                                    <div class="opacity-50 small">ID: #{{ $product->id }}</div>
                                </td>
                                <td class="fw-bold text-warning">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $color = $product->stock <= 0 ? 'text-danger' : ($product->stock <= 10 ? 'text-warning' : 'text-success');
                                    @endphp
                                    <span class="stock-badge {{ $color }}">{{ $product->stock }}</span>
                                </td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="status-pill bg-danger text-white">Agotado</span>
                                    @elseif($product->stock <= 10)
                                        <span class="status-pill bg-warning text-dark">Bajo</span>
                                    @else
                                        <span class="status-pill bg-success text-white">Bien</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-glass me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Borrar?')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 opacity-50">
                                    No hay productos registrados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($products->count() > 0)
            <div class="card-footer bg-transparent border-top border-white border-opacity-10 py-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 small text-uppercase fw-bold">Capital Invertido</span>
                    <div class="total-amount">${{ number_format($valorTotalBodega ?? 0, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-cash-coin text-warning fs-1 opacity-25"></i>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
