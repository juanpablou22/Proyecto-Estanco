<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Table;
use App\Models\Purchase;

class HomeController extends Controller
{
    public function __construct()
    {
        // Esto asegura que solo usuarios logueados vean el menú
        $this->middleware('auth');
    }

    public function index()
    {
        // Datos rápidos para las tarjetas o el saludo
        $totalProductos = Product::count();
        $mesasActivas = Table::where('status', 'open')->count();
        $ultimasCompras = Purchase::with('product')->latest()->take(5)->get();

        return view('home', compact('totalProductos', 'mesasActivas', 'ultimasCompras'));
    }
}

