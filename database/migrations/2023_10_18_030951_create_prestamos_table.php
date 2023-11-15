<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->string('cididdocumento', 10);
            $table->string('user_id');
            $table->dateTime('fecha');
            $table->string('serie', 50);
            $table->integer('folio');
            $table->integer('total'); 
            $table->integer('moneda');
            $table->decimal('tipodecambio', 10, 4);
            $table->integer('naturaleza');
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
        Schema::dropIfExists('prestamos');
    }
}
