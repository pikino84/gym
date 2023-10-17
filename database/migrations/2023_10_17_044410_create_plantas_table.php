<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantas', function (Blueprint $table) {
            $table->id();
            $table->string('cididdocumento', 10);
            $table->dateTime('fecha');
            $table->string('semana', 255);
            $table->string('serie', 50);
            $table->integer('folio');
            $table->string('concepto', 250);
            $table->integer('importe');
            $table->integer('iva'); 
            $table->integer('total'); 
            $table->integer('pendiente');
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
        Schema::dropIfExists('plantas');
    }
}
