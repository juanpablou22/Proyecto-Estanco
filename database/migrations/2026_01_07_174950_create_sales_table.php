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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            // Guardamos el nombre de la mesa como texto para el historial permanente
            $table->string('table_name');

            // Relación opcional con el ID de la mesa
            $table->foreignId('table_id')->nullable()->constrained()->onDelete('set null');

            // Nombre del vendedor/mesero
            $table->string('seller_name')->nullable();

            $table->decimal('total', 12, 2)->default(0);

            // Método de pago (Vital para el reporte)
            $table->string('payment_method')->default('Efectivo');

            // Estado de la venta
            $table->string('status')->default('closed');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
