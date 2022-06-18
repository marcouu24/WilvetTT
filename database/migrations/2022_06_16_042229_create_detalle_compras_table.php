<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad')->default(0);
            $table->integer('total_detalle')->default(0);
            $table->integer('precio_unitario')->default(0);
            $table->unsignedBigInteger('id_compra');
            $table->unsignedBigInteger('id_producto');

            $table->foreign('id_compra')->references('id')->on('compras')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_compras');
    }
};
