<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Estanco POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-dark: #1a1a1a;
            --accent-gold: #ffc107;
        }

        body {
            /* Imagen de fondo profesional */
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                        url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: white;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 200px;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-10px);
            border-color: var(--accent-gold);
            color: var(--accent-gold);
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 1.8rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-card {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            padding: 15px;
            border-left: 4px solid var(--accent-gold);
        }

        .navbar-custom {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark navbar-custom px-4 py-3 mb-5">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-shield-check text-warning me-2"></i>ESTANCO POS
            </span>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline opacity-75">Administrador</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-power me-1"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-5">
            <div class="col-md-8">
                <h1 class="fw-bold">Panel de Control</h1>
                <p class="text-white-50">Bienvenido de nuevo. Aquí tienes el resumen de tu negocio hoy.</p>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <span class="small text-white-50">MESAS ABIERTAS</span>
                    <h3 class="fw-bold mb-0 text-warning">{{ $mesasActivas ?? '0' }}</h3>
                </div>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('tables.index') }}" class="glass-card shadow">
                    <div class="icon-circle">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>
                    <span class="fw-bold">MESAS</span>
                </a>
            </div>



            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('purchases.index') }}" class="glass-card shadow">
                    <div class="icon-circle">
                        <i class="bi bi-truck"></i>
                    </div>
                    <span class="fw-bold">SURTIDO</span>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('sales.report') }}" class="glass-card shadow">
                    <div class="icon-circle">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <span class="fw-bold">REPORTES</span>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('products.index') }}" class="glass-card shadow">
                    <div class="icon-circle">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <span class="fw-bold">PRODUCTOS</span>
                </a>
            </div>

        </div>

        <div class="row mt-5">
            <div class="col text-center opacity-50 small">
                <p>Estanco POS v1.0 | Sistema de Gestión de Inventario y Ventas</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
