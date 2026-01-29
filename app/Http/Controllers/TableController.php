<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TableController extends Controller
{
    /**
     * Muestra el panel de mesas (Tablero visual).
     */
    public function index()
    {
        $tables = Table::all();
        return view('tables.index', compact('tables'));
    }

    /**
     * Registra una nueva mesa en el sistema.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:tables']);

        Table::create([
            'name' => $request->name,
            'status' => 'disponible'
        ]);

        return redirect()->back()->with('success', 'Mesa creada correctamente.');
    }

    /**
     * NUEVO: Elimina una mesa del sistema.
     */
    public function destroy($id)
    {
        $table = Table::findOrFail($id);

        // Seguridad: No permitir borrar si la mesa está ocupada
        if ($table->status === 'ocupada') {
            return redirect()->back()->with('error', 'No puedes eliminar una mesa que tiene una cuenta abierta.');
        }

        $table->delete();
        return redirect()->back()->with('success', 'Mesa eliminada correctamente.');
    }

    /**
     * Cambia el estado de la mesa a 'ocupada'.
     */
    public function open(Table $table)
    {
        $table->update([
            'status' => 'ocupada'
        ]);

        return redirect()->route('tables.show', $table->id)->with('success', 'Cuenta abierta para ' . $table->name);
    }

    /**
     * Muestra el detalle de una mesa y su cuenta actual.
     */
    public function show(Table $table)
    {
        $products = Product::where('stock', '>', 0)->get();

        $currentOrders = Order::where('table_id', $table->id)
                            ->with('product')
                            ->get();

        return view('tables.show', compact('table', 'products', 'currentOrders'));
    }

    /**
     * Agrega un producto al pedido y descuenta del stock.
     */
    public function addProduct(Request $request, Table $table)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'No hay suficiente stock de ' . $product->name);
        }

        Order::create([
            'table_id' => $table->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price
        ]);

        $product->decrement('stock', $request->quantity);

        return redirect()->back()->with('success', 'Producto añadido a la cuenta.');
    }

    /**
     * Elimina un producto del pedido y devuelve la cantidad al stock.
     */
    public function removeProduct(Order $order)
    {
        $product = Product::find($order->product_id);

        if ($product) {
            $product->increment('stock', $order->quantity);
        }

        $order->delete();

        return redirect()->back()->with('success', 'Producto eliminado y stock restaurado.');
    }

    /**
     * Cierra la cuenta, REGISTRA LA VENTA y libera la mesa.
     */
    public function close(Request $request, Table $table)
    {
        $orders = Order::where('table_id', $table->id)->get();
        $totalCuenta = $orders->sum(function($order) {
            return $order->quantity * $order->price;
        });

        if ($totalCuenta > 0) {
            Sale::create([
                'table_name' => $table->name,
                'total' => $totalCuenta,
                'payment_method' => $request->payment_method ?? 'Efectivo'
            ]);

            Order::where('table_id', $table->id)->delete();
        }

        $table->update([
            'status' => 'disponible'
        ]);

        return redirect()->route('tables.index')->with('success', 'Venta registrada: $' . number_format($totalCuenta, 0) . ' y mesa liberada.');
    }

    /**
     * Reporte histórico de ventas.
     */
    public function salesReport(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicio', now()->format('Y-m-d'));
        $fecha_fin = $request->get('fecha_fin', now()->format('Y-m-d'));

        $sales = Sale::whereDate('created_at', '>=', $fecha_inicio)
                     ->whereDate('created_at', '<=', $fecha_fin)
                     ->orderBy('created_at', 'desc')
                     ->get();

        $totalGeneral = $sales->sum('total');

        $totalesPorMetodo = Sale::whereDate('created_at', '>=', $fecha_inicio)
                                ->whereDate('created_at', '<=', $fecha_fin)
                                ->select('payment_method', DB::raw('SUM(total) as total'))
                                ->groupBy('payment_method')
                                ->get();

        return view('sales.report', compact('sales', 'totalGeneral', 'totalesPorMetodo', 'fecha_inicio', 'fecha_fin'));
    }

    /**
     * Genera PDF del reporte de ventas.
     */
    public function downloadPDF(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicio', now()->format('Y-m-d'));
        $fecha_fin = $request->get('fecha_fin', now()->format('Y-m-d'));

        $sales = Sale::whereDate('created_at', '>=', $fecha_inicio)
                     ->whereDate('created_at', '<=', $fecha_fin)
                     ->get();

        $totalGeneral = $sales->sum('total');
        $totalesPorMetodo = Sale::whereDate('created_at', '>=', $fecha_inicio)
                                ->whereDate('created_at', '<=', $fecha_fin)
                                ->select('payment_method', DB::raw('SUM(total) as total'))
                                ->groupBy('payment_method')
                                ->get();

        $pdf = Pdf::loadView('sales.pdf_report', compact('sales', 'totalGeneral', 'totalesPorMetodo', 'fecha_inicio', 'fecha_fin'));
        return $pdf->download("reporte-ventas-{$fecha_inicio}.pdf");
    }
}
