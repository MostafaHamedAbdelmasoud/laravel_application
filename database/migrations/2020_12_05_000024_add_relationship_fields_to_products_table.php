<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->foreign('trader_id', 'trader_fk_2504438')->references('id')->on('traders')->cascadeOnDelete();

            $table->unsignedBigInteger('main_product_type_id')->nullable();
            $table->foreign('main_product_type_id')->references('id')->on('main_product_types')->cascadeOnDelete();

            $table->unsignedBigInteger('sub_product_type_id')->nullable();
            $table->foreign('sub_product_type_id')->references('id')->on('sub_product_types')->cascadeOnDelete();

            $table->unsignedBigInteger('sub_product_service_type_id')->nullable();
            $table->foreign('sub_product_service_type_id')->references('id')
                ->on('sub_product_service_types')->cascadeOnDelete();

            $table->unsignedBigInteger('main_product_service_type_id')->nullable();
            $table->foreign('main_product_service_type_id')->references('id')
                ->on('main_product_service_types')->cascadeOnDelete();

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnDelete();

            $table->unsignedInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }
}
