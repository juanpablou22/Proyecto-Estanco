@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">

                <div class="card-header bg-dark py-3 px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary p-2 rounded-3 me-3">
                            <i class="bi bi-truck text-white fs-4"></i>
                        </div>
                        <div>
                            <h5 class="text-white mb-0 fw-bold">Gestión de Surtido</h5>
                            <small class="text-white-50">Entrada de mercancía y control de costos financieros</small>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i> Panel Principal
                    </a>
                </div>

                <div class="card-body p-4 bg-white">

                    {{-- Formulario de Registro Profesional --}}
                    <div class="p-4 rounded-4 mb-5" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                        <h6 class="fw-bold mb-4 text-dark"><i class="bi bi-plus-circle-fill text-success me-2"></i>Nueva Entrada de Inventario</h6>

                        <form action="{{ route('purchases.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold text-secondary">Producto / Licor</label>
                                    <select name="product_id" class="form-select border-0 shadow-sm py-2" required>
                                        <option value="">Seleccione un producto...</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }} (Actual: {{ $product->stock }} unidades)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small fw-semibold text-secondary">Cantidad</label>
                                    <input type="number" name="quantity" class="form-control border-0 shadow-sm py-2" min="1" placeholder="Ej: 100" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small fw-semibold text-secondary">Costo Unitario ($)</label>
                                    <div class="input-group shadow-sm rounded">
                                        <span class="input-group-text border-0 bg-white text-muted">$</span>
                                        <input type="number" name="cost_price" class="form-control border-0 py-2" step="0.01" placeholder="0.00" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label small fw-semibold text-secondary">Proveedor</label>
                                    <input type="text" name="supplier" class="form-control border-0 shadow-sm py-2" placeholder="Ej: Distribuidora S.A.">
                                </div>

                                <div class="col-md-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-dark btn-lg px-5 shadow rounded-pill fw-bold">
                                        <i class="bi bi-check2-all me-2"></i>Registrar y Actualizar Stock
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Sección de Historial y Reportes --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold text-uppercase tracking-wider text-muted mb-0">Historial de Abastecimiento Detallado</h6>

                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('purchases.pdf') }}" class="btn btn-danger btn-sm rounded-pill px-4 shadow-sm fw-bold">
                                <i class="bi bi-file-earmark-pdf-fill me-2"></i>DESCARGAR PDF
                            </a>

                            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill border border-primary border-opacity-25">
                                Total Registros: {{ $purchases->count() }}
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive rounded-3">
                        <table class="table table-hover align-middle border-bottom">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th class="ps-4 py-3">Fecha y Hora</th>
                                    <th>Proveedor</th>
                                    <th>Producto</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">V. Unitario</th>
                                    <th class="text-end pe-4">Inversión Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                <tr class="border-start border-4 border-transparent hover-border-primary">
                                    <td class="ps-4">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $purchase->created_at->format('d M, Y') }}</span>
                                            <small class="text-muted">{{ $purchase->created_at->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $purchase->supplier ?? 'Proveedor General' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border p-2 fw-semibold">
                                            {{ $purchase->product->name }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-success fw-bold">+{{ $purchase->quantity }}</span>
                                    </td>
                                    <td class="text-end text-muted">
                                        ${{ number_format($purchase->cost_price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end pe-4 fw-bold text-primary">
                                        ${{ number_format($purchase->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-info-circle fs-2 d-block mb-2"></i>
                                        No se han registrado compras de mercancía aún.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-border-primary:hover {
        border-left-color: #0d6efd !important;
        background-color: #f8f9fa;
    }
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
    }
    /* Estilo para el botón PDF para que resalte profesionalmente */
    .btn-danger {
        background-color: #dc3545;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        background-color: #b02a37;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
</style>
@endsection
