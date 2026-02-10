<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas - Estanco POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .card-table {
            position: relative;
            transition: transform 0.2s;
            overflow: visible !important; /* Asegura que la X no se corte */
        }
        .card-table:hover { transform: translateY(-5px); }

        /* Botón de eliminar con estilo reforzado */
        .btn-delete-table {
            position: absolute;
            top: -10px; /* Un poco salido para que se vea bien */
            right: -10px;
            background: white;
            border: 2px solid #dc3545;
            color: #dc3545;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050; /* Por encima de todo */
            padding: 0;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .btn-delete-table:hover {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">

        {{-- Diagnóstico visual para el desarrollador --}}
        <div class="alert alert-dark p-2 mb-4" style="font-size: 0.8rem;">
            Sesión iniciada como: <strong>{{ Auth::user()->name }}</strong> |
            Rol: <span class="badge bg-primary">{{ Auth::user()->role }}</span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Mesas</h2>

            <div class="d-flex gap-3">
                <a href="{{ route('sales.report') }}" class="btn btn-warning shadow-sm">
                    <i class="bi bi-graph-up"></i> Ver Reporte de Ventas
                </a>

                <form action="{{ route('tables.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name" class="form-control" placeholder="Nombre de mesa" required>
                    <button type="submit" class="btn btn-primary">Añadir Mesa</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mt-4">
            @forelse($tables as $table)
                <div class="col-md-3 mb-5">
                    <div class="card shadow-sm card-table {{ $table->status == 'disponible' ? 'border-success' : 'border-danger' }}">

                        {{-- Lógica de Rol Reforzada --}}
                        @php
                            $roleCheck = strtolower(trim(Auth::user()->role));
                        @endphp

                        @if($roleCheck == 'admin' || $roleCheck == 'empleado')
                            <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta mesa definitivamente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-table" title="Eliminar Mesa">
                                    <i class="bi bi-x"></i>
                                </button>
                            </form>
                        @endif

                        <div class="card-body text-center p-4">
                            <i class="bi bi-house-door fs-1 {{ $table->status == 'disponible' ? 'text-success' : 'text-danger' }}"></i>
                            <h5 class="card-title mt-2">{{ $table->name }}</h5>

                            <span class="badge {{ $table->status == 'disponible' ? 'bg-success' : 'bg-danger' }} mb-3">
                                {{ strtoupper($table->status) }}
                            </span>

                            <div class="d-grid gap-2">
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
                                        <button type="submit" class="btn btn-sm btn-outline-success w-100" onclick="return confirm('¿Seguro que deseas cobrar y liberar la mesa?')">
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
                    <p>No hay mesas configuradas.</p>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
