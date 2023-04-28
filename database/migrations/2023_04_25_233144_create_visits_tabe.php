<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTabe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('name');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('code');
            $table->enum('status', ['pending', 'confirmed', 'canceled'])->default('pending');
            $table->string('office_name')->default('Alcaldía');
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
        Schema::dropIfExists('visits_tabe');
    }
}
