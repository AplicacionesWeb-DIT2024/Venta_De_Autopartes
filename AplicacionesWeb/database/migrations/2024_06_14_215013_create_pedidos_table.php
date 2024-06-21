<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numero_pedido')->nullable()->unique(); // número de pedido como secuencia única
            $table->timestamp('fecha_cierre');
            $table->decimal('costo_total', 8, 2);
            $table->string('tipo_pago');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}