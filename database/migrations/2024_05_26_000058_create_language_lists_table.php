<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageListsTable extends Migration
{
    public function up()
    {
        Schema::create('language_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('nmae_en')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
