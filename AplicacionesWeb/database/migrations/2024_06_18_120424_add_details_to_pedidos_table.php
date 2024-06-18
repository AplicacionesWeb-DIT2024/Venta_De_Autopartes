<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToPedidosTable extends Migration
{
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('numero_pedido')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->decimal('costo_total', 8, 2)->nullable();
            $table->string('tipo_pago')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['numero_pedido', 'fecha_cierre', 'costo_total', 'tipo_pago']);
        });
    }
}
