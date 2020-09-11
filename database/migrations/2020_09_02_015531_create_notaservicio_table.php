<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaservicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notaservicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idCliente');
            $table->foreignId('idEmpleado');
            $table->foreignId('idSalon');
            $table->foreignId('idPaqueteItem');
            $table->date('fecha');
            $table->time('horaInicio',0);
            $table->time('horaFin',0);
            $table->float('montoTotal',8,2);
            $table->string('estado',60);
          
            $table->foreign('idCliente')->references('id')->on('cliente');
            $table->foreign('idEmpleado')->references('id')->on('empleado');
            $table->foreign('idSalon')->references('id')->on('salon');
            $table->foreign('idPaqueteItem')->references('id')->on('paqueteitem');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notaservicio');
    }
}
