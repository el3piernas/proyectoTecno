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
            $table->date('fecha');
            $table->datetime('fechaInicio',0);
            $table->datetime('fechaFin',0);
            $table->double('montoTotal',18,2);
            $table->string('estado',60);
          
            $table->foreign('idCliente')->references('id')->on('cliente');
            $table->foreign('idEmpleado')->references('id')->on('empleado');
            $table->foreign('idSalon')->references('id')->on('salon');

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
