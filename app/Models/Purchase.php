<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    /**
     * Campos que permiten asignación masiva.
     * Estos deben coincidir con lo que enviamos desde el PurchaseController.
     */
    protected $fillable = [
        'product_id',
        'supplier',
        'quantity',
        'cost_price',
        'total_amount'
    ];

    /**
     * Relación: Una compra pertenece a un solo producto.
     * Esto permite hacer $purchase->product->name en las vistas.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
