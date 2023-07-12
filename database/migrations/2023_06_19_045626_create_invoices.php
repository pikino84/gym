<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('id_invoice')->unique();
            $table->string('razonsocial');
            $table->text('description');
            $table->decimal('monto', 8, 2);
            $table->integer('moneda');
            $table->string('tipocambio', 8, 4);
            $table->dateTime('fecha');
            $table->string('semana');
            $table->integer('cancelado');
            $table->integer('id_status')->default(0);
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
        Schema::dropIfExists('invoices');
    }
}
