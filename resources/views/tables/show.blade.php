<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido - {{ $table->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            /* Imagen de fondo específica para pedidos */
            background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
                              url('/images/fondo pedido.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: white;
        }

        /* Efecto de cristal para las tarjetas */
        .card {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        /* Estilo para tablas y textos internos */
        .table {
            color: white !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: white !important;
        }

        .form-label, .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
        }

        /* Resalte para el total */
        .total-box {
            background: rgba(220, 53, 69, 0.2);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid rgba(220, 53, 69, 0.5);
        }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('tables.index') }}" class="btn btn-outline-light">
                <i class="bi bi-arrow-left"></i> Volver a Mesas
            </a>

            @if(count($currentOrders) > 0)
                <form action="{{ route('tables.close', $table->id) }}" method="POST" class="d-flex gap-2 align-items-center" onsubmit="return confirm('¿Deseas registrar el pago y liberar la mesa?')">
                    @csrf
                    <select name="payment_method" class="form-select border-success shadow-sm" style="width: auto;" required>
                        <option value="Efectivo">💵 Efectivo</option>
                        <option value="Nequi">📱 Nequi</option>
                        <option value="Transferencia">🏦 Transferencia</option>
                        <option value="Tarjeta">💳 Tarjeta</option>
                    </select>
                    <button type="submit" class="btn btn-success shadow">
                        <i class="bi bi-cash-stack"></i> Finalizar Venta
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-header bg-transparent text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Añadir al Pedido</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tables.add-product', $table->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Seleccionar Producto</label>
                                <select name="product_id" class="form-select" required>
                                    <option value="" disabled selected>Busca un producto...</option>
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
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
                                <i class="bi bi-cart-plus"></i> AGREGAR A LA CUENTA
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-transparent text-white py-3">
                        <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-receipt me-2"></i>Cuenta Actual - {{ $table->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr class="text-uppercase small" style="letter-spacing: 1px;">
                                        <th>Cant.</th>
                                        <th>Producto</th>
                                        <th class="text-end">Subtotal</th>
                                        <th class="text-center">Acción</th>
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
                                            <td class="fw-bold">{{ $order->quantity }}</td>
                                            <td>{{ $order->product->name }}</td>
                                            <td class="text-end font-monospace fw-bold fs-5">${{ number_format($subtotal, 0) }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('orders.remove', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Eliminar" onclick="return confirm('¿Eliminar este producto?')">
                                                        <i class="bi bi-trash fs-5"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 opacity-50">
                                                <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                                                Aún no hay productos en esta cuenta.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="total-box mt-4 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold">TOTAL A PAGAR:</h4>
                            <h2 class="text-warning mb-0 fw-bold font-monospace">$ {{ number_format($total, 0) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
