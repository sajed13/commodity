<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommoditiesTable extends Migration
{
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->string('day');
            $table->string('present');
            $table->string('weekly');
            $table->string('monthly');
            $table->string('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commodities');
    }
}
