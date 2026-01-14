<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Importamos la librería para el PDF

class ProductController extends Controller
{
    /**
     * Muestra la lista de productos (Gestión CRUD).
     */
    public function index()
    {
        $products = Product::orderBy('name')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Producto registrado correctamente.');
    }

    /**
     * Muestra el formulario para editar un producto.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Actualiza el producto en la base de datos.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto del inventario.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Producto eliminado del sistema.');
    }

    /**
     * VISTA DE INVENTARIO PROFESIONAL
     * Aquí corregimos la ruta de la vista para que no te dé error 404.
     */
    public function inventory()
    {
        $products = Product::all();

        // Calculamos el valor total de la mercancía para el dueño
        $valorTotalBodega = $products->sum(function($product) {
            return $product->stock * $product->price;
        });

        // IMPORTANTE: Ruta corregida según tu estructura de carpetas
        return view('products.inventory.index', compact('products', 'valorTotalBodega'));
    }

    /**
     * GENERAR REPORTE PDF DEL INVENTARIO
     */
    public function generateInventoryPDF()
    {
        $products = Product::orderBy('name')->get();
        $valorTotal = $products->sum(fn($p) => $p->stock * $p->price);

        // Cargamos la vista del reporte (Debes crearla en resources/views/products/inventory/pdf.blade.php)
        $pdf = Pdf::loadView('products.inventory.pdf', compact('products', 'valorTotal'));

        return $pdf->download('Inventario_Total_'.date('d-m-Y').'.pdf');
    }
}
