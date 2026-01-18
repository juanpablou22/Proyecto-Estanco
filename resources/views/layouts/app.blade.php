<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="bg-white">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-white text-uppercase" href="{{ url('/') }}">
                    <i class="bi bi-shield-check text-warning me-1"></i>{{ config('app.Estanco', 'Estanco POS') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @auth
                            {{-- ENLACES VISIBLES PARA TODOS (ADMIN Y EMPLEADO) --}}
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->routeIs('tables.index') ? 'active fw-bold text-warning' : '' }}" href="{{ route('tables.index') }}">
                                    <i class="bi bi-grid-3x3-gap"></i> Mesas
                                </a>
                            </li>

                            {{-- ENLACES SOLO PARA ADMINISTRADOR --}}
                            @if(Auth::user()->role == 'admin')
                                <li class="nav-item border-start border-secondary ms-2 ps-2">
                                    <a class="nav-link text-white {{ request()->routeIs('products.index') ? 'active fw-bold text-warning' : '' }}" href="{{ route('products.index') }}">
                                        <i class="bi bi-pencil-square"></i> Productos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('purchases.index') ? 'active fw-bold text-warning' : '' }}" href="{{ route('purchases.index') }}">
                                        <i class="bi bi-truck"></i> Surtido
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ request()->routeIs('sales.report') ? 'active fw-bold text-warning' : '' }}" href="{{ route('sales.report') }}">
                                        <i class="bi bi-file-earmark-bar-graph"></i> Reportes
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white border border-secondary rounded-pill px-3"
                                   href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end bg-dark border-secondary shadow" aria-labelledby="navbarDropdown">
                                    <div class="px-3 py-2 small text-muted text-uppercase border-bottom border-secondary mb-2">
                                        Rol: <strong class="text-warning">{{ Auth::user()->role }}</strong>
                                    </div>

                                    <a class="dropdown-item text-white" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right text-danger"></i> {{ __('Cerrar sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <style>
        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffc107 !important;
        }
        .nav-link.active {
            color: #ffc107 !important;
        }
    </style>
</body>
</html>
