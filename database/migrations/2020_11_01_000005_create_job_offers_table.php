<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOffersTable extends Migration
{
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->longText('details');
            $table->boolean('approved')->default(0);
            $table->date('add_date')->nullable();
            $table->longText('about')->nullable();
            $table->integer('age')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
