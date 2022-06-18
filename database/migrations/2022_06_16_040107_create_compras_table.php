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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_compra')->nullable();
            $table->integer('total_compra')->default(0);
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_proveedor');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('RESTRICT')->onUpdate('CASCADE');
            $table->foreign('id_proveedor')->references('id')->on('proveedores')->onDelete('RESTRICT')->onUpdate('CASCADE');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
};
