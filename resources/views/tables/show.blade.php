<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido - {{ $table->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="mb-4">
            <a href="{{ route('tables.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver a Mesas
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-5">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Añadir al Pedido</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tables.add-product', $table->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Producto</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="" disabled selected>Seleccione un producto...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }} (${{ number_format($product->price, 0) }}) - Stock: {{ $product->stock }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Agregar a la cuenta
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card shadow border-0">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Cuenta Actual - {{ $table->name }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cant.</th>
                                    <th>Producto</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @forelse($currentOrders as $order)
                                    @php
                                        $subtotal = $order->quantity * $order->price;
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $order->quantity }}</td>
                                        <td>{{ $order->product->name }}</td>
                                        <td class="text-end">${{ number_format($subtotal, 0) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            No hay productos en esta cuenta todavía.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Total:</h4>
                            <h3 class="text-danger mb-0">$ {{ number_format($total, 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
