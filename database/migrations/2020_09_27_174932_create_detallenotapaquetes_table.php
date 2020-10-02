<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallenotapaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detallenotapaquetes', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->double('subTotal',18,2);
            $table->foreignId('idNotaservicio');
            $table->foreignId('idPaqueteitem');
            
            $table->foreign('idNotaservicio')->references('id')->on('notaservicio');
            $table->foreign('idPaqueteitem')->references('id')->on('paqueteitem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detallenotapaquetes');
    }
}
