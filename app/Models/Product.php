<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Estos campos deben coincidir con tu migración
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];
}
