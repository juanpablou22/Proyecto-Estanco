<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            // Relacionamos con la tabla de productos
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Datos del surtido
            $table->string('supplier')->nullable(); // Nombre del proveedor o tienda
            $table->integer('quantity');            // Cantidad que compró
            $table->decimal('cost_price', 12, 2);   // Precio al que compró cada unidad
            $table->decimal('total_amount', 12, 2); // Costo total de esa compra (Cant * Precio)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
