<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForestBeatsTable extends Migration
{
    public function up()
    {
        Schema::create('forest_beats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_bn')->unique();
            $table->string('name_en')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
