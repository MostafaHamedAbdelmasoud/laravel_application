<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOffersTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->foreign('trader_id', 'trader_fk_2504442')->references('id')->on('traders');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
        });
        Schema::enableForeignKeyConstraints();
    }
}
