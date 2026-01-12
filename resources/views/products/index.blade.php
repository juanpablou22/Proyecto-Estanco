<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Estanco POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            /* Aplicamos el fondo con una capa de oscuridad del 70% */
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                              url('/images/fondo inventario.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        /* Títulos en blanco para resaltar sobre el fondo oscuro */
        .navbar-brand, h5.text-dark {
            color: white !important;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }

        /* Tarjeta con efecto Glassmorphism (Cristal) */
        .card {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(10px);
            border-radius: 15px !important;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid rgba(0,0,0,0.1) !important;
        }

        /* Ajuste de sombras para los botones */
        .btn-primary {
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark mb-4 shadow">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ route('tables.index') }}" class="btn btn-outline-light btn-sm me-3">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <span class="navbar-brand mb-0 h1 text-white">Sistema de Control - Estanco</span>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="card shadow border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-box-seam me-2"></i>Inventario de Productos</h5>
                <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg"></i> Agregar Producto
                </a>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle border-top">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Nombre del Producto</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td class="ps-3 fw-bold text-dark">{{ $product->name }}</td>
                                <td class="text-muted small">{{ $product->description ?? 'Sin descripción' }}</td>
                                <td class="fw-semibold text-dark">${{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="fs-6 fw-bold text-danger">0</span>
                                    @elseif($product->stock <= 10)
                                        <span class="fs-6 fw-bold text-warning">{{ $product->stock }}</span>
                                    @else
                                        <span class="fs-6 fw-bold text-success">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->stock <= 0)
                                        <span class="badge bg-danger">Agotado</span>
                                    @elseif($product->stock <= 10)
                                        <span class="badge bg-warning text-dark">Stock Bajo</span>
                                    @else
                                        <span class="badge bg-success text-white">Disponible</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-dark" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que deseas eliminar este producto?')" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-info-circle fs-2 d-block mb-2 text-dark"></i>
                                    No hay productos registrados aún.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
