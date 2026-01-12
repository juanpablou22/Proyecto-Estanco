<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas - Estanco POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            /* Ruta de la imagen cargada */
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/images/fondo estanco.png');

            /* Ajustes para cobertura total */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        /* Estilo para que las letras del título resalten */
        h2 {
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        /* Tarjetas con un poco de transparencia para efecto elegante */
        .card {
            background-color: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(5px);
            border: none !important;
        }

        .text-muted p {
            color: white !important;
            background: rgba(0,0,0,0.5);
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Gestión de Mesas</h2>

            <div class="d-flex gap-3">
                <a href="{{ route('sales.report') }}" class="btn btn-warning shadow-sm fw-bold">
                    <i class="bi bi-graph-up"></i> Reporte de Ventas
                </a>

                <form action="{{ route('tables.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name" class="form-control" placeholder="Nombre de mesa" required>
                    <button type="submit" class="btn btn-primary shadow">Añadir</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            @forelse($tables as $table)
                <div class="col-md-3 mb-4">
                    <div class="card shadow {{ $table->status == 'disponible' ? 'border-top border-success border-4' : 'border-top border-danger border-4' }}">
                        <div class="card-body text-center">
                            <i class="bi bi-house-door fs-1 {{ $table->status == 'disponible' ? 'text-success' : 'text-danger' }}"></i>
                            <h5 class="card-title mt-2 fw-bold">{{ $table->name }}</h5>

                            <span class="badge {{ $table->status == 'disponible' ? 'bg-success' : 'bg-danger' }} mb-3">
                                {{ strtoupper($table->status) }}
                            </span>

                            <div class="mt-1 d-grid gap-2">
                                @if($table->status == 'disponible')
                                    <form action="{{ route('tables.open', $table->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary w-100 fw-bold">
                                            <i class="bi bi-unlock"></i> Abrir Cuenta
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('tables.show', $table->id) }}" class="btn btn-sm btn-danger w-100 fw-bold">
                                        <i class="bi bi-eye"></i> Ver Pedido
                                    </a>

                                    <form action="{{ route('tables.close', $table->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success w-100 fw-bold" onclick="return confirm('¿Seguro que deseas cobrar y liberar la mesa?')">
                                            <i class="bi bi-check-circle"></i> Liberar Mesa
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    <p>No hay mesas configuradas. ¡Crea la primera arriba!</p>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</body>
</html>
