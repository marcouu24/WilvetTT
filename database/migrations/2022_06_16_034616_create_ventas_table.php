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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_venta')->nullable();
            $table->integer('total_venta')->default(0);
            $table->timestamps();
            $table->string('rut_cliente',10);
            $table->unsignedBigInteger('id_usuario');

            $table->foreign('rut_cliente')->references('rut')->on('clientes')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
