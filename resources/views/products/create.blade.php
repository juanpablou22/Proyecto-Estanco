<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Producto - Estanco</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Agregar Nuevo Producto al Inventario</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nombre del Licor / Producto</label>
                                <input type="text" name="name" class="form-control" placeholder="Ej: Ron Viejo de Caldas 750ml" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción (Opcional)</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Detalles adicionales..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Precio de Venta</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="price" class="form-control" placeholder="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock Inicial</label>
                                    <input type="number" name="stock" class="form-control" placeholder="Cantidad" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">Guardar Producto</button>
                                <a href="{{ route('products.index') }}" class="btn btn-light">Volver al listado</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
