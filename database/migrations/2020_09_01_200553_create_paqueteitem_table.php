<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaqueteitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paqueteitem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idPaquete');
            $table->foreignId('idItem');
            $table->integer('cantidad');
            $table->double('precio',20,2);
            
            $table->foreign('idPaquete')->references('id')->on('paquete')->ondelete('cascade');
            $table->foreign('idItem')->references('id')->on('item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paqueteitem');
    }
}
