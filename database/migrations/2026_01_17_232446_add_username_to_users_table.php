<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregar 'role' si no existe
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('empleado')->after('username');
            }

            // Eliminar 'email' y 'email_verified_at' si existen
            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restaurar campos eliminados
            $table->string('email')->unique()->after('role');
            $table->timestamp('email_verified_at')->nullable()->after('email');

            // No eliminar 'username' ni 'role' si ya están en uso
        });
    }
};