<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanciamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financiamientos', function (Blueprint $table) {
            $table->id();
            $table->string('cididdocumento', 50);
            $table->dateTime('fecha');
            $table->string('serie', 50);
            $table->string('folio', 50);
            $table->string('prestamos', 100);
            $table->string('descuentos', 100);
            $table->string('deuda_total', 100);
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
        Schema::dropIfExists('financiamientos');
    }
}


