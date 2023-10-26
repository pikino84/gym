<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegaliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regalias', function (Blueprint $table) {
            $table->id();
            $table->string('cididdocumento', 50);
            $table->string('user_id');
            $table->dateTime('fecha');
            $table->string('semana');
            $table->string('serie', 50);
            $table->string('folio', 50);
            $table->string('concepto', 100);
            $table->string('importe', 100);
            $table->string('iva', 100);
            $table->string('total', 100);
            $table->string('pendiente', 100);   
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
        Schema::dropIfExists('regalias');
    }
}
