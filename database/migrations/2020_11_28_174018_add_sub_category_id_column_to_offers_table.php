<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubCategoryIdColumnToOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')
                ->references('id')
                ->on('departments_sub_categories')
                ->cascadeOnDelete();
        });
    }
}
