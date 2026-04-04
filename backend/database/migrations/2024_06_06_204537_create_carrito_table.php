<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritoTable extends Migration
{
    public function up()
    {
        Schema::create('carrito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('autopart_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Foreign key constraint, assuming 'autopart_id' references 'id' on 'autopart' table
            $table->foreign('autopart_id')->references('id')->on('autopart')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carrito');
    }
}