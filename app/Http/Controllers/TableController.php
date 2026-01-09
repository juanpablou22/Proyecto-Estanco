<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Product;
use App\Models\Order; // Anexamos el modelo Order
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
     * Cambia el estado de la mesa a 'ocupada'.
     */
    public function open(Table $table)
    {
        $table->update([
            'status' => 'ocupada'
        ]);

        return redirect()->route('tables.index')->with('success', 'La ' . $table->name . ' ahora está ocupada.');
    }

    /**
     * Muestra el detalle de una mesa y su cuenta actual.
     */
    public function show(Table $table)
    {
        // Traemos los productos con stock para el selector
        $products = Product::where('stock', '>', 0)->get();

        // ANEXO: Traemos los pedidos actuales de esta mesa con su relación de producto
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

        // ANEXO: Guardamos el registro del pedido en la base de datos
        Order::create([
            'table_id' => $table->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price // Guardamos el precio actual por si cambia después
        ]);

        // Descontar del inventario automáticamente
        $product->decrement('stock', $request->quantity);

        return redirect()->back()->with('success', 'Producto añadido a la cuenta.');
    }

    /**
     * Cambia el estado de la mesa a 'disponible' y limpia la cuenta.
     */
    public function close(Table $table)
    {
        // ANEXO: Al liberar la mesa, borramos los pedidos asociados
        // (En un sistema avanzado, aquí los marcarías como "pagados" en otra tabla)
        Order::where('table_id', $table->id)->delete();

        $table->update([
            'status' => 'disponible'
        ]);

        return redirect()->route('tables.index')->with('success', 'La ' . $table->name . ' ha sido liberada y la cuenta cerrada.');
    }
}
