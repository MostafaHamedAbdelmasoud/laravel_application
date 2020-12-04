<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();

            $table->string('detailed_title')->nullable();
            $table->string('details')->nullable();
            $table->string('price_after_discount')->nullable();
            $table->string('product_code')->nullable();
            $table->boolean('show_trader_name')->default(1);

            $table->boolean('show_in_main_page')->default(1);
            $table->boolean('show_in_trader_page')->default(1);
            $table->string('price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
