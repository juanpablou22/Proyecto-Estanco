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
        // 1. Nos aseguramos de que 'username' exista antes de intentar poner algo 'after'
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->unique()->after('id');
            });
        }

        // 2. Ahora que 'username' existe sí o sí, añadimos el rol y quitamos el email
        Schema::table('users', function (Blueprint $table) {
            // Agregar 'role'
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('empleado')->after('username');
            }

            // Eliminar 'email' de forma segura
            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }

            // Eliminar 'email_verified_at' de forma segura
            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restaurar campos originales
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->after('id');
            }

            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            // Eliminar campos personalizados
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};
