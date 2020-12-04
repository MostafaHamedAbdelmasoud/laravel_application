<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatecouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->decimal('fixed_discount')->nullable();
            $table->decimal('percentage_discount')->nullable();
//            $table->integer('max_usage_per_order')->nullable();
            $table->integer('max_usage_per_user')->nullable();
            $table->integer('number_of_usage')->default(0);
//            $table->boolean('is_used')->nullable();
            $table->integer('min_total')->default(1);
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
        Schema::dropIfExists('coupons');
    }
}
