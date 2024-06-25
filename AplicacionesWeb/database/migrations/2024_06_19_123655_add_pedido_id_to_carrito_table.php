<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPedidoIdToCarritoTable extends Migration
{
    public function up()
    {
        Schema::table('carrito', function (Blueprint $table) {
            $table->unsignedBigInteger('pedido_id')->nullable()->after('autopart_id');

            // Foreign key constraint, assuming 'pedido_id' references 'id' on 'pedidos' table
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('carrito', function (Blueprint $table) {
            $table->dropForeign(['pedido_id']);
            $table->dropColumn('pedido_id');
        });
    }
}