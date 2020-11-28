<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('details');
            $table->date('add_date');
            $table->string('phone_number');
            $table->boolean('approved')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
