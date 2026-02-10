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
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/images/fondo estanco.png');
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

        .card {
            background-color: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(5px);
            border: none !important;
            transition: transform 0.2s;
            position: relative; /* Necesario para ubicar el botón X */
        }

        .card:hover {
            transform: scale(1.02);
        }

        .text-muted-custom p {
            color: white !important;
            background: rgba(0,0,0,0.5);
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-back:hover {
            background: #ffc107;
            color: black;
            border-color: #ffc107;
        }

        .btn-delete-table {
            position: absolute;
            top: 5px;
            right: 8px;
            color: #dc3545;
            opacity: 0.6;
            transition: opacity 0.2s;
            background: none;
            border: none;
            font-size: 1.2rem;
        }

        .btn-delete-table:hover {
            opacity: 1;
            color: #a71d2a;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                {{-- BOTÓN REGRESAR AL DASHBOARD --}}
                <a href="{{ route('home') }}" class="btn btn-back rounded-pill me-3 shadow-sm">
                    <i class="bi bi-house-door-fill me-2"></i> Menu Principal
                </a>
                <h2 class="mb-0">Gestión de Mesas</h2>
            </div>

            <div class="d-flex gap-3">
                @if(Auth::user()->role == 'admin')

                @endif

                <form action="{{ route('tables.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name" class="form-control shadow-sm" placeholder="Mesa o Cliente" required>
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

                        {{-- BOTÓN ELIMINAR (Solo Admin) --}}
                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'empleado')
                            <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta mesa definitivamente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-table" title="Eliminar Mesa">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            </form>
                        @endif

                        <div class="card-body text-center">
                            <i class="bi bi-house-door fs-1 {{ $table->status == 'disponible' ? 'text-success' : 'text-danger' }}"></i>
                            <h5 class="card-title mt-2 fw-bold text-dark">{{ $table->name }}</h5>

                            <span class="badge {{ $table->status == 'disponible' ? 'bg-success' : 'bg-danger' }} mb-3">
                                {{ strtoupper($table->status) }}
                            </span>

                            <div class="mt-1 d-grid gap-2">
                                @if($table->status == 'disponible')
                                    <form action="{{ route('tables.open', $table->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary w-100 fw-bold shadow-sm">
                                            <i class="bi bi-unlock"></i> Abrir Cuenta
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('tables.show', $table->id) }}" class="btn btn-sm btn-danger w-100 fw-bold shadow-sm">
                                        <i class="bi bi-eye"></i> Ver Pedido
                                    </a>

                                    <form action="{{ route('tables.close', $table->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success w-100 fw-bold shadow-sm" onclick="return confirm('¿Seguro que deseas cobrar y liberar la mesa?')">
                                            <i class="bi bi-check-circle"></i> Liberar Mesa
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted-custom">
                    <p>No hay mesas configuradas. ¡Crea la primera arriba!</p>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
