<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deudas', function (Blueprint $table) {
            $table->id();
            $table->string('cididdocumento', 50);
            $table->dateTime('fecha');
            $table->string('serie', 50);
            $table->string('folio', 50);
            $table->string('importe', 100);
            $table->string('total_unidades', 100);
            $table->string('moneda', 100);
            $table->string('descuentos', 100);
            $table->string('saldo', 100);
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
        Schema::dropIfExists('deudas');
    }
}
