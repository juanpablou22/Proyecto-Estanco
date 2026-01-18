@extends('layouts.app')

@section('content')
<style>
    body {
        /* Fondo con imagen de bar/estanco y overlay oscuro */
        background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                          url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2070&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        color: white;
    }

    /* Tarjeta Efecto Cristal */
    .glass-card {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px !important;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    }

    .table {
        color: white !important;
        --bs-table-bg: transparent;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
    }

    .table thead th {
        background: rgba(255, 255, 255, 0.1);
        color: #ffc107; /* Dorado */
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        border: none;
        padding: 15px;
    }

    .table td {
        padding: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .stock-number {
        font-size: 1.2rem;
        font-weight: 800;
    }

    .badge-status {
        padding: 8px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .value-footer {
        background: rgba(255, 193, 7, 0.1);
        border-radius: 0 0 20px 20px;
        padding: 20px;
        border-top: 1px solid rgba(255, 193, 7, 0.2);
    }

    .btn-action {
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-action:hover {
        transform: scale(1.05);
    }
</style>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-white mb-0">
                <i class="bi bi-shield-check text-warning"></i> Control de Inventario
            </h2>
            <p class="text-white-50">Monitoreo de existencias y valor de capital</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('inventory.pdf') }}" class="btn btn-outline-danger rounded-pill px-4">
                <i class="bi bi-file-pdf"></i> Reporte PDF
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-warning rounded-pill px-4 fw-bold">
                <i class="bi bi-plus-lg"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <div class="glass-card card border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Producto</th>
                            <th>Precio Venta</th>
                            <th class="text-center">Stock</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold fs-5">{{ $product->name }}</div>
                                <small class="text-white-50">Ref: #00{{ $product->id }}</small>
                            </td>
                            <td>
                                <span class="text-warning fw-bold fs-5">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="stock-number {{ $product->stock <= 5 ? 'text-danger' : 'text-success' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                @if($product->stock <= 0)
                                    <span class="badge bg-danger badge-status text-white">AGOTADO</span>
                                @elseif($product->stock <= 10)
                                    <span class="badge bg-warning badge-status text-dark">CRÍTICO</span>
                                @else
                                    <span class="badge bg-success badge-status text-white">OPTIMO</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-light btn-action">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="value-footer d-flex justify-content-between align-items-center">
            <span class="text-uppercase fw-bold text-white-50">Capital total en mercancía:</span>
            <h3 class="text-warning fw-bold mb-0">
                ${{ number_format($valorTotalBodega ?? 0, 0, ',', '.') }}
            </h3>
        </div>
    </div>
</div>
@endsection
