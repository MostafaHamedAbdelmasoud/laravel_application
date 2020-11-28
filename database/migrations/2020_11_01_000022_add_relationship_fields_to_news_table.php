<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToNewsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('news', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_fk_2472772')->references('id')->on('categories');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id', 'city_fk_2472773')->references('id')->on('cities');
        });
        Schema::enableForeignKeyConstraints();
    }
}
