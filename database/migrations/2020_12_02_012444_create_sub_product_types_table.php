<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('main_product_type_id');
            $table->foreign('main_product_type_id')->references('id')
                ->on('main_product_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_product_types');
    }
}
