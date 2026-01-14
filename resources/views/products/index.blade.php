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
            /* Fondo de bar con alta oscuridad para resaltar el cristal */
            background-image: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)),
                              url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        /* Efecto Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.03) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px !important;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }

        .navbar {
            background: rgba(0, 0, 0, 0.5) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Estilo de la Tabla */
        .table {
            color: rgba(255,255,255,0.9) !important;
            margin-bottom: 0;
        }

        .table thead th {
            background: rgba(255, 255, 255, 0.05);
            color: #ffc107; /* Dorado */
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            font-weight: 700;
            border: none;
            padding: 20px;
        }

        .table tbody td {
            padding: 20px;
            border-color: rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }

        /* Badges de Stock Personalizados */
        .stock-badge {
            font-size: 1rem;
            font-weight: 800;
            padding: 8px 15px;
            border-radius: 12px;
        }

        .status-pill {
            font-size: 0.7rem;
            padding: 5px 10px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        /* Footer de Valor Total */
        .inventory-footer {
            background: rgba(255, 193, 7, 0.1);
            border-top: 1px solid rgba(255, 193, 7, 0.2);
            padding: 25px;
        }

        .total-amount {
            color: #ffc107;
            font-size: 1.8rem;
            font-weight: 800;
            text-shadow: 0 0 15px rgba(255, 193, 7, 0.3);
        }

        .btn-gold {
            background: linear-gradient(45deg, #ffc107, #ff9800);
            border: none;
            color: black;
            font-weight: 700;
            border-radius: 12px;
            transition: 0.3s;
        }

        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3);
            color: black;
        }

        .btn-outline-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 12px;
        }

        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffc107;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark mb-4 shadow">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ route('home') }}" class="btn btn-outline-glass btn-sm me-3">
                    <i class="bi bi-arrow-left"></i> Panel
                </a>
                <span class="navbar-brand mb-0 h2 fw-bold">CONTROL DE INVENTARIO</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('inventory.pdf') }}" class="btn btn-outline-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Reporte
                </a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="glass-card card border-0 shadow-lg">
            <div class="card-header bg-transparent py-4 px-4 border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 fw-bold">Existencias en Tiempo Real</h4>
                    <small class="text-white-50 small">Vigila el stock y el capital de tu estanco</small>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-gold px-4">
                    <i class="bi bi-plus-lg me-2"></i> Nuevo Registro
                </a>
            </div>

            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success mx-4 border-0 bg-success text-white bg-opacity-25" role="alert">
                        <i class="bi bi-check-all me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">Detalle del Producto</th>
                                <th>Precio Venta</th>
                                <th class="text-center">Existencias</th>
                                <th>Estado de Stock</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold fs-5">{{ $product->name }}</div>
                                    <div class="text-white-50 small">{{ $product->description ?? 'Sin especificaciones' }}</div>
                                </td>
                                <td class="fw-bold text-warning fs-5">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    @if($product->stock <= 0)
                                        <span class="stock-badge text-danger">0</span>
                                    @elseif($product->stock <= 10)
                                        <span class="stock-badge text-warning">{{ $product->stock }}</span>
                                    @else
                                        <span class="stock-badge text-success">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="status-pill bg-danger text-white">Agotado</span>
                                    @elseif($product->stock <= 10)
                                        <span class="status-pill bg-warning text-dark">Stock Bajo</span>
                                    @else
                                        <span class="status-pill bg-success text-white">Saludable</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-glass" title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('¿Borrar producto?')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="bi bi-box2 fs-1 text-white-50"></i>
                                    <p class="mt-3">Aún no hay productos cargados en el sistema.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($products->count() > 0)
            <div class="inventory-footer d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-white-50 small text-uppercase fw-bold">Capital Total Invertido:</span>
                    <div class="total-amount">${{ number_format($valorTotalBodega ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="text-end">
                    <i class="bi bi-cash-coin text-warning fs-1 opacity-50"></i>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
