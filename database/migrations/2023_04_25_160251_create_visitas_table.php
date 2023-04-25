<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->string('asunto');
            $table->string('nombre');
            $table->datetime('fecha');
            $table->string('cargo');
            $table->enum('estado', ['pendiente', 'descartado', 'confirmado'])->default('pendiente');
            $table->string('oficina')->default('Alcaldía');
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
        Schema::dropIfExists('visitas');
    }
}
