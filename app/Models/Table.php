<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',   // Ejemplo: "Mesa 1", "Barra", "VIP"
        'status', // Ejemplo: "disponible", "ocupada"
    ];
}
