<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('empresa_id');
            $table->string('categoria_id')->nullable();
            $table->string('proveedor_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('nombre')->nullable();
            $table->string('cantidad')->nullable();
            $table->string('costo')->nullable();
            $table->string('precio')->nullable();
            $table->string('precio_promocion')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('estado')->default('borrador');
            $table->string('nuevo')->nullable();
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
        Schema::dropIfExists('productos');
    }
}
