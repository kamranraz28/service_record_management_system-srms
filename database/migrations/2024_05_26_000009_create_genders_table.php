<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGendersTable extends Migration
{
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_bn');
            $table->string('name_en');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
