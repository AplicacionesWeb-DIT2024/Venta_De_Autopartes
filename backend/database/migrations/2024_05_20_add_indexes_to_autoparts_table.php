<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('autoparts', function (Blueprint $table) {
            // Agregar índice al campo created_at para la ordenación
            $table->index('created_at');
            // Agregar índice al campo codigo para búsquedas rápidas
            $table->unique('codigo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('autoparts', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropUnique(['codigo']);
        });
    }
};
