<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
//        Schema::disableForeignKeyConstraints();

        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('content');
            $table->timestamps();
            $table->softDeletes();
        });
//        Schema::enableForeignKeyConstraints();
    }
}
