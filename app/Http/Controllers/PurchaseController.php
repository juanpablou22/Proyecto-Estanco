<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseController extends Controller
{
    /**
     * Muestra la vista de Surtido con la lista de compras y productos.
     */
    public function index()
    {
        // Traemos las compras con su producto relacionado (Eager Loading)
        $purchases = Purchase::with('product')->orderBy('created_at', 'desc')->get();

        // Traemos los productos para el selector del formulario, ordenados alfabéticamente
        $products = Product::orderBy('name')->get();

        // IMPORTANTE: Asegúrate de que la vista esté en resources/views/purchases/index.blade.php
        return view('purchases.index', compact('purchases', 'products'));
    }

    /**
     * Registra la compra y aumenta el stock del producto automáticamente.
     */
    public function store(Request $request)
    {
        // Validamos que los datos sean correctos
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
        ]);

        // 1. Calcular el total de la factura de compra
        $total_amount = $request->quantity * $request->cost_price;

        // 2. Registrar el ingreso en la tabla de compras (Surtido)
        Purchase::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'cost_price' => $request->cost_price,
            'total_amount' => $total_amount,
            'supplier' => $request->supplier,
        ]);

        // 3. ACTUALIZAR EL INVENTARIO PRINCIPAL (Sumar lo que llegó)
        $product = Product::find($request->product_id);
        $product->increment('stock', $request->quantity);

        return redirect()->back()->with('success', '¡El surtido se registró y el stock subió correctamente!');
    }

    /**
     * Genera el reporte en PDF de todos los registros de surtido.
     */
    public function generatePDF()
    {
        $purchases = Purchase::with('product')->orderBy('created_at', 'desc')->get();

        // Calculamos el total invertido para mostrarlo en el reporte
        $totalInversion = $purchases->sum('total_amount');

        // Cargamos la vista del PDF (Asegúrate de crear resources/views/purchases/report_pdf.blade.php)
        $pdf = Pdf::loadView('purchases.report_pdf', compact('purchases', 'totalInversion'));

        return $pdf->download('Reporte_Surtido_'.date('d-m-Y').'.pdf');
    }
}
