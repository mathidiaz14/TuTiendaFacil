<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_entradas', function (Blueprint $table) {
            $table->id();
            $table->string('empresa_id');
            $table->string('titulo')->nullable();
            $table->text('contenido')->nullable();
            $table->text('extracto')->nullable();
            $table->string('url'); 
            $table->string('imagen')->nullable();
            $table->string('meta_descripcion')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('estado')->default('borrador');
            $table->string('user_id');
            $table->string('categoria_id')->nullable();
            $table->string('comentario_activo')->nullable();
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
        Schema::dropIfExists('blog_entradas');
    }
}
