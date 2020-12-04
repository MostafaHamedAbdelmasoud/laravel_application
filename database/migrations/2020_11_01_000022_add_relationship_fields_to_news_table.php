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
            $table->unsignedBigInteger('news_category_id');
            $table->foreign('news_category_id')->references('id')->on('news_categories');
            $table->unsignedBigInteger('news_sub_category_id');
            $table->foreign('news_sub_category_id')->references('id')->on('news_sub_categories');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id', 'city_fk_2472773')->references('id')->on('cities');
        });
        Schema::enableForeignKeyConstraints();
    }
}
