<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsSubCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('news_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('news_category_id');
            $table->foreign('news_category_id')->references('id')
                ->on('news_categories')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
