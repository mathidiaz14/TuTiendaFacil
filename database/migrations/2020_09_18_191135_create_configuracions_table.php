<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->id();
            $table->string('empresa_id');
            $table->string('titulo')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('email_admin')->nullable();
            $table->string('logo')->nullable();
            $table->string('efectivo_estado')->default('on')->nullable();
            $table->string('transferencia_estado')->default('on')->nullable();
            $table->string('transferencia_cuenta')->nullable();
            $table->string('transferencia_contacto')->nullable();
            $table->string('mp_estado')->nullable();
            $table->string('mp_access_token')->nullable();
            $table->string('mp_public_key')->nullable();
            $table->string('mp_refresh_token')->nullable();
            $table->string('mp_user_id')->nullable();
            $table->string('mp_expires_in')->nullable();
            $table->string('envio')->nullable();
            $table->string('retiro')->nullable();
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
        Schema::dropIfExists('configuracions');
    }
}

