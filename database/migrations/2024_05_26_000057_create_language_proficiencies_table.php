<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageProficienciesTable extends Migration
{
    public function up()
    {
        Schema::create('language_proficiencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('name_en')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
