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
        $table->id(); // Esta línea crea una clave primaria autoincrementable 'id'
        $table->string('cididdocumento', 10);
        $table->dateTime('fecha');
        $table->string('serie', 50);
        $table->integer('folio'); // Elimina 'auto_increment' de aquí
        $table->string('semana', 255); // Añade la longitud, si es necesario
        $table->string('nombre', 100);
        $table->string('talla', 100);
        $table->integer('total'); // Elimina 'auto_increment' de aquí
        $table->integer('pendientes'); // Elimina 'auto_increment' de aquí
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
