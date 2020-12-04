<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variant', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')
                ->on('products')->cascadeOnDelete();
            $table->unsignedBigInteger('variant_id');
            $table->foreign('variant_id')->references('id')
                ->on('variants')->cascadeOnDelete();
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
        Schema::dropIfExists('product_variant');
    }
}
