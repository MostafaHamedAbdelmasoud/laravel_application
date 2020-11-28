<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('add_date');
            $table->date('date_end');
            $table->string('phone_number');
            $table->string('location');
            $table->float('price', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
