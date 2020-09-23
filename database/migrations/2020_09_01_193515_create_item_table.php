<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idTipoItem');
            $table->string('foto',50);
            $table->string('nombre',50);
            $table->string('descripcion',50);
            $table->float('precio',8,2); 
            $table->integer('stock');
            $table->foreign('idTipoItem')->references('id')->on('tipoitem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
