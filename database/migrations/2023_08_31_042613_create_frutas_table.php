<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frutas', function (Blueprint $table) {
            $table->id();
            $table->string('cididdocumento', 10);
            $table->dateTime('fecha');
            $table->string('serie', 50);
            $table->string('folio', 50);
            $table->string('semana');
            $table->string('nombre', 100);
            $table->string('talla', 100);
            $table->integer('total');
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
        Schema::dropIfExists('frutas');
    }
}
