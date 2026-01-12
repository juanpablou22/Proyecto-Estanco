@extends('layouts.app') @section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-box-seam text-primary"></i> Control de Inventario</h2>
        <a href="{{ route('products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Producto</th>
                        <th>Precio Venta</th>
                        <th class="text-center">Stock Actual</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $product->name }}</td>
                        <td>$ {{ number_format($product->price, 0) }}</td>
                        <td class="text-center">
                            <span class="fs-5 fw-bold {{ $product->stock <= 5 ? 'text-danger' : 'text-dark' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            @if($product->stock <= 0)
                                <span class="badge bg-danger">Agotado</span>
                            @elseif($product->stock <= 10)
                                <span class="badge bg-warning text-dark">Bajo Stock</span>
                            @else
                                <span class="badge bg-success">Disponible</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
