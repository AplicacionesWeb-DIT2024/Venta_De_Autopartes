<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameQuantityToStockCarrito extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carrito', function (Blueprint $table) {
            // Rename cantidad to stock
            if (Schema::hasColumn('carrito', 'cantidad')) {
                $table->renameColumn('cantidad', 'stock');
            } elseif (Schema::hasColumn('carrito', 'quantity')) {
                $table->renameColumn('quantity', 'stock');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carrito', function (Blueprint $table) {
            if (Schema::hasColumn('carrito', 'stock')) {
                $table->renameColumn('stock', 'cantidad');
            }
        });
    }
}
