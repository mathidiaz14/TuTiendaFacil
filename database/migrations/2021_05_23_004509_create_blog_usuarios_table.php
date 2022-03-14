<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('empresa_id');
            $table->string('tipo')->default('suscriptor');
            $table->string('user_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('email');
            $table->string('contrasena')->nullable();
            $table->string('imagen')->nullable();
            $table->string('web')->nullable();
            $table->text('info')->nullable();
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
        Schema::dropIfExists('blog_usuarios');
    }
}
