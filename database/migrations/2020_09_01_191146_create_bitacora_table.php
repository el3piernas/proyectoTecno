<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idEmpleado');   
            $table->date('fecha');
            $table->time('hora',0);
            $table->string('tabla',20);
            $table->integer('codigoTabla');
            $table->string('transaccion',20);              
            $table->foreign('idEmpleado')->references('id')->on('empleado');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitacora');
    }
}
