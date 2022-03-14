<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
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
            $table->string('empresa_id');
            $table->string('user_id')->nullable();
            $table->string('entrega')->nullable();
            $table->string('local_id')->nullable();
            $table->string('cliente_id')->nullable();
            $table->string('cliente_nombre')->nullable();
            $table->string('cliente_apellido')->nullable();
            $table->string('cliente_telefono')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_ciudad')->nullable();
            $table->string('cliente_direccion')->nullable();
            $table->string('cliente_apartamento')->nullable();
            $table->string('cliente_observacion')->nullable();
            $table->string('precio')->nullable();
            $table->string('descuento')->nullable();
            $table->string('mp_id')->nullable();
            $table->string('observacion')->nullable();
            $table->string('estado')->nullable();
            $table->string('codigo');
            $table->string('codigo_num')->nullable();
            $table->timestamps();
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
}
