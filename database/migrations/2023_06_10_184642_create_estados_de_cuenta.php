<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosDeCuenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados_de_cuenta', function (Blueprint $table) {
            $table->id();
            $table->string('id_fac_compac')->unique();
            $table->string('idproveedor')->unique();
            $table->text('descripcion');
            $table->decimal('monto', 8, 2);
            $table->integer('status')->default(0);
            $table->string('pdf')->nullable();
            $table->string('xml')->nullable();
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
        Schema::dropIfExists('estados_de_cuenta');
    }
}
