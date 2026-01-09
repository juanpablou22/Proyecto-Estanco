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
        $table->foreignId('table_id')->constrained(); // Relación con la mesa
        $table->string('seller_name'); // Nombre del vendedor que atiende
        $table->decimal('total', 10, 2)->default(0);
        // 'open' = Factura abierta (no afecta inventario todavía)
        // 'closed' = Factura confirmada (aquí sí se descuenta)
        $table->string('status')->default('open');
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
