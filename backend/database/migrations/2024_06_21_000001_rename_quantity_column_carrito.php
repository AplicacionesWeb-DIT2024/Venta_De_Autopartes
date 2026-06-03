<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameQuantityColumnCarrito extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('carrito', function (Blueprint $table) {
            // Rename quantity to stock
            if (Schema::hasColumn('carrito', 'quantity')) {
                $table->renameColumn('quantity', 'stock');
            } elseif (Schema::hasColumn('carrito', 'cantidad')) {
                $table->renameColumn('cantidad', 'stock');
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
                $table->renameColumn('stock', 'quantity');
            }
        });
    }
}
