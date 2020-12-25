<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('departments', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('trader_id');
            $table->foreign('trader_id')
                ->references('id')->on('traders')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();;
        });
        Schema::enableForeignKeyConstraints();
    }
}
