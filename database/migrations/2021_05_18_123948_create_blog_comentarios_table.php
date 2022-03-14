<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_comentarios', function (Blueprint $table) {
            $table->id();
            $table->string('empresa_id');
            $table->string('entrada_id');
            $table->string('user_id')->nullable();
            $table->string('user_name');
            $table->string('user_email');
            $table->text('contenido');
            $table->string('estado');
            $table->string('parent_id')->nullable();
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
        Schema::dropIfExists('blog_comentarios');
    }
}
