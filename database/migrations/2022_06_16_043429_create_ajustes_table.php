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
        Schema::create('ajustes', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->date('fecha_ajuste')->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_producto');

            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('RESTRICT')->onUpdate('CASCADE');
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
        Schema::dropIfExists('ajustes');
    }
};
