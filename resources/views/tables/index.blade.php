<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas - Estanco POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Mesas</h2>
            <form action="{{ route('tables.store') }}" method="POST" class="d-flex gap-2">
                @csrf
                <input type="text" name="name" class="form-control" placeholder="Nombre de mesa (ej: Mesa 5)" required>
                <button type="submit" class="btn btn-primary">Añadir Mesa</button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            @forelse($tables as $table)
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm {{ $table->status == 'disponible' ? 'border-success' : 'border-danger' }}">
                        <div class="card-body text-center">
                            <i class="bi bi-house-door fs-1 {{ $table->status == 'disponible' ? 'text-success' : 'text-danger' }}"></i>
                            <h5 class="card-title mt-2">{{ $table->name }}</h5>

                            <span class="badge {{ $table->status == 'disponible' ? 'bg-success' : 'bg-danger' }}">
                                {{ strtoupper($table->status) }}
                            </span>

                            <div class="mt-3 d-grid gap-2">
                                @if($table->status == 'disponible')
                                    <form action="{{ route('tables.open', $table->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                                            <i class="bi bi-unlock"></i> Abrir Cuenta
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('tables.show', $table->id) }}" class="btn btn-sm btn-danger w-100">
                                        <i class="bi bi-eye"></i> Ver Pedido
                                    </a>

                                    <form action="{{ route('tables.close', $table->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success w-100" onclick="return confirm('¿Seguro que deseas liberar la mesa?')">
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
