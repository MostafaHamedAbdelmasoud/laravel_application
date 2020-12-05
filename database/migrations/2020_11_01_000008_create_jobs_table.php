<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('whats_app_number');
            $table->string('email');
            $table->date('add_date');
            $table->boolean('approved')->default(0);
            $table->longText('details');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
