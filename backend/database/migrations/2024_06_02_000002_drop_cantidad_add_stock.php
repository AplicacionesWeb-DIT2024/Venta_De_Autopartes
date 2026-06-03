<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCantidadAddStock extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carrito', function (Blueprint $table) {
            // Drop cantidad column if it exists and stock doesn't
            if (Schema::hasColumn('carrito', 'cantidad') && !Schema::hasColumn('carrito', 'stock')) {
                $table->renameColumn('cantidad', 'stock');
            } elseif (Schema::hasColumn('carrito', 'cantidad') && Schema::hasColumn('carrito', 'stock')) {
                // If both exist, drop cantidad
                $table->dropColumn('cantidad');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrito', function (Blueprint $table) {
            // On rollback, do nothing as we're just cleaning up
        });
    }
}
